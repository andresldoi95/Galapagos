<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t('title.empresas') }}</h1>
        <masterForm
          @adding="adding"
          @canceled="canceled"
          @realizarAccion="realizarAccion"
          @editar="editar"
          ref="masterForm"
          @submitFormulario="submitFormulario"
          resource="/api/empresas"
          :isPaginated="false"
          :columns="[
                {
                    label : $t('message.id'),
                    field : 'id',
                    sortable : true
                },
                {
                    label : $t('message.nombre'),
                    field : 'nombre',
                    sortable : true
                }
                ,
                {
                    label : $t('message.descripcion'),
                    field : 'descripcion',
                    sortable : true
                }
            ]"
        >
          <div class="columns">
            <div class="column">
              <b-field :label="$t('message.id')">
                <b-input readonly v-model="form.id"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.nombre?errores.nombre[0]:''"
                :type="errores.nombre?'is-danger':''"
                :label="$t('message.nombre')"
              >
                <b-input v-model="form.nombre"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.descripcion?errores.descripcion[0]:''"
                :type="errores.descripcion?'is-danger':''"
                :label="$t('message.descripcion')"
              >
                <b-input v-model="form.descripcion"></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
              <label class="label" for="modulos">{{ $t('etiqueta.modulos') }}</label>
              <div v-for="modulo in modulos" :key="modulo.id" class="field">
                <b-checkbox v-model="form.modulos" :native-value="modulo.id">{{ modulo.nombre }}</b-checkbox>
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
  data: function() {
    return {
      form: {
        nombre: "",
        descripcion: "",
        id: "",
        _method: undefined,
        modulos: []
      },
      modulos: [],
      errores: {
        nombre: undefined,
        descripcion: undefined
      }
    };
  },
  methods: {
    canceled: function() {
      this.limpiar();
    },
    limpiar: function() {
      this.form.id = "";
      this.form._method = undefined;
      this.form.nombre = "";
      this.form.descripcion = "";
      this.form.modulos.splice(0, this.form.modulos.length);
    },
    adding: function() {
      this.limpiar();
    },
    realizarAccion: function(type, empresas) {
      if (type === "E") {
        let empresasId = [];
        for (let i = 0; i < empresas.length; i++)
          empresasId.push(empresas[i].id);
        this.$http
          .post(process.env.MIX_APP_URL_API + "/empresas", {
            empresas: empresasId,
            _method: "DELETE"
          })
          .then(() => {
            this.$buefy.toast.open({
              message: this.$t("message.guardado_generico"),
              type: "is-success"
            });
            this.$store.commit(
              "reload",
              this.$moment(new Date()).format("YYYYMMDDHHmmss")
            );
          })
          .catch(() => {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger"
            });
          });
      }
    },
    editar: function(empresa) {
      this.form.id = empresa.id;
      this.form.nombre = empresa.nombre;
      this.form.descripcion = empresa.descripcion;
      for (let i = 0; i < empresa.modulos.length; i++)
        this.form.modulos.push(empresa.modulos[i].id);
    },
    limpiarErrores: function() {
      this.errores.descripcion = undefined;
      this.errores.nombre = undefined;
    },
    submitFormulario: function() {
      this.limpiarErrores();
      let path = process.env.MIX_APP_URL_API + "/empresas";
      if (this.form.id !== "") {
        path += "/" + this.form.id;
        this.form._method = "PUT";
      } else this.form._method = undefined;
      this.$http
        .post(path, this.form)
        .then(() => {
          this.$buefy.toast.open({
            message: this.$t("message.guardado_generico"),
            type: "is-success"
          });
          this.$store.commit(
            "reload",
            this.$moment(new Date()).format("YYYYMMDDHHmmss")
          );
        })
        .catch(({ response }) => {
          let status = response.status;
          if (status === 422) {
            this.errores.nombre = response.data.errors.nombre;
            this.errores.descripcion = response.data.errors.descripcion;
          } else {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger"
            });
          }
        });
    },
    cargarModulos: function() {
      this.$http
        .get(process.env.MIX_APP_URL_API + "/modulos")
        .then(({ data }) => {
          this.modulos = data;
        });
    }
  },
  mounted: function() {
    this.cargarModulos();
  }
};
</script>
