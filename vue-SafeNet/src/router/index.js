import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from "@/stores/auth";
import HomeView from '../components/HomeView.vue'
import Login from "@/components/auth/Login.vue";
import Register from "@/components/auth/Register.vue";
import Missoes from "@/components/missoes/Missoes.vue";
import Estatisticas from "@/components/estatisticas/Estatisticas.vue";
import Loja from "@/components/loja/Loja.vue";
import Jogo from "@/components/jogos/index.vue";
import CriarJogo from "@/components/jogos/create.vue";

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
      path: '/unidade/:idUnidade/jogos',
      name: 'Jogos',
      component: Jogo,
      props: true,
    },
    {
      path: '/unidade/:idUnidade/jogos/criar',
      name: 'CriarJogo',
      component: CriarJogo,
      props: true,
    }
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
