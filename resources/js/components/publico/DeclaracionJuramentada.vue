<template>
  <div>
    <section class="hero is-small is-primary">
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
                <b-input v-model="form.numero_identificacion"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.apellidos ? errores.apellidos[0] : ''"
                :type="errores.apellidos ? 'is-danger' : ''"
                :label="$t('etiqueta.apellidos')"
              >
                <b-input v-model="form.apellidos"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.nombres ? errores.nombres[0] : ''"
                :type="errores.nombres ? 'is-danger' : ''"
                :label="$t('etiqueta.nombres')"
              >
                <b-input v-model="form.nombres"></b-input>
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
                <b-input v-model="form.nacionalidad"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.telefono ? errores.telefono[0] : ''"
                :type="errores.telefono ? 'is-danger' : ''"
                :label="$t('etiqueta.telefono')"
              >
                <b-input v-model="form.telefono"></b-input>
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
                <b-input v-model="form.correo_electronico"></b-input>
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
                <b-input v-model="form.lugar_residencia"></b-input>
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
                <b-input v-model="form.direccion_domicilio"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field
                :message="errores.linea_aerea ? errores.linea_aerea[0] : ''"
                :type="errores.linea_aerea ? 'is-danger' : ''"
                :label="$t('etiqueta.linea_aerea')"
              >
                <b-input v-model="form.linea_aerea"></b-input>
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
                <b-input v-model="form.numero_vuelo"></b-input>
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
                <b-input v-model="form.aeropuerto_origen"></b-input>
              </b-field>
            </div>
            <div class="column">
              <b-field :label="$t('etiqueta.fecha')">
                <b-datepicker
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
                      v-model="form.alimentos_procesados"
                      name="alimentos_procesados"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
                      v-model="form.alimentos_procesados"
                      name="alimentos_procesados"
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
                  <p>2. {{ $t("message.lugares_concentracion") }}.</p>
                </div>
                <div class="column">
                  <div class="block">
                    <b-radio
                      v-model="form.lugares_concentracion"
                      name="lugares_concentracion"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
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
                      v-model="form.equipos_campamento"
                      name="equipos_campamento"
                      native-value="S"
                    >
                      {{ $t("message.si") }}
                    </b-radio>
                    <b-radio
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
    <div class="container">
      <section class="hero">
        <div class="hero-body">
          <b-button type="is-primary" @click="confirmarDeclaracion">
            {{ $t("message.confirmar_declaracion") }}
          </b-button>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      form: {
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
        alimentos_procesados: "",
        lugares_concentracion: "",
        equipos_campamento: "",
        fecha: new Date(),
      },
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
      },
    };
  },
  methods: {
    confirmarDeclaracion: function () {},
    clearDate: function () {
      this.form.fecha = null;
    },
  },
};
</script>
