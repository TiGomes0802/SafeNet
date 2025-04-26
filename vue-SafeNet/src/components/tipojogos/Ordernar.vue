<script setup>
  import { ref } from 'vue'
  import { useRoute } from 'vue-router'
  import { useJogoStore } from '@/stores/jogo'
  import draggable from 'vuedraggable'

  const jogoStore = useJogoStore()
  const route = useRoute()

  const idUnidade = route.params.idUnidade

  const jogo = ref({
    idUnidade: idUnidade,
    xp: 20,
    tipoJogo: 4,
    pergunta: '',
    respostas: ['', '', ''], 
  })

  const erros = ref({
    pergunta: false,
    respostas: [],
  })

  const AdicionarResposta = () => {
    if (jogo.value.respostas.length < 6) {
      jogo.value.respostas.push('')  
    }else {
      alert('Só pode adicionar até 6 respostas de cada vez')
    }
  }

  const RemoverResposta = () => {
    if (jogo.value.respostas.length > 3) {
      jogo.value.respostas.pop()
    }else {
      alert('Mínimo de 3 respostas atingido')
    }
  }

  function criarPergunta() {
    erros.value.pergunta = false
    erros.value.respostas = []
    
    // Verifica se a pergunta guia está vazia
    if (!jogo.value.pergunta.trim()) {
      erros.value.pergunta = true
    }

    // Verifica se há respostas vazias
    jogo.value.respostas.forEach((resposta, i) => {
      if (!resposta.trim()) {
          erros.value.respostas.push(i)
      }
    })

    // Se houver erros, não prossegue
    if (erros.value.pergunta || erros.value.respostas.length > 0) {
      return
    }

    jogo.value.pergunta = jogo.value.pergunta.trim()
    jogo.value.respostas = jogo.value.respostas.map(resposta => resposta.trim())

    jogoStore.createJogo(jogo.value)
  }
</script>

<template>
  <div class="mb-4">
    <div class="mb-4">
      <label class="block font-semibold mb-1">Pergunta guia:</label>
      <textarea v-model="jogo.pergunta" class="w-full pl-5 py-2 border-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.pergunta ? 'border-red-500' : 'border-black'" rows="3" />
    </div>
    <div class="max-w-xl mx-auto">
      <h2 class="text-xl font-semibold mb-4">Ordena as respostas</h2>
      <draggable v-model="jogo.respostas" class="space-y-2 " item-key="index">
        <template #item="{ element, index }">
          <div class="bg-white shadow rounded p-2 border flex items-center gap-2 cursor-move">
            <span class="items-center justify-center -top-[4px] relative text-xl text-gray-400">|</span>
            <input
              v-model="jogo.respostas[index]"
              type="text"
              class="flex-1 border-1 border-black rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
              :class="erros.respostas.includes(index) ? 'border-red-500' : 'border-black'"
              placeholder="Escreve a resposta"
            />
          </div>
        </template>
      </draggable>
      <div class="flex justify-end gap-4 mt-4">
        <button @click="AdicionarResposta" class="flex items-center justify-center text-blue-500 font-bold text-xl border-2 border-blue-500 rounded-full w-7 h-7 mt-1 hover:bg-blue-500 hover:text-black relative" >
            <span class="-top-[3px] relative">+</span>
        </button>
        <button @click="RemoverResposta" class="flex items-center justify-center text-red-500 font-bold text-xl border-2 border-red-500 rounded-full w-7 h-7 mt-1 hover:bg-red-500 hover:text-black relative" >
            <span class="-top-[3px] relative">-</span>
        </button>
      </div>
    </div>
    <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
      Criar pergunta
    </button>
  </div>
</template> 