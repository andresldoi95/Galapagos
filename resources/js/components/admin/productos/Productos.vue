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
          <div class="columns">
            <div class="column">
              <b-field
                :message="
                  errores.informacion_adicional
                    ? errores.informacion_adicional[0]
                    : ''
                "
                :type="errores.informacion_adicional ? 'is-danger' : ''"
                :label="$t('etiqueta.informacion_adicional')"
              >
                <b-input
                  type="textarea"
                  v-model="form.informacion_adicional"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field>
                <b-upload
                  @input="inputFoto"
                  accept="image/*"
                  v-model="foto"
                  drag-drop
                  expanded
                >
                  <section class="section">
                    <div class="content has-text-centered">
                      <p>
                        <b-icon icon="upload" size="is-large"></b-icon>
                      </p>
                      <p>{{ $t("message.arrastra_archivo") }}</p>
                    </div>
                  </section>
                </b-upload>
              </b-field>
              <div v-if="foto != null" class="tags">
                <span class="tag is-primary">
                  {{ foto.name }}
                  <button
                    class="delete is-small"
                    type="button"
                    @click="quitarArchivo"
                  ></button>
                </span>
              </div>
            </div>
            <div class="column">
              <b-image :src="imagenActual" alt="Imagen" ratio="6by4"></b-image>
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
      imagenActual: "/img/sin-imagen.jpg",
      form: {
        descripcion: "",
        codigo: "",
        id: "",
        _method: undefined,
        categoria: "",
        tipo_foto: "S",
        informacion_adicional: "",
      },
      errores: {
        descripcion: undefined,
        codigo: undefined,
        categoria: undefined,
        foto: undefined,
        informacion_adicional: undefined,
      },
      foto: null,
    };
  },
  methods: {
    inputFoto: function () {
      this.form.tipo_foto = this.foto != null ? "S" : "N";
      if (this.foto != null) {
        let reader = new FileReader();
        reader.readAsDataURL(this.foto);
        let that = this;
        reader.onload = function () {
          that.imagenActual = reader.result;
        };
      } else this.imagenActual = "/img/sin-imagen.jpg";
    },
    quitarArchivo: function () {
      this.foto = null;
      this.form.tipo_foto = "Q";
      this.imagenActual = "/img/sin-imagen.jpg";
    },
    canceled: function () {
      this.limpiar();
    },
    limpiar: function () {
      this.form.id = "";
      this.form._method = undefined;
      this.form.descripcion = "";
      this.form.codigo = "";
      this.form.categoria = "";
      this.form.tipo_foto = "S";
      this.form.informacion_adicional = "";
      this.imagenActual = "/img/sin-imagen.jpg";
      this.foto = null;
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
      this.form.informacion_adicional = producto.informacion_adicional;
      if (producto.url_foto != null) this.imagenActual = producto.url_foto;
      else this.imagenActual = "/img/sin-imagen.jpg";
    },
    limpiarErrores: function () {
      this.errores.descripcion = undefined;
      this.errores.codigo = undefined;
      this.errores.categoria = undefined;
      this.errores.foto = undefined;
      this.errores.informacion_adicional = undefined;
    },
    submitFormulario: function () {
      this.limpiarErrores();
      let path = process.env.MIX_APP_URL_API + "/productos";
      if (this.form.id !== "") {
        path += "/" + this.form.id;
        this.form._method = "PATCH";
      } else this.form._method = undefined;
      let formData = new FormData();
      formData.append("codigo", this.form.codigo);
      formData.append("descripcion", this.form.descripcion);
      formData.append("categoria", this.form.categoria);
      if (
        this.form.informacion_adicional != "" &&
        this.form.informacion_adicional != null
      )
        formData.append(
          "informacion_adicional",
          this.form.informacion_adicional
        );
      if (this.form._method != null)
        formData.append("_method", this.form._method);
      if (this.foto != null) formData.append("foto", this.foto);
      this.$http({
        method: "post",
        url: path,
        data: formData,
        headers: { "Content-Type": "multipart/form-data" },
      })
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
            this.errores.foto = response.data.errors.foto;
            this.errores.informacion_adicional =
              response.data.errors.informacion_adicional;
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
