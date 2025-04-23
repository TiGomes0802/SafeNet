import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../components/HomeView.vue'
import Login from "@/components/auth/Login.vue";
import Register from "@/components/auth/Register.vue";
import Missoes from "@/components/missoes/Missoes.vue";
import Estatisticas from "@/components/estatisticas/Estatisticas.vue";
import Loja from "@/components/loja/Loja.vue";

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
  ],
})

export default router
