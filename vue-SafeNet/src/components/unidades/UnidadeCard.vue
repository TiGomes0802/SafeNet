<script setup>
defineProps({
  titulo: String,
  descricao: String,
  status: Number
})
</script>

<template>
  <div
    class="p-6 rounded-lg shadow-md w-full transition-all duration-200"
    :class="{
      'bg-green-100 hover:bg-green-200 cursor-pointer': status === 1,
      'bg-white hover:bg-blue-100 cursor-pointer': status === 0,
      'bg-gray-200 text-gray-600 pointer-events-none cursor-not-allowed': status === -1
    }"
  >
    <div>
      <h3 class="text-2xl font-semibold text-gray-800">{{ titulo }}</h3>
      <p class="text-sm text-gray-600 mt-2">{{ descricao }}</p>
    </div>
  </div>
</template>
