<template>
  <div class="columns is-vcentered is-centered">
    <div class="column is-half">
      <section class="hero">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">{{ $t('title.recuperar_cuenta') }}</h1>
            <h2 class="subtitle">{{ $t('title.set_password') }}</h2>
            <form @submit.prevent="submit">
              <b-field
                :message="errores.email?errores.email[0]:''"
                :type="errores.email?'is-danger':''"
                :label="$t('message.email')"
              >
                <b-input v-model="form.email"></b-input>
              </b-field>
              <b-field
                :message="errores.password?errores.password[0]:''"
                :type="errores.password?'is-danger':''"
                :label="$t('message.password')"
              >
                <b-input password-reveal type="password" v-model="form.password"></b-input>
              </b-field>
              <b-field
                :message="errores.password_confirmation?errores.password_confirmation[0]:''"
                :type="errores.password_confirmation?'is-danger':''"
                :label="$t('message.password_confirmation')"
              >
                <b-input password-reveal type="password" v-model="form.password_confirmation"></b-input>
              </b-field>
              <b-button
                expanded
                native-type="submit"
                type="is-primary"
              >{{ $t('button.set_password') }}</b-button>
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
    submit: function() {
      this.$http
        .post(process.env.MIX_APP_URL_API + "/set-password", this.form)
        .then(() => {
          this.$buefy.toast.open(this.$t("message.guardado_generico"));
          this.$router.push("/login");
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 422) {
            this.errores.email = response.data.errors.email;
            this.errores.password = response.data.errors.password;
            this.errores.token = response.data.errors.token;
            if (this.errores.token) {
              this.$buefy.toast.open({
                message: this.errores.token[0],
                type: "is-warning"
              });
            }
            this.errores.password_confirmation =
              response.data.errors.password_confirmation;
          } else {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger"
            });
          }
        });
    }
  },
  data: function() {
    return {
      form: {
        email: "",
        token: "",
        password: "",
        password_confirmation: ""
      },
      errores: {
        email: undefined,
        token: undefined,
        password: undefined,
        password_confirmation: undefined
      }
    };
  },
  mounted: function() {
    let token = this.$route.params.token;
    if (token && token !== "") {
      this.form.token = token;
    } else {
      this.$buefy.toast.open(this.$t("message.token_invalido"));
    }
  }
};
</script>
