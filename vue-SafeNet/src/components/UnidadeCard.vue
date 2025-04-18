<script setup>
defineProps({
  titulo: String
})
</script>

<template>
  <div class="bg-white p-6 rounded-lg shadow-md w-full">
    <!-- Título e Descrição -->
    <div>
      <h3 class="text-2xl font-semibold text-gray-800">{{ titulo }}</h3>
      <p class="text-sm text-gray-600 mt-2">Descrição do módulo</p>
    </div>

    <!-- Níveis -->
    <div class="mt-6">
      <div class="text-lg font-semibold text-gray-800 mb-4">Níveis</div>
      <!-- Contêiner dos retângulos -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        <div
          v-for="level in 4"
          :key="level"
          class="w-full h-16 flex items-center justify-center bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600 transition"
        >
          {{ level }}
        </div>
      </div>
    </div>
  </div>
</template>
