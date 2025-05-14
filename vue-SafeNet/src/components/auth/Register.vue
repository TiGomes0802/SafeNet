<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const storeAuth = useAuthStore()

const missingFields = ref([]);
const loading = ref(false);
const credentials = ref({
    nome: '',
    username: '',
    email: '',
    password: ''
})

const register = async () => {
    missingFields.value = []

    missingFields.value = Object.keys(credentials.value).filter(
        key => !credentials.value[key].trim()
    )

    if (missingFields.value.length > 0) return

    loading.value = true

    try {
        await storeAuth.register(credentials.value)
    } finally {
        loading.value = false
    }
}

const goToLogin = () => {
    router.push({ name: 'login' })
}
</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-white to-gray-100 px-4">
        <!-- Ícone -->
        <img src="@/assets/SafeNetLogo.png" alt="Ícone" class="w-100 h-auto mb-10 animate-fade-in" />

        <!-- Formulário -->
        <form @submit.prevent="register" class="flex flex-col items-center space-y-6 w-full max-w-md">

            <input type="text" placeholder="Nome:"
                class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                :class="missingFields.includes('nome') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                v-model="credentials.nome" />

            <input type="text" placeholder="Username:"
                class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                :class="missingFields.includes('username') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                v-model="credentials.username" />

            <input type="email" placeholder="Email:"
                class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                :class="missingFields.includes('email') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                v-model="credentials.email" />

            <input type="password" placeholder="Password:"
                class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                :class="missingFields.includes('password') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                v-model="credentials.password" />

            <div v-if="storeAuth.errorResgistar" class="text-red-500 font-bold text-sm">
                {{ storeAuth.errorResgistar }}
            </div>

            <div v-if="missingFields.length > 0" class="text-red-500 font-bold text-sm">
                Preencha todos os campos
            </div>

            <div class="flex space-x-3 sm:space-x-6">
                <button @click="goToLogin" type="button" class="btn-soft">
                    Login
                </button>
                <button type="submit" class="btn-soft min-w-[6rem]" :disabled="loading">
                    <template v-if="!loading">Registar</template>
                    <template v-else>
                        <span class="spinner"></span>
                    </template>
                </button>
            </div>
        </form>
    </div>
</template>
