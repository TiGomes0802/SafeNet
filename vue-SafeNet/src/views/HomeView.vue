<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'

const route = useRoute()
const unidade = ref(route.params.nome || 'Básico I') // Por default fica "Básico I"

watch(() => route.params.nome, (newVal) => {
  unidade.value = newVal
})
</script>


<template>
  <div class="flex h-screen">
    <Sidebar />
    <div class="flex-1 bg-gray-100 p-6 overflow-y-scroll">
      <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ unidade }}</h1>
      
      <!-- Lista de Módulos (ainda não está dinâmica)-->
      <div class="space-y-12">
        <UnidadeCard v-for="i in 6" :key="i" :titulo="`Módulo ${i}`" />
      </div>
    </div>
  </div>
</template>


