<template>
  <div class="columns is-vcentered is-centered">
    <div class="column is-half">
      <section class="hero">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">{{ $t("title.edit_account") }}</h1>
            <form @submit.prevent="submit">
              <b-field
                :message="errores.name ? errores.name[0] : ''"
                :type="errores.name ? 'is-danger' : ''"
                :label="$t('message.nombre')"
              >
                <b-input v-model="form.name"></b-input>
              </b-field>
              <b-field
                :message="errores.email ? errores.email[0] : ''"
                :type="errores.email ? 'is-danger' : ''"
                :label="$t('message.email')"
              >
                <b-input v-model="form.email"></b-input>
              </b-field>
              <b-field
                :message="errores.password ? errores.password[0] : ''"
                :type="errores.password ? 'is-danger' : ''"
                :label="$t('message.password')"
              >
                <b-input
                  password-reveal
                  type="password"
                  v-model="form.password"
                ></b-input>
              </b-field>
              <b-field
                :message="
                  errores.password_confirmation
                    ? errores.password_confirmation[0]
                    : ''
                "
                :type="errores.password_confirmation ? 'is-danger' : ''"
                :label="$t('message.password_confirmation')"
              >
                <b-input
                  password-reveal
                  type="password"
                  v-model="form.password_confirmation"
                ></b-input>
              </b-field>
              <b-button expanded native-type="submit" type="is-info">{{
                $t("button.edit_account")
              }}</b-button>
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
    limpiarErrores: function () {
      this.errores.name = undefined;
      this.errores.email = undefined;
      this.errores.password = undefined;
      this.errores.password_confirmation = undefined;
    },
    submit: function () {
      this.limpiarErrores();
      this.$http
        .post(process.env.MIX_APP_URL_API + "/usuario/perfil", this.form)
        .then(({ data }) => {
          this.$buefy.toast.open(this.$t("message.guardado_generico"));
          this.$store.commit(
            "reload",
            this.$moment(new Date()).format("YYYYMMDDHHmmss")
          );
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 422) {
            this.errores.name = response.data.errors.name;
            this.errores.email = response.data.errors.email;
            this.errores.password = response.data.errors.password;
            this.errores.password_confirmation =
              response.data.errors.password_confirmation;
          } else {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger",
            });
          }
        });
    },
  },
  data: function () {
    return {
      form: {
        name: "",
        password: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errores: {
        name: undefined,
        email: undefined,
        password: undefined,
        password_confirmation: undefined,
      },
    };
  },
  mounted: function () {
    this.$http
      .get(process.env.MIX_APP_URL_API + "/usuario/datos")
      .then(({ data }) => {
        this.form.name = data.name;
        this.form.email = data.email;
        this.form.password = "";
        this.form.password_confirmation = "";
      })
      .catch(({ response }) => {
        this.$buefy.toast.open({
          message: this.$t("message.generic_error"),
          type: "is-danger",
        });
      });
  },
};
</script>
