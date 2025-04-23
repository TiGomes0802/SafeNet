<script setup>
  import { useTemplateRef, provide } from 'vue'
  import { useAuthStore } from '@/stores/auth'  
  
  const storeAuth = useAuthStore()
  
  const alertDialog = useTemplateRef('alert-dialog')
  provide('alertDialog', alertDialog)

  const logoutConfirmed = () => {
    storeAuth.logout()
  }

  const logout = () => {
    storeAuth.logout()
  }
</script>

<template>
    <aside class="w-64 bg-white shadow-md p-4 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-6">SafeNet</h1>

            <div class="mb-6">
                <h2 class="text-sm font-semibold text-gray-500 mb-2 px-3">Cursos</h2>
                <nav class="space-y-2">
                    <router-link to="/unidade/Engenharia Social"
                        class="block py-2 px-6 rounded hover:bg-gray-100">Engenharia Social
                    </router-link>
                    <router-link to="/unidade/Autenticação"
                        class="block py-2 px-6 rounded hover:bg-gray-100">Autenticação
                    </router-link>
                    <router-link to="/unidade/Malware" class="block py-2 px-6 rounded hover:bg-gray-100">Malware
                    </router-link>
                    <router-link to="/unidade/Redes Sociais" class="block py-2 px-6 rounded hover:bg-gray-100">Redes
                        Sociais
                    </router-link>
                    <router-link to="/unidade/Sistemas Operativos"
                        class="block py-2 px-6 rounded hover:bg-gray-100">Sistemas Operativos
                    </router-link>
                    <router-link to="/unidade/Navegação" class="block py-2 px-6 rounded hover:bg-gray-100">Navegação na
                        Internet
                    </router-link>
                </nav>
            </div>
            <nav class="space-y-1 mt-8">
                <router-link to="/missoes" class="block py-2 px-3 rounded hover:bg-gray-100">Missões</router-link>
                <router-link to="/estatisticas"
                    class="block py-2 px-3 rounded hover:bg-gray-100">Estatísticas</router-link>
                <router-link to="/loja" class="block py-2 px-3 rounded hover:bg-gray-100">Loja</router-link>
            </nav>
        </div>
        <div class="border-t pt-7 space-y-6">
            <div class="block text-sm text-gray-700 font-semibold px-3">120 🪙 </div>
            <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3">Perfil</router-link>
            <router-link to="#" class="block text-sm text-gray-500 hover:underline px-3" @click="logout">Logout</router-link>
        </div>
    </aside>
</template>