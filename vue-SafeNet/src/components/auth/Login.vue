<script setup>  
    import { ref } from 'vue'
    import { useRouter } from 'vue-router'
    import { useAuthStore } from '@/stores/auth'

    const router = useRouter()
    const storeAuth = useAuthStore()

    const missingFields = ref([]);

    const credentials = ref({
        email: '',
        password: ''
    })

    const login = () => {
        missingFields.value = []

        missingFields.value = Object.keys(credentials.value).filter(
            key => !credentials.value[key].trim()
        )

        if (missingFields.value.length > 0) return

        storeAuth.login(credentials.value)
    }

    const goToRegister = () => {
        router.push({ name: 'register' });
    };

</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-white px-4">
        <!-- Ícone -->
        <img src="@/assets/logo.svg" alt="Icone" class="w-32 h-32 mb-8" />

        <!-- Formulário -->
        <form @submit.prevent="login" class="flex flex-col items-center space-y-6">
            <div class="flex flex-col items-start w-full sm:w-100">
                <input id="email" type="email" class="w-full pl-5 py-2 border-1 border-black rounded-xl placeholder:text-black placeholder:font-bold" :class="missingFields.includes('email') ? 'border-red-500 placeholder:text-red-500' : 'border-black placeholder:text-black'" placeholder="Email:" v-model="credentials.email" />
            </div>

            <div class="flex flex-col items-start w-full sm:w-100">
                <input id="password" type="password" class="w-full pl-5 py-2 border-1 border-black rounded-xl placeholder:text-black placeholder:font-bold" :class="missingFields.includes('password') ? 'border-red-500 placeholder:text-red-500' : 'border-black placeholder:text-black'" placeholder="Password:" v-model="credentials.password"/>
                <!-- Mensagem de error de login -->
            </div>

            <div v-if="storeAuth.errorLogin" class="font-bold text-red-500 text-sm -mt-4">
                <p>Credenciais Incorretas! Tente Novamente!</p>
            </div>

            <div v-if="missingFields.length > 0" class="font-bold text-red-500 text-sm">
                <p>Preencha todos os campos</p>
            </div>

            <div class="flex space-x-1 sm:space-x-15">
                <button @click="goToRegister" type="button" class="px-8 py-2 border-1 border-black rounded-xl font-bold hover:bg-black hover:text-green-400">Registar</button>
                <button type="submit" class="px-8 py-2 border-1 border-black rounded-xl font-bold hover:bg-black hover:text-green-400">Login</button>
            </div>
        </form>
    </div>
</template>