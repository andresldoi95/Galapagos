<template>
  <div class="columns is-vcentered is-centered">
    <div class="column is-half">
      <section class="hero">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">{{ $t("title.recuperar_cuenta") }}</h1>
            <h2 class="subtitle">{{ $t("title.recuperar_cuenta_sub") }}</h2>
            <form @submit.prevent="submit">
              <b-field
                :message="errores.email ? errores.email[0] : ''"
                :type="errores.email ? 'is-danger' : ''"
                :label="$t('message.email')"
              >
                <b-input v-model="form.email"></b-input>
              </b-field>
              <b-button expanded native-type="submit" type="is-info">{{
                $t("button.enviar_link")
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
    submit: function () {
      this.$http
        .post(process.env.MIX_APP_URL_API + "/reset", this.form)
        .then(() => {
          this.$buefy.toast.open(this.$t("message.link_enviado"));
          this.form.email = "";
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 422) {
            this.errores.email = response.data.errors.email;
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
        email: "",
      },
      errores: {
        email: undefined,
      },
    };
  },
};
</script>
