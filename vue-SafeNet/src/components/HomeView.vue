<script setup>
  import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'
  import { useRoute } from 'vue-router'
  import { useRouter } from 'vue-router'
  import Sidebar from '@/components/Sidebar.vue'
  import UnidadeCard from '@/components/UnidadeCard.vue'
  import { useAuthStore } from '@/stores/auth'
  import { useCursoStore } from '@/stores/curso'
  import { useUnidadeStore } from '@/stores/unidade'
  import { useMissaoStore } from '@/stores/missao'
  import Loading from '@/components/loading/FrontofficeLaoding.vue'

  const route = useRoute()
  const router = useRouter()
  const storeAuth = useAuthStore()
  const storeCurso = useCursoStore()
  const storeUnidade = useUnidadeStore()
  const storeMissao = useMissaoStore()

  const user = storeAuth.user

  const cursoId = ref(route.params.idCurso)
  const unidades = ref([])
  const loading = ref(true);

  const irParaUnidade = (id) => {
    const unidadeSelecionada = unidades.value.find(u => u.id === id);

    if (!unidadeSelecionada) return;

    console.log('Unidade selecionada:', unidadeSelecionada);

    storeUnidade.unidade = unidadeSelecionada;

    console.log('ID Unidade:', storeUnidade.unidade.id);

    router.push(`/curso/${storeCurso.curso.id}/unidade/${storeUnidade.unidade.id}`)
  };

  watch(() => route.params.idCurso, (newVal) => {
    cursoId.value = newVal
    for (const curso of storeCurso.cursos) {
      if (curso.id == cursoId.value) {
        storeCurso.curso = curso
        unidades.value = curso.unidades
      }
    }
  })

  const windowWidth = ref(window.innerWidth)
  const isSidebarOpen = ref(false)

  onMounted(async () => {
    await storeCurso.getCursos()
    for (const curso of storeCurso.cursos) {
      if (curso.id == cursoId.value) {
        console.log('Curso encontrado:', curso)
        storeCurso.curso = curso
        unidades.value = curso.unidades
      }
      window.addEventListener('resize', updateWidth)
      loading.value = false
      if (user.type === 'J') {
        storeMissao.getMinhasmissoes()
      }
    }
  });

  const updateWidth = () => {
    windowWidth.value = window.innerWidth
  }

  onUnmounted(() => {
    window.removeEventListener('resize', updateWidth)
  })

  const dynamicPadding = computed(() => {
    if (windowWidth.value < 768 && !isSidebarOpen.value) {
      return 'pl-20' // Padding 20 para home não ficar por baixo da sidebar
    }
    return 'pl-10'  // Ecrãs maiores
  })

  const closeSidebar = () => {
    isSidebarOpen.value = false
  }

</script>

<template>
  <div v-if="loading">
    <Loading />
  </div>
  <div v-else>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
      enter-to-class="opacity-100">
      <div class="flex h-screen ">
        <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
        <div class='flex-1 bg-gray-100 overflow-y-scroll transition-all duration-300'>

          <!-- Se não houver curso selecionado -->
          <div v-if="!cursoId" class="relative w-full h-full">
            <img src="@/assets/SafeNetBg.jpg" alt="SafeNet Background"
              class="absolute top-0 left-0 w-full h-full object-cover z-0 opacity-80" />
            <div class="relative z-10 text-center p-10">
              <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 drop-shadow-lg mb-2">
                Bem-vindo, {{ storeAuth.user.nome }}! 
              </h1>
              <p class="text-lg text-gray-700 drop-shadow">
                Selecione um curso no menu lateral para começar
              </p>
            </div>
          </div>

          <!-- Se houver curso selecionado -->
          <div v-else :class="['p-6', dynamicPadding]">
            <p class="text-3xl font-bold text-blue-600 mb-6">{{ storeCurso.curso.nome }} </p>

            <!-- Lista de Unidades -->
            <div class="space-y-12">
              <template v-for="unidade in unidades" :key="unidade.id">
                <!-- Link apenas se for clicável -->
                <div v-if="unidade.status !== -1" @click="irParaUnidade(unidade.id)"
                  class="cursor-pointer block transform transition duration-300 hover:scale-101 hover:shadow-lg">
                  <UnidadeCard
                    :titulo="unidade.titulo"
                    :descricao="unidade.descricao"
                    :status="unidade.status"
                  />
                </div>
                <!-- Apenas o card, sem link, se estiver bloqueado -->
                <div v-else>
                  <UnidadeCard :titulo="unidade.titulo" :descricao="unidade.descricao" :status="unidade.status" />
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
