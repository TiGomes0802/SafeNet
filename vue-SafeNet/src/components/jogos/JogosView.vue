<script setup>
import { ref, onMounted, computed, watch, onBeforeUnmount } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import draggable from 'vuedraggable'
import { useJogoStore } from '@/stores/jogo'
import { useVidasStore } from '@/stores/vidas'
import { useAuthStore } from '@/stores/auth'
import { useUnidadeStore } from '@/stores/unidade'
import ReportarPergunta from '@/components/reports/Report.vue'
import DesistirJogo from '@/components/jogos/DesistirJogo.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'

const route = useRoute()
const router = useRouter()
const storeUnidade = useUnidadeStore()
const storeJogo = useJogoStore()
const storeVidas = useVidasStore()
const storeAuth = useAuthStore()

const idUnidade = route.params.idUnidade

const respostaSelecionada = ref([])
const report = ref(false)
const desistir = ref(false)
const loading = ref(true);

const tempo = ref(0);
let intervalo = null;

const indiceAtual = ref(0)
const pergunta = computed(() => filaPerguntas.value[indiceAtual.value])
const totalPerguntas = ref(0)

const jogos = ref([])

const filaPerguntas = ref([])
const perguntasErradas = ref([])
const progresso = ref(0) // para só avançar quando a resposta for correta

const mostrarFeedback = ref(false)
const respostaCorretaAtual = ref(false)


const validarResposta = async () => {
  const tipo = pergunta.value?.idTipo
  let respostaCorreta = false

  if (tipo === 1) {
    respostaCorreta = respostaSelecionada.value.certa === 1
  } else if (tipo === 2) {
    respostaCorreta = true
    for (let i = 0; i < pergunta.value.respostas.length; i++) {
      if (respostaSelecionada.value[i] != pergunta.value.respostas[i].certa) {
        respostaCorreta = false
        break
      }
    }
  } else if (tipo === 3) {
    respostaCorreta = true
    for (let i = 0; i < pergunta.value.respostas.length; i++) {
      if (respostaSelecionada.value[i].certa != i) {
        respostaCorreta = false
        break
      }
    }
  }

  if(!jogos.value.some(jogo => jogo.idJogo === pergunta.value.id )) {
    jogos.value.push({ idJogo: pergunta.value.id, acertou: respostaCorreta })
  }
  
  respostaCorretaAtual.value = respostaCorreta
  mostrarFeedback.value = true // Mostra o feedback
  
  if (!respostaCorreta) {
    await storeVidas.perderVida()
    perguntasErradas.value.push(pergunta.value) // guarda para repetir
  } else {
    progresso.value++

    // Se a pergunta já estava marcada como errada, removê-la
    const index = perguntasErradas.value.findIndex(p => p.id === pergunta.value.id)
    if (index !== -1) {
      perguntasErradas.value.splice(index, 1)
    }
  }

  if (storeAuth.user.vida <= 0) {
    router.push({ name: 'gameover', params: { idUnidade } })
    return
  }
}

const proximaPergunta = async () => {
  mostrarFeedback.value = false

  if (indiceAtual.value < filaPerguntas.value.length - 1) {
    indiceAtual.value++
    respostaSelecionada.value = []
  } else {
    if (perguntasErradas.value.length > 0) {
      filaPerguntas.value = [...perguntasErradas.value]
      perguntasErradas.value = []
      indiceAtual.value = 0
      respostaSelecionada.value = []
    } else {
      await storeUnidade.concluirUnidade(idUnidade, jogos.value, tempo.value)
    }
  }
}




watch(pergunta, (novaPergunta) => {
  if (novaPergunta?.idTipo === 2) {
    // Reinicializar com valores undefined para forçar nova resposta
    respostaSelecionada.value = Array(novaPergunta.respostas.length).fill(undefined)
  }
  else if (novaPergunta?.idTipo === 3) {
    respostaSelecionada.value = [...novaPergunta.respostas]
  } else {
    respostaSelecionada.value = []
  }
}, { immediate: true })

onMounted(async () => {
  await storeJogo.comecarJogo(idUnidade)
  await storeVidas.getVidas()
  filaPerguntas.value = [...storeJogo.jogos] // inicializa fila com todas as perguntas
  totalPerguntas.value = storeJogo.jogos.length
  loading.value = false
  intervalo = setInterval(() => {
    tempo.value += 1;
  }, 1000);
})

onBeforeUnmount(() => {
  clearInterval(intervalo);
});

</script>

<template>
  <div v-if="loading">
    <Loading mensagem="A preparar as melhores perguntas para ti..." />
  </div>
  <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
    enter-to-class="opacity-100">
    <div class="flex h-screen">
      <main class="flex-1 p-6 bg-white flex flex-col justify-between overflow-auto">
        <div v-if="pergunta" class="mb-8">
          <h2 class="text-xl font-bold mb-4">Pergunta {{ progresso + 1 }} - {{ pergunta.pergunta }}</h2>

          <!-- Escolha múltipla -->
          <ul v-if="pergunta.idTipo === 1" class="space-y-3">
            <li v-for="(opcao, index) in pergunta.respostas" :key="index">
              <button @click="respostaSelecionada = opcao" :class="[
                'w-full text-left px-4 py-2 border rounded font-medium',
                respostaSelecionada === opcao ? 'bg-gray-400 text-white' : 'hover:bg-gray-100'
              ]">
                <strong>{{ String.fromCharCode(65 + index) }})</strong> {{ opcao.resposta }}
              </button>
            </li>
          </ul>

          <!-- Verdadeiro / Falso -->
          <ul v-else-if="pergunta.idTipo === 2" class="space-y-3">
            <li v-for="(resposta, index) in pergunta.respostas" :key="index"
              class="flex items-center justify-between space-x-4 border rounded-md p-4 bg-gray-50">
              <span class="text-base font-medium">{{ resposta.resposta }}</span>
              <div class="flex space-x-2">
                <button @click="respostaSelecionada[index] = true" class="px-4 py-2 rounded font-semibold"
                  :class="[respostaSelecionada[index] === true ? 'bg-green-600 text-white' : 'bg-gray-200']">
                  V
                </button>
                <button @click="respostaSelecionada[index] = false" :class="[
                  'px-4 py-2 rounded font-semibold',
                  respostaSelecionada[index] === false ? 'bg-red-600 text-white' : 'bg-gray-200'
                ]">
                  F
                </button>
              </div>
            </li>
          </ul>

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
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
          <button @click="desistir = true"
            class="bg-gray-300 px-4 py-2 rounded font-semibold w-full md:w-auto">Sair</button>

          <div v-if="desistir">
            <DesistirJogo :idCurso="idCurso" :idUnidade="idUnidade" @fecharSairJogo="desistir = false" />
          </div>

          <div class="flex items-center space-x-1 w-full md:w-auto">
            <span class="text-red-600 font-bold text-xl">{{ storeAuth.user.vida }}</span>
            <img src="/icons/vida.png" alt="Vida" class="w-20 h-15" />
            <div class="w-130 h-3 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-green-600" :style="{ width: (progresso / totalPerguntas) * 100 + '%' }">
              </div>
            </div>
          </div>




          <button @click="validarResposta" :disabled="respostaSelecionada === null"
            class="bg-green-500 text-white px-4 py-2 rounded font-semibold transition-colors disabled:opacity-50 w-full md:w-auto">
            Validar
          </button>
        </div>
        <transition name="fade" appear>
          <div v-if="mostrarFeedback" class="fixed bottom-0 left-0 right-0 w-full z-50 pointer-events-none">
            <div :class="[
              'pointer-events-auto py-14 px-6 rounded-none text-center shadow-xl w-full',
              respostaCorretaAtual ? 'bg-green-100 border-t-4 border-green-200' : 'bg-red-100 border-t-4 border-red-200',
              'transition-all duration-300'
            ]">

              <div class="flex items-center justify-between w-full max-w-4xl mx-auto gap-8">
                <!-- Emoji e mensagens juntos -->
                <div class="flex items-center gap-3 flex-grow max-w-xs">
                  <div class="text-4xl">
                    <span v-if="respostaCorretaAtual" class="text-green-600">✅</span>
                    <span v-else class="text-red-600">❌</span>
                  </div>
                  <div class="flex flex-col text-left">
                    <h3 class="text-lg font-bold leading-tight">
                      {{ respostaCorretaAtual ? 'Incrível!' : 'Ohh, resposta errada...' }}
                    </h3>
                    <p class="text-sm text-gray-700">
                      {{ respostaCorretaAtual ? 'Continua assim!' : 'Tenta novamente da próxima vez!' }}
                    </p>
                  </div>
                </div>

                <button @click="report = true"
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full md:w-auto">
                  Reportar pergunta
                </button>

                <div v-if="report">
                  <ReportarPergunta :idJogo="pergunta.id" @fecharReport="report = false" />
                </div>

                <!-- Botão à direita -->
                <div class="flex-shrink-0">
                  <button @click="proximaPergunta"
                    class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                    Continuar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </main>
    </div>
  </transition>
</template>
