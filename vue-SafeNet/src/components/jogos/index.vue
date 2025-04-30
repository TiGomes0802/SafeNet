<script setup>
    import { onMounted, watch } from 'vue'
    import { useRouter } from 'vue-router'
    import { useJogoStore } from '@/stores/jogo'
    import Sidebar from '@/components/Sidebar.vue'
    import Ordernar from '../tipojogos/ShowOrdenar.vue'
    import VerdadeiroFalso from '../tipojogos/ShowVerdadeiroFalso.vue'
    import EscolhaMultipla from '../tipojogos/ShowEscolhaMultipla.vue'

    const router = useRouter()
    const jogoStore = useJogoStore()

    const props = defineProps(['idUnidade'])

    onMounted(async () => {
        await jogoStore.getJogos(props.idUnidade);
    });

    //waht para ver ficar a lista de jogos atualizada
    watch(() => jogoStore.jogos, (newJogos) => {
        console.log('Lista de jogos atualizada:', newJogos);
    });
</script>

<template>
    <div class="flex">
        <Sidebar />
        <div class="flex-1 bg-gray-200 w-screen h-screen overflow-y-scroll">
            <div class="row w-5/6 justify-center mx-auto mt-4 pt-10">
                <p class="text-3xl mb-3">Jogos</p>
                <div class="flex flex-col gap-y-7 px-5 pt-3">
                    <div v-for="(jogo, index) in jogoStore.jogos" :key="jogo.id">
                        <div class="bg-white p-4 rounded-lg shadow-xl flex flex-col gap-y-1">
                            <p class="text-2xl">{{ index + 1 }}º pergunta</p>
                            <div class="px-4 py-2 rounded-lg shadow-xl">
                                <p class="text-lg py-1">Tipo de jogo: {{ jogo.tipoJogo }}</p>
                                <p class="text-lg py-2">{{ jogo.pergunta }}</p>
                                <div class="items-center gap-x-2 mb-3">
                                    <div v-if="jogo.idTipoJogo === 1">
                                        <VerdadeiroFalso :respostas="jogo.respostas" />
                                    </div>
                                    <div v-else-if="jogo.idTipoJogo === 2">
                                        <EscolhaMultipla :respostas="jogo.respostas" />
                                    </div>
                                    <div v-else-if="jogo.idTipoJogo === 4">
                                        <Ordernar :respostas="jogo.respostas" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center mt-4 gap-x-4">
                                <button @click="$router.push({ name: 'EditarJogo', params: { idUnidade: props.idUnidade, idJogo: jogo.id } })" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
                                    Editar Jogo
                                </button>
                                <div v-if="jogo.estado">
                                    <!--butao para mudar o estado para não ativo-->
                                    <button @click="jogoStore.mudarEstadoJogo(jogo.id, props.idUnidade)" class="bg-red-300 hover:bg-red-400 text-black font-semibold py-2 px-4 rounded">
                                        Desativar Jogo
                                    </button>
                                </div>
                                <div v-else>
                                    <!--butao para mudar o estado para ativo-->
                                    <button @click="jogoStore.mudarEstadoJogo(jogo.id, props.idUnidade)" class="bg-green-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                        Ativar Jogo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>