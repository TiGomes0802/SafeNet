<script setup>
    import { useMissaoStore } from '@/stores/missao';
    import Sidebar from '@/components/Sidebar.vue'

    const storeMissao = useMissaoStore();

</script>

<template>

    
    <div class="flex h-screen">
        <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
        <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
            <div class="flex flex-col gap-4">
                <p class="text-3xl ">Missões</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="missao in storeMissao.missoes" :key="missao.id" class="bg-white p-4 rounded shadow">
                        <h3 class="text-xl font-semibold">{{ missao.missao.descricao }}</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                            <div
                                class="bg-green-500 h-4 rounded-full transition-all duration-300"
                                :style="{ width: ((missao.progresso / missao.missao.objetivo) * 100) + '%' }"
                            ></div>
                        </div>
                        <p class="text-sm text-gray-600">
                            {{ missao.progresso }} / {{ missao.missao.objetivo }}
                        </p>
                    </div>
                </div>
                <p class="text-3xl">Conquistas</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="conquista in storeMissao.conquistas" :key="conquista.id" class="bg-white p-4 rounded shadow">
                        <h3 class="text-xl font-semibold">{{ conquista.missao.descricao }}</h3>
                        <p>{{ conquista.progresso }} / {{ conquista.missao.objetivo }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>