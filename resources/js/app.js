//Importando dependencias
import Vue from "vue";
import Buefy from "buefy";
import Vuex from "vuex";
import axios from "axios";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import VueI18n from "vue-i18n";
import VueSession from "vue-session";
//Importando componentes globales
import App from "./components/App";
//Instalando plugins
Vue.use(Buefy);
Vue.use(Vuex);
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(VueI18n);
Vue.use(VueSession);
Vue.use(require("vue-moment"));
Vue.use(require("vue-cookies"));
//Importando configuraciones de los diferentes plugins
const store = new Vuex.Store(require("./plugins/store").default);
const routes = require("./routes/router").default;
const router = new VueRouter(routes);
const messages = require("./lang/translator").default;
let currentLang = Vue.$cookies.get("locale");
const i18n = new VueI18n({
    locale: currentLang ? currentLang : "es",
    messages
});

if (currentLang) {
    store.commit("setOnlyLang", currentLang);
}
//Configurando interceptores para axios
axios.interceptors.request.use(
    config => {
        if (app.$session.exists()) {
            let token = app.$session.get("oauth2");
            if (token) {
                config.headers["Authorization"] = `Bearer ${token}`;
                if (app.$store.state.token === "") {
                    app.$store.dispatch("loggedIn", token);
                }
            }
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

//Instanciando VueJS en el proyecto con sus diferentes recursos
const app = new Vue({
    i18n,
    router,
    store,
    components: {
        App
    },
    el: "#app"
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!app.$session.exists()) {
            next({
                name: "Login"
            });
        } else next();
    } else if (to.matched.some(record => record.meta.guest)) {
        if (app.$session.exists()) {
            next({
                name: "Home"
            });
        } else next();
    } else next();
});
