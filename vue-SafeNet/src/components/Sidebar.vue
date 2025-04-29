<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useCoinsStore } from '@/stores/coins'

const storeAuth = useAuthStore()
const isOpen = ref(false)
const windowWidth = ref(window.innerWidth)
const storeCoins = useCoinsStore();

const updateWidth = () => {
    windowWidth.value = window.innerWidth
}

onMounted(() => {
    window.addEventListener('resize', updateWidth)
})

onUnmounted(() => {
    window.removeEventListener('resize', updateWidth)
})

const logout = () => {
    storeAuth.logout()
}

const toggleSidebar = () => {
    isOpen.value = !isOpen.value
}

// Para fechar sidebar quando o utilizador clica num link
const handleLinkClick = () => {
    if (windowWidth.value < 768) {
        isOpen.value = false
    }
}

</script>


<template>
    <!-- Mini sidebar para Responsividade-->
    <aside v-if="!isOpen && windowWidth < 768"
        class="fixed inset-y-0 left-0 w-12 bg-white shadow-md z-40 flex flex-col items-center pt-4 md:hidden">
        <button @click="toggleSidebar" class="text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </aside>


    <transition name="slide">
        <aside v-if="isOpen || windowWidth >= 768"
            class="fixed md:static inset-y-0 z-40 w-64 bg-white shadow-md p-4 flex flex-col justify-between transform transition-transform duration-300 md:translate-x-0"
            :class="[
                { '-translate-x-full': !isOpen && windowWidth < 768 },
                { 'left-0': isOpen || windowWidth >= 768 }
            ]">
            <!--Botão X-->
            <button @click="toggleSidebar" class="absolute top-4 right-4 md:hidden text-gray-600 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div>
                <h1 class="text-2xl font-bold mb-6">SafeNet</h1>

                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-500 mb-2 px-3">Cursos</h2>
                    <nav class="space-y-2">
                        <router-link to="/unidade/Engenharia Social" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Engenharia Social</router-link>
                        <router-link to="/unidade/Autenticação" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Autenticação</router-link>
                        <router-link to="/unidade/Malware" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Malware</router-link>
                        <router-link to="/unidade/Redes Sociais" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Redes
                            Sociais</router-link>
                        <router-link to="/unidade/Sistemas Operativos" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Sistemas Operativos</router-link>
                        <router-link to="/unidade/Navegação" class="block py-2 px-6 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Navegação
                            na Internet</router-link>
                    </nav>
                </div>

                <nav class="space-y-1 mt-8">
                    <router-link to="/missoes" class="block py-2 px-3 rounded hover:bg-gray-100"
                        @click="handleLinkClick">Missões</router-link>
                    <router-link to="/estatisticas" class="block py-2 px-3 rounded hover:bg-gray-100"
                        @click="handleLinkClick">Estatísticas</router-link>
                    <router-link to="/loja" class="block py-2 px-3 rounded hover:bg-gray-100"
                        @click="handleLinkClick">Loja</router-link>
                </nav>
            </div>

            <div class="border-t pt-7 space-y-6">
                <div class="block text-sm text-gray-700 font-semibold px-3">{{ storeCoins.gameCoins }} 🪙</div>
                <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3"
                    @click="handleLinkClick">Perfil</router-link>
                <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3"
                    @click="logout">Logout</router-link>
            </div>
        </aside>
    </transition>
</template>
