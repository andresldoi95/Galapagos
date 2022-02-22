<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t("title.dashboard") }}</h1>
        <div class="columns">
          <div class="column">
            <b-datepicker
              v-model="form.desde"
              icon="calendar-today"
              placeholder="DD/MM/YYYY"
              trap-focus
              locale="es-ES"
            >
            </b-datepicker>
          </div>
          <div class="column">
            <b-datepicker
              v-model="form.hasta"
              icon="calendar-today"
              placeholder="DD/MM/YYYY"
              trap-focus
              locale="es-ES"
            >
            </b-datepicker>
          </div>
          <div class="column">
            <b-button type="is-info" @click="consultar" icon-left="magnify">
            </b-button>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <strong>Registros totales</strong>
            <column-chart :data="registrosTotales"></column-chart>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <strong>Alimentos o productos/organismos adicionales</strong>
            <pie-chart :data="alimentosProcesados"></pie-chart>
          </div>
          <div class="column">
            <strong> Lugares de concentración de animales </strong>
            <pie-chart :data="lugaresConcentracion"></pie-chart>
          </div>
          <div class="column">
            <strong>Equipos de campamento</strong>
            <pie-chart :data="equiposCampamento"></pie-chart>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <strong>Top 10 de productos/organismos más llevados</strong>
            <bar-chart :data="top10"></bar-chart>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data: function () {
    return {
      form: {
        desde: new Date(),
        hasta: new Date(),
      },
      registrosTotales: [],
      alimentosProcesados: [],
      lugaresConcentracion: [],
      equiposCampamento: [],
      top10: [],
    };
  },
  methods: {
    consultar: function () {
      let path = process.env.MIX_APP_URL_API + "/dashboard";
      this.$http
        .get(path, {
          params: this.form,
        })
        .then(({ data }) => {
          this.registrosTotales = data.registrosTotales;
          this.alimentosProcesados = data.alimentosProcesados;
          this.lugaresConcentracion = data.lugaresConcentracion;
          this.equiposCampamento = data.equiposCampamento;
          this.top10 = data.top10;
        });
    },
  },
  mounted: function () {
    this.consultar();
  },
};
</script>
