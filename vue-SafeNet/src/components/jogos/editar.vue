<script setup>
    import { onMounted, computed, ref, watch } from 'vue';  
    import { useJogoStore } from '@/stores/jogo'
    import Sidebar from '@/components/Sidebar.vue'
    import VerdadeiroFalso from '@/components/tipojogos/VerdadeiroFalso.vue';
    import EscolhaMultipla from '@/components/tipojogos/EscolhaMultipla.vue';
    import Ordernar from '@/components/tipojogos/Ordernar.vue';

    const jogoStore = useJogoStore()
    const props = defineProps(['idUnidade', 'idJogo']);
    
    onMounted(async () => {
        await jogoStore.getJogo(props.idJogo)
        console.log('Jogo:', jogoStore.jogo)
    });
    
    const jogoCarregado = computed(() => !!jogoStore.jogo && Object.keys(jogoStore.jogo).length > 0);

</script>


<template>
    <div class="flex">
        <Sidebar />
        <div v-if="jogoCarregado" class="flex-1 px-4 pt-6 bg-gray-200 w-screen h-screen overflow-y-scroll">
            <h1 class="text-3xl font-bold mb-4">Criar Pergunta</h1>

            <div class="mb-4">
            <label class="block font-semibold mb-1">Tipo de Pergunta:</label>
            <input type="text" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :value="jogoStore.jogo.tipoJogo" disabled/>
            </div>

            <VerdadeiroFalso v-if="jogoStore.jogo.idTipoJogo === 1" :modo="'editar'"/>
            <EscolhaMultipla v-if="jogoStore.jogo.idTipoJogo === 2" :modo="'editar'"/>
            <div v-else-if="jogoStore.jogo.idTipoJogo === 3"></div>
            <Ordernar v-if="jogoStore.jogo.idTipoJogo === 4" :modo="'editar'"/>
            <div v-else-if="jogoStore.jogo.idTipoJogo === 5"></div>
            <div v-else-if="jogoStore.jogo.idTipoJogo === 6"></div>
        </div> 
        <div v-else class="flex items-center justify-center w-full h-screen">
            <p class="text-xl font-medium">A carregar o jogo...</p>
        </div>
    </div>
    
</template>
  
 