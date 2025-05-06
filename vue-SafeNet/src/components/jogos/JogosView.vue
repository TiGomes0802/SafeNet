<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useJogoStore } from '@/stores/jogo'
import Sidebar from '@/components/Sidebar.vue'
import draggable from 'vuedraggable'

const route = useRoute()
const router = useRouter()
const idUnidade = route.params.idUnidade
const jogoStore = useJogoStore()

const perguntaAtual = ref(0)
const respostaSelecionada = ref(null)
const vidas = ref(4)

onMounted(async () => {
  await jogoStore.comecarJogo(idUnidade)
})

const pergunta = computed(() => jogoStore.jogos?.[perguntaAtual.value])
const totalPerguntas = computed(() => jogoStore.jogos?.length || 0)

const validarResposta = () => {

  const correta = pergunta.value?.resposta_correta
  if (respostaSelecionada.value !== correta) {
    vidas.value--
  }

  if (perguntaAtual.value < totalPerguntas.value - 1) {
    perguntaAtual.value++
    respostaSelecionada.value = null
  } else {
    router.push({ name: 'home' })
  }
}

const sair = () => {
  router.push({ name: 'home' })
}
</script>

<template>
  <div class="flex h-screen">

    <main class="flex-1 p-6 bg-white flex flex-col justify-between overflow-auto">
      <div v-if="pergunta" class="mb-8">
        <h2 class="text-xl font-bold mb-4">Pergunta {{ perguntaAtual + 1 }} - {{ pergunta.pergunta }}</h2>

        <!-- Escolha múltipla -->
        <ul v-if="pergunta.idTipo === 1" class="space-y-3">
          <li v-for="(opcao, index) in pergunta.opcoes" :key="index">
            <button @click="respostaSelecionada = opcao" :class="[
              'w-full text-left px-4 py-2 border rounded font-medium',
              respostaSelecionada === opcao ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
            ]">
              <strong>{{ String.fromCharCode(65 + index) }})</strong> {{ opcao }}
            </button>
          </li>
        </ul>

        <!-- Verdadeiro / Falso -->
        <div v-else-if="pergunta.idTipo === 2" class="space-y-3">
          <button @click="respostaSelecionada = true" :class="[
            'w-full px-4 py-2 border rounded font-medium',
            respostaSelecionada === true ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
          ]">
            Verdadeiro
          </button>
          <button @click="respostaSelecionada = false" :class="[
            'w-full px-4 py-2 border rounded font-medium',
            respostaSelecionada === false ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
          ]">
            Falso
          </button>
        </div>

        <!-- Ordenação -->
        <div v-else-if="pergunta.idTipo === 3" class="space-y-3">
          <draggable v-model="respostaSelecionada" item-key="id" class="space-y-2" ghost-class="ghost">
            <template #item="{ element, index }">
              <div class="p-3 border rounded bg-white shadow-sm cursor-move">
                {{ index + 1 }}. {{ element }}
              </div>
            </template>
          </draggable>
        </div>

        <!-- Tipo desconhecido -->
        <p v-else class="text-red-600">Tipo de pergunta não suportado.</p>
      </div>

      <!-- Vidas, Barra e butões -->
      <div class="flex items-center justify-between mb-4">
        <button @click="sair" class="bg-gray-300 px-5 py-2 rounded font-semibold">Sair</button>

        <div class="flex items-center space-x-1">
          <span class="text-red-600 font-bold text-xl">{{ vidas }}</span>
          <img src="/icons/vida.png" alt="Vida" class="w-20 h-15" />
          <div class="w-130 h-3 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-green-600" :style="{ width: ((perguntaAtual + 1) / totalPerguntas) * 100 + '%' }">
            </div>
          </div>
        </div>

        <button @click="validarResposta" :disabled="respostaSelecionada === null"
          class="bg-gray-300 px-5 py-2 rounded font-semibold disabled:opacity-50">
          Validar
        </button>
      </div>
    </main>
  </div>
</template>
