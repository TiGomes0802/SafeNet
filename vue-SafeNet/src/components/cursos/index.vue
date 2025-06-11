<script setup>
import { onMounted } from 'vue'
import { useCursoStore } from '@/stores/curso'
import Sidebar from '@/components/Sidebar.vue'

const storeCurso = useCursoStore()

onMounted(async () => {
  storeCurso.getCursos()
})

function alterarEstado(id) {
  storeCurso.alterarEstadoCurso(id)
}

</script>

<template>
  <div class="flex h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Cursos</h1>

        <router-link to="/backoffice/cursos/create"
          class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
          Criar Curso
        </router-link>
      </div>

      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-6 py-3">Nome</th>
            <th class="px-6 py-3">Unidades</th>
            <th class="px-6 py-3">Estado</th>
            <th class="px-6 py-3">Alterar</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="curso in storeCurso.cursos" :key="curso.id" class="border-t hover:bg-gray-50">
            <td class="px-6 py-4">{{ curso.nome }}</td>
            <td class="px-6 py-4">
              <router-link :to="`/backoffice/cursos/${curso.id}/unidades`"
                class="ml-5 inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-sm font-medium hover:bg-blue-200">
                {{ curso.unidades.length }}
              </router-link>
            </td>
            <td class="px-6 py-4">
              <span class="inline-block px-3 py-1 rounded-full text-sm"
                :class="curso.estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                {{ curso.estado == 1 ? 'Ativo' : 'Desativo' }}
              </span>
            </td>
            <td class="px-6 py-4">
              <button @click="alterarEstado(curso.id)" class="px-4 py-2 rounded font-semibold
                transition-colors duration-200
                focus:outline-none
                text-white
                " :class="curso.estado === 1
                  ? 'bg-red-400 hover:bg-red-500'
                  : 'bg-green-400 hover:bg-green-500'">
                {{ curso.estado === 1 ? 'Desativar' : 'Ativar' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>
