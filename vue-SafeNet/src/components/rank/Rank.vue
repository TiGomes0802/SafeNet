<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import Sidebar from '@/components/Sidebar.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'
import { useRankStore } from '@/stores/rank'

const storeRank = useRankStore()
const loading = ref(true)
const windowWidth = ref(window.innerWidth)
const isSidebarOpen = ref(false)
const apiDomain = import.meta.env.VITE_API_DOMAIN


const updateWidth = () => {
  windowWidth.value = window.innerWidth
}

// Paginação amigos
const amigosPorPagina = 10
const paginaActual = ref(1)
const todosOsAmigos = ref([])

const amigosPaginados = computed(() => {
  const inicio = (paginaActual.value - 1) * amigosPorPagina
  return todosOsAmigos.value.slice(inicio, inicio + amigosPorPagina)
})

const paginaSeguinte = () => {
  if (paginaActual.value * amigosPorPagina < todosOsAmigos.value.length) {
    paginaActual.value++
  }
}
const paginaAnterior = () => {
  if (paginaActual.value > 1) {
    paginaActual.value--
  }
}

// Padding dinâmico
const dynamicPadding = computed(() => {
  if (windowWidth.value < 768 && !isSidebarOpen.value) {
    return 'pl-20'
  }
  return 'pl-10'
})

onMounted(() => {
  window.addEventListener('resize', updateWidth)
  storeRank.getRank().then(() => {
    todosOsAmigos.value = Array.isArray(storeRank.rank.amigos) ? storeRank.rank.amigos : []
    loading.value = false
  })

})

onUnmounted(() => {
  window.removeEventListener('resize', updateWidth)
})
</script>

<template>
  <div v-if="loading">
    <Loading />
  </div>
  <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0" enter-to-class="opacity-100">
    <div class="flex h-screen">
      <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
      <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">

        <h1 class="text-3xl font-bold mb-8">Rankings</h1>

        <div class="flex flex-col md:flex-row gap-6">

          <!-- Global -->
          <div class="w-full md:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Ranking Global 🌍</h2>
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                <thead class="bg-blue-500 text-white">
                  <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Utilizador</th>
                    <th class="py-3 px-6 text-center">XP</th>
                    <th class="py-3 px-6 text-center">Rank</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in storeRank.rank.mundial" :key="user.username"
                      :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
                      class="hover:bg-blue-100 transition duration-300">
                    <td class="py-3 px-6 font-bold text-blue-600">{{ user.posicao }}</td>
                    <td class="py-3 px-6 flex items-center gap-3">
                      <img :src="`http://${apiDomain}/storage/photos/${user.foto}`" class="w-10 h-10 rounded-full border-2 border-blue-300 object-cover" />
                      {{ user.username }}
                    </td>
                    <td class="py-3 px-6 text-center text-yellow-700 font-semibold">{{ user.xp }}</td>
                    <td class="py-3 px-6 text-center">{{ user.rank }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Amigos -->
          <div class="w-full md:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Ranking dos Amigos 👥</h2>
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                <thead class="bg-green-500 text-white">
                  <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Utilizador</th>
                    <th class="py-3 px-6 text-center">XP</th>
                    <th class="py-3 px-6 text-center">Rank</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in amigosPaginados" :key="user.username"
                      :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
                      class="hover:bg-green-100 transition duration-300">
                    <td class="py-3 px-6 font-bold text-green-700">{{ user.posicao }}</td>
                    <td class="py-3 px-6 flex items-center gap-3">
                      <img :src="`http://${apiDomain}/storage/photos/${user.foto}`" class="w-10 h-10 rounded-full border-2 border-blue-300 object-cover" />
                      {{ user.username }}
                    </td>
                    <td class="py-3 px-6 text-center text-yellow-700 font-semibold">{{ user.xp }}</td>
                    <td class="py-3 px-6 text-center">{{ user.rank }}</td>
                  </tr>
                </tbody>
              </table>
              <div class="flex justify-between items-center mt-4">
                <button @click="paginaAnterior" :disabled="paginaActual === 1" class="bg-green-500 text-white px-4 py-2 rounded disabled:opacity-50">
                  Anterior
                </button>
                <span class="text-gray-700">Página {{ paginaActual }}</span>
                <button @click="paginaSeguinte" :disabled="paginaActual * amigosPorPagina >= todosOsAmigos.length" class="bg-green-500 text-white px-4 py-2 rounded disabled:opacity-50">
                  Seguinte
                </button>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </transition>
</template>
