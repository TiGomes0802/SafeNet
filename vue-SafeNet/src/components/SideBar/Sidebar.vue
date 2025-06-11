<script setup>
    import { ref, onMounted, onUnmounted } from 'vue'
    import { useAuthStore } from '@/stores/auth'
    import { useCursoStore } from '@/stores/curso'
    import { useVidasStore } from '@/stores/vidas'
    import defaultAvatar from '@/assets/avatar-default-icon.png'
    import SidebarJogador from './SidebarJogador.vue'
    import SidebarBackoffice from './SidebarBackoffice.vue'

    const storeAuth = useAuthStore()
    const storeCurso = useCursoStore()
    const storeVidas = useVidasStore()

    const isOpen = ref(false)
    const tempoRestante = ref(null)
    const windowWidth = ref(window.innerWidth)
    let intervalo = null


    const updateWidth = () => {
        windowWidth.value = window.innerWidth
    }

    const calcularTempoRestante = () => {
        const user = storeAuth.user
        if (!user.ultima_vida_update || user.vida >= 5) {
            tempoRestante.value = null
            return
        }

        const update = new Date(user.ultima_vida_update)
        const proximaVida = new Date(update.getTime() + 5 * 60000)
        const agora = new Date()
        const diff = proximaVida - agora

        if (diff <= 0) {
            storeVidas.getVidas()
            return
        }

        const minutos = Math.floor(diff / 60000)
        const segundos = Math.floor((diff % 60000) / 1000)
        tempoRestante.value = `${minutos}:${segundos.toString().padStart(2, '0')}`
    }

    const logout = () => {
        storeAuth.logout()
    }

    const toggleSidebar = () => {
        isOpen.value = !isOpen.value
    }

    const handleLinkClick = () => {
        if (windowWidth.value < 768) {
            isOpen.value = false
        }
    }

    onMounted(async () => {
        window.addEventListener('resize', updateWidth)

        if (storeAuth.user?.type === 'J') {
            await Promise.all([
            storeAuth.getUser(),
            storeCurso.getCursos()
            ])
            calcularTempoRestante()
            intervalo = setInterval(calcularTempoRestante, 1000)
        }
    })

    onUnmounted(() => {
        window.removeEventListener('resize', updateWidth)
        clearInterval(intervalo)
    })
</script>



<template v-if="storeAuth.user?.type === 'J'">

    <!-- Mini sidebar para Responsividade-->
    <aside v-if="!isOpen && windowWidth < 768"
        class="inset-y-0 left-0  w-12 bg-white shadow-md z-40 flex flex-col items-center pt-4 md:hidden">
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
                { '-translate-x-full ': !isOpen && windowWidth < 768 },
                { 'left-0': isOpen || windowWidth >= 768 }
            ]">
            <!--Botão X-->
            <button @click="toggleSidebar" class="absolute top-4 right-4 md:hidden text-gray-600 hover:text-gray-800 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div>
                <!-- Ícone -->
                <img src="@/assets/SafeNetLogo.png" alt="Ícone" class="w-45 h-auto ml-1 mb-6 animate-fade-in" />
                
                <SidebarJogador :handleLinkClick="handleLinkClick" />

                <SidebarBackoffice :handleLinkClick="handleLinkClick" />
                
            </div>

            <div class="border-t pt-7 space-y-6">
                <div v-if="storeAuth.user?.type === 'J'" class="flex flex-row space-x-4 px-2">
                    <div class="block text-sm text-gray-700 font-semibold px-2">
                        {{ storeAuth.user.moedas }} 🪙
                    </div>
                    <div class="relative group block text-sm text-gray-700 font-semibold px-1">
                        {{ storeAuth.user.streak }}
                        {{ storeAuth.user.streakFeita ? '🔥' : '🌡️' }}
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 
                            bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-normal text-center
                            opacity-0 group-hover:opacity-100 transition-opacity z-50 w-48">
                                Uma streak é uma sequência de dias em que completaste pelo menos uma unidade.
                        </span>
                    </div>

                    <div class="relative group block text-sm text-gray-700 font-semibold px-2">
                        {{ storeAuth.user.vida }}
                        {{ storeAuth.user.vida === 0 ? '💔' : '❤️' }}
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 
                            bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap 
                            opacity-0 group-hover:opacity-100 transition-opacity z-50 ">
                                {{ storeAuth.user.vida >= 5 ? 'Já tens todas as vidas!' : 'Nova vida em ' + tempoRestante }}
                        </span>
                    </div>
                </div>
                <router-link :to="`/profile/${storeAuth.user.username}`"
                    class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-100 cursor-pointer"
                    @click="handleLinkClick">
                    <img :src= "storeAuth.user?.foto || defaultAvatar" alt="Foto de perfil"
                        class="w-9 h-9 rounded-full object-cover border" />
                    <span class="text-sm text-gray-700 font-semibold">{{ storeAuth.user?.username }}</span>
                </router-link>
                <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3" @click="logout">Logout
                </router-link>
            </div>
        </aside>
    </transition>
</template>
