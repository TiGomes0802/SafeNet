<script setup>
    import { onMounted, ref, watch } from 'vue';  
    import { useTipoJogoStore } from '@/stores/tipoJogo'
    import Sidebar from '@/components/Sidebar.vue'
    import VerdadeiroFalso from '@/components/tipojogos/VerdadeiroFalso.vue';
    import EscolhaMultipla from '@/components/tipojogos/EscolhaMultipla.vue';
    import Ordernar from '@/components/tipojogos/Ordernar.vue';

    const tipoJogoStore = useTipoJogoStore()

    const props = defineProps(['idUnidade'])

    const tiposJogos = ref([])
    const tipoJogo = ref('')

    onMounted(async () => {
        await tipoJogoStore.getTipoJogos()
    });

    watch(
        () => tipoJogoStore.tiposjogos,
        (novosTipos) => {
            tiposJogos.value = novosTipos;
            if (novosTipos && novosTipos.length > 0) {

                tipoJogo.value = novosTipos[0].id;
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
                <select v-model="tipoJogo" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                <option v-for="tipo in tiposJogos" :key="tipo.id" :value="tipo.id">{{ tipo.tipo }}</option>            
                </select>
            </div>
        
            <VerdadeiroFalso v-if="tipoJogo === 1" />
            <EscolhaMultipla v-if="tipoJogo === 2" />
            <Ordernar v-if="tipoJogo === 3" />
        </div>  
    </div>
</template>
  
 