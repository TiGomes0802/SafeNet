<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useJogoStore } from '@/stores/jogo'
import draggable from 'vuedraggable'
import { useVidasStore } from '@/stores/vidas'
import ReportarPergunta from '@/components/reports/Report.vue'

const route = useRoute()
const router = useRouter()
const idUnidade = route.params.idUnidade
const jogoStore = useJogoStore()
const vidasStore = useVidasStore()

const perguntaAtual = ref(0)
const respostaSelecionada = ref(null)

const mostrar = ref(false)

onMounted(async () => {
  await jogoStore.comecarJogo(idUnidade)
  await vidasStore.getVidas()
})

const pergunta = computed(() => jogoStore.jogos?.[perguntaAtual.value])
const totalPerguntas = computed(() => jogoStore.jogos?.length || 0)

watch(pergunta, (novaPergunta) => {
  if (novaPergunta?.idTipo === 3) {
    respostaSelecionada.value = [...novaPergunta.respostas]
  }
}, { immediate: true })


const validarResposta = async () => {
  const tipo = pergunta.value?.idTipo

  // Escolha múltipla, V/F e Ordenação
  if (tipo === 1) {
    if (!respostaSelecionada.value?.correta) {
      await vidasStore.perderVida()
    }
  }
  else if (tipo === 2) {
    pergunta.value.respostas.forEach(async (resposta, index) => {
      if (respostaSelecionada.value[index] !== resposta.correta) {
        await vidasStore.perderVida()
      }
    })
  }
  else if(tipo === 3) {

    let respostaCorreta = true

    // Compara as respostas na ordem correta
    pergunta.value.respostas.forEach((resposta, index) => {
      if (respostaSelecionada.value[index].id !== resposta.id) {
        respostaCorreta = false
      }
    })

    if (!respostaCorreta) {
      await vidasStore.perderVida()
    }
  }


  // Por agora redireciona para a página inicial
  if (vidasStore.vidas <= 0) {
    router.push({ name: 'home' })
    return
  }

  // Avançar
  if (perguntaAtual.value < totalPerguntas.value - 1) {
    perguntaAtual.value++
    respostaSelecionada.value = []
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
          <li v-for="(opcao, index) in pergunta.respostas" :key="index">
            <button @click="respostaSelecionada = opcao" :class="[
              'w-full text-left px-4 py-2 border rounded font-medium',
              respostaSelecionada === opcao ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
            ]">
              <strong>{{ String.fromCharCode(65 + index) }})</strong> {{ opcao.resposta }}
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
        <!--
        <div v-else-if="pergunta.idTipo === 2" class="space-y-3">
          <button v-for="(opcao, index) in pergunta.respostas" :key="index" @click="respostaSelecionada = opcao" :class="[
            'w-full px-4 py-2 border rounded font-medium',
            respostaSelecionada === opcao ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
          ]">
            {{ opcao.resposta }}
          </button>
        </div>

        <div v-else-if="pergunta.idTipo === 2" class="space-y-3">
          <div v-for="(opcao, index) in pergunta.respostas" :key="index" class="space-y-2">
            <p>{{ opcao.resposta }}</p>

            <button @click="respostaSelecionada[index] = true" :class="[
              'w-full px-4 py-2 border rounded font-medium',
              respostaSelecionada[index] === true ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
            ]">
              Verdadeiro
            </button>
            <button @click="respostaSelecionada[index] = false" :class="[
              'w-full px-4 py-2 border rounded font-medium',
              respostaSelecionada[index] === false ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'
            ]">
              Falso
            </button>
          </div>
        </div>-->

        <!-- Ordenação -->
        <div v-else-if="pergunta.idTipo === 3" class="space-y-3">
          <draggable v-model="respostaSelecionada" item-key="resposta" class="space-y-2" ghost-class="ghost">
            <template #item="{ element, index }">
              <div class="p-3 border rounded bg-white shadow-sm cursor-move">
                {{ index + 1 }}. {{ element.resposta }}
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
          <span class="text-red-600 font-bold text-xl">{{ vidasStore.vidas }}</span>
          <img src="/icons/vida.png" alt="Vida" class="w-20 h-15" />
          <div class="w-130 h-3 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-green-600" :style="{ width: ((perguntaAtual + 1) / totalPerguntas) * 100 + '%' }">
            </div>
          </div>
        </div>

        <button @click="mostrar = true"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" >
          Reportar pergunta
        </button>

        <div v-if="mostrar">
          <ReportarPergunta :idJogo="pergunta.id" @fechar="mostrar = false"/>
        </div>
        
        <button @click="validarResposta" :disabled="respostaSelecionada === null"
          class="bg-gray-300 px-5 py-2 rounded font-semibold disabled:opacity-50">
          Validar
        </button>
      </div>
    </main>
  </div>
</template>
