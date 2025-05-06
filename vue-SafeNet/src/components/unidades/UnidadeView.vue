<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import { usePaginaStore } from '@/stores/pagina'
import { useCursosStore } from '@/stores/curso'

const route = useRoute()
const idUnidade = route.params.idUnidade
const cursoId = parseInt(route.params.idCurso)
const cursosStore = useCursosStore()
const paginaStore = usePaginaStore()
const paginaVisivel = computed(() => paginaStore.paginas[paginaAtual.value])

onMounted(async () => {
  await cursosStore.getCursos()
  await paginaStore.getPaginas(idUnidade)

  //console.log('Páginas carregadas:', paginaStore.paginas)
})

const paginaAtual = ref(0)

const proximaPagina = () => {
  if (paginaAtual.value < paginaStore.paginas.length - 1) {
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
          {{ cursosStore.getCurso(cursoId)?.nome }} | Unidade: {{ idUnidade }}
        </h1>
        <div class="bg-white p-6 rounded shadow min-h-[200px]">
          <p v-if="paginaStore.paginas.length > 0" v-html="paginaVisivel.descricao"></p>
          <p v-else>A carregar páginas...</p>
        </div>
      </div>

      <!-- Navegação entre páginas -->
      <div class="mt-8 flex justify-between items-center">
        <button v-if="paginaAtual > 0" @click="paginaAnterior"
          class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded">
          ← Voltar
        </button>

        <div class="flex-1"></div>

        <button v-if="paginaAtual < paginaStore.paginas.length - 1" @click="proximaPagina"
          class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
          Avançar →
        </button>

        <button v-else>
          <RouterLink :to="`/unidade/${idUnidade}/jogos/play`"
            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded">
            Avaliar
          </RouterLink>
        </button>
      </div>
    </main>
  </div>
</template>
