<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t("title.declaraciones_juramentadas") }}</h1>
        <masterForm
          @realizarAccion="realizarAccion"
          :createButton="false"
          :editable="false"
          @editar="editar"
          sortOrderDefault="desc"
          sortByDefault="created_at"
          ref="masterForm"
          resource="/api/declaraciones-juramentadas"
          :columns="[
            {
              label: $t('message.codigo'),
              field: 'codigo',
              sortable: true,
            },
            {
              label: $t('etiqueta.nombres'),
              field: 'nombres',
              sortable: true,
            },
            {
              label: $t('etiqueta.apellidos'),
              field: 'apellidos',
              sortable: true,
            },
            {
              label: $t('etiqueta.numero_identificacion'),
              field: 'numero_identificacion',
              sortable: true,
            },
            {
              label: $t('etiqueta.fecha'),
              field: 'fecha',
              sortable: true,
            },
            {
              label: $t('message.created_at'),
              field: 'created_at',
              sortable: true,
            },
            {
              label: $t('message.status'),
              field: 'estado',
              sortable: true,
            },
          ]"
        >
          <declaracion-juramentada
            v-model="selectedDeclaracion"
            :editable="false"
          ></declaracion-juramentada>
        </masterForm>
      </div>
    </div>
  </section>
</template>

<script>
import MasterForm from "../layouts/MasterForm.vue";
import DeclaracionJuramentada from "../publico/DeclaracionJuramentada.vue";
export default {
  data: function () {
    return {
      selectedDeclaracion: {
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
      },
    };
  },
  components: {
    MasterForm,
    DeclaracionJuramentada,
  },
  methods: {
    editar: function (row) {
      this.selectedDeclaracion.nombres = row.nombres;
      this.selectedDeclaracion.apellidos = row.apellidos;
      this.selectedDeclaracion.numero_identificacion =
        row.numero_identificacion;
      this.selectedDeclaracion.telefono = row.telefono;
      this.selectedDeclaracion.correo_electronico = row.correo_electronico;
      this.selectedDeclaracion.lugar_residencia = row.lugar_residencia;
      this.selectedDeclaracion.nacionalidad = row.nacionalidad;
      this.selectedDeclaracion.direccion_domicilio = row.direccion_domicilio;
      this.selectedDeclaracion.linea_aerea = row.linea_aerea;
      this.selectedDeclaracion.numero_vuelo = row.numero_vuelo;
      this.selectedDeclaracion.aeropuerto_origen = row.aeropuerto_origen;
      this.selectedDeclaracion.alimentos_procesados = row.alimentos_procesados;
      this.selectedDeclaracion.lugares_concentracion =
        row.lugares_concentracion;
      this.selectedDeclaracion.equipos_campamento = row.equipos_campamento;
      this.selectedDeclaracion.fecha = new Date(row.fecha);
      this.selectedDeclaracion.productos.splice(
        0,
        this.selectedDeclaracion.productos.length
      );
    },
    realizarAccion: function (estado, declaraciones) {
      let declaracionesId = [];
      for (let i = 0; i < declaraciones.length; i++)
        declaracionesId.push(declaraciones[i].id);
      this.$http
        .post(process.env.MIX_APP_URL_API + "/declaraciones-juramentadas", {
          declaraciones: declaracionesId,
          _method: "DELETE",
          estado: estado,
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
    },
  },
};
</script>
