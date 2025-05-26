<script setup>
import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'
import { useCursoStore } from '@/stores/curso'
import { useMissaoStore } from '@/stores/missao'
import { useAuthStore } from '@/stores/auth'
import Loading from '@/components/loading/FrontofficeLaoding.vue'

const route = useRoute()
const storeCurso = useCursoStore()
const storeMissao = useMissaoStore()
const storeAuth = useAuthStore()

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

onMounted(async () => {
  await storeCurso.getCursos()
  for (const curso of storeCurso.cursos) {
    if (curso.id == cursoId.value) {
      storeCurso.curso = curso
      unidades.value = curso.unidades
    }
  }
  window.addEventListener('resize', updateWidth)
  loading.value = false
  storeMissao.getMinhasmissoes()
})

const updateWidth = () => {
  windowWidth.value = window.innerWidth
}

onMounted(async () => {
  await storeCurso.getCursos()
  for (const curso of storeCurso.cursos) {
    if (curso.id == cursoId.value) {
      storeCurso.curso = curso
      unidades.value = curso.unidades
    }
  }
  window.addEventListener('resize', updateWidth)
  loading.value = false
})

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
  <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
    enter-to-class="opacity-100">
    <div class="flex h-screen">
      <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
      <div class='flex-1 overflow-y-scroll transition-all duration-300'>

        <!-- Se não houver curso selecionado -->
        <div v-if="!cursoId" class="relative w-full h-full">
          <img src="@/assets/SafeNetBg.jpg" alt="SafeNet Background"
            class="absolute top-0 left-0 w-full h-full object-cover z-0 opacity-30" />
          <div class="relative z-10 text-center p-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-600 drop-shadow-lg mb-2">
              Bem-vindo, {{ storeAuth.user.nome }}!
            </h1>
            <p class="text-lg text-gray-500 drop-shadow">
              Selecione um curso no menu lateral para começar
            </p>
          </div>
        </div>



        <!-- Se houver curso selecionado -->
        <div v-else :class="['p-6', dynamicPadding]">
          <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ curso.nome }}</h1>

          <!-- Lista de Unidades -->
          <div class="space-y-12">
            <template v-for="unidade in unidades" :key="unidade.id">
              <!-- Link apenas se for clicável -->
              <router-link v-if="unidade.status !== -1" :to="`/curso/${cursoId}/unidade/${unidade.id}`"
                class="block transform transition duration-300 hover:scale-101 hover:shadow-lg">
                <UnidadeCard :titulo="unidade.titulo" :descricao="unidade.descricao" :status="unidade.status" />
              </router-link>
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
</template>
