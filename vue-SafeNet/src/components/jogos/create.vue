<script setup>
    import { onMounted, ref, watch } from 'vue';
    import { useRoute } from 'vue-router'
    import { useJogoStore } from '@/stores/jogo'
    import { useTipoJogoStore } from '@/stores/tipoJogo'
    import Sidebar from '@/components/Sidebar.vue'
    import VerdadeiroFalso from '@/components/tipojogos/VerdadeiroFalso.vue';
    import EscolhaMultipla from '@/components/tipojogos/EscolhaMultipla.vue';
    import Ordernar from '@/components/tipojogos/Ordernar.vue';

    const jogoStore = useJogoStore()
    const tipoJogoStore = useTipoJogoStore()
    const route = useRoute()

    const props = defineProps(['idUnidade'])
    
    const jogo = ref({
        idUnidade: props.idUnidade,
        xp: 20,
        pergunta: '',
        tipoJogo: '',
        respostas: [],
        respostaCerta: '', 
    });

    const dadosTipoJogo = ref({})


    const erros = ref({
        pergunta: false,
        respostas: [],
        respostaCerta: false, 
    });

    const tiposJogos = ref([])

    const criarPergunta = () => {
        erros.value.pergunta = false
        erros.value.respostas = []
        erros.value.respostaCerta = false
        
        if (!jogo.value.pergunta.trim()) {
            erros.value.pergunta = true
        }

        if (jogo.value.tipoJogo == 2) {
        
            // Verifica se há respostas vazias
            dadosTipoJogo.value.respostas.forEach((resposta, i) => {
                if (!resposta.trim()) {
                    erros.value.respostas.push(i)
                }
            })

            // Verifica se a resposta certa está vazia
            if (dadosTipoJogo.value.indexRespostaCerta === '') {
                erros.value.respostaCerta = true
            }

        }

        if (erros.value.pergunta || erros.value.respostas.length > 0 || erros.value.respostaCerta) {
            return
        }

        jogo.value.pergunta = jogo.value.pergunta.trim()
        jogo.value.respostas = dadosTipoJogo.value.respostas;
        jogo.value.respostaCerta = dadosTipoJogo.value.respostaCerta;

        console.log('Dados do jogo:', jogo.value)
        jogoStore.createJogo(jogo.value)
    };

    onMounted(async () => {
        await tipoJogoStore.getTipoJogos()
    });

    watch(
        () => tipoJogoStore.tiposjogos,
        (novosTipos) => {
            tiposJogos.value = novosTipos;
            if (novosTipos && novosTipos.length > 0) {

                jogo.value.tipoJogo = novosTipos[0].id;
            }
        },
        { immediate: true }
    );
</script>


<template>
    <div class="flex">
        <Sidebar />
        <div class="flex-1 px-4 pt-6 sm:px-6 md:px-9 md:pt-7 lg:px-12 lg:pt-9 xl:px-16 xl:pt-10 bg-gray-200 w-screen h-screen overflow-y-scroll">
        <h1 class="text-3xl font-bold mb-4">Criar Pergunta</h1>
    
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipo de Pergunta:</label>
            <select v-model="jogo.tipoJogo" class="w-full pl-5 py-2 border-1 border-black rounded-md">
            <option v-for="tipo in tiposJogos" :key="tipo.id" :value="tipo.id">{{ tipo.tipo }}</option>            
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Pergunta:</label>
            <textarea v-model="jogo.pergunta" class="w-full pl-5 py-2 border-1 border-black rounded-md" :class="erros.pergunta ? 'border-red-500' : 'border-gray-300'" rows="3" />
        </div>
    
        <VerdadeiroFalso v-if="jogo.tipoJogo === 1" v-model="dadosTipoJogo" />

        <EscolhaMultipla v-if="jogo.tipoJogo === 2" v-model="dadosTipoJogo" :erros="erros" />
        
        <div v-else-if="jogo.tipoJogo === 3">
            
        </div>

        <Ordernar v-if="jogo.tipoJogo === 4" v-model="dadosTipoJogo" />

        <div v-else-if="jogo.tipoJogo === 5">
            
        </div>
        <div v-else-if="jogo.tipoJogo === 6">
            
        </div>
        
        <p v-if="erros.pergunta || erros?.respostas?.length || erros.respostaCerta" class="text-red-600 text-md font-bold mt-4 mb-4">
            Por favor preencha todos os campos antes de criar a pergunta.
        </p>

        <button @click="criarPergunta" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
            Criar
        </button>
        </div>  
    </div>
</template>
  
 