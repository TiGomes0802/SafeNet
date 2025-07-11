import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from "@/stores/auth";
import HomeView from '@/components/HomeView.vue'
import Login from "@/components/auth/Login.vue";
import Register from "@/components/auth/Register.vue";
import Missoes from "@/components/missoes/Missoes.vue";
import Rank from "@/components/rank/Rank.vue";
import Loja from "@/components/loja/Loja.vue";
import Jogo from "@/components/jogos/index.vue";
import JogosView from "@/components/jogos/JogosView.vue";
import CriarJogo from "@/components/jogos/create.vue";
import EditarJogo from "@/components/jogos/editar.vue";
import CursosIndex from '@/components/cursos/index.vue'
import CursosCreate from '@/components/cursos/create.vue'
import CursosEdit from '@/components/cursos/edit.vue'
import UnidadeView from '@/components/unidades/UnidadeView.vue';
import UnidadesIndex from '@/components/unidades/index.vue';
import UnidadesCreate from '@/components/unidades/create.vue';
import UnidadesEdit from '@/components/unidades/edit.vue';
import Sucesso from "@/components/unidades/Sucesso.vue";
import GameOver from '@/components/unidades/GameOver.vue';
import Paginas from "@/components/paginas/index.vue";
import CriarPaginas from "@/components/paginas/create.vue";
import CreateReport from "@/components/reports/Report.vue";
import Report from "@/components/reports/index.vue";
import indexMissoes from '@/components/missoes/index.vue';
import indexAmigos from '@/components/amigos/index.vue';
import LojaIndex from "@/components/loja/index.vue";
import LojaCreate from "@/components/loja/create.vue";
import Perfil from '@/components/auth/Perfil.vue';
import UpdatePerfil from '@/components/auth/UpdatePerfil.vue';
import Users from '@/components/users/index.vue';
import UsersCreate from '@/components/users/create.vue';
import CursoView from '@/components/cursos/view.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/curso/:idCurso',
      name: 'curso',
      component: CursoView
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
      path: '/rank',
      name: 'Rank',
      component: Rank,
    },
    {
      path: '/loja',
      name: 'Loja',
      component: Loja,
    },
    {
      path: '/unidade/:idUnidade/jogos/play',
      name: 'JogosView',
      component: JogosView,
      props: true,
    },
    {
      path: '/unidade/:idUnidade/gameover',
      name: 'gameover',
      component: GameOver,
    },
    {
      path: '/amigos',
      name: 'amigos',
      component: indexAmigos,
    },
    {
      path: '/unidade/:idUnidade',
      name: 'Unidade',
      component: UnidadeView,
      props: true,
    },
    {
      path: '/report',
      name: 'CreateReport',
      component: CreateReport,
    },
    {
      path: '/sucesso',
      name: 'Sucesso',
      component: Sucesso,
    },
    {
      path: '/profile/:username',
      name: 'Perfil',
      component: Perfil,
    },
    {
      path: '/profile/update',
      name: 'UpdatePerfil',
      component: UpdatePerfil,
    },
    {
      path: '/backoffice/unidade/:idUnidade/jogos',
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
      path: '/backoffice/unidade/:idUnidade/edit',
      name: 'UnidadesEdit',
      component: UnidadesEdit,
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
      name: 'CriarPaginas',
      component: CriarPaginas,
      props: true,
    },
    {
      path: '/backoffice/missoes',
      name: 'indexMissoes',
      component: indexMissoes,
    },
    {
      path: '/backoffice/loja',
      name: 'LojaIndex',
      component: LojaIndex,
    },
    {
      path: '/backoffice/loja/create',
      name: 'LojaCreate',
      component: LojaCreate,
    },
    {
      path: '/backoffice/reports',
      name: 'Report',
      component: Report,
    },
    {
      path: '/admin/users',
      name: 'Users',
      component: Users,
    },
    {
      path: '/admin/users/create',
      name: 'UsersCreate',
      component: UsersCreate,
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

  const publicRoutes = ['login', 'register'];
  const isPublicRoute = publicRoutes.includes(to.name);
  const user = storeAuth.user;

  const tipo = (user?.type || '').toUpperCase();
  const isAdminRoute = to.path.startsWith('/admin');
  const isBackofficeRoute = to.path.startsWith('/backoffice');

  if (!user) {
    return isPublicRoute ? next() : next({ name: 'login' });
  }

  if (isPublicRoute) {
    return next({ name: 'home' });
  }

  // Permitir a todos o acesso ao home
  if (to.name === 'home') {
    return next();
  }

  if (tipo === 'A') {
    return next();
  }

  if (tipo === 'G') {
    if (isBackofficeRoute && !isAdminRoute) {
      return next();
    }
    return next({ name: 'home' });
  }

  if (tipo === 'J') {
    if (!isBackofficeRoute && !isAdminRoute) {
      return next();
    }
    return next({ name: 'home' });
  }

  return next({ name: 'login' });
});


export default router
