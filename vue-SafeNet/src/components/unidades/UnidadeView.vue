<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import axios from 'axios'

const route = useRoute()
const curso = route.params.curso
const idUnidade = route.params.idUnidade

const paginas = ref([])

const fetchPaginas = async () => {
  try {
    const response = await axios.get(`/unidade/${idUnidade}/getPaginas`)
    paginas.value = response.data || []
  } catch (error) {
    console.error("Erro ao buscar páginas da unidade:", error)
  }
}

onMounted(() => {
  fetchPaginas()
})

const paginaAtual = ref(0)

const proximaPagina = () => {
  if (paginaAtual.value < paginas.value.length - 1) {
    paginaAtual.value++
  }
}

const paginaAnterior = () => {
  if (paginaAtual.value > 0) {
    paginaAtual.value--
  }
}
</script>

<template>
  <div class="flex h-screen">
    <Sidebar />
    <main class="flex-1 p-6 bg-gray-100 overflow-auto flex flex-col justify-between">
      <div>
        <h1 class="text-2xl font-bold text-blue-600 mb-4">
          Curso: {{ curso }} | Unidade: {{ idUnidade }}
        </h1>

        <div class="bg-white p-6 rounded shadow min-h-[200px]">
          <p>{{ paginas[paginaAtual]?.descricao }}</p>
        </div>
      </div>

      <!-- Navegação entre páginas -->
      <div class="mt-8 flex justify-between items-center">
        <button
          v-if="paginaAtual > 0"
          @click="paginaAnterior"
          class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded"
        >
          ← Voltar
        </button>

        <div class="flex-1"></div>

        <button
          v-if="paginaAtual < paginas.length - 1"
          @click="proximaPagina"
          class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded"
        >
          Avançar →
        </button>

        <button
          v-else
          class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded"
        >
          Avaliar
        </button>
      </div>
    </main>
  </div>
</template>
