<script setup>
import { useAuthStore } from '@/stores/auth'

const storeAuth = useAuthStore()
defineProps(['handleLinkClick'])
</script>

<template>
  <div v-if="storeAuth.user?.type === 'G' || storeAuth.user?.type === 'A'" class="pt-8">
    <h2 class="text-sm font-semibold text-gray-500 mb-4 px-3">Gestão</h2>
    <nav class="space-y-2 flex flex-col justify-start">
      <!-- Sempre visíveis (gestores e admins) -->
      <router-link to="/backoffice/cursos" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
        @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3.78552 9.5 12.7855 14l9-4.5-9-4.5-8.99998 4.5Zm0 0V17m3-6v6.2222c0 .3483 2 1.7778 5.99998 1.7778 4 0 6-1.3738 6-1.7778V11" />
        </svg>
        <span>Cursos</span>
      </router-link>

      <router-link to="/backoffice/estatisticas" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
        @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
        </svg>
        <span>Estatísticas</span>
      </router-link>

      <router-link to="/backoffice/missoes" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
        @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
          viewBox="0 0 24 24">
          <path d="M11 9a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" />
          <path fill-rule="evenodd"
            d="M9.896 3.051a2.681 2.681 0 0 1 4.208 0c.147.186.38.282.615.255a2.681 2.681 0 0 1 2.976 2.975.681.681 0 0 0 .254.615 2.681 2.681 0 0 1 0 4.208.682.682 0 0 0-.254.615 2.681 2.681 0 0 1-2.976 2.976.681.681 0 0 0-.615.254 2.682 2.682 0 0 1-4.208 0 .681.681 0 0 0-.614-.255 2.681 2.681 0 0 1-2.976-2.975.681.681 0 0 0-.255-.615 2.681 2.681 0 0 1 0-4.208.681.681 0 0 0 .255-.615 2.681 2.681 0 0 1 2.976-2.975.681.681 0 0 0 .614-.255ZM12 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"
            clip-rule="evenodd" />
          <path
            d="M5.395 15.055 4.07 19a1 1 0 0 0 1.264 1.267l1.95-.65 1.144 1.707A1 1 0 0 0 10.2 21.1l1.12-3.18a4.641 4.641 0 0 1-2.515-1.208 4.667 4.667 0 0 1-3.411-1.656Zm7.269 2.867 1.12 3.177a1 1 0 0 0 1.773.224l1.144-1.707 1.95.65A1 1 0 0 0 19.915 19l-1.32-3.93a4.667 4.667 0 0 1-3.4 1.642 4.643 4.643 0 0 1-2.53 1.21Z" />
        </svg>
        <span>Missões</span>
      </router-link>

      <router-link to="/backoffice/reports" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
        @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
        </svg>
        <span>Reports</span>
      </router-link>

      <router-link to="/backoffice/loja" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100"
        @click="handleLinkClick">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800 dark:text-white" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 9l1.5 12h15L21 9M16 3h-8l-1 6h10l-1-6z" />
        </svg>
        <span>Loja</span>
      </router-link>

      <!-- Apenas para Admins -->
      <router-link v-if="storeAuth.user?.type === 'A'" to="/admin/users"
        class="flex items-center gap-3 py-2 px-4 rounded hover:bg-gray-100" @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd"
            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
            clip-rule="evenodd" />
        </svg>
        <span>Users</span>
      </router-link>

    </nav>
  </div>
</template>
