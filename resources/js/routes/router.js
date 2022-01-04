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
export default {
    mode: "history",
    routes: [
        {
            path: "/",
            component: Home,
            name: "Home",
            meta: {
                requiresAuth: true
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
            path: "/declaraciones-juramentadas",
            component: ConsultaDeclaracionesJuramentadas,
            name: "DeclaracionesJuramentadas",
            meta: {
                requiresAuth: true
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
                }
            ]
        }
    ]
};
