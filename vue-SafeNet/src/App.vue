<script setup>
  import Header from './components/HelloWorld.vue';
  import Sonner  from './components/ui/sonner/Sonner.vue';

</script>

<template>
  <Header />
  <main>
    <div id="app">
      <Sonner />
      <router-view />
    </div>
  </main>
</template>