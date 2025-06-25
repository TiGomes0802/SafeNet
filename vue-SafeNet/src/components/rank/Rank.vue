<script setup>
  import { ref, onMounted, onUnmounted, computed } from 'vue'
  import Sidebar from '@/components/sideBar/Sidebar.vue'
  import Loading from '@/components/loading/FrontofficeLaoding.vue'
  import { useRankStore } from '@/stores/rank'
  import { useAuthStore } from '@/stores/auth'
  import defaultAvatar from '@/assets/avatar-default-icon.png'

  const storeAuth = useAuthStore()
  const storeRank = useRankStore()

  const loading = ref(true)
  const windowWidth = ref(window.innerWidth)
  const isSidebarOpen = ref(false)

  const mostrarGlobal = ref(true) // true = Global, false = Amigos
  const tipoRank = ref('xp') // Preparado para mais tipos no futuro

  const updateWidth = () => {
    windowWidth.value = window.innerWidth
  }

  const dynamicPadding = computed(() => {
    if (windowWidth.value < 768 && !isSidebarOpen.value) {
      return 'pl-20'
    }
    return 'pl-10'
  })

  const todosOsAmigos = ref([])

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
  <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
    enter-to-class="opacity-100">
    <div class="flex h-screen">
      <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
      <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">

        <h1 class="text-3xl font-bold mb-8 text-blue-600">Rankings</h1>

        <!-- Controlos -->
        <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
          <label class="flex items-center gap-2">
            <input type="checkbox" v-model="mostrarGlobal" />
            <span>{{ "Ranking Global 🌍" }}</span>
          </label>

          <select v-model="tipoRank" class="border border-gray-300 rounded px-3 py-1">
            <option value="xp">XP</option>
            <option value="" disabled>Streak</option>
            <option value="" disabled>XP curso</option>
            <!-- futuras opções: <option value="outra">Outra Métrica</option> -->
          </select>
        </div>

        <!-- Tabela Global -->
        <div v-if="mostrarGlobal && tipoRank === 'xp'" class="w-full">
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
                  :class="[storeAuth.user.username === user.username ? 'bg-blue-300 font-bold text-blue-800'
                    : index % 2 === 0 ? 'bg-gray-50' : 'bg-white', 'hover:bg-blue-100 transition duration-300']">
                  <td class="py-3 px-6 font-bold text-blue-600">{{ user.posicao }}</td>
                  <td class="py-3 px-6">
                    <router-link :to="{ name: 'Perfil', params: { username: user.username } }"
                      class="flex items-center gap-3 text-blue-600">
                      <img :src="user.foto || defaultAvatar"
                        class="w-10 h-10 rounded-full border-2 border-blue-300 object-cover" />
                      {{ user.username }}
                    </router-link>
                  </td>
                  <td class="py-3 px-6 text-center text-yellow-700 font-semibold">{{ user.xp }}</td>
                  <td class="py-3 px-6 text-center">{{ user.rank }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Tabela Amigos -->
        <div v-else-if="!mostrarGlobal && tipoRank === 'xp'" class="w-full">
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
                <tr v-for="(user, index) in todosOsAmigos" :key="user.username"
                  :class="[storeAuth.user.username === user.username ? 'bg-green-300 font-bold text-green-800'
                    : index % 2 === 0 ? 'bg-gray-50' : 'bg-white', 'hover:bg-green-100 transition duration-300']">
                  <td class="py-3 px-6 font-bold text-green-700">{{ user.posicao }}</td>
                  <td class="py-3 px-6">
                    <router-link :to="{ name: 'Perfil', params: { username: user.username } }"
                      class="flex items-center gap-3">
                      <img :src="user.foto || defaultAvatar"
                        class="w-10 h-10 rounded-full border-2 border-green-300 object-cover" />
                      {{ user.username }}
                    </router-link>
                  </td>
                  <td class="py-3 px-6 text-center text-yellow-700 font-semibold">{{ user.xp }}</td>
                  <td class="py-3 px-6 text-center">{{ user.rank }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </transition>
</template>
