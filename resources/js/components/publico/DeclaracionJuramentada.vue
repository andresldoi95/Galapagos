<template>
  <div>
    <section class="hero is-small is-info">
      <div class="hero-body">
        <h1 class="title">{{ $t("title.declaracion_juramentada") }}</h1>
        <h2 class="subtitle">{{ $t("message.declaracion_juramentada") }}</h2>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <h3 class="title">I. {{ $t("title.identificacion") }}</h3>
        <div class="container">
          <div class="columns">
            <div class="column">
              <b-field
                :message="
                  errores.numero_identificacion
                    ? errores.numero_identificacion[0]
                    : ''
                "
                :type="errores.numero_identificacion ? 'is-danger' : ''"
                :label="$t('etiqueta.numero_identificacion')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.numero_identificacion"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.apellidos ? errores.apellidos[0] : ''"
                :type="errores.apellidos ? 'is-danger' : ''"
                :label="$t('etiqueta.apellidos')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.apellidos"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.nombres ? errores.nombres[0] : ''"
                :type="errores.nombres ? 'is-danger' : ''"
                :label="$t('etiqueta.nombres')"
              >
                <b-input :disabled="!editable" v-model="form.nombres"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="errores.nacionalidad ? errores.nacionalidad[0] : ''"
                :type="errores.nacionalidad ? 'is-danger' : ''"
                :label="$t('etiqueta.nacionalidad')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.nacionalidad"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.telefono ? errores.telefono[0] : ''"
                :type="errores.telefono ? 'is-danger' : ''"
                :label="$t('etiqueta.telefono')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.telefono"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.correo_electronico
                    ? errores.correo_electronico[0]
                    : ''
                "
                :type="errores.correo_electronico ? 'is-danger' : ''"
                :label="$t('etiqueta.correo_electronico')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.correo_electronico"
                ></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="
                  errores.lugar_residencia ? errores.lugar_residencia[0] : ''
                "
                :type="errores.lugar_residencia ? 'is-danger' : ''"
                :label="$t('etiqueta.lugar_residencia')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.lugar_residencia"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.direccion_domicilio
                    ? errores.direccion_domicilio[0]
                    : ''
                "
                :type="errores.direccion_domicilio ? 'is-danger' : ''"
                :label="$t('etiqueta.direccion_domicilio')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.direccion_domicilio"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.linea_aerea ? errores.linea_aerea[0] : ''"
                :type="errores.linea_aerea ? 'is-danger' : ''"
                :label="$t('etiqueta.linea_aerea')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.linea_aerea"
                ></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="errores.numero_vuelo ? errores.numero_vuelo[0] : ''"
                :type="errores.numero_vuelo ? 'is-danger' : ''"
                :label="$t('etiqueta.numero_vuelo')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.numero_vuelo"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.aeropuerto_origen ? errores.aeropuerto_origen[0] : ''
                "
                :type="errores.aeropuerto_origen ? 'is-danger' : ''"
                :label="$t('etiqueta.aeropuerto_origen')"
              >
                <b-input
                  :disabled="!editable"
                  v-model="form.aeropuerto_origen"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field :label="$t('etiqueta.fecha')">
                <b-datepicker
                  :disabled="!editable"
                  v-model="form.fecha"
                  icon="calendar-today"
                  placeholder="DD/MM/YYYY"
                  trap-focus
                  locale="es-ES"
                >
                </b-datepicker>
              </b-field>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <h3 class="title">II. {{ $t("title.declaro_que") }}:</h3>
        <div class="container">
          <section class="hero">
            <div class="hero-body">
              <div class="columns">
                <div class="column">
                  <p>1. {{ $t("message.alimentos_procesados") }}.</p>
                </div>
                <div class="column">
                  <div class="block">
                    <b-radio
                      :disabled="!editable"
                      v-model="form.alimentos_procesados"
                      name="alimentos_procesados"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
                      :disabled="!editable"
                      v-model="form.alimentos_procesados"
                      name="alimentos_procesados"
                      native-value="N"
                    >
                      {{ $t("message.no") }}
                    </b-radio>
                  </div>
                </div>
              </div>
              <div class="columns" v-show="form.alimentos_procesados === 'S'">
                <div class="column">
                  <b-field :label="$t('etiqueta.productos')">
                    <b-taginput
                      v-model="form.productos"
                      :data="productos"
                      autocomplete
                      ref="productos"
                      icon="label"
                      :placeholder="$t('message.seleccione')"
                      @typing="cargarProductos"
                    >
                      <template slot-scope="props">
                        <strong>{{ props.option.codigo }}</strong
                        >: {{ props.option.descripcion }}
                      </template>
                      <template #empty> {{ $t("message.empty") }} </template>
                      <template #selected="props">
                        <b-tag
                          v-for="(producto, index) in props.tags"
                          :key="index"
                          type="is-primary"
                          rounded
                          :tabstop="false"
                          ellipsis
                          closable
                          @close="$refs.productos.removeTag(index, $event)"
                        >
                          {{ producto.descripcion }}
                        </b-tag>
                      </template>
                    </b-taginput>
                  </b-field>
                </div>
              </div>
            </div>
          </section>
          <section class="hero">
            <div class="hero-body">
              <div class="columns">
                <div class="column">
                  <p>2. {{ $t("message.lugares_concentracion") }}.</p>
                </div>
                <div class="column">
                  <div class="block">
                    <b-radio
                      :disabled="!editable"
                      v-model="form.lugares_concentracion"
                      name="lugares_concentracion"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
                      :disabled="!editable"
                      v-model="form.lugares_concentracion"
                      name="lugares_concentracion"
                      native-value="N"
                    >
                      {{ $t("message.no") }}
                    </b-radio>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="hero">
            <div class="hero-body">
              <div class="columns">
                <div class="column">
                  <p>3. {{ $t("message.equipos_campamento") }}.</p>
                </div>
                <div class="column">
                  <div class="block">
                    <b-radio
                      :disabled="!editable"
                      v-model="form.equipos_campamento"
                      name="equipos_campamento"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
                      :disabled="!editable"
                      v-model="form.equipos_campamento"
                      name="equipos_campamento"
                      native-value="N"
                    >
                      {{ $t("message.no") }}
                    </b-radio>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
    <div v-show="editable" class="container">
      <section class="hero">
        <div class="hero-body">
          <b-button type="is-info" @click="confirmarDeclaracion">
            {{ $t("message.confirmar_declaracion") }}
          </b-button>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    editable: {
      type: Boolean,
      required: false,
      default: true,
    },
    value: {
      type: Object,
      required: false,
      default: function () {
        return {
          apellidos: "",
          nombres: "",
          numero_identificacion: "",
          telefono: "",
          correo_electronico: "",
          lugar_residencia: "",
          nacionalidad: "",
          direccion_domicilio: "",
          linea_aerea: "",
          numero_vuelo: "",
          aeropuerto_origen: "",
          alimentos_procesados: "N",
          lugares_concentracion: "N",
          equipos_campamento: "N",
          fecha: new Date(),
          productos: [],
        };
      },
    },
  },
  data: function () {
    return {
      form: this.value,
      errores: {
        apellidos: undefined,
        nombres: undefined,
        numero_identificacion: undefined,
        telefono: undefined,
        correo_electronico: undefined,
        lugar_residencia: undefined,
        nacionalidad: undefined,
        direccion_domicilio: undefined,
        linea_aerea: undefined,
        numero_vuelo: undefined,
        aeropuerto_origen: undefined,
        fecha: undefined,
      },
      productos: [],
    };
  },
  methods: {
    cargarProductos: function (name) {
      this.$http
        .get(process.env.MIX_APP_URL_API + "/productos/search", {
          params: {
            search: name,
          },
        })
        .then(({ data }) => {
          this.productos = data;
        });
    },
    limpiarErrores: function () {
      this.errores.apellidos = undefined;
      this.errores.nombres = undefined;
      this.errores.numero_identificacion = undefined;
      this.errores.telefono = undefined;
      this.errores.correo_electronico = undefined;
      this.errores.lugar_residencia = undefined;
      this.errores.nacionalidad = undefined;
      this.errores.direccion_domicilio = undefined;
      this.errores.linea_aerea = undefined;
      this.errores.numero_vuelo = undefined;
      this.errores.aeropuerto_origen = undefined;
      this.errores.fecha = undefined;
    },
    limpiarFormulario: function () {
      this.form.productos.splice(0, this.form.productos.length);
      this.form.apellidos = "";
      this.form.nombres = "";
      this.form.numero_identificacion = "";
      this.form.telefono = "";
      this.form.correo_electronico = "";
      this.form.lugar_residencia = "";
      this.form.nacionalidad = "";
      this.form.direccion_domicilio = "";
      this.form.linea_aerea = "";
      this.form.numero_vuelo = "";
      this.form.aeropuerto_origen = "";
      this.form.alimentos_procesados = "N";
      this.form.lugares_concentracion = "N";
      this.form.equipos_campamento = "N";
      this.form.fecha = new Date();
      this.limpiarErrores();
    },
    confirmarDeclaracion: function () {
      this.$buefy.dialog.confirm({
        cancelText: this.$t("message.no"),
        confirmText: this.$t("message.si"),
        message: this.$t("message.confirmacion_declaracion"),
        onConfirm: () => {
          let path = process.env.MIX_APP_URL_API + "/declaracion-juramentada";
          this.$http
            .post(path, this.form)
            .then(() => {
              this.$buefy.toast.open({
                message: this.$t("message.guardado_generico"),
                type: "is-success",
              });
              this.limpiarFormulario();
            })
            .catch(({ response }) => {
              let status = response.status;
              if (status === 422) {
                this.errores.apellidos = response.data.errors.apellidos;
                this.errores.nombres = response.data.errors.nombres;
                this.errores.numero_identificacion =
                  response.data.errors.numero_identificacion;
                this.errores.telefono = response.data.errors.telefono;
                this.errores.correo_electronico =
                  response.data.errors.correo_electronico;
                this.errores.lugar_residencia =
                  response.data.errors.lugar_residencia;
                this.errores.nacionalidad = response.data.errors.nacionalidad;
                this.errores.direccion_domicilio =
                  response.data.errors.direccion_domicilio;
                this.errores.linea_aerea = response.data.errors.linea_aerea;
                this.errores.numero_vuelo = response.data.errors.numero_vuelo;
                this.errores.aeropuerto_origen =
                  response.data.errors.aeropuerto_origen;
                this.errores.fecha = response.data.errors.fecha;
              } else {
                this.$buefy.toast.open({
                  message: this.$t("message.generic_error"),
                  type: "is-danger",
                });
              }
            });
        },
      });
    },
  },
  watch: {
    value: function (value) {
      this.form = value;
    },
  },
};
</script>
