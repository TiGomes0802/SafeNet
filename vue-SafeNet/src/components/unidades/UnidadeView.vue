<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { usePaginaStore } from '@/stores/pagina'
import { useCursoStore } from '@/stores/curso'
import { useAuthStore } from '@/stores/auth'
import Sidebar from '@/components/sideBar/Sidebar.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'

const route = useRoute()
const storeCurso = useCursoStore()
const storePagina = usePaginaStore()
const storeAuth = useAuthStore()

const idUnidade = route.params.idUnidade
const paginaVisivel = computed(() => storePagina.paginas[paginaAtual.value])
const loading = ref(true);

const paginaAtual = ref(0)

const proximaPagina = () => {
  if (paginaAtual.value < storePagina.paginas.length - 1) {
    paginaAtual.value++
  }
}

const paginaAnterior = () => {
  if (paginaAtual.value > 0) {
    paginaAtual.value--
  }
}

onMounted(async () => {
  await Promise.all([
    storeCurso.getCursos(),
    storePagina.getPaginas(idUnidade)
  ])
  loading.value = false
})
</script>

<template>
  <div v-if="loading">
    <Loading mensagem="A preparar o conteúdo da Unidade..." />
  </div>
  <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
    enter-to-class="opacity-100">
    <div class="flex h-screen">
      <Sidebar />
      <main class="flex-1 p-6 bg-gray-100 overflow-auto flex flex-col justify-between">
        <div>
          <div class="flex flex-col pb-4 sm:pb-0 sm:flex-row">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">
              {{ storeCurso.curso?.nome }} | Unidade {{ idUnidade }}
            </h1>
            <div class="sm:justify-end flex-grow text-right">
              <RouterLink :to="`/unidade/${idUnidade}/jogos/play`" class="px-4 py-2 text-white rounded"
                :class="storeAuth.user.vida === 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600'"
                :disabled="storeAuth.user.vida === 0">
                Avaliar
              </RouterLink>
            </div>
          </div>
          <div class="bg-white p-6 rounded shadow min-h-[200px]">
            <p v-if="storePagina.paginas.length > 0" v-html="paginaVisivel.descricao"></p>
            <p v-else>A carregar páginas...</p>
          </div>
        </div>

        <!-- Navegação entre páginas -->
        <div class="mt-8 relative flex items-center justify-center">
          <button v-if="paginaAtual > 0" @click="paginaAnterior"
            class="absolute left-0 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded">
            ← Voltar
          </button>

          <div class="text-gray-600 font-semibold">
            Página {{ paginaAtual + 1 }} de {{ storePagina.paginas.length }}
          </div>

          <button v-if="paginaAtual < storePagina.paginas.length - 1" @click="proximaPagina"
            class="absolute right-0 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
            Avançar →
          </button>
        </div>
      </main>
    </div>
  </transition>
</template>
