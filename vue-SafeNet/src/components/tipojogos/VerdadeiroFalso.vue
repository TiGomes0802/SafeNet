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
        tipoJogo: 2,
        perguntaguia: '',
        perguntas: ['', '', ''],
        respostas: ['', '', ''], 
    });

    const erros = ref({
        perguntaguia: false,
        perguntas: [],
        respostas: [], 
    });

    const AdicionarResposta = () => {
        if (jogo.value.perguntas.length < 10) {
            jogo.value.perguntas.push('')
            jogo.value.respostas.push('')
        }else {
            alert('Só pode adicionar até 10 perguntas de cada vez')
        }
    }

    const RemoverResposta = () => {
        if (jogo.value.perguntas.length > 1) {
            jogo.value.perguntas.pop()
            jogo.value.respostas.pop()
        }else {
            alert('Mínimo de 1 perguntas atingido')
        }
    }

    const criarPergunta = () => {
        erros.value.perguntaguia = false
        erros.value.perguntas = []
        erros.value.respostas = []


        // Verifica se há pergunta vazias
        jogo.value.perguntas.forEach((pergunta, i) => {
            if (!pergunta.trim()) {
                erros.value.perguntas.push(i)
            }
            jogo.value.perguntas[i] = pergunta.trim()
        })
        
        // Verifica se a resposta V/F está vazia
        jogo.value.respostas.forEach((resposta, i) => {

            if (resposta === '') {
                erros.value.respostas.push(i)
            }
            //if (!resposta.trim()) {
            //    erros.value.respostas.push(i)
            //}
        })

        // Verifica se a pergunta guia está vazia
        if (!jogo.value.perguntaguia.trim()) {
            erros.value.perguntaguia = true
        }

        if (erros.value.perguntas.length > 0 || erros.value.respostas.length > 0 || erros.value.perguntaguia) {
            return
        }

        jogo.value.perguntaguia = jogo.value.perguntaguia.trim()

        console.log('Dados do jogo:', jogo.value)
        //jogoStore.createJogo(jogo.value)
    };

</script>
<template>
    <div class="mb-4">
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pergunta guia:</label>
            <textarea v-model="jogo.perguntaguia" class="w-full pl-5 py-2 border-1 border-black rounded-md" :class="erros.perguntaguia ? 'border-red-500' : 'border-black'" rows="3" />
        </div>
        <label class="block font-semibold mb-1">Pergunta:</label>
        <div v-for="(resposta, index) in jogo.perguntas" :key="index" class="flex items-center mb-4 gap-x-2 gap-y-2 flex-wrap lg:flex-nowrap">
            <span class="w-6 font-bold">{{ index + 1 }})</span>
            <input v-model="jogo.perguntas[index]" class="w-full pl-5 py-2 border-1 border-black rounded-md" :class="erros?.perguntas?.includes(index) ? 'border-red-500' : 'border-black'"/>
            <select v-model="jogo.respostas[index]" class="w-full lg:w-45 pl-5 py-2 border-1 border-black rounded-md" :class="erros?.respostas?.includes(index) ? 'border-red-500' : 'border-black'">
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

    <p v-if="erros?.perguntas?.length || erros?.respostas?.length || erros.perguntaguia" class="text-red-600 text-md font-bold mt-4 mb-4">
        Por favor preencha todos os campos antes de criar a pergunta.
    </p>

    <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
        Criar
    </button>


</template>