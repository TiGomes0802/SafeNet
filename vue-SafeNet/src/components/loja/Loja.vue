<script setup>
import { ref, watch, onMounted, onUnmounted, computed, } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/Sidebar.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'

const loading = ref(true);

const windowWidth = ref(window.innerWidth)
const isSidebarOpen = ref(false)

const updateWidth = () => {
    windowWidth.value = window.innerWidth
}

const produtos = ref([
    { id: 1, nome: 'Produto 1', preco: 10, imagem: 'https://via.placeholder.com/150' },
    { id: 2, nome: 'Produto 2', preco: 20, imagem: 'https://via.placeholder.com/150' },
    { id: 3, nome: 'Produto 3', preco: 30, imagem: 'https://via.placeholder.com/150' },
    { id: 4, nome: 'Produto 4', preco: 40, imagem: 'https://via.placeholder.com/150' },
    { id: 5, nome: 'Produto 5', preco: 50, imagem: 'https://via.placeholder.com/150' },
])

onMounted(async () => {
    window.addEventListener('resize', updateWidth)
    loading.value = false
})

onUnmounted(() => {
    window.removeEventListener('resize', updateWidth)
})

const dynamicPadding = computed(() => {
    if (windowWidth.value < 768 && !isSidebarOpen.value) {
        return 'pl-20' // Padding 20 para loja não ficar por baixo da sidebar
    }
    return 'pl-10'  // Ecrãs maiores
})

</script>



<template>
    <div v-if="loading">
        <Loading />
    </div>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
        enter-to-class="opacity-100">
        <div class="flex h-screen">
            <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
            <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
                <h1 class="text-3xl font-bold text-blue-600 mb-6">Loja</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-15">
                    <div v-for="produto in produtos" :key="produto.id"
                        class="backdrop-blur-md bg-white/30 shadow-xl rounded-2xl p-4 flex flex-col items-center text-center transition hover:scale-105 duration-300">

                        <img :src="produto.imagem" alt="produto" class="w-24 h-24 object-contain mb-10" />

                        <p class="text-gray-800 font-semibold text-lg mb-2">{{ produto.nome }}</p>

                        <div class="text-yellow-600 font-bold text-sm flex items-center gap-1">
                            {{ produto.preco }} 🪙
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
