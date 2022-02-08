<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t("title.usuarios") }}</h1>
        <masterForm
          @adding="adding"
          @canceled="canceled"
          @realizarAccion="realizarAccion"
          @editar="editar"
          ref="masterForm"
          @submitFormulario="submitFormulario"
          resource="/api/usuarios"
          :columns="[
            {
              label: $t('message.id'),
              field: 'id',
              sortable: true,
            },
            {
              label: $t('message.nombre'),
              field: 'name',
              sortable: true,
            },
            {
              label: $t('message.numero_identificacion'),
              field: 'numero_identificacion',
              sortable: true,
            },
            {
              label: $t('message.email'),
              field: 'email',
              sortable: true,
            },
          ]"
        >
          <div class="columns">
            <div class="column is-one-third">
              <b-field :label="$t('message.id')">
                <b-input readonly v-model="form.id"></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
              <b-field
                :message="errores.name ? errores.name[0] : ''"
                :type="errores.name ? 'is-danger' : ''"
                :label="$t('message.nombre')"
              >
                <b-input v-model="form.name"></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
              <b-field
                :message="
                  errores.numero_identificacion
                    ? errores.numero_identificacion[0]
                    : ''
                "
                :type="errores.numero_identificacion ? 'is-danger' : ''"
                :label="$t('message.numero_identificacion')"
              >
                <b-input v-model="form.numero_identificacion"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column is-one-third">
              <b-field
                :message="errores.email ? errores.email[0] : ''"
                :type="errores.email ? 'is-danger' : ''"
                :label="$t('message.email')"
              >
                <b-input v-model="form.email"></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
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
            </div>
            <div class="column is-one-third">
              <b-field
                password-reveal
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
            </div>
          </div>
          <div class="columns">
            <div class="column is-one-third">
              <label class="label" for="roles">{{
                $t("etiqueta.roles")
              }}</label>
              <div v-for="rol in roles" :key="rol.id" class="field">
                <b-checkbox v-model="form.roles" :native-value="rol.id">{{
                  rol.nombre
                }}</b-checkbox>
              </div>
            </div>
          </div>
        </masterForm>
      </div>
    </div>
  </section>
</template>

<script>
import MasterForm from "../../layouts/MasterForm";
export default {
  components: { MasterForm },
  data: function () {
    return {
      form: {
        name: "",
        email: "",
        id: "",
        _method: undefined,
        roles: [],
        password: "",
        password_confirmation: "",
        numero_identificacion: "",
      },
      roles: [],
      errores: {
        name: undefined,
        email: undefined,
        password: undefined,
        password_confirmation: undefined,
        numero_identificacion: undefined,
      },
    };
  },
  methods: {
    canceled: function () {
      this.limpiar();
    },
    limpiar: function () {
      this.form.id = "";
      this.form._method = undefined;
      this.form.name = "";
      this.form.email = "";
      this.form.password = "";
      this.form.password_confirmation = "";
      this.form.numero_identificacion = "";
      this.form.roles.splice(0, this.form.roles.length);
    },
    adding: function () {
      this.limpiar();
    },
    realizarAccion: function (type, usuarios) {
      if (type === "E") {
        let usuariosId = [];
        for (let i = 0; i < usuarios.length; i++)
          usuariosId.push(usuarios[i].id);
        this.$http
          .post(process.env.MIX_APP_URL_API + "/usuario", {
            usuarios: usuariosId,
            _method: "DELETE",
          })
          .then(() => {
            this.$buefy.toast.open({
              message: this.$t("message.guardado_generico"),
              type: "is-success",
            });
            this.$refs.masterForm.submit();
          })
          .catch(() => {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger",
            });
          });
      }
    },
    editar: function (usuario) {
      this.form.id = usuario.id;
      this.form.numero_identificacion = usuario.numero_identificacion;
      this.form.name = usuario.name;
      this.form.email = usuario.email;
      for (let i = 0; i < usuario.roles.length; i++)
        this.form.roles.push(usuario.roles[i].id);
      this.form.password = "";
      this.form.password_confirmation = "";
    },
    limpiarErrores: function () {
      this.errores.numero_identificacion = undefined;
      this.errores.name = undefined;
      this.errores.email = undefined;
      this.errores.password = undefined;
      this.errores.password_confirmation = undefined;
    },
    submitFormulario: function () {
      this.limpiarErrores();
      if (this.form.roles.length === 0) {
        this.$buefy.toast.open({
          message: this.$t("message.debe_seleccionar_roles"),
          type: "is-warning",
        });
        return;
      }
      let path = process.env.MIX_APP_URL_API + "/usuario";
      if (this.form.id !== "") {
        path += "/" + this.form.id;
        this.form._method = "PATCH";
      } else this.form._method = undefined;
      this.$http
        .post(path, this.form)
        .then(() => {
          this.$buefy.toast.open({
            message: this.$t("message.guardado_generico"),
            type: "is-success",
          });
          this.$refs.masterForm.submit();
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 422) {
            this.errores.numero_identificacion =
              response.data.errors.numero_identificacion;
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
    cargarRoles: function () {
      this.$http
        .get(process.env.MIX_APP_URL_API + "/roles/listado")
        .then(({ data }) => {
          this.roles = data;
        });
    },
  },
  mounted: function () {
    this.cargarRoles();
  },
};
</script>
