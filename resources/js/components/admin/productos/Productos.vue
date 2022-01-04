<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t("title.productos") }}</h1>
        <masterForm
          @adding="adding"
          @canceled="canceled"
          @realizarAccion="realizarAccion"
          @editar="editar"
          ref="masterForm"
          @submitFormulario="submitFormulario"
          resource="/api/productos"
          :columns="[
            {
              label: $t('message.codigo'),
              field: 'codigo',
              sortable: true,
            },
            {
              label: $t('message.descripcion'),
              field: 'descripcion',
              sortable: true,
            },
            {
              label: $t('message.categoria'),
              field: 'categoria',
              sortable: true,
            },
          ]"
        >
          <div class="columns">
            <div class="column is-one-third">
              <b-field
                :message="errores.codigo ? errores.codigo[0] : ''"
                :type="errores.codigo ? 'is-danger' : ''"
                :label="$t('message.codigo')"
              >
                <b-input
                  :readonly="form.id !== ''"
                  v-model="form.codigo"
                ></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
              <b-field
                :message="errores.descripcion ? errores.descripcion[0] : ''"
                :type="errores.descripcion ? 'is-danger' : ''"
                :label="$t('message.descripcion')"
              >
                <b-input v-model="form.descripcion"></b-input>
              </b-field>
            </div>
            <div class="column is-one-third">
              <b-field
                :message="errores.categoria ? errores.categoria[0] : ''"
                :type="errores.categoria ? 'is-danger' : ''"
                :label="$t('message.categoria')"
              >
                <b-select
                  v-model="form.categoria"
                  :placeholder="$t('message.seleccione')"
                  expanded
                >
                  <option value="P">{{ $t("message.permitido") }}</option>
                  <option value="R">{{ $t("message.restringido") }}</option>
                  <option value="NP">{{ $t("message.no_permitido") }}</option>
                </b-select>
              </b-field>
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
        descripcion: "",
        codigo: "",
        id: "",
        _method: undefined,
        categoria: "",
      },
      errores: {
        descripcion: undefined,
        codigo: undefined,
        categoria: undefined,
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
      this.form.descripcion = "";
      this.form.codigo = "";
      this.form.categoria = "";
    },
    adding: function () {
      this.limpiar();
    },
    realizarAccion: function (type, productos) {
      if (type === "E") {
        let productosId = [];
        for (let i = 0; i < productos.length; i++)
          productosId.push(productos[i].id);
        this.$http
          .post(process.env.MIX_APP_URL_API + "/producto", {
            productos: productosId,
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
    editar: function (producto) {
      this.form.id = producto.id;
      this.form.descripcion = producto.descripcion;
      this.form.codigo = producto.codigo;
      this.form.categoria = producto.categoria;
    },
    limpiarErrores: function () {
      this.errores.descripcion = undefined;
      this.errores.codigo = undefined;
      this.errores.categoria = undefined;
    },
    submitFormulario: function () {
      this.limpiarErrores();
      let path = process.env.MIX_APP_URL_API + "/productos";
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
            this.errores.descripcion = response.data.errors.descripcion;
            this.errores.codigo = response.data.errors.codigo;
            this.errores.categoria = response.data.errors.categoria;
          } else {
            this.$buefy.toast.open({
              message: this.$t("message.generic_error"),
              type: "is-danger",
            });
          }
        });
    },
  },
};
</script>
