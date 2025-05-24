<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { useMissaoStore } from '@/stores/missao';
    import Sidebar from '@/components/Sidebar.vue';
    import Loading from '@/components/loading/FrontofficeLaoding.vue'

    const storeMissao = useMissaoStore();

    const loading = ref(true);
    const tempoRestante = ref('');

    let intervalo = 0;

    function atualizarTempo() {
        const agora = new Date();
        const meiaNoite = new Date();
        meiaNoite.setHours(24, 0, 0, 0);

        const diff = meiaNoite.getTime() - agora.getTime();

        const horas = Math.floor(diff / (1000 * 60 * 60));
        const minutos = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const segundos = Math.floor((diff % (1000 * 60)) / 1000);

        if (horas >= 1) {
            tempoRestante.value = `🕑 ${horas.toString().padStart(2)} Horas`;
        } else {
            tempoRestante.value = `🕑 ${minutos.toString().padStart(2, '0')} Minutos`;
        }
    }
    
    onMounted(() => {
        storeMissao.getMinhasmissoes();
        atualizarTempo();
        intervalo = setInterval(atualizarTempo, 1000);
        loading.value = false;
    });

    onUnmounted(() => {
        clearInterval(intervalo);
    });
</script>

<template>
    
    <div v-if="loading || storeMissao.missoes.length === 0">
        <Loading />
    </div>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div class="flex h-screen overflow-y-auto">
            <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
            <div class="flex flex-col items-center justify-start w-full mx-auto bg-gray-100 overflow-y-scroll">
                <div class="m-5 md:m-10 w-[90%] md:w-[75%]">
                    <div class="flex flex-col items-center justify-between w-full mx-auto mb-10">
                        <div class="flex flex-col sm:flex-row items-center justify-between w-full mb-4">
                            <p class="text-4xl">Missões Diárias</p>
                            <p class="text-2xl justify-end text-yellow-400">{{ tempoRestante }}</p>
                        </div>
                        <div class="flex flex-col border-3 border-gray-600 rounded-lg bg-white p-2 w-full">
                            <div v-for="missao in storeMissao.missoes" :key="missao.id" class="flex flex-col items-center w-full my-4">
                                <p class="text-xl font-semibold text-center w-5/7 mb-5">{{ missao.missao.descricao }}</p>
                                <div class="relative flex flex-row w-[93%] bg-gray-200 rounded-full h-6 mb-2">
                                    <div class="h-6 rounded-full"
                                        :class="missao.concluida ? 'bg-yellow-400' : 'bg-green-500'"
                                        :style="{ width: ((missao.progresso / missao.missao.objetivo) * 100) + '%' }">
                                    </div>
                                    <p class="absolute inset-0 flex items-center justify-center text-sm text-gray-600 font-medium select-none">
                                        {{ missao.progresso }} / {{ missao.missao.objetivo }}
                                    </p>
                                </div>
                                <div v-if="missao.concluida" class="text-sm text-center text-yellow-600 font-semibold">
                                    +{{ missao.missao.moedas }} moedas
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-between w-full mx-auto">
                        <div class="flex flex-col w-full mb-4">
                            <p class="text-4xl text-center">Conquistas</p>
                        </div>
                        <div class="flex flex-col border-3 border-gray-600 rounded-lg bg-white w-full mb-10">
                            <div class="grid grid-cols-1 sm:grid-cols-2 w-full p-3">
                                <div v-for="conquista in storeMissao.conquistas" :key="conquista.id"
                                  class="flex flex-col justify-between items-center w-full my-4 p-2 min-h-22">
                                    <h3 class="text-md font-semibold text-center mb-3 w-[90%]">
                                        {{ conquista.missao.descricao }}
                                    </h3>
                                    <div class="relative flex flex-row w-[93%] bg-gray-200 rounded-full h-6">
                                        <div class="h-6 rounded-full"
                                            :class="conquista.concluida ? 'bg-yellow-400' : 'bg-green-500'"
                                            :style="{ width: ((conquista.progresso / conquista.missao.objetivo) * 100) + '%' }">
                                        </div>
                                        <p class="absolute inset-0 flex items-center justify-center text-sm text-gray-600 font-medium select-none">
                                            {{ conquista.progresso }} / {{ conquista.missao.objetivo }}
                                        </p>
                                    </div>
                                    <div v-if="conquista.concluida" class="text-sm text-center text-yellow-600 font-semibold">
                                        +{{ conquista.missao.moedas }} moedas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>