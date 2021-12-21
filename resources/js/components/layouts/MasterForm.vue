<template>
  <section>
    <form @submit.prevent="submit">
      <b-field v-show="tipo_formulario === 'C'" grouped group-multiline>
        <div v-show="createButton" class="control">
          <b-button @click="add" icon-left="plus">{{
            $t("message.add")
          }}</b-button>
        </div>
        <b-select v-model="type">
          <option disabled value>{{ $t("message.group_action") }}</option>
          <option
            v-for="type in typeOptions"
            :key="type.value"
            :value="type.value"
          >
            {{ type.text }}
          </option>
        </b-select>
        <div class="control">
          <b-button
            @click="realizarAccion"
            icon-left="check"
            type="is-warning"
            >{{ $t("message.do_group_action") }}</b-button
          >
        </div>
        <b-select @input="submit" v-model="form.status">
          <option
            v-for="option in statusOptions"
            :key="option.value"
            :value="option.value"
          >
            {{ option.text }}
          </option>
        </b-select>
        <b-input
          type="text"
          v-model="form.search"
          :placeholder="$t('message.search')"
        ></b-input>
        <div class="control">
          <b-button
            native-type="submit"
            type="is-info"
            icon-left="magnify"
          ></b-button>
        </div>
        <b-select v-model="form.per_page" v-show="isPaginated">
          <option v-for="page in pageOptions" :value="page" :key="page">
            {{ page }} {{ $t("message.perpage") }}
          </option>
        </b-select>
      </b-field>
    </form>
    <form v-show="tipo_formulario !== 'C'" @submit.prevent="submitFormulario">
      <slot></slot>
      <b-field grouped group-multiline>
        <div class="control">
          <b-button
            v-show="editable"
            native-type="submit"
            type="is-info"
            icon-left="content-save"
            >{{ $t("message.guardar") }}</b-button
          >
        </div>
        <div class="control">
          <b-button
            @click="cancel"
            native-type="button"
            type="is-danger"
            icon-left="close"
            >{{ $t("message.cancelar") }}</b-button
          >
        </div>
      </b-field>
    </form>
    <br />
    <b-table
      :loading="isLoading"
      @sort="onSort"
      @page-change="onPageChange"
      :total="total"
      :checked-rows.sync="checkedRows"
      @dblclick="editar"
      focusable
      :selected.sync="selected"
      v-show="tipo_formulario === 'C'"
      :checkable="checkable"
      :columns="columns"
      :data="registros"
      :paginated="isPaginated"
      :backend-pagination="isPaginated"
      :per-page="form.per_page"
      :current-page.sync="form.current_page"
      sort-icon="arrow-up"
      :aria-next-label="$t('message.next_page')"
      :aria-previous-label="$t('message.prev_page')"
      :aria-page-label="$t('message.page')"
      :aria-current-label="$t('message.current_page')"
    ></b-table>
  </section>
</template>

<script>
export default {
  props: {
    editable: {
      type: Boolean,
      required: false,
      default: true,
    },
    defaultStatus: {
      type: String,
      required: false,
      default: "A",
    },
    createButton: {
      type: Boolean,
      required: false,
      default: true,
    },
    sortOrderDefault: {
      type: String,
      required: false,
      default: "asc",
    },
    sortByDefault: {
      type: String,
      required: false,
      default: "",
    },
    resource: {
      type: String,
      required: false,
      default: "/",
    },
    pageDefault: {
      type: Number,
      required: false,
      default: 5,
    },
    pageOptions: {
      type: Array,
      required: false,
      default: function () {
        return [5, 10, 20, 30, 50, 100];
      },
    },
    checkable: {
      type: Boolean,
      required: false,
      default: true,
    },
    columns: {
      type: Array,
      required: true,
    },
    isPaginated: {
      type: Boolean,
      required: false,
      default: true,
    },
    statusOptions: {
      type: Array,
      required: false,
      default: function () {
        return [
          {
            value: "A",
            text: this.$t("message.active"),
          },
          {
            value: "I",
            text: this.$t("message.inactive"),
          },
          {
            value: "T",
            text: this.$t("message.all"),
          },
        ];
      },
    },
    typeOptions: {
      type: Array,
      required: false,
      default: function () {
        return [
          {
            value: "E",
            text: this.$t("message.delete"),
          },
        ];
      },
    },
  },
  data: function () {
    return {
      isLoading: false,
      checkedRows: [],
      selected: null,
      type: "",
      form: {
        status: this.defaultStatus,
        search: "",
        per_page: this.pageDefault,
        current_page: 1,
        sort_by: this.sortByDefault,
        sort_order: this.sortOrderDefault,
      },
      registros: [],
      sortIcon: "arrow-up",
      tipo_formulario: "C",
      total: 0,
    };
  },
  methods: {
    onSort(field, order) {
      if (
        this.isPaginated &&
        (this.form.sort_by !== field || this.form.sort_order !== order)
      ) {
        this.form.sort_by = field;
        this.form.sort_order = order;
        this.submit();
      }
    },
    onPageChange: function (page) {
      if (this.isPaginated && this.form.current_page !== page) {
        this.form.current_page = page;
        this.submit();
      }
    },
    realizarAccion: function () {
      if (this.type === "") {
        this.$buefy.toast.open({
          message: this.$t("message.debe_seleccionar_accion"),
          type: "is-warning",
        });
      } else if (this.checkedRows.length === 0) {
        this.$buefy.toast.open({
          message: this.$t("message.debe_seleccionar"),
          type: "is-warning",
        });
      } else this.$emit("realizarAccion", this.type, this.checkedRows);
    },
    editar: function (row) {
      this.tipo_formulario = "E";
      this.$emit("editar", row);
    },
    submit: function () {
      this.isLoading = true;
      if (this.tipo_formulario !== "C") this.tipo_formulario = "C";
      this.$http
        .get(this.resource, {
          params: this.form,
        })
        .then(({ data }) => {
          if (!this.isPaginated) this.registros = data;
          else {
            this.registros = data.data;
            this.total = data.total;
          }
          this.checkedRows.splice(0, this.checkedRows.length);
          this.isLoading = false;
        })
        .catch(() => {
          this.$buefy.toast.open({
            message: this.$t("message.generic_error"),
            type: "is-danger",
          });
          this.isLoading = false;
        });
    },
    submitFormulario: function () {
      this.$emit("submitFormulario", this.form);
    },
    add: function () {
      this.tipo_formulario = "N";
      this.$emit("adding");
    },
    cancel: function () {
      this.tipo_formulario = "C";
      this.$emit("canceled");
    },
  },
  mounted: function () {
    this.submit();
  },
};
</script>
