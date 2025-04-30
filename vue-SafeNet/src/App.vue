<script setup>
  import { ref, onMounted } from 'vue'
  import { useAuthStore } from '@/stores/auth'

  const isReady = ref(false)
  const authStore = useAuthStore()

  onMounted(async () => {
    await authStore.restoreToken()
    isReady.value = true
  })
</script>

<template>
  <main>
    <div v-if="!isReady"></div>
    <div v-else id="app">
      <router-view />
    </div>
  </main>
</template>