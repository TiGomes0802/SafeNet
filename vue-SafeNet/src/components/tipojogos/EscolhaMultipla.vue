<script setup>
    import { ref, watch } from 'vue'
    import { useJogoStore } from '@/stores/jogo'
    import { useRoute } from 'vue-router'

    const jogoStore = useJogoStore()
    const route = useRoute()

    const idUnidade = route.params.idUnidade
    
    const props = defineProps(['tipoJogo'])
    
    const letras = ['A', 'B', 'C', 'D']
    const jogo = ref({
        idUnidade: idUnidade,
        xp: 20,
        pergunta: '',
        tipoJogo: 2,
        respostas: ['', '', '', ''],
        respostaCerta: '', 
    });

    const indexRespostaCerta = ref('')

    const erros = ref({
        pergunta: false,
        respostas: [],
        respostaCerta: false, 
    });

    const criarPergunta = () => {
        erros.value.pergunta = false
        erros.value.respostas = []
        erros.value.respostaCerta = false
        
        if (!jogo.value.pergunta.trim()) {
            erros.value.pergunta = true
        }

        // Verifica se há respostas vazias
        jogo.value.respostas.forEach((resposta, i) => {
            if (!resposta.trim()) {
                erros.value.respostas.push(i)
            }
        })

        // Verifica se a resposta certa está vazia
        if (indexRespostaCerta.value === '') {
            erros.value.respostaCerta = true
        }

        if (erros.value.pergunta || erros.value.respostas.length > 0 || erros.value.respostaCerta) {
            return
        }

        jogo.value.pergunta = jogo.value.pergunta.trim()

        console.log('Dados do jogo:', jogo.value)
        jogoStore.createJogo(jogo.value)
    };

    watch([
        () => indexRespostaCerta.value, 
        () => jogo.value.respostas[indexRespostaCerta.value]
        ], () => {
            jogo.value.respostaCerta = jogo.value.respostas[indexRespostaCerta.value]
        }
    )

</script>
<template>
    <div class="mb-4">
        <label class="block font-semibold mb-1">Pergunta:</label>
        <textarea v-model="jogo.pergunta" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.pergunta ? 'border-red-500' : 'border-black'" rows="3" />
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Respostas:</label>
        <div v-for="(letra, index) in letras" :key="index" class="flex items-center mb-2">
        <span class="w-6 font-bold">{{ letra }})</span>
        <input
            v-model="jogo.respostas[index]" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros?.respostas?.includes(index) ? 'border-red-500' : 'border-black'"
        />
        </div>
    </div>
    
    <div class="mb-4">
        <label class="block font-semibold mb-1">Resposta Certa:</label>
        <select v-model="indexRespostaCerta" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.respostaCerta ? 'border-red-500' : 'border-black'">
            <option value="" disabled>Selecione a resposta certa</option>
        <option v-for="(letra, index) in letras" :key="index" :value="index">{{ letra }})</option>
        </select>
    </div>

    <p v-if="erros.pergunta || erros?.respostas?.length || erros.respostaCerta" class="text-red-600 text-md font-bold mt-4 mb-4">
        Por favor preencha todos os campos antes de criar a pergunta.
    </p>

    <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
        Criar pergunta
    </button>

</template>