<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useCoinsStore } from '@/stores/coins'
import { useCursoStore } from '@/stores/curso'

const storeAuth = useAuthStore()
const storeCoins = useCoinsStore()
const storeCurso = useCursoStore()
const isOpen = ref(false)
const windowWidth = ref(window.innerWidth)

const updateWidth = () => {
    windowWidth.value = window.innerWidth
}

onMounted(() => {
    window.addEventListener('resize', updateWidth)
    if (storeAuth.user?.type === 'J') {
        storeCurso.getCursos()
    }
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


<template v-if="storeAuth.user?.type === 'J'">

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
                <!-- Ícone -->
                <img src="@/assets/SafeNetLogo.png" alt="Ícone" class="w-45 h-auto ml-1 mb-6 animate-fade-in" />
                <div v-if="storeAuth.user?.type === 'J'">
                    <div class="mb-6">
                        <h2 class="text-sm font-semibold text-gray-500 mb-2 px-3">Cursos</h2>
                        <nav class="space-y-2">
                            <router-link
                                v-for="curso in storeCurso.cursos"
                                :key="curso.id"
                                :to="curso.estado !== 0 ? `/curso/${curso.id}` : ''"
                                class="block py-2 px-6 rounded"
                                :class="curso.estado === 0 ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'hover:bg-gray-100 text-black'"
                                @click="curso.estado === 0 ? $event.preventDefault() : handleLinkClick"
                                >
                                    {{ curso.nome }}
                            </router-link>
                        </nav>
                    </div>

                    <nav class="space-y-1 mt-8">
                        <router-link to="/missoes" class="block py-2 px-3 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Missões</router-link>
                        <router-link to="/estatisticas" class="block py-2 px-3 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Ranking</router-link>
                        <router-link to="/loja" class="block py-2 px-3 rounded hover:bg-gray-100"
                            @click="handleLinkClick">Loja</router-link>
                    </nav>
                </div>

                <!-- Sidebar para Gestores e Admins ---------------------------------------------------------------------->
                <div v-if="storeAuth.user?.type === 'G' || storeAuth.user?.type === 'A'" class="pt-8">
                    <h2 class="text-sm font-semibold text-gray-500 mb-4 px-3">Gestão</h2>
                    <nav class="space-y-2 flex flex-col justify-start">
                        <router-link to="/backoffice/cursos"
                            class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
                            @click="handleLinkClick">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3.78552 9.5 12.7855 14l9-4.5-9-4.5-8.99998 4.5Zm0 0V17m3-6v6.2222c0 .3483 2 1.7778 5.99998 1.7778 4 0 6-1.3738 6-1.7778V11" />
                            </svg>


                            <span>Cursos</span>
                        </router-link>

                        <router-link to="/backoffice/estatisticas"
                            class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
                            @click="handleLinkClick">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
                            </svg>

                            <span>Estatísticas</span>
                        </router-link>

                        <router-link to="/backoffice/reports"
                            class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
                            @click="handleLinkClick">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                            </svg>

                            <span>Reports</span>
                        </router-link>

                        <router-link to="/backoffice/users"
                            class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
                            @click="handleLinkClick">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Users</span>
                        </router-link>
                    </nav>
                </div>
            </div>

            <div class="border-t pt-7 space-y-6">
                <div v-if="storeAuth.user?.type === 'J'" class="block text-sm text-gray-700 font-semibold px-3">{{
                    storeCoins.gameCoins }} 🪙</div>
                <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3"
                    @click="handleLinkClick">Perfil</router-link>
                <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3"
                    @click="logout">Logout</router-link>
            </div>
        </aside>
    </transition>
</template>
