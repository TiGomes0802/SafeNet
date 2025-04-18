<script setup>
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <Sidebar />

    <!-- Conteúdo Principal -->
    <div class="flex-1 bg-gray-100 p-6 overflow-y-scroll">

      <h1 class="text-3xl font-bold text-blue-600 mb-6">Básico I</h1>

      <!-- Lista de Módulos -->
      <div class="space-y-12">
        <UnidadeCard v-for="i in 6" :key="i" :titulo="`Módulo ${i}`" />
      </div>
    </div>
  </div>
</template>

