<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Sidebar from '@/components/sideBar/Sidebar.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'
import { useAuthStore } from '@/stores/auth'

const storeAuth = useAuthStore()

const loading = ref(true)
const isSidebarOpen = ref(false)

const windowWidth = ref(window.innerWidth)

const updateWidth = () => {
  windowWidth.value = window.innerWidth
}

onMounted(() => {
  window.addEventListener('resize', updateWidth)
  loading.value = false
})

onUnmounted(() => {
  window.removeEventListener('resize', updateWidth)
})
</script>

<template>
  <div v-if="loading">
    <Loading />
  </div>
  <div v-else>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
      enter-to-class="opacity-100">
      <div class="flex h-screen">
        <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />

        <div class="flex-1 bg-gray-100 overflow-y-scroll transition-all duration-300">
          <div class="relative w-full h-full">
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
        </div>
      </div>
    </transition>
  </div>
</template>