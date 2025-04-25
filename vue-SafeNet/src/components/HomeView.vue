<script setup>
import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'

import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'

const route = useRoute()
const curso = ref(route.params.nome)

watch(() => route.params.nome, (newVal) => {
  curso.value = newVal
})

const windowWidth = ref(window.innerWidth)
const isSidebarOpen = ref(false)

const updateWidth = () => {
  windowWidth.value = window.innerWidth
}

onMounted(() => {
  window.addEventListener('resize', updateWidth)
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
  <div class="flex h-screen">
    <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
    <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
      <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ curso }}</h1>

      <!-- Lista de Unidades -->
      <div class="space-y-12">
        <router-link v-for="i in 6" :key="i" :to="`/curso/${curso}/unidade/${i}`" 
          @click="closeSidebar" class="block transform transition duration-300 hover:scale-101 hover:shadow-lg">
          <UnidadeCard :titulo="`Unidade ${i}`" />
        </router-link>
      </div>
    </div>
  </div>
</template>
