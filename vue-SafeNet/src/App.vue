<script setup>
  import { ref, onMounted } from 'vue'

  const isReady = ref(false)

</script>

<template>
  <main>
    <div id="app">
      <router-view />
    </div>
  </main>
</template>