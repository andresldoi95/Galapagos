<template>
  <tr>
    <td>
      <b-field>
        <b-autocomplete
          clearable
          :data="productos"
          :placeholder="$t('message.seleccione')"
          field="descripcion"
          :loading="isFetching"
          @typing="cargarProductos"
          @select="selectedProducto"
          v-model="productoSeleccionado"
        >
          <template slot-scope="props">
            <div class="media">
              <div class="media-left">
                <img
                  width="32"
                  :src="
                    props.option.url_foto != null
                      ? props.option.url_foto
                      : '/img/sin-imagen.jpg'
                  "
                />
              </div>
              <div class="media-content">
                {{ props.option.descripcion }}
              </div>
            </div>
          </template>
        </b-autocomplete>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-input v-model="modelValue.observacion"></b-input>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-input v-model="modelValue.cantidad"></b-input>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-input v-model="modelValue.peso"></b-input>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-input v-model="modelValue.unidad"></b-input>
      </b-field>
    </td>
    <td>
      {{ modelValue.categoria }}
    </td>
    <td>
      <b-field>
        <b-select
          v-model="modelValue.razon_retencion"
          :placeholder="$t('message.seleccione')"
          expanded
        >
          <option value="PL">PL</option>
          <option value="ME">ME</option>
          <option value="SR">SR</option>
          <option value="NP">NP</option>
        </b-select>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-select
          v-model="modelValue.destino_producto"
          :placeholder="$t('message.seleccione')"
          expanded
        >
          <option value="INC">INC</option>
          <option value="TTO">TTO</option>
          <option value="DEV/OR">DEV/OR</option>
          <option value="DEV">DEV</option>
        </b-select>
      </b-field>
    </td>
    <td>
      <b-field>
        <b-select
          v-model="modelValue.transportado_en"
          :placeholder="$t('message.seleccione')"
          expanded
        >
          <option value="C">C</option>
          <option value="EA">EA</option>
          <option value="ENA">ENA</option>
          <option value="V">MT</option>
        </b-select>
      </b-field>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    value: {
      type: Object,
      required: false,
      default: function () {
        return {
          producto_id: "",
          nombre_producto: "",
          cantidad: 1,
          peso: 0,
          categoria: "",
          razon_retencion: "",
          destino_producto: "",
          transportado_en: "",
          observacion: "",
          unidad: "",
        };
      },
    },
  },
  methods: {
    cargarProductos: function (name) {
      this.isFetching = true;
      this.$http
        .get(process.env.MIX_APP_URL_API + "/productos/search", {
          params: {
            search: name,
          },
        })
        .then(({ data }) => {
          this.productos = data;
          this.isFetching = false;
        })
        .catch(() => {
          this.isFetching = false;
        });
    },
    selectedProducto: function (producto) {
      if (producto != null) {
        (this.modelValue.nombre_producto = producto.descripcion),
          (this.modelValue.producto_id = producto.id);
        this.modelValue.categoria = producto.categoria;
      } else {
        this.modelValue.nombre_producto = "";
        this.modelValue.producto_id = "";
        this.modelValue.categoria = "";
      }
    },
  },
  data: function () {
    return {
      productos: [],
      isFetching: false,
      modelValue: this.value,
      productoSeleccionado: "",
    };
  },
  mounted: function () {
    this.productoSeleccionado = this.modelValue.nombre_producto;
  },
};
</script>
