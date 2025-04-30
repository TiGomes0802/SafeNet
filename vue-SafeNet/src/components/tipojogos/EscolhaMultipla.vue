<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useJogoStore } from '@/stores/jogo'
    import { useRoute } from 'vue-router'

    const jogoStore = useJogoStore()
    const route = useRoute()

    const idUnidade = route.params.idUnidade

    const props = defineProps(['modo'])
    
    const letras = ['A', 'B', 'C', 'D']
    const jogo = ref({
        idUnidade: idUnidade,
        xp: 25,
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
        xp: false,
    });

    const criarPergunta = () => {
        erros.value.pergunta = false
        erros.value.respostas = []
        erros.value.respostaCerta = false
        erros.value.xp = false
        
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

        // Verifica se o XP é válido
        if (jogo.value.xp == null || jogo.value.xp === '' || jogo.value.xp < 0 || jogo.value.xp > 100) {
            erros.value.xp = true
        }

        if (erros.value.pergunta || erros.value.respostas.length > 0 || erros.value.respostaCerta || erros.value.xp) {
            return
        }

        jogo.value.pergunta = jogo.value.pergunta.trim()

        if (props.modo === 'editar' && jogoStore.jogo) {
            jogoStore.updateJogo(jogo.value)
        } else {
            jogoStore.createJogo(jogo.value)
        }
    };

    onMounted(() => {
        if (props.modo === 'editar' && jogoStore.jogo) {
            jogo.value.idUnidade = jogoStore.jogo.idUnidade;
            jogo.value.xp = jogoStore.jogo.xp;
            jogo.value.pergunta = jogoStore.jogo.pergunta;
            for (let i = 0; i < jogoStore.jogo.respostas.length; i++) {
                jogo.value.respostas[i] = jogoStore.jogo.respostas[i].resposta;
                if (jogoStore.jogo.respostas[i].certa == 1) {
                    jogo.value.respostaCerta = jogoStore.jogo.respostas[i].resposta
                    indexRespostaCerta.value = i
                }
            }
        }
    })

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
        <label class="block font-semibold mb-1">XP:</label>
        <select v-model="jogo.xp" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.xp ? 'border-red-500' : 'border-black'">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
        </select>
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
    <p v-if="erros.pergunta || erros?.respostas?.length || erros.respostaCerta || erros.xp" class="text-red-600 text-md font-bold mt-4 mb-4">
        Por favor preencha todos os campos antes de criar a pergunta.
    </p>
    <div v-if="props.modo === 'editar' && jogoStore.jogo" class="mb-4">
        <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
            Atualizar pergunta
        </button>
    </div>
    <div v-else class="mb-4">
        <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
            Criar pergunta
        </button>
    </div>
</template>