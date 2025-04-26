<script setup>
    import { ref, watch } from 'vue'
    import { useJogoStore } from '@/stores/jogo'
    import { useRoute } from 'vue-router'

    const jogoStore = useJogoStore()
    const route = useRoute()

    const idUnidade = route.params.idUnidade

    const props = defineProps(['tipoJogo'])

    const jogo = ref({
        idUnidade: idUnidade,
        xp: 20,
        tipoJogo: 1,
        pergunta: '',
        respostas: ['', '', ''],
        respostaCerta: ['', '', ''], 
    });

    const erros = ref({
        pergunta: false,
        respostas: [],
        respostaCerta: [], 
    });

    const AdicionarResposta = () => {
        if (jogo.value.respostas.length < 10) {
            jogo.value.respostas.push('')
            jogo.value.respostaCerta.push('')
        }else {
            alert('Só pode adicionar até 10 respostas de cada vez')
        }
    }

    const RemoverResposta = () => {
        if (jogo.value.respostas.length > 1) {
            jogo.value.respostas.pop()
            jogo.value.respostaCerta.pop()
        }else {
            alert('Mínimo de 1 respostas atingido')
        }
    }

    const criarPergunta = () => {
        erros.value.pergunta = false
        erros.value.respostas = []
        erros.value.respostaCerta = []

        // Verifica se há pergunta vazias
        jogo.value.respostas.forEach((pergunta, i) => {
            if (!pergunta.trim()) {
                erros.value.respostas.push(i)
            }
            jogo.value.respostas[i] = pergunta.trim()
        })
        
        // Verifica se a resposta V/F está vazia
        jogo.value.respostaCerta.forEach((resposta, i) => {
            if (resposta === '') {
                erros.value.respostaCerta.push(i)
            }
        })

        // Verifica se a pergunta guia está vazia
        if (!jogo.value.pergunta.trim()) {
            erros.value.pergunta = true
        }

        // Se houver erros, não prossegue
        if (erros.value.respostas.length > 0 || erros.value.respostaCerta.length > 0 || erros.value.pergunta) {
            return
        }

        jogo.value.pergunta = jogo.value.pergunta.trim()

        console.log('Dados do jogo:', jogo.value)
        jogoStore.createJogo(jogo.value)
    };

</script>
<template>
    <div class="mb-4">
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pergunta guia:</label>
            <textarea v-model="jogo.pergunta" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.pergunta ? 'border-red-500' : 'border-black'" rows="3" />
        </div>
        <label class="block font-semibold mb-1">Pergunta:</label>
        <div v-for="(resposta, index) in jogo.respostas" :key="index" class="flex items-center mb-4 gap-x-2 gap-y-2 flex-wrap lg:flex-nowrap">
            <span class="w-6 font-bold">{{ index + 1 }})</span>
            <input v-model="jogo.respostas[index]" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros?.respostas?.includes(index) ? 'border-red-500' : 'border-black'"/>
            <select v-model="jogo.respostaCerta[index]" class="w-full lg:w-45 pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros?.respostaCerta?.includes(index) ? 'border-red-500' : 'border-black'">
                <option value="" disabled>Resposta</option>
                <option :value="1">Verdadeiro</option>
                <option :value="0">Falso</option>
            </select>
        </div>
        <div class="flex justify-end gap-4">
            <button @click="AdicionarResposta" class="flex items-center justify-center text-blue-500 font-bold text-xl border-2 border-blue-500 rounded-full w-7 h-7 mt-1 hover:bg-blue-500 hover:text-black relative" >
                <span class="-top-[3px] relative">+</span>
            </button>
            <button @click="RemoverResposta" class="flex items-center justify-center text-red-500 font-bold text-xl border-2 border-red-500 rounded-full w-7 h-7 mt-1 hover:bg-red-500 hover:text-black relative" >
                <span class="-top-[3px] relative">-</span>
            </button>
        </div>
    </div>

    <p v-if="erros?.respostas?.length || erros?.respostaCerta?.length || erros.pergunta" class="text-red-600 text-md font-bold mt-4 mb-4">
        Por favor preencha todos os campos antes de criar a pergunta.
    </p>

    <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
        Criar pergunta
    </button>


</template>