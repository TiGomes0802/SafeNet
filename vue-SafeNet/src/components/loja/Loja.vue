<script setup>
import { ref, onMounted, computed, onUnmounted } from 'vue'
import { useLojaStore } from '@/stores/loja'
import Sidebar from '@/components/Sidebar.vue'
import Loading from '@/components/loading/FrontofficeLaoding.vue'
import { useCoinsStore } from '@/stores/coins'

const coinsStore = useCoinsStore()
const lojaStore = useLojaStore()
const loading = ref(true);

const windowWidth = ref(window.innerWidth)
const isSidebarOpen = ref(false)

const updateWidth = () => {
    windowWidth.value = window.innerWidth
}

onMounted(async () => {
    window.addEventListener('resize', updateWidth)
    await lojaStore.fetchProdutos()
    loading.value = false
})

onUnmounted(() => {
    window.removeEventListener('resize', updateWidth)
})


// Apenas mostrar produtos ativos
const produtos = computed(() => lojaStore.produtos.filter(p => p.estado === 1))

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

                        <img :src="produto.tipo_produto.imagem" alt="produto"
                            class="w-30 h-30 object-contain mt-5 mb-7" />

                        <p class="text-gray-800 font-semibold text-lg mb-2">{{ produto.nome }}</p>

                        <div class="text-yellow-600 font-bold text-lg flex items-center gap-1">
                            {{ produto.preco }} 🪙
                        </div>

                        <button @click="coinsStore.comprarProduto(produto.id)"
                            class="mt-8 bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded">
                            Comprar
                        </button>

                    </div>
                </div>
                <button @click="coinsStore.ganharMoedas(100)" class="bg-blue-500 text-white ml-250 px-4 py-2 rounded">
                    Ganhar 100 moedas
                </button>
            </div>
        </div>
    </transition>
</template>
