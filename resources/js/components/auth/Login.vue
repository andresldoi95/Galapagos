<template>
  <div class="columns is-vcentered is-centered">
    <div class="column is-half">
      <section class="hero">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">{{ $t("title.login") }}</h1>
            <h2 class="subtitle">{{ $t("title.access") }}</h2>
            <section>
              <b-image src="/img/login.png" alt="Logo" responsive></b-image>
            </section>
            <form @submit.prevent="submit">
              <b-field
                :message="errores.username ? errores.username[0] : ''"
                :type="errores.username ? 'is-danger' : ''"
                :label="$t('etiqueta.username')"
              >
                <b-input v-model="form.username"></b-input>
              </b-field>
              <b-field
                :message="errores.password ? errores.password[0] : ''"
                :type="errores.password ? 'is-danger' : ''"
                :label="$t('etiqueta.password')"
              >
                <b-input type="password" v-model="form.password"></b-input>
              </b-field>
              <b-button expanded native-type="submit" type="is-info">{{
                $t("button.login")
              }}</b-button>
              <router-link :to="{ name: 'Recuperar' }">{{
                $t("link.recuperar")
              }}</router-link>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    submit: function () {
      this.$http
        .post(process.env.MIX_APP_URL + "/oauth/token", {
          grant_type: "password",
          client_id: process.env.MIX_CLIENT_ID,
          client_secret: process.env.MIX_CLIENT_SECRET,
          username: this.form.username,
          password: this.form.password,
        })
        .then(({ data }) => {
          this.$session.start();
          let token = data.access_token;
          this.$store.dispatch("loggedIn", token);
          this.$session.set("oauth2", token);
          this.$buefy.toast.open(this.$t("message.acceso_exitoso"));
          this.$router.push({
            name: "Home",
          });
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 400) {
            this.$buefy.toast.open({
              message: this.$t("message.invalid_credentials"),
              type: "is-danger",
            });
          }
        });
    },
  },
  data: function () {
    return {
      form: {
        username: "",
        password: "",
      },
      errores: {
        username: undefined,
        password: undefined,
      },
    };
  },
  mounted: function () {
    if (this.$session.exists()) {
      this.$router.push({
        name: "Home",
      });
    }
  },
};
</script>
