<script setup>
    import { ref, onMounted } from 'vue'
    import { useJogoStore } from '@/stores/jogo'
    import { useRoute } from 'vue-router'

    const jogoStore = useJogoStore()
    const route = useRoute()

    const idUnidade = route.params.idUnidade

    const props = defineProps(['modo'])

    const jogo = ref({
        idUnidade: idUnidade,
        xp: 25,
        tipoJogo: 1,
        pergunta: '',
        respostas: ['', '', ''],
        respostaCerta: ['', '', ''], 
    });

    const erros = ref({
        pergunta: false,
        respostas: [],
        respostaCerta: [], 
        xp: false,
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
        erros.value.xp = false

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

        // Verifica se o XP é válido
        if (jogo.value.xp == null || jogo.value.xp === '' || jogo.value.xp < 0 || jogo.value.xp > 100) {
            erros.value.xp = true
        }

        console.log('jogo', jogo.value)

        // Se houver erros, não prossegue
        if (erros.value.pergunta || erros.value.respostas.length > 0 || erros?.respostaCerta?.length || erros.value.xp) {
            return
        }

        jogo.value.pergunta = jogo.value.pergunta.trim()

        
        if (props.modo === 'editar' && jogoStore.jogo) {
            console.log('atualizando jogo', jogo.value)
            jogoStore.updateJogo(jogo.value)
        } else{
            console.log('criando jogo', jogo.value)
            jogoStore.createJogo(jogo.value)
        }

    };


    onMounted(async () => {
        if (props.modo === 'editar' && jogoStore.jogo) {
            jogo.value.idUnidade = jogoStore.jogo.idUnidade;
            jogo.value.xp = jogoStore.jogo.xp;
            jogo.value.pergunta = jogoStore.jogo.pergunta;
            for (let i = 0; i < jogoStore.jogo.respostas.length; i++) {
                jogo.value.respostas[i] = jogoStore.jogo.respostas[i].resposta;
                jogo.value.respostaCerta[i] = jogoStore.jogo.respostas[i].certa == 1 ? 1 : 0;
            }
        }
    });

</script>
<template>
    <div class="mb-4">
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pergunta guia:</label>
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

    <p v-if="erros.pergunta || erros?.respostas?.length || erros?.respostaCerta?.length  || erros.xp" class="text-red-600 text-md font-bold mt-4 mb-4">
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