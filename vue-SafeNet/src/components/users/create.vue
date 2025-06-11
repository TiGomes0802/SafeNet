<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Sidebar from '@/components/SideBar/Sidebar.vue'

const router = useRouter()
const storeAuth = useAuthStore()

const loading = ref(false)
const missingFields = ref([])

const credentials = ref({
  nome: '',
  username: '',
  email: '',
  password: '',
  type: ''
})

const criarUser = async () => {
  missingFields.value = []

  missingFields.value = Object.keys(credentials.value).filter(
    key => !credentials.value[key].trim()
  )

  if (missingFields.value.length > 0) return

  loading.value = true

  try {
    const registado = await storeAuth.register(credentials.value)
    if (registado) {
      router.push({
        name: 'Perfil',
        params: { username: credentials.value.username }
      })
    }

  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="flex min-h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <h1 class="text-2xl font-bold mb-6">Criar Utilizador</h1>

      <form @submit.prevent="criarUser" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div class="space-y-4">
          <div>
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
            <input id="nome" v-model="credentials.nome" type="text" class="mt-1 block w-full border rounded px-3 py-2"
              :class="missingFields.includes('nome') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'" />
          </div>

          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input id="username" v-model="credentials.username" type="text"
              class="mt-1 block w-full border rounded px-3 py-2"
              :class="missingFields.includes('username') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'" />
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input id="email" v-model="credentials.email" type="email"
              class="mt-1 block w-full border rounded px-3 py-2"
              :class="missingFields.includes('email') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'" />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input id="password" v-model="credentials.password" type="password"
              class="mt-1 block w-full border rounded px-3 py-2"
              :class="missingFields.includes('password') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'" />
          </div>

          <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
            <select id="type" v-model="credentials.type" class="mt-1 block w-full border rounded px-3 py-2"
              :class="missingFields.includes('type') ? 'border-red-500 placeholder:text-red-500' : 'border-gray-300'">
              <option value="" disabled>Selecione um tipo</option>
              <option value="G">Gestor</option>
              <option value="A">Admin</option>
            </select>
          </div>
        </div>

        <div v-if="storeAuth.errorResgistar" class="text-red-500 font-bold text-sm">
          {{ storeAuth.errorResgistar }}
        </div>

        <div v-if="missingFields.length > 0" class="text-red-500 font-bold text-sm">
          Preenche todos os campos
        </div>

        <button type="submit" :disabled="loading"
          class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded">
          {{ loading ? 'A criar...' : 'Criar' }}
        </button>
      </form>
    </main>
  </div>
</template>
