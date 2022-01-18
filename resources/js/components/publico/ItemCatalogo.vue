<template>
  <section class="hero">
    <div class="hero-body">
      <h3 class="title">{{ descripcionCategoria }}</h3>
      <div class="container">
        <div class="columns">
          <div
            class="column is-one-quarter"
            v-for="producto in productos"
            :key="producto.id"
          >
            <div class="card">
              <div class="card-image">
                <figure class="image is-5by4">
                  <a @click="verProducto(producto)"
                    ><img
                      :src="
                        producto.url_foto == null
                          ? '/img/sin-imagen.jpg'
                          : producto.url_foto
                      "
                      :alt="producto.descripcion"
                  /></a>
                </figure>
              </div>
              <div class="card-content">
                <div class="content">
                  <p class="title is-6">
                    {{ producto.descripcion }} ({{ producto.codigo }})
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="column" v-show="productos.length === 0">
            <p>
              <strong>{{ $t("message.no_results") }}</strong>
            </p>
          </div>
        </div>
        <b-pagination
          @change="consultar"
          :total="total"
          v-model="current"
          simple
          rounded
          :per-page="perPage"
          icon-prev="chevron-left"
          icon-next="chevron-right"
          aria-next-label="Next page"
          aria-previous-label="Previous page"
          aria-page-label="Page"
          aria-current-label="Current page"
        >
        </b-pagination>
      </div>
    </div>
    <b-modal v-model="mostrarProducto">
      <div class="card">
        <div class="card-image">
          <figure class="image is-4by3">
            <img
              :src="
                currentProducto.url_foto == null
                  ? '/img/sin-imagen.jpg'
                  : currentProducto.url_foto
              "
              :alt="currentProducto.descripcion"
            />
          </figure>
        </div>
        <div class="card-content">
          <div class="content">
            <p>
              <strong
                >{{ currentProducto.descripcion }} ({{
                  currentProducto.codigo
                }})</strong
              >
            </p>
            <p>
              <i>
                {{ currentProducto.informacion_adicional }}
              </i>
            </p>
          </div>
        </div>
      </div>
    </b-modal>
  </section>
</template>
<script>
export default {
  props: {
    descripcionCategoria: {
      type: String,
      required: false,
      default: "",
    },
    categoria: {
      type: String,
      required: false,
      default: "",
    },
    consulta: {
      type: String,
      required: false,
      default: "",
    },
  },
  data: function () {
    return {
      mostrarProducto: false,
      productos: [],
      total: 0,
      current: 1,
      perPage: 8,
      currentProducto: {},
    };
  },
  methods: {
    verProducto: function (producto) {
      this.currentProducto = producto;
      this.mostrarProducto = true;
    },
    consultar: function () {
      this.$http
        .get(process.env.MIX_APP_URL_API + "/productos", {
          params: {
            status: "T",
            search: this.consulta,
            categoria: this.categoria,
            per_page: this.perPage,
            current_page: this.current,
          },
        })
        .then(({ data }) => {
          this.productos = data.data;
          this.total = data.total;
        });
    },
  },
  mounted: function () {
    this.consultar();
  },
};
</script>
