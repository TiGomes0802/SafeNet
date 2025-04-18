<script setup>
  import Sonner  from './components/ui/sonner/Sonner.vue';
  import HomeView from './views/HomeView.vue';
</script>

<template>
  <main>
    <div id="app">
      <Sonner />
      <router-view />
      <HomeView />
    </div>
  </main>
</template>