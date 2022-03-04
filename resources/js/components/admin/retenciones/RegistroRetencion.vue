<template>
  <div>
    <section class="hero is-small is-info">
      <div class="hero-body">
        <h1 class="title">
          {{ $t("title.registro_retencion") }} {{ form.numero_documento }}
        </h1>
        <h2 class="subtitle">{{ $t("message.registro_retencion") }}</h2>
      </div>
    </section>
    <section>
      <div v-show="form.id != null && form.id != ''" class="container mt-2">
        <div class="row">
          <div class="columns">
            <div class="column">
              <b-button type="is-danger" @click="imprimir">
                {{ $t("message.imprimir") }}
              </b-button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <div v-show="form.id === ''" class="columns">
            <div class="column">
              <b-field :label="$t('etiqueta.numero_declaracion_cedula')">
                <b-input v-model="numero_declaracion"></b-input>
                <b-button
                  icon-left="check"
                  type="is-success"
                  @click="consultarDeclaracion"
                ></b-button>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field :label="$t('etiqueta.tipo')">
                <div class="block">
                  <b-checkbox v-model="form.retencion">
                    {{ $t("etiqueta.retencion") }}
                  </b-checkbox>
                  <b-checkbox v-model="form.rechazo">
                    {{ $t("etiqueta.rechazo") }}
                  </b-checkbox>
                </div>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.lugar ? errores.lugar[0] : ''"
                :type="errores.lugar ? 'is-danger' : ''"
                :label="$t('etiqueta.lugar')"
              >
                <b-select
                  v-model="form.lugar"
                  :placeholder="$t('message.seleccione')"
                  expanded
                >
                  <option value="B">B</option>
                  <option value="F">F</option>
                  <option value="I">I</option>
                  <option value="SC">SC</option>
                  <option value="SX">SX</option>
                  <option value="G">G</option>
                  <option value="Q">Q</option>
                </b-select>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.tipo_transporte ? errores.tipo_transporte[0] : ''
                "
                :type="errores.tipo_transporte ? 'is-danger' : ''"
                :label="$t('etiqueta.tipo_transporte')"
              >
                <b-select
                  v-model="form.tipo_transporte"
                  :placeholder="$t('message.seleccione')"
                  expanded
                >
                  <option value="ME">
                    {{ $t("message.maritimo_exterior") }}
                  </option>
                  <option value="MC">
                    {{ $t("message.maritimo_continente") }}
                  </option>
                  <option value="MI">
                    {{ $t("message.maritimo_interista") }}
                  </option>
                  <option value="AE">{{ $t("message.aereo_exterior") }}</option>
                  <option value="AC">
                    {{ $t("message.aereo_continente") }}
                  </option>
                  <option value="AI">
                    {{ $t("message.aereo_interista") }}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.nombre_transporte ? errores.nombre_transporte[0] : ''
                "
                :type="errores.nombre_transporte ? 'is-danger' : ''"
                :label="$t('etiqueta.nombre_transporte')"
              >
                <b-input v-model="form.nombre_transporte"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="errores.destino ? errores.destino[0] : ''"
                :type="errores.destino ? 'is-danger' : ''"
                :label="$t('etiqueta.destino')"
              >
                <b-input v-model="form.destino"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.procedencia ? errores.procedencia[0] : ''"
                :type="errores.procedencia ? 'is-danger' : ''"
                :label="$t('etiqueta.procedencia')"
              >
                <b-input v-model="form.procedencia"></b-input>
              </b-field>
            </div>
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
                <b-input v-model="form.numero_identificacion"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.nombre_completo ? errores.nombre_completo[0] : ''
                "
                :type="errores.nombre_completo ? 'is-danger' : ''"
                :label="$t('etiqueta.nombre_completo')"
              >
                <b-input v-model="form.nombre_completo"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="errores.direccion ? errores.direccion[0] : ''"
                :type="errores.direccion ? 'is-danger' : ''"
                :label="$t('etiqueta.direccion')"
              >
                <b-input v-model="form.direccion"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field :label="$t('etiqueta.tipo_residencia')">
                <div class="block">
                  <b-radio native-value="R" v-model="form.tipo_residencia">
                    {{ $t("etiqueta.residente") }}
                  </b-radio>
                  <b-radio native-value="N" v-model="form.tipo_residencia">
                    {{ $t("etiqueta.nacional") }}
                  </b-radio>
                  <b-radio native-value="E" v-model="form.tipo_residencia">
                    {{ $t("etiqueta.extranjero") }}
                  </b-radio>
                </div>
              </b-field>
            </div>
            <div class="column">
              <b-field :label="$t('etiqueta.fecha_hora')">
                <b-datetimepicker
                  v-model="form.fecha"
                  :placeholder="$t('message.seleccione')"
                  icon="calendar-today"
                  icon-right-clickable
                  trap-focus
                  locale="es-ES"
                >
                </b-datetimepicker>
              </b-field>
            </div>
          </div>
          <!-- <div class="columns">
            <div class="column">
              <b-field :label="$t('etiqueta.inspeccion_origen')">
                <div class="block">
                  <b-radio native-value="S" v-model="form.inspeccion_origen">
                    {{ $t("message.si") }}
                  </b-radio>
                  <b-radio native-value="N" v-model="form.inspeccion_origen">
                    {{ $t("message.no") }}
                  </b-radio>
                </div>
              </b-field>
            </div>
          </div> -->
          <div class="columns">
            <!-- <div class="column">
              <b-field
                :message="
                  errores.inspector_responsable
                    ? errores.inspector_responsable[0]
                    : ''
                "
                :type="errores.inspector_responsable ? 'is-danger' : ''"
                :label="$t('etiqueta.inspector_responsable')"
              >
                <b-input v-model="form.inspector_responsable"></b-input>
              </b-field>
            </div> -->
            <!-- <div class="column">
              <b-field :label="$t('etiqueta.fecha_inspeccion')">
                <b-datepicker
                  v-model="form.fecha_inspeccion"
                  icon="calendar-today"
                  placeholder="DD/MM/YYYY"
                  trap-focus
                  locale="es-ES"
                >
                </b-datepicker>
              </b-field>
            </div> -->
            <!-- <div class="column">
              <b-field
                :message="
                  errores.numero_guia_sanitaria
                    ? errores.numero_guia_sanitaria[0]
                    : ''
                "
                :type="errores.numero_guia_sanitaria ? 'is-danger' : ''"
                :label="$t('etiqueta.numero_guia_sanitaria')"
              >
                <b-input v-model="form.numero_guia_sanitaria"></b-input>
              </b-field>
            </div> -->
            <div class="column is-one-third">
              <b-field
                :message="
                  errores.numero_candado ? errores.numero_candado[0] : ''
                "
                :type="errores.numero_candado ? 'is-danger' : ''"
                :label="$t('etiqueta.numero_candado')"
              >
                <b-input v-model="form.numero_candado"></b-input>
              </b-field>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column">
              <productos-retenidos
                v-model="form.productos"
              ></productos-retenidos>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column">
              <b-field
                :message="
                  errores.nombre_inspector_responsable
                    ? errores.nombre_inspector_responsable[0]
                    : ''
                "
                :type="errores.nombre_inspector_responsable ? 'is-danger' : ''"
                :label="$t('etiqueta.nombre_inspector_responsable')"
              >
                <b-input
                  readonly
                  v-model="form.nombre_inspector_responsable"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.identificacion_inspector_responsable
                    ? errores.identificacion_inspector_responsable[0]
                    : ''
                "
                :type="
                  errores.identificacion_inspector_responsable
                    ? 'is-danger'
                    : ''
                "
                :label="$t('etiqueta.identificacion_inspector_responsable')"
              >
                <b-input
                  readonly
                  v-model="form.identificacion_inspector_responsable"
                ></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.nombre_testigo ? errores.nombre_testigo[0] : ''
                "
                :type="errores.nombre_testigo ? 'is-danger' : ''"
                :label="$t('etiqueta.nombre_testigo')"
              >
                <b-input v-model="form.nombre_testigo"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.identificacion_testigo
                    ? errores.identificacion_testigo[0]
                    : ''
                "
                :type="errores.identificacion_testigo ? 'is-danger' : ''"
                :label="$t('etiqueta.identificacion_testigo')"
              >
                <b-input v-model="form.identificacion_testigo"></b-input>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                :message="errores.observaciones ? errores.observaciones[0] : ''"
                :type="errores.observaciones ? 'is-danger' : ''"
                :label="$t('etiqueta.observaciones')"
              >
                <b-input
                  maxlength="500"
                  type="textarea"
                  v-model="form.observaciones"
                ></b-input>
              </b-field>
            </div>
            <!-- <div class="column">
              <b-field
                :message="
                  errores.numero_guia_transporte
                    ? errores.numero_guia_transporte[0]
                    : ''
                "
                :type="errores.numero_guia_transporte ? 'is-danger' : ''"
                :label="$t('etiqueta.numero_guia_transporte')"
              >
                <b-input v-model="form.numero_guia_transporte"></b-input>
              </b-field>
            </div> -->
            <div class="column">
              <b-field
                :message="
                  errores.porcentaje_mal_estado
                    ? errores.porcentaje_mal_estado[0]
                    : ''
                "
                :type="errores.porcentaje_mal_estado ? 'is-danger' : ''"
                :label="$t('etiqueta.porcentaje_mal_estado')"
              >
                <b-input v-model="form.porcentaje_mal_estado"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="
                  errores.porcentaje_plagados
                    ? errores.porcentaje_plagados[0]
                    : ''
                "
                :type="errores.porcentaje_plagados ? 'is-danger' : ''"
                :label="$t('etiqueta.porcentaje_plagados')"
              >
                <b-input v-model="form.porcentaje_plagados"></b-input>
              </b-field>
            </div>
          </div>
          <!-- <div class="columns">
            <div class="column">
              <b-field :label="$t('etiqueta.retencion_patio')">
                <div class="block">
                  <b-radio native-value="S" v-model="form.retencion_patio">
                    {{ $t("message.si") }}
                  </b-radio>
                  <b-radio native-value="N" v-model="form.retencion_patio">
                    {{ $t("message.no") }}
                  </b-radio>
                </div>
              </b-field>
            </div>
          </div> -->
          <div class="columns">
            <div class="column">
              <b-field>
                <b-upload
                  @input="inputFoto"
                  accept="image/*"
                  v-model="form.foto"
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
              <div v-if="form.foto != null" class="tags">
                <span class="tag is-primary">
                  {{ form.foto.name }}
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
            <div class="column">
              <b-field>
                <b-upload
                  @input="inputFoto2"
                  accept="image/*"
                  v-model="form.foto2"
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
              <div v-if="form.foto2 != null" class="tags">
                <span class="tag is-primary">
                  {{ form.foto2.name }}
                  <button
                    class="delete is-small"
                    type="button"
                    @click="quitarArchivo2"
                  ></button>
                </span>
              </div>
            </div>
            <div class="column">
              <b-image :src="imagenActual2" alt="Imagen" ratio="6by4"></b-image>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <b-button type="is-info" @click="registrarRetencion">
            {{ $t("message.registrar_retencion") }}
          </b-button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import ProductosRetenidos from "./ProductosRetenidos.vue";
import { serialize } from 'object-to-formdata';
export default {
  props: {
    value: {
      type: Object,
      required: false,
      default: function () {
        return {
            foto2: null,
          fecha_inspeccion: null,
          retencion: false,
          rechazo: false,
          fecha: new Date(),
          lugar: "",
          tipo_transporte: "",
          nombre_transporte: "",
          destino: "",
          procedencia: "",
          inspeccion_origen: "N",
          inspector_responsable: "",
          numero_guia_sanitaria: "",
          numero_candado: "",
          nombre_completo: "",
          direccion: "",
          numero_identificacion: "",
          tipo_residencia: "",
          observaciones: "",
          numero_guia_transporte: "",
          porcentaje_mal_estado: 0,
          porcentaje_plagados: 0,
          retencion_patio: "N",
          nombre_inspector_responsable: "",
          identificacion_inspector_responsable: "",
          nombre_testigo: "",
          identificacion_testigo: "",
          productos: [],
          numero_documento: "",
          id: "",
          _method: undefined,
          foto: null,
        };
      },
    },
  },
  components: {
    ProductosRetenidos,
  },
  methods: {
    quitarArchivo: function () {
      this.form.foto = null;
      this.imagenActual = "/img/sin-imagen.jpg";
    },
    quitarArchivo2: function () {
      this.form.foto2 = null;
      this.imagenActual2 = "/img/sin-imagen.jpg";
    },
    inputFoto: function () {
      if (this.form.foto != null) {
        let reader = new FileReader();
        reader.readAsDataURL(this.form.foto);
        let that = this;
        reader.onload = function () {
          that.imagenActual = reader.result;
        };
      } else this.imagenActual = "/img/sin-imagen.jpg";
    },
    inputFoto2: function () {
      if (this.form.foto2 != null) {
        let reader = new FileReader();
        reader.readAsDataURL(this.form.foto2);
        let that = this;
        reader.onload = function () {
          that.imagenActual2 = reader.result;
        };
      } else this.imagenActual2 = "/img/sin-imagen.jpg";
    },
    imprimir: function () {
      let url =
        process.env.MIX_APP_URL + "/exportar/" + this.form.id + "/retencion";
      window.open(url, "_blank");
    },
    consultarDeclaracion: function () {
      this.isFetching = true;
      this.$http
        .get(
          process.env.MIX_APP_URL_API +
            "/declaraciones-juramentadas/" +
            this.numero_declaracion
        )
        .then(({ data }) => {
          this.form.numero_identificacion = data.numero_identificacion;
          this.form.direccion = data.direccion_domicilio;
          this.form.procedencia = data.aeropuerto_origen;
          this.form.nombre_completo = data.apellidos + " " + data.nombres;
          this.form.nombre_transporte = data.linea_aerea;
          for (let i = 0; i < data.productos.length; i++) {
            this.form.productos.push({
              producto_id: data.productos[i].id,
              nombre_producto: data.productos[i].descripcion,
              peso: 0,
              categoria: data.productos[i].categoria,
              razon_retencion: "",
              destino_producto: "",
              transportado_en: "",
              cantidad: 1,
            });
          }
        })
        .catch(() => {
          this.$buefy.toast.open({
            message: this.$t("message.declaracion_no_existente"),
            type: "is-danger",
          });
        });
    },
    limpiarFormulario: function () {
      this.form._method = undefined;
      this.form.id = "";
      this.form.numero_documento = "";
      this.form.lugar = "";
      this.form.tipo_transporte = "";
      this.form.nombre_transporte = "";
      this.form.destino = "";
      this.form.procedencia = "";
      this.form.fecha = new Date();
      this.form.retencion = false;
      this.form.rechazo = false;
      this.form.inspeccion_origen = "N";
      (this.form.inspector_responsable = ""),
        (this.form.fecha_inspeccion = null);
      this.form.numero_guia_sanitaria = "";
      this.form.numero_candado = "";
      this.form.nombre_completo = "";
      this.form.direccion = "";
      this.form.numero_identificacion = "";
      this.form.tipo_residencia = "";
      this.form.observaciones = "";
      this.form.numero_guia_transporte = "";
      this.form.porcentaje_mal_estado = 0;
      this.form.porcentaje_plagados = 0;
      this.form.retencion_patio = "N";
      this.form.nombre_inspector_responsable = "";
      this.form.identificacion_inspector_responsable = "";
      (this.form.nombre_testigo = ""), (this.form.identificacion_testigo = "");
      this.form.productos.splice(0, this.form.productos.length);
      this.errores = {};
    },
    registrarRetencion: function () {
      if (this.form.productos.length === 0) {
        this.$buefy.toast.open({
          message: this.$t("message.registrar_items"),
          type: "is-warning",
        });
        return;
      }
      for (let i = 0; i < this.form.productos.length; i++) {
        let producto = this.form.productos[i];
        if (
          producto.producto_id == "" ||
          producto.producto_id == null ||
          producto.cantidad == "" ||
          parseFloat(producto.cantidad) == 0 ||
          producto.peso == "" ||
          parseFloat(producto.peso) == 0 ||
          producto.unidad == "" ||
          producto.razon_retencion == "" ||
          producto.destino_producto == "" ||
          producto.transportado_en == ""
        ) {
          this.$buefy.toast.open({
            message: this.$t("message.item_requerido"),
            type: "is-warning",
          });
          return;
        }
      }
      this.errores = {};
      this.$buefy.dialog.confirm({
        cancelText: this.$t("message.no"),
        confirmText: this.$t("message.si"),
        message: this.$t("message.confirmar_registro_retencion"),
        onConfirm: () => {
          let path = process.env.MIX_APP_URL_API + "/registro-retencion";
          if (this.form.id != "") {
            this.form._method = "PUT";
            path += "/" + this.form.id;
          } else {
            this.form._method = undefined;
          }
          this.$http({
                method: "post",
                url: path,
                data: serialize(this.form, {
                    indices: true
                }),
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(() => {
              this.$buefy.toast.open({
                message: this.$t("message.guardado_generico"),
                type: "is-success",
              });
              this.$emit("input", this.form);
              if (this.form.id == "") this.limpiarFormulario();
            })
            .catch(({ response }) => {
              let status = response.status;
              if (status === 422) {
                this.errores = response.data.errors;
                this.$buefy.toast.open({
                  message: this.$t("message.errores_formulario"),
                  type: "is-warning",
                });
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
  data: function () {
    return {
      imagenActual: "/img/sin-imagen.jpg",
      imagenActual2: "/img/sin-imagen.jpg",
      numero_declaracion: "",
      form: this.value,
      errores: {
        retencion: undefined,
        rechazo: undefined,
        fecha: undefined,
        lugar: undefined,
        tipo_transporte: undefined,
        nombre_transporte: undefined,
        destino: undefined,
        procedencia: undefined,
        inspeccion_origen: undefined,
        inspector_responsable: undefined,
        numero_guia_sanitaria: undefined,
        numero_candado: undefined,
        nombre_completo: undefined,
        direccion: undefined,
        numero_identificacion: undefined,
        tipo_residencia: undefined,
        observaciones: undefined,
        numero_guia_transporte: undefined,
        porcentaje_mal_estado: undefined,
        porcentaje_plagados: undefined,
        retencion_patio: undefined,
        nombre_inspector_responsable: undefined,
        identificacion_inspector_responsable: undefined,
        nombre_testigo: undefined,
        identificacion_testigo: undefined,
      },
    };
  },
  mounted: function () {
    let path = process.env.MIX_APP_URL_API + "/registro-retencion/datos";
    this.$http.get(path).then(({ data }) => {
      this.form.nombre_inspector_responsable = data.usuario.name;
      this.form.identificacion_inspector_responsable =
        data.usuario.numero_identificacion;
    });
  },
};
</script>
