<script setup>
    import { ref, computed, onMounted, watch } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    import Sidebar from '@/components/Sidebar.vue'
    import Loading from '@/components/loading/FrontofficeLaoding.vue'
    import { useAuthStore } from '@/stores/auth'
    import { useAmigoStore } from '@/stores/amigo'
    import defaultAvatar from '@/assets/avatar-default-icon.png'

    const route = useRoute()
    const router = useRouter()
    const storeAuth = useAuthStore()
    const storeAmigo = useAmigoStore()
    const windowWidth = ref(window.innerWidth)
    const isSidebarOpen = ref(false)
    const apiDomain = import.meta.env.VITE_API_DOMAIN
    
    const username = route.params.username

    const loading = ref(true)
    const loadingAdicionar = ref(true)
    
    const isOwnProfile = ref(true)
    const user = ref()

    const adicionarAmigo = async () => {
        loadingAdicionar.value = false;
        
        await storeAmigo.enviarPedido(user.value.username)
        user.value = await storeAuth.getUserByUsername(username)
    
        loadingAdicionar.value = true
    };

    const carregarPerfil = async (username) => {
        console.log('Carregando perfil para o usuário:', username)
        if (storeAuth.user?.username === username) {
            user.value = storeAuth.user
            isOwnProfile.value = true
        } else {
            const fetchedUser = await storeAuth.getUserByUsername(username)
            user.value = fetchedUser
            isOwnProfile.value = false
        }
    }

    const updateWidth = () => {
        windowWidth.value = window.innerWidth
    }

    onMounted(async () => {
        await carregarPerfil(route.params.username)

        window.addEventListener('resize', updateWidth)
        setTimeout(() => loading.value = false, 300)     
    })

    watch(() => route.params.username, (newName) => {
        carregarPerfil(newName)
    })

    const dynamicPadding = computed(() => {
        if (windowWidth.value < 768 && !isSidebarOpen.value) {
            return 'pl-20'
        }
        return 'pl-10'
    })

    const rankColorClass = computed(() => {
        switch (user.value.rank) {
            case 'Bronze':
                return 'text-yellow-800'
            case 'Prata':
                return 'text-gray-400'
            case 'Ouro':
                return 'text-yellow-500'
            case 'Platina':
                return 'text-blue-400'
            case 'Diamante':
                return 'text-cyan-300'
            case 'Mestre':
                return 'text-purple-600'
            default:
                return 'text-gray-600'
        }
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
                <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-8 mt-10 flex flex-col items-center">
                    <img :src= "user?.foto || defaultAvatar" alt="Foto de perfil"
                            class="w-32 h-32 rounded-full border-4 border-blue-300 object-cover mb-6" />
                    <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ user?.nome }}</h1>
                    <p class="text-lg text-gray-600 mb-4">@{{ user?.username }}</p>
                    <template v-if="user?.type === 'J'">
                        <div class="flex flex-wrap gap-8 justify-center mb-6">
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-semibold text-yellow-600">{{ user?.xp }}</span>
                                <span class="text-gray-500 text-sm">XP</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-semibold" :class="rankColorClass">{{ user?.rank }}</span>
                                <span class="text-gray-500 text-sm">Rank</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-semibold text-orange-600">{{ user?.streak }} {{ user.streakFeita ? '🔥' : '🌡️' }}</span>
                                <span class="text-gray-500 text-sm">Streak</span>
                            </div>
                            <div v-if="storeAuth.user?.username === route.params.username" class="flex flex-col items-center">
                                <span class="text-xl font-semibold text-blue-600">{{ user?.congelar }} ❄️</span>
                                <span class="text-gray-500 text-sm">Congelar</span>
                            </div>
                        </div>
                    </template>
                    <div class="w-full border-t pt-6 mt-4 flex flex-col items-center">
                        <p class="text-gray-700 mb-2">
                            <span class="font-semibold">Email:</span> {{ user?.email }}
                        </p>
                        <p class="text-gray-700 mb-2" v-if="user?.type">
                            <span class="font-semibold">Tipo: </span>
                            <span v-if="user?.type === 'J'">Jogador</span>
                            <span v-else-if="user?.type === 'G'">Gestor</span>
                            <span v-else-if="user?.type === 'A'">Administrador</span>
                            <span v-else>{{ user?.type }}</span>
                        </p>
                    </div>
                    <!-- Botões de ação futuros -->
                    <div class="mt-6 flex gap-4">
                        <button class="btn-soft" @click="() => router.push({ name: 'UpdatePerfil' })" v-if="isOwnProfile">Editar Perfil</button>
                        <button class="btn-soft" @click="adicionarAmigo" :disabled="!loadingAdicionar" v-if="!isOwnProfile && !user?.isFriend && !user?.isHaveRequest">Adicionar Amigo</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>