<script setup>
  import { ref, onMounted } from 'vue'
  import { useAuthStore } from '@/stores/auth'
  import Sidebar from '@/components/Sidebar.vue'
  import Loading from '@/components/loading/BackofficeLoading.vue'
  import defaultAvatar from '@/assets/avatar-default-icon.png'

  const storeAuth = useAuthStore()

  const loading = ref(true)

  onMounted(async () => {
    storeAuth.getAllGestoresAdmins()
    loading.value = false
  })
</script>

<template>
    <div v-if="loading">
    <Loading />
  </div>
  <transition 
    name="fade" 
    appear enter-active-class="transition-opacity duration-700" 
    enter-from-class="opacity-0"
    enter-to-class="opacity-100">
    <div class="flex h-screen">
      <Sidebar class="h-screen" />

      <main class="flex-1 p-6 bg-gray-50 overflow-auto">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Cursos</h1>

          <router-link to="/admin/users/create"
            class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
            Adicionar novo membro
          </router-link>
        </div>

        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="px-6 py-3">Nome</th>
              <th class="px-6 py-3">Username</th>
              <th class="px-6 py-3">E-mail</th>
              <th class="px-6 py-3">Role</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in storeAuth?.users" :key="user.id" class="border-t hover:bg-gray-50">
              <td class="px-6 py-4">
                <router-link :to="{ name: 'Perfil', params: { username: user.username } }"
                  class="flex items-center gap-3">
                  <img :src="user.foto || defaultAvatar"
                      class="w-10 h-10 rounded-full border-2 border-blue-300 object-cover" />
                  {{ user.nome }}
                </router-link></td>
              <td class="px-6 py-4">{{ user.username }}</td>
              <td class="px-6 py-4">{{ user.email }}</td>
              <td class="px-6 py-4">{{ user.type === 'G' ? 'Gestor' : 'Admin' }}</td>
            </tr>
          </tbody>
        </table>
      </main>
    </div>
  </transition>
</template>
