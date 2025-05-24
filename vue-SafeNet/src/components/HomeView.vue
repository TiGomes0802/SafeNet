<script setup>
  import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'
  import { useRoute } from 'vue-router'
  import Sidebar from '@/components/Sidebar.vue'
  import UnidadeCard from '@/components/UnidadeCard.vue'
  import { useAuthStore } from '@/stores/auth'
  import { useCursoStore } from '@/stores/curso'
  import { useMissaoStore } from '@/stores/missao'
  import Loading from '@/components/loading/FrontofficeLaoding.vue'

  const route = useRoute()
  const user = useAuthStore().user
  const storeCurso = useCursoStore()
  const storeMissao = useMissaoStore()

  const cursoId = ref(route.params.idCurso)
  const curso = ref({})
  const unidades = ref([])
  const loading = ref(true);

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

  onMounted(async() => {
    await storeCurso.getCursos()
    for(const curso of storeCurso.cursos) {
      if (curso.id == cursoId.value) {
        storeCurso.curso = curso
        unidades.value = curso.unidades
      }
    }
    window.addEventListener('resize', updateWidth)
    loading.value = false
    if (user.type === 'J') {
      storeMissao.getMinhasmissoes()
    }
  })

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
        <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
          <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ curso.nome }}</h1>

          <!-- Lista de Unidades -->
          <div class="space-y-12">
            <template v-for="unidade in unidades" :key="unidade.id">
              <!-- Link apenas se for clicável -->
              <router-link
                v-if="unidade.status !== -1"
                :to="`/curso/${cursoId}/unidade/${unidade.id}`"
                class="block transform transition duration-300 hover:scale-101 hover:shadow-lg">
                <UnidadeCard
                  :titulo="unidade.titulo"
                  :descricao="unidade.descricao"
                  :status="unidade.status"/>
              </router-link>
              <!-- Apenas o card, sem link, se estiver bloqueado -->
              <div v-else >
                <UnidadeCard
                  :titulo="unidade.titulo"
                  :descricao="unidade.descricao"
                  :status="unidade.status"/>
              </div>
            </template>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
