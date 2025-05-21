<script setup>
  import { ref, onMounted, computed, watch } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import draggable from 'vuedraggable'
  import { useJogoStore } from '@/stores/jogo'
  import { useVidasStore } from '@/stores/vidas'
  import { useUnidadeStore } from '@/stores/unidade'
  import ReportarPergunta from '@/components/reports/Report.vue'
  import DesistirJogo from '@/components/jogos/DesistirJogo.vue'
  import Loading from '@/components/loading/FrontofficeLaoding.vue'

  const route = useRoute()
  const router = useRouter()
  const storeUnidade = useUnidadeStore()
  const storeJogo = useJogoStore()
  const storeVidas = useVidasStore()

  const idUnidade = route.params.idUnidade

  const perguntaAtual = ref(0)
  const respostaSelecionada = ref([])
  const report = ref(false)
  const desistir = ref(false)
  const loading = ref(true);

  const pergunta = computed(() => storeJogo.jogos?.[perguntaAtual.value])
  const totalPerguntas = computed(() => storeJogo.jogos?.length || 0)

  const jogos = ref([])

  const validarResposta = async () => {
    const tipo = pergunta.value?.idTipo

    // Escolha múltipla, V/F e Ordenação
    if (tipo === 1) {
      let respostaCorreta = false;
      for (let i = 0; i < pergunta.value.respostas.length; i++) {
        if (respostaSelecionada.value.id == pergunta.value.respostas[i].id) {
          respostaCorreta = true
          break
        }
      }

      jogos.value.push({ idJogo: pergunta.value.id, acertou: respostaCorreta })

      if (!respostaCorreta) {
        await storeVidas.perderVida()
      }
    } else if (tipo === 2) {
      let respostaCorreta = true

      for (let i = 0; i < pergunta.value.respostas.length; i++) {
        if (respostaSelecionada.value[i] != pergunta.value.respostas[i].certa) {
          respostaCorreta = false
          break // já sabemos que está errada, não precisamos continuar
        }
      }

      jogos.value.push({ idJogo: pergunta.value.id, acertou: respostaCorreta })

      if (!respostaCorreta) {
        await storeVidas.perderVida() // só perde uma vida, mesmo com vários erros
      }

    } else if (tipo === 3) {

      let respostaCorreta = true

      for (let i = 0; i < pergunta.value.respostas.length; i++) {
        if (respostaSelecionada.value[i].certa != i + 1) {
          respostaCorreta = false
          break // já sabemos que está errada, não precisamos continuar
        }
      }

      if (!respostaCorreta) {
        await storeVidas.perderVida()
      }

      jogos.value.push({ idJogo: pergunta.value.id, acertou: respostaCorreta })
    }

    if (storeVidas.vidas <= 0) {
      router.push({ name: 'gameover', params: { idUnidade } })
      return
    }

    // Avançar
    if (perguntaAtual.value < totalPerguntas.value - 1) {
      perguntaAtual.value++
      respostaSelecionada.value = []
    } else {
      // Alterar para uma página de sucesso
      //router.push({ name: 'success' })
      storeUnidade.concluirUnidade(idUnidade, jogos.value)
    }
  }


  watch(pergunta, (novaPergunta) => {
    if (novaPergunta?.idTipo === 3) {
      respostaSelecionada.value = [...novaPergunta.respostas]
    }
  }, { immediate: true })

  onMounted(async () => {
    await storeJogo.comecarJogo(idUnidade)
    await storeVidas.getVidas()
    loading.value = false
  })

</script>

<template>
  <div v-if="loading">
    <Loading mensagem="A preparar as melhores perguntas para ti..." />
  </div>
  <transition
    name="fade"
    appear
    enter-active-class="transition-opacity duration-700"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
  >
    <div class="flex h-screen">
      <main class="flex-1 p-6 bg-white flex flex-col justify-between overflow-auto">
        <div v-if="pergunta" class="mb-8">
          <h2 class="text-xl font-bold mb-4">Pergunta {{ perguntaAtual + 1 }} - {{ pergunta.pergunta }}</h2>

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
        <div class="flex items-center justify-between mb-4">
          <button @click="desistir = true" class="bg-gray-300 px-5 py-2 rounded font-semibold">Sair</button>

          <div v-if="desistir">
            <DesistirJogo :idCurso="idCurso" :idUnidade="idUnidade"  @fecharSairJogo="desistir = false"/>
          </div>

          <div class="flex items-center space-x-1">
            <span class="text-red-600 font-bold text-xl">{{ storeVidas.vidas }}</span>
            <img src="/icons/vida.png" alt="Vida" class="w-20 h-15" />
            <div class="w-130 h-3 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-green-600" :style="{ width: ((perguntaAtual + 1) / totalPerguntas) * 100 + '%' }">
              </div>
            </div>
          </div>

          <button @click="report = true"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" >
            Reportar pergunta
          </button>

          <div v-if="report">
            <ReportarPergunta :idJogo="pergunta.id" @fecharReport="report = false"/>
          </div>        
          
          <button @click="validarResposta" :disabled="respostaSelecionada === null"
            class="bg-gray-300 px-5 py-2 rounded font-semibold disabled:opacity-50">
            Validar
          </button>
        </div>
      </main>
    </div>
  </transition>
</template>
