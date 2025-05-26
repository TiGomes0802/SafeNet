<script setup>
import { useMissaoStore } from '@/stores/missao';
import Sidebar from '@/components/Sidebar.vue'

const storeMissao = useMissaoStore();

</script>

<template>


    <div class="flex h-screen">
        <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
        <!--<div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
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
        </div>-->
        <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
            <div class="flex flex-col items-center justify-start w-full mx-auto bg-gray-100">
                <div class="m-5 md:m-10 lg:m-[60px] w-[65%]">
                    <div class="flex flex-col items-center justify-between w-full mx-auto mb-10">
                        <div class="flex flex-col sm:flex-row items-center justify-between w-full mb-4">
                            <p class="text-4xl">Missões Diárias</p>
                            <p class="text-2xl justify-end text-yellow-400">5 Horas ⏰</p>
                        </div>
                        <div class="flex flex-col border-3 border-gray-600 rounded-lg bg-white p-2 w-full">
                            <div v-for="missao in storeMissao.missoes" :key="missao.id"
                                class="flex flex-col items-center w-full my-5">
                                <p class="text-xl font-semibold text-center w-2/6 mb-4">{{ missao.missao.descricao }}
                                </p>
                                <div class="relative flex flex-row w-[93%] bg-gray-200 rounded-full h-6 mb-2">
                                    <div class="bg-green-500 h-6 rounded-full transition-all duration-300"
                                        :style="{ width: ((missao.progresso / missao.missao.objetivo) * 100) + '%' }">
                                    </div>
                                    <p
                                        class="absolute inset-0 flex items-center justify-center text-sm text-gray-600 font-medium select-none">
                                        {{ missao.progresso }} / {{ missao.missao.objetivo }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-between w-full mx-auto">
                        <div class="flex flex-col w-full mb-4">
                            <p class="text-4xl text-center">Conquistas</p>
                        </div>
                        <div class="flex flex-col border-3 border-gray-600 rounded-lg bg-white p-2 w-full">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                                <div v-for="conquista in storeMissao.conquistas" :key="conquista.id"
                                    class="flex flex-col items-center w-full my-5 border-2 border-gray-600 rounded-lg bg-white p-2">
                                    <h3 class="text-md font-semibold text-center mb-4">{{ conquista.missao.descricao }}
                                    </h3>
                                    <div class="relative flex flex-row w-[93%] bg-gray-200 rounded-full h-6">
                                        <div class="bg-green-500 h-6 rounded-full transition-all duration-300"
                                            :style="{ width: ((conquista.progresso / conquista.missao.objetivo) * 100) + '%' }">
                                        </div>
                                        <p
                                            class="absolute inset-0 flex items-center justify-center text-sm text-gray-600 font-medium select-none">
                                            {{ conquista.progresso }} / {{ conquista.missao.objetivo }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>