<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const storeAuth = useAuthStore()

const missingFields = ref([]);
const loading = ref(false);

const credentials = ref({
    email: '',
    password: ''
})

const login = async () => {
    missingFields.value = []

    missingFields.value = Object.keys(credentials.value).filter(
        key => !credentials.value[key].trim()
    )

    if (missingFields.value.length > 0) return

    loading.value = true

    try {
        await storeAuth.login(credentials.value)
    } finally {
        loading.value = false
    }
}

const goToRegister = () => {
    router.push({ name: 'register' });
};

</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-white to-gray-100 px-4">
        <!-- Ícone -->
        <img src="@/assets/logo.svg" alt="Ícone" class="w-28 h-28 mb-6 animate-fade-in" />

        <!-- Formulário -->
        <form @submit.prevent="login" class="flex flex-col items-center space-y-6 w-full max-w-md">
            <div class="w-full">
                <input id="email" type="email"
                    class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                    :class="missingFields.includes('email') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                    placeholder="Email:" v-model="credentials.email" />
            </div>

            <div class="w-full">
                <input id="password" type="password"
                    class="w-full px-5 py-3 border rounded-xl text-black placeholder:font-semibold transition-all duration-300"
                    :class="missingFields.includes('password') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'"
                    placeholder="Password:" v-model="credentials.password" />
            </div>

            <transition name="fade">
                <div v-if="storeAuth.errorLogin" class="text-red-500 font-bold text-sm -mt-3">
                    Credenciais incorretas! Tente novamente!
                </div>
            </transition>

            <transition name="fade">
                <div v-if="missingFields.length > 0" class="text-red-500 font-bold text-sm">
                    Preencha todos os campos
                </div>
            </transition>

            <div class="flex space-x-3 sm:space-x-6">
                <button @click="goToRegister" type="button" class="btn-soft">
                    Registar
                </button>

                <button type="submit" class="btn-soft min-w-[6rem]" :disabled="loading">
                    <template v-if="!loading">Login</template>
                    <template v-else>
                        <span class="spinner"></span>
                    </template>
                </button>
            </div>

        </form>
    </div>
</template>
