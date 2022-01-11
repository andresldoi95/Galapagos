<template>
  <div class="sidebar-page">
    <section class="sidebar-layout">
      <b-sidebar
        type="is-light"
        :open.sync="open"
        fullheight
        expand-on-hover
        :can-cancel="['x', 'outside', 'escape']"
      >
        <div class="p-1">
          <img src="/img/logo.png" alt="Logo" />
          <b-menu class="is-custom-mobile">
            <b-menu-list :label="$t('title.menu')">
              <b-menu-item
                to="/admin"
                tag="router-link"
                icon="monitor"
                :label="$t('title.dashboard')"
              ></b-menu-item>
              <b-menu-item
                icon="office-building"
                :label="$t('title.empresas')"
                tag="router-link"
                to="/admin/empresas"
              ></b-menu-item>
              <b-menu-item
                icon="account-lock"
                :label="$t('title.roles')"
                tag="router-link"
                to="/admin/roles"
              ></b-menu-item>
              <b-menu-item
                icon="account-multiple"
                :label="$t('title.usuarios')"
                tag="router-link"
                to="/admin/usuarios"
              ></b-menu-item>
              <b-menu-item
                icon="file-table-box"
                :label="$t('title.productos')"
                tag="router-link"
                to="/admin/productos"
              ></b-menu-item>
              <b-menu-item
                icon="clipboard-text"
                :label="$t('title.declaraciones_juramentadas')"
                tag="router-link"
                to="/admin/declaraciones-juramentadas"
              ></b-menu-item>
              <b-menu-item
                icon="book-information-variant"
                :label="$t('title.registro_retencion')"
                tag="router-link"
                to="/admin/registro-retencion"
              ></b-menu-item>
              <b-menu-item
                icon="format-align-justify"
                :label="$t('title.retenciones')"
                tag="router-link"
                to="/admin/retenciones"
              ></b-menu-item>
            </b-menu-list>
          </b-menu>
        </div>
      </b-sidebar>
      <div class="p-1 sidebar-body">
        <b-button @click="open = !open" icon-left="menu">
          {{ $t("title.menu") }}
        </b-button>
        <router-view></router-view>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      open: false,
    };
  },
};
</script>

<style lang="scss">
.p-1 {
  padding: 1em;
}
.sidebar-body {
  width: 100%;
}
.sidebar-page {
  display: flex;
  flex-direction: column;
  width: 100%;
  min-height: 100%;
  // min-height: 100vh;
  .sidebar-layout {
    display: flex;
    flex-direction: row;
    min-height: 100%;
    // min-height: 100vh;
  }
}
@media screen and (max-width: 1023px) {
  .b-sidebar {
    .sidebar-content {
      &.is-mini-mobile {
        &:not(.is-mini-expand),
        &.is-mini-expand:not(:hover) {
          .menu-list {
            li {
              a {
                span:nth-child(2) {
                  display: none;
                }
              }
              ul {
                padding-left: 0;
                li {
                  a {
                    display: inline-block;
                  }
                }
              }
            }
          }
          .menu-label:not(:last-child) {
            margin-bottom: 0;
          }
        }
      }
    }
  }
}
@media screen and (min-width: 1024px) {
  .b-sidebar {
    .sidebar-content {
      &.is-mini {
        &:not(.is-mini-expand),
        &.is-mini-expand:not(:hover) {
          .menu-list {
            li {
              a {
                span:nth-child(2) {
                  display: none;
                }
              }
              ul {
                padding-left: 0;
                li {
                  a {
                    display: inline-block;
                  }
                }
              }
            }
          }
          .menu-label:not(:last-child) {
            margin-bottom: 0;
          }
        }
      }
    }
  }
}
</style>
