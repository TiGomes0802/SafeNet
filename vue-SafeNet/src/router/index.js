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

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/unidade/:nome',
      name: 'unidade',
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
      //passing the id of the unidade in the url for show the games of the unit
      path: '/unidade/:idUnidade/jogos',
      name: 'Jogos',
      component: Jogo,
      props: true,
      // what props do: the props option allows you to pass the route params as props to the component.

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
      path: '/curso/:curso/unidade/:idUnidade',
      name: 'Unidade',
      component: UnidadeView,
    },
    {
      path: '/backoffice/cursos/:idCurso/unidades',
      name: 'UnidadesCurso',
      component: UnidadesIndex,
    }
  ],
})

let handlingFirstRoute = true;

router.beforeEach(async (to, from, next) => {
  const storeAuth = useAuthStore();
  console.log("teste:" + storeAuth.user)

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
