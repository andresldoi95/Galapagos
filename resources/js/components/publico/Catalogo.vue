<template>
  <div>
    <section class="hero is-small is-info">
      <div class="hero-body">
        <h1 class="title">{{ $t("title.catalogo") }}</h1>
        <h2 class="subtitle">{{ $t("message.descripcion_catalogo") }}</h2>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <h3 class="title">{{ $t("title.productos") }}</h3>
        <div class="container">
          <div class="columns">
            <div class="column is-one-quarter">
              <b-field :label="$t('etiqueta.categoria')">
                <b-select
                  @input="consultar"
                  v-model="form.categoria"
                  :placeholder="$t('message.seleccione')"
                  expanded
                >
                  <option value="T">{{ $t("message.all") }}</option>
                  <option value="P">{{ $t("message.permitido") }}</option>
                  <option value="R">{{ $t("message.restringido") }}</option>
                  <option value="NP">{{ $t("message.no_permitido") }}</option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-one-quarter">
              <b-field :label="$t('etiqueta.consulta')">
                <b-input
                  @keyup.enter="consultar"
                  v-model="form.consulta"
                ></b-input>
                <b-button type="is-info" @click="consultar">
                  {{ $t("message.search") }}
                </b-button>
              </b-field>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero">
      <div class="hero-body">
        <h3 class="title">{{ $t("title.resultados") }}</h3>
        <div class="container">
          <item-catalogo
            v-if="form.categoria == 'T' || form.categoria == 'P'"
            :consulta="form.consulta"
            ref="permitidos"
            categoria="P"
            :descripcionCategoria="$t('message.permitido')"
          ></item-catalogo>
          <item-catalogo
            v-if="form.categoria == 'T' || form.categoria == 'R'"
            :consulta="form.consulta"
            ref="restringidos"
            categoria="R"
            :descripcionCategoria="$t('message.restringido')"
          ></item-catalogo>
          <item-catalogo
            v-if="form.categoria == 'T' || form.categoria == 'NP'"
            :consulta="form.consulta"
            ref="no_permitidos"
            categoria="NP"
            :descripcionCategoria="$t('message.no_permitido')"
          ></item-catalogo>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import ItemCatalogo from "./ItemCatalogo.vue";
export default {
  components: {
    ItemCatalogo,
  },
  data: function () {
    return {
      form: {
        categoria: "T",
        consulta: "",
      },
    };
  },
  methods: {
    consultar: function () {
      if (this.$refs.permitidos != null) this.$refs.permitidos.consultar();
      if (this.$refs.restringidos != null) this.$refs.restringidos.consultar();
      if (this.$refs.no_permitidos != null)
        this.$refs.no_permitidos.consultar();
    },
  },
};
</script>
