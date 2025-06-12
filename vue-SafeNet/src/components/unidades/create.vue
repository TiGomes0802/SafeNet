<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import Sidebar from '@/components/sideBar/Sidebar.vue'
import { useUnidadeStore } from '@/stores/unidade'

const route = useRoute()
const router = useRouter()
const unidadeStore = useUnidadeStore()

const cursoId = route.params.idCurso

const titulo = ref('')
const descricao = ref('')

const criarUnidade = async () => {
  try {
    const response = await axios.post(`/cursos/${cursoId}/unidades`, {
      titulo: titulo.value,
      descricao: descricao.value,
    })
    router.push(`/backoffice/cursos/${cursoId}/unidades`)
  } catch (error) {
    console.error('Erro ao criar unidade:', error)
  }
}
</script>


<template>
  <div class="flex min-h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <h1 class="text-2xl font-bold mb-6">Criar Unidade</h1>

      <form @submit.prevent="criarUnidade" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div>
          <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
          <input id="titulo" v-model="titulo" type="text"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required />
        </div>

        <div>
          <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
          <textarea id="descricao" v-model="descricao" rows="3"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required></textarea>
        </div>

        <button type="submit" class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded">
          Criar
        </button>
      </form>
    </main>
  </div>
</template>
