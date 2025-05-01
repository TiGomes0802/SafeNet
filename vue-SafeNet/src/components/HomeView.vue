<script setup>
import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'

import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'
import axios from 'axios'

const route = useRoute()
const cursoId = ref(route.params.idCurso)
const curso = ref({})
const unidades = ref([])

watch(() => route.params.idCurso, (newVal) => {
  cursoId.value = newVal
  fetchCurso()
  fetchUnidades()
})

const windowWidth = ref(window.innerWidth)
const isSidebarOpen = ref(false)

const updateWidth = () => {
  windowWidth.value = window.innerWidth
}

onMounted(() => {
  window.addEventListener('resize', updateWidth)
  fetchCurso()
  fetchUnidades()
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


const fetchCurso = async () => {
  try {
    const response = await axios.get(`/cursos/${cursoId.value}`)
    curso.value = response.data
  } catch (error) {
    console.error('Erro ao buscar curso:', error)
  }
}

const fetchUnidades = async () => {
  try {
    const response = await axios.get(`/cursos/${cursoId.value}/unidades`)
    unidades.value = response.data
  } catch (error) {
    console.error('Erro ao buscar unidades:', error)
  }
}

</script>

<template>
  <div class="flex h-screen">
    <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
    <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
      <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ curso.nome }}</h1>

      <!-- Lista de Unidades -->
      <div class="space-y-12">
        <router-link v-for="unidade in unidades" :key="unidade.id" :to="`/curso/${cursoId}/unidade/${unidade.id}`"
          class="block transform transition duration-300 hover:scale-101 hover:shadow-lg">
          <UnidadeCard :titulo="unidade.titulo" />
        </router-link>
      </div>

    </div>
  </div>
</template>
