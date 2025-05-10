<script setup>

import { useRouter } from 'vue-router'
import { useCursoStore } from '@/stores/curso'

const router = useRouter()
const storeCurso = useCursoStore()

const voltarCurso = () => {
    router.push()
}
</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-white text-black text-center px-4">
        <h1 class="text-6xl font-extrabold text-red-600 drop-shadow-md mb-10">Ohhhhh! 😵</h1>
        <p class="text-4xl sm:text-5xl font-bold text-black-200 mb-10">Infelizmente ficaste sem vidas! 💔</p>

        <p class="text-2xl sm:text-3xl font-semibold text-gray-600 mb-20">Tenta novamente mais tarde ou
            adquire mais vidas na loja!</p>

        <button @click="voltarCurso"
            class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
            Voltar ao Menu
        </button>
    </div>
</template>