import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from "@/components/auth/Login.vue";
import Register from "@/components/auth/Register.vue";
import Missoes from "@/views/Missoes.vue";
import Estatisticas from "@/views/Estatisticas.vue";
import Loja from "@/views/Loja.vue";

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
