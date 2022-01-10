<template>
  <b-navbar>
    <template slot="brand">
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <img src="/img/logo.png" alt="Logo" />
      </b-navbar-item>
    </template>
    <template slot="start">
      <b-navbar-dropdown
        v-if="
          $store.state.empresas.length > 1 ||
          $store.state.nombre_empresa_actual === ''
        "
        :label="
          $store.state.nombre_empresa_actual === ''
            ? $t('message.seleccione_empresa')
            : $store.state.nombre_empresa_actual
        "
      >
        <b-navbar-item
          @click="cambiarEmpresa(empresa.id, empresa.nombre)"
          v-show="$store.state.empresa_actual_id != empresa.id"
          v-for="empresa in $store.state.empresas"
          :key="empresa.id"
          >{{ empresa.nombre }}</b-navbar-item
        >
      </b-navbar-dropdown>
      <b-navbar-item tag="router-link" to="/declaracion-juramentada">{{
        $t("link.declaracion_juramentada")
      }}</b-navbar-item>
      <b-navbar-item
        v-if="$store.state.usuario.id !== ''"
        tag="router-link"
        to="/declaraciones-juramentadas"
        >{{ $t("link.declaraciones_juramentadas") }}</b-navbar-item
      >
      <b-navbar-item
        v-if="$store.state.usuario.id !== ''"
        tag="router-link"
        to="/registro-retencion"
        >{{ $t("link.registro_retenciones") }}</b-navbar-item
      >
      <b-navbar-item tag="router-link" to="/">{{
        $t("link.home")
      }}</b-navbar-item>
      <b-navbar-item tag="router-link" to="/admin">{{
        $t("link.admin")
      }}</b-navbar-item>
    </template>

    <template slot="end">
      <b-navbar-dropdown :label="$store.state.locale">
        <b-navbar-item
          v-show="$store.state.locale !== 'es'"
          @click="cambiarLenguaje('es')"
          >Español (es)</b-navbar-item
        >
        <b-navbar-item
          v-show="$store.state.locale !== 'en'"
          @click="cambiarLenguaje('en')"
          >English (en)</b-navbar-item
        >
      </b-navbar-dropdown>
      <b-navbar-dropdown
        v-if="$store.state.usuario.id !== ''"
        :label="$store.state.usuario.nombre"
      >
        <b-navbar-item tag="router-link" to="/perfil">{{
          $t("link.perfil")
        }}</b-navbar-item>
        <b-navbar-item @click="logout">{{ $t("link.logout") }}</b-navbar-item>
      </b-navbar-dropdown>
      <b-navbar-item v-else tag="div">
        <div class="buttons">
          <router-link :to="{ name: 'Login' }" class="button is-info">{{
            $t("link.login")
          }}</router-link>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>

<script>
export default {
  methods: {
    logout: function () {
      this.$store.dispatch("loggedOut");
      this.$session.destroy();
      this.$router.push({
        name: "Login",
      });
    },
    cambiarEmpresa: function (id, nombre) {
      this.$http
        .post(process.env.MIX_APP_URL_API + "/usuario/" + id, {
          _method: "PUT",
        })
        .then(() => {
          this.$store.commit("cambiarEmpresaActual", {
            id: id,
            nombre: nombre,
          });
          this.$store.commit(
            "reload",
            this.$moment(new Date()).format("YYYYMMDDHHmmss")
          );
        })
        .catch(() => {
          this.$buefy.toast.open({
            message: this.$t("message.generic_error"),
            type: "is-danger",
          });
        });
    },
    cambiarLenguaje: function (lang) {
      this.$store.commit("setLang", lang);
    },
  },
};
</script>
