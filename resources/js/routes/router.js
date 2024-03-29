import Home from "../components/Home";
import Login from "../components/auth/Login";
import Admin from "../components/layouts/AdminPanel";
import Empresas from "../components/admin/empresas/Empresas";
import Dashboard from "../components/admin/Dashboard";
import Roles from "../components/admin/usuarios/Roles";
import Usuarios from "../components/admin/usuarios/Usuarios";
import ModificarCuenta from "../components/auth/ModificarCuenta";
import SetPassword from "../components/auth/SetPassword";
import RecuperarCuenta from "../components/auth/RecuperarCuenta";
import DeclaracionJuramentada from "../components/publico/DeclaracionJuramentada.vue";
import ConsultaDeclaracionesJuramentadas from "../components/publico/ConsultaDeclaracionesJuramentadas.vue";
import Productos from "../components/admin/productos/Productos.vue";
import RegistroRetencion from '../components/admin/retenciones/RegistroRetencion.vue';
import ConsultaRetenciones from '../components/admin/retenciones/ConsultaRetenciones.vue';
import Catalogo from '../components/publico/Catalogo.vue';

export default {
    mode: "history",
    routes: [
        {
            path: "/",
            component: Home,
            name: "Home",
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/catalogo",
            component: Catalogo,
            name: "Catalogo",
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/declaracion-juramentada",
            component: DeclaracionJuramentada,
            name: "DeclaracionJuramentada",
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/perfil",
            component: ModificarCuenta,
            name: "Perfil",
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/recuperar",
            component: RecuperarCuenta,
            name: "Recuperar",
            meta: {
                guest: true
            }
        },
        {
            path: "/set-password/:token",
            component: SetPassword,
            name: "SetPassword",
            meta: {
                guest: true
            }
        },
        {
            path: "/login",
            component: Login,
            name: "Login",
            meta: {
                guest: true
            }
        },
        {
            path: "/admin",
            component: Admin,
            meta: {
                requiresAuth: true
            },
            children: [
                {
                    name: "Dashboard",
                    path: "",
                    component: Dashboard
                },
                {
                    component: Empresas,
                    path: "empresas",
                    meta: {
                        requiresAuth: true
                    },
                    name: "Empresas"
                },
                {
                    component: Roles,
                    path: "roles",
                    meta: {
                        requiresAuth: true
                    },
                    name: "Roles"
                },
                {
                    component: Usuarios,
                    path: "usuarios",
                    meta: {
                        requiresAuth: true
                    },
                    name: "Usuarios"
                },
                {
                    component: Productos,
                    path: "productos",
                    meta: {
                        requiresAuth: true
                    },
                    name: "Productos"
                },
                {
                    component: RegistroRetencion,
                    path: "registro-retencion",
                    meta: {
                        requiresAuth: true
                    },
                    name: "RegistroRetencion"
                },
                {
                    component: ConsultaRetenciones,
                    path: "retenciones",
                    meta: {
                        requiresAuth: true
                    },
                    name: "ConsultarRetenciones"
                },
                {
                    component: ConsultaDeclaracionesJuramentadas,
                    path: "declaraciones-juramentadas",
                    meta: {
                        requiresAuth: true
                    },
                    name: "DeclaracionesJuramentadas"
                }
            ]
        }
    ]
};
