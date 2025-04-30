<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'

const nome = ref('')
const estado = ref('inativo')
const router = useRouter()
const route = useRoute()


const carregarCurso = async () => {
  try {
    const response = await axios.get(`/api/cursos/${route.params.id}`)
    nome.value = response.data.nome
    estado.value = response.data.estado
  } catch (error) {
    console.error('Erro ao carregar curso:', error)
  }
}


const atualizarCurso = async () => {
  try {
    await axios.put(`/api/cursos/${route.params.id}`, {
      nome: nome.value,
      estado: estado.value
    })
    router.push('/backoffice/cursos')
  } catch (error) {
    console.error('Erro ao atualizar curso:', error)
  }
}

onMounted(() => {
  carregarCurso()
})
</script>

<template>
  <div class="flex min-h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <h1 class="text-2xl font-bold mb-6">Editar Curso</h1>

      <form @submit.prevent="atualizarCurso" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div>
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            id="nome"
            v-model="nome"
            type="text"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            required
          />
        </div>

        <button
          type="submit"
          class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded"
        >
          Salvar
        </button>
      </form>
    </main>
  </div>
</template>
