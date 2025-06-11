<script setup>
import { useCursoStore } from '@/stores/curso'
import Sidebar from '@/components/SideBar/Sidebar.vue'

const storeCurso = useCursoStore()

const criarCurso = async () => {
  storeCurso.createCurso(nome.value)
}
</script>

<template>
  <div class="flex min-h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <h1 class="text-2xl font-bold mb-6">Criar Curso</h1>

      <form @submit.prevent="criarCurso" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div>
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
          <input id="nome" v-model="nome" type="text" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            required />
        </div>

        <button type="submit" class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded">
          Criar
        </button>
      </form>
    </main>
  </div>
</template>
