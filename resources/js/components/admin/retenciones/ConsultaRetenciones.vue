<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">{{ $t("title.retenciones") }}</h1>
        <masterForm
          exportableExcel
          filterByDate
          @exportar="exportar"
          @realizarAccion="realizarAccion"
          :createButton="false"
          :editable="false"
          @editar="editar"
          sortOrderDefault="desc"
          sortByDefault="created_at"
          ref="masterForm"
          resource="/api/registro-retencion"
          :columns="[
            {
              label: $t('message.numero_documento'),
              field: 'numero_documento',
              sortable: true,
            },
            {
              label: $t('etiqueta.nombre_completo'),
              field: 'nombre_completo',
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
          <registro-retencion
            ref="registroRetencion"
            @input="inputRetencion"
            v-model="selectedRetencion"
          ></registro-retencion>
        </masterForm>
      </div>
    </div>
  </section>
</template>

<script>
import queryString from "query-string";
import MasterForm from "../../layouts/MasterForm.vue";
import RegistroRetencion from "./RegistroRetencion.vue";
export default {
  components: {
    RegistroRetencion,
  },
  data: function () {
    return {
      selectedRetencion: {
        foto: null,
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
        id: "",
        numero_documento: "",
        _method: undefined,
      },
    };
  },
  components: {
    MasterForm,
    RegistroRetencion,
  },
  methods: {
    exportar: function (form) {
      form.desde = this.$moment(form.desde).format("YYYY-MM-DD");
      form.hasta = this.$moment(form.hasta).format("YYYY-MM-DD");
      let params = queryString.stringify(form);
      let urlRedirect =
        process.env.MIX_APP_URL + "/exportar/retenciones?" + params;
      window.open(urlRedirect, "_blank");
    },
    inputRetencion: function () {
      this.$refs.masterForm.submit();
    },
    editar: function (row) {
      if (row.url_foto != null)
        this.$refs.registroRetencion.imagenActual = row.url_foto;
      else this.$refs.registroRetencion.imagenActual = "/img/sin-imagen.jpg";
      if (row.url_foto2 != null)
        this.$refs.registroRetencion.imagenActual2 = row.url_foto2;
      else this.$refs.registroRetencion.imagenActual2 = "/img/sin-imagen.jpg";
      this.selectedRetencion._method = "PUT";
      this.selectedRetencion.id = row.id;
      this.selectedRetencion.numero_documento = row.numero_documento;
      this.selectedRetencion.fecha_inspeccion = new Date(row.fecha_inspeccion);
      this.selectedRetencion.retencion = row.retencion === "S";
      this.selectedRetencion.rechazo = row.rechazo === "S";
      this.selectedRetencion.fecha = new Date(row.fecha);
      this.selectedRetencion.lugar = row.lugar;
      this.selectedRetencion.tipo_transporte = row.tipo_transporte;
      this.selectedRetencion.nombre_transporte = row.nombre_transporte;
      this.selectedRetencion.destino = row.destino;
      this.selectedRetencion.procedencia = row.procedencia;
      this.selectedRetencion.inspeccion_origen = row.inspeccion_origen;
      this.selectedRetencion.inspector_responsable = row.inspector_responsable;
      this.selectedRetencion.numero_guia_sanitaria = row.numero_guia_sanitaria;
      this.selectedRetencion.numero_candado = row.numero_candado;
      this.selectedRetencion.nombre_completo = row.nombre_completo;
      this.selectedRetencion.direccion = row.direccion;
      this.selectedRetencion.numero_identificacion = row.numero_identificacion;
      this.selectedRetencion.tipo_residencia = row.tipo_residencia;
      this.selectedRetencion.observaciones = row.observaciones;
      this.selectedRetencion.numero_guia_transporte =
        row.numero_guia_transporte;
      this.selectedRetencion.porcentaje_mal_estado = row.porcentaje_mal_estado;
      this.selectedRetencion.porcentaje_plagados = row.porcentaje_plagados;
      this.selectedRetencion.retencion_patio = row.retencion_patio;
      this.selectedRetencion.nombre_inspector_responsable =
        row.nombre_inspector_responsable;
      this.selectedRetencion.identificacion_inspector_responsable =
        row.identificacion_inspector_responsable;
      this.selectedRetencion.nombre_testigo = row.nombre_testigo;
      this.selectedRetencion.identificacion_testigo =
        row.identificacion_testigo;
      this.selectedRetencion.productos.splice(
        0,
        this.selectedRetencion.productos.length
      );
      for (let i = 0; i < row.productos.length; i++) {
        this.selectedRetencion.productos.push({
          producto_id: row.productos[i].producto_id,
          nombre_producto: row.productos[i].producto.descripcion,
          peso: row.productos[i].peso,
          categoria: row.productos[i].categoria,
          razon_retencion: row.productos[i].razon_retencion,
          destino_producto: row.productos[i].destino_producto,
          transportado_en: row.productos[i].transportado_en,
          cantidad: row.productos[i].cantidad,
          unidad: row.productos[i].unidad,
          observacion: row.productos[i].observacion,
        });
      }
    },
    realizarAccion: function (estado, retenciones) {
      let retencionesId = [];
      for (let i = 0; i < retenciones.length; i++)
        retencionesId.push(retenciones[i].id);
      this.$http
        .post(process.env.MIX_APP_URL_API + "/registro-retencion", {
          retenciones: retencionesId,
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
