import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from "@/stores/auth";
import HomeView from '../components/HomeView.vue'
import Login from "@/components/auth/Login.vue";
import Register from "@/components/auth/Register.vue";
import Missoes from "@/components/missoes/Missoes.vue";
import Estatisticas from "@/components/estatisticas/Estatisticas.vue";
import Loja from "@/components/loja/Loja.vue";
import Jogo from "@/components/jogos/index.vue";
import CursosIndex from '@/components/cursos/index.vue'
import CursosCreate from '@/components/cursos/create.vue'
import CursosEdit from '@/components/cursos/edit.vue'
import UnidadeView from '@/components/unidades/UnidadeView.vue';
import UnidadesIndex from '@/components/unidades/index.vue';
import UnidadesCreate from '@/components/unidades/create.vue';
//import UnidadesEdit from '@/components/unidades/edit.vue';
import CriarJogo from "@/components/jogos/create.vue";
import EditarJogo from "@/components/jogos/editar.vue";
import Paginas from "@/components/paginas/index.vue";
import CriarPaginas from "@/components/paginas/create.vue";
import EditarPaginas from "@/components/paginas/editar.vue";
import Report from "@/components/reports/Report.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView, // Terá que ser um bem-vindo ou assim, para não mostrar unidades à toa
    },
    {
      path: '/curso/:idCurso',
      name: 'curso',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/missoes',
      name: 'Missoes',
      component: Missoes,
    },
    {
      path: '/estatisticas',
      name: 'Estatisticas',
      component: Estatisticas,
    },
    {
      path: '/loja',
      name: 'Loja',
      component: Loja,
    },
    {
      path: '/unidade/:idUnidade/jogos',
      name: 'Jogos',
      component: Jogo,
      props: true,
    },
    {
      path: '/backoffice/cursos',
      name: 'CursosIndex',
      component: CursosIndex,
    },
    {
      path: '/backoffice/cursos/create',
      name: 'CursosCreate',
      component: CursosCreate,
    },
    {
      path: '/backoffice/cursos/:id/edit',
      name: 'CursosEdit',
      component: CursosEdit,
    },
    {
      path: '/curso/:idCurso/unidade/:idUnidade',
      name: 'Unidade',
      component: UnidadeView,
      props: true,
    },    
    {
      path: '/backoffice/cursos/:idCurso/unidades',
      name: 'UnidadesCurso',
      component: UnidadesIndex,
    },
    {
      path: '/backoffice/cursos/:idCurso/unidades/create',
      name: 'UnidadesCreate',
      component: UnidadesCreate,
      props: true,
    },
    {
      path: '/backoffice/unidade/:idUnidade/jogos/criar',
      name: 'CriarJogo',
      component: CriarJogo,
      props: true,
    },
    {
      path: '/backoffice/unidade/:idUnidade/jogos/:idJogo',
      name: 'EditarJogo',
      component: EditarJogo,
      props: true,
    },
    {
      path: '/backoffice/unidade/:idUnidade/paginas/',
      name: 'Paginas',
      component: Paginas,
      props: true,
    },
    {
      path: '/backoffice/unidade/:idUnidade/paginas/criar',
      name: 'CriarPagianas',
      component: CriarPaginas,
      props: true,
    },
    {
      path: '/backoffice/unidade/:idUnidade/paginas/:idPagina',
      name: 'EditarPaginas',
      component: EditarPaginas,
      props: true,
    },
    {
      path: '/report',
      name: 'Report',
      component: Report,
    },
  ],
})

let handlingFirstRoute = true;

router.beforeEach(async (to, from, next) => {
  const storeAuth = useAuthStore();

  if (handlingFirstRoute) {
    handlingFirstRoute = false;
    await storeAuth.restoreToken();
  }

  // user is not logged in
  /*if (to.name !== "login" && to.name !== "register" && !storeAuth.user) {

    next({ name: "login" });
    return;
  }

  if ((to.name === "login" || to.name === "register") && storeAuth.user) {
    next({ name: "home" });
    return;
  }*/

  // user is logged in

  next();
})

export default router
