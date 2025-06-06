<script setup>
    import { ref, computed, onMounted } from 'vue'
    import { useAuthStore } from '@/stores/auth'
    import Sidebar from '@/components/Sidebar.vue'
    import Loading from '@/components/loading/FrontofficeLaoding.vue'

    const storeAuth = useAuthStore()
    const user = ref(null)
    const windowWidth = ref(window.innerWidth)
    const isSidebarOpen = ref(false)

    const loading = ref(true)
    const loadingUpdate = ref(true)
    const previewFoto = ref(null)

    const form = ref({
        nome: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        foto: null
    })

    const erros = ref({
        nome: '',
        username: '',
        password: '',
        password_confirmation: ''
    })

    const mensagemSucesso = ref('')

    const updateWidth = () => {
        windowWidth.value = window.innerWidth
    }

    onMounted(() => {
        // carregar dados do utilizador autenticado
        user.value = storeAuth.user

        form.value.nome = user.value.nome
        form.value.username = user.value.username
        form.value.email = user.value.email

        window.addEventListener('resize', updateWidth)
        setTimeout(() => loading.value = false, 300)
    })

    const dynamicPadding = computed(() => {
        if (windowWidth.value < 768 && !isSidebarOpen.value) {
            return 'pl-20'
        }
        return 'pl-10'
    })

    const handleFoto = (event) => {
        const file = event.target.files[0]
        if (file) {
            form.value.foto = file
            previewFoto.value = URL.createObjectURL(file)
        }
    }

    const submeterFormulario = async () => {
        erros.value = {
            nome: '',
            username: '',
            password: '',
            password_confirmation: ''
        }

        let temErro = false

        if (!form.value.nome.trim()) {
            erros.value.nome = 'O campo nome é obrigatório.'
            temErro = true
        }

        if (!form.value.username.trim()) {
            erros.value.username = 'O campo username é obrigatório.'
            temErro = true
        }

        if (form.value.password && form.value.password !== form.value.password_confirmation) {
            erros.value.password_confirmation = 'As passwords não coincidem.'
            temErro = true
        }

        if (temErro) return

        const formData = new FormData()
        formData.append('nome', form.value.nome)
        formData.append('username', form.value.username)
        formData.append('email', form.value.email)

        if (form.value.password) {
            formData.append('password', form.value.password)
            formData.append('password_confirmation', form.value.password_confirmation)
        }

        if (form.value.foto) {
            formData.append('foto', form.value.foto)
        }

        loadingUpdate.value = false

        const sucesso = await storeAuth.atualizarPerfil(formData)

        loadingUpdate.value = true

        if (sucesso) {
            mensagemSucesso.value = 'Perfil atualizado com sucesso.'
            setTimeout(() => mensagemSucesso.value = '', 3500)
        }
    }

</script>

<template>
    <div v-if="loading">
        <Loading />
    </div>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div class="flex h-screen">
            <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
            <div :class="['flex-1 bg-gray-100 p-6 overflow-y-scroll transition-all duration-300', dynamicPadding]">
                <form @submit.prevent="submeterFormulario" class="w-full max-w-xl mx-auto bg-white p-8 rounded-xl shadow">
                    <h2 class="text-2xl font-semibold mb-3 text-center">Editar Perfil</h2>
                    <p v-if="mensagemSucesso" class="text-green-600 text-xl text-center mb-4">
                    {{ mensagemSucesso }}
                    </p>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Nome</label>
                        <input v-model="form.nome" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring" />
                        <p v-if="erros.nome" class="text-red-600 text-sm mt-1">{{ erros.nome }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Username</label>
                        <input v-model="form.username" type="text" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring" />
                        <p v-if="erros.username" class="text-red-600 text-sm mt-1">{{ erros.username }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Email</label>
                        <input v-model="form.email" type="email" class="w-full px-4 py-2 border rounded bg-gray-100 cursor-not-allowed" disabled />
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Nova Password</label>
                        <input v-model="form.password" type="password" class="w-full px-4 py-2 border rounded" placeholder="Deixar vazio se não quiser mudar" />
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Confirmar Password</label>
                        <input v-model="form.password_confirmation" type="password" class="w-full px-4 py-2 border rounded" placeholder="Confirmar nova password" />
                        <p v-if="erros.password_confirmation" class="text-red-600 text-sm mt-1">{{ erros.password_confirmation }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">Foto de Perfil</label>
                        <input type="file" accept="image/*" @change="handleFoto" />
                        <img v-if="previewFoto" :src="previewFoto" alt="Preview" class="w-24 h-24 mt-4 rounded-full object-cover border" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded w-full hover:bg-blue-700 transition" :disabled="!loadingUpdate">
                            Guardar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </transition>
</template>
