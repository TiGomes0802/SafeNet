<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import UnidadeCard from '@/components/UnidadeCard.vue'

const route = useRoute()
const curso = ref(route.params.nome)

watch(() => route.params.nome, (newVal) => {
  curso.value = newVal
})
</script>


<template>
  <div class="flex h-screen">
    <Sidebar />
    <div class="flex-1 bg-gray-100 p-6 overflow-y-scroll">
      <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ curso }}</h1>

      <!-- Lista de Unidades (/modulo/nº)
       Não está dinâmica, só vai até 6-->
      <div class="space-y-12">
        <router-link v-for="i in 6" :key="i" :to="`/curso/${curso}/unidade/${i}`" class="block block transform transition duration-300 hover:scale-101 hover:shadow-lg">
          <UnidadeCard :titulo="`Unidade ${i}`" />
        </router-link>
      </div>
    </div>
  </div>
</template>
