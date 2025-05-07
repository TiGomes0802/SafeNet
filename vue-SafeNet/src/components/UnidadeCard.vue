<script setup>
defineProps({
  titulo: String,
  descricao: String
})
</script>

<template>
  <div class="bg-white p-6 rounded-lg shadow-md w-full">
    <!-- Título e Descrição -->
    <div>
      <h3 class="text-2xl font-semibold text-gray-800">{{ titulo }}</h3>
      <p class="text-sm text-gray-600 mt-2">{{ descricao }}</p>
    </div>
  </div>
</template>
