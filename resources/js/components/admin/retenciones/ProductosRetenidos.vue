<template>
  <div class="b-table">
    <div class="table-wrapper has-mobile-cards">
      <table class="table">
        <thead>
          <tr>
            <th width="25%">{{ $t("etiqueta.producto") }}</th>
            <th>{{ $t("etiqueta.observacion") }}</th>
            <th>{{ $t("etiqueta.cantidad") }}</th>
            <th>{{ $t("etiqueta.peso") }}</th>
            <th>{{ $t("etiqueta.unidad") }}</th>
            <th>{{ $t("etiqueta.categoria") }}</th>
            <th>{{ $t("etiqueta.razon_retencion") }}</th>
            <th>{{ $t("etiqueta.destino_producto") }}</th>
            <th>{{ $t("etiqueta.transportado_en") }}</th>
            <th>
              <b-button
                icon-left="plus"
                type="is-success"
                @click="agregar"
              ></b-button>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-model="productos[index]"
            is="tr-producto-retenido"
            v-for="(producto, index) in productos"
            :key="index"
          ></tr>
          <tr v-show="productos.length === 0">
            <td colspan="8">
              <strong>{{ $t("message.no_agregado") }}</strong>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import TrProductoRetenido from "./TrProductoRetenido.vue";
export default {
  components: {
    TrProductoRetenido,
  },
  props: {
    value: {
      type: Array,
      required: false,
      default: function () {
        return [];
      },
    },
  },
  data: function () {
    return {
      productos: this.value,
    };
  },
  methods: {
    agregar: function () {
      this.productos.push({
        producto_id: "",
        nombre_producto: "",
        cantidad: 1,
        peso: 0,
        categoria: "",
        razon_retencion: "",
        destino_producto: "",
        transportado_en: "",
        unidad: "",
        observacion: "",
      });
    },
  },
};
</script>
