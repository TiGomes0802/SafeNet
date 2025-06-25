<script setup>
import { useCursoStore } from '@/stores/curso'
import { useAuthStore } from '@/stores/auth'

const storeCurso = useCursoStore()
const storeAuth = useAuthStore()

defineProps(['handleLinkClick'])
</script>

<template>
  <div v-if="storeAuth.user?.type === 'J'">
    <div class="mb-6">
      <h2 class="text-sm font-semibold text-gray-500 mb-2 px-3">Cursos</h2>
      <nav class="space-y-2">
        <router-link v-for="curso in storeCurso.cursos" :key="curso.id"
          :to="curso.estado !== 0 ? `/curso/${curso.id}` : ''" class="block py-2 px-6 rounded"
          :class="curso.estado === 0 ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'hover:bg-gray-100 text-black'"
          @click="curso.estado === 0 ? $event.preventDefault() : handleLinkClick">
          {{ curso.nome }}
        </router-link>
      </nav>
    </div>

    <nav class="space-y-1 mt-4 mb-2 px-3">
      <!-- Jogos -->
      <router-link
        to="/backoffice/estatisticas"
        class="flex items-center py-2 px-3 rounded text-gray-600 bg-gray-100 cursor-not-allowed pointer-events-none"
        @click.prevent>
        <svg class="w-6 h-6 text-gray-500 dark:text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
          <path d="M192 64C86 64 0 150 0 256S86 448 192 448l256 0c106 0 192-86 192-192s-86-192-192-192L192 64zM496 168a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM392 304a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM168 200c0-13.3 10.7-24 24-24s24 10.7 24 24l0 32 32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0 0 32c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-32-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l32 0 0-32z"/>
        </svg>
        <span class="ml-2">Desafios</span>
      </router-link>


      <!-- Missões -->
      <router-link to="/missoes" class="flex items-center py-2 px-3 rounded hover:bg-gray-100" @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
          fill="currentColor" viewBox="0 0 24 24">
          <path d="M11 9a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" />
          <path fill-rule="evenodd"
            d="M9.896 3.051a2.681 2.681 0 0 1 4.208 0c.147.186.38.282.615.255a2.681 2.681 0 0 1 2.976 2.975.681.681 0 0 0 .254.615 2.681 2.681 0 0 1 0 4.208.682.682 0 0 0-.254.615 2.681 2.681 0 0 1-2.976 2.976.681.681 0 0 0-.615.254 2.682 2.682 0 0 1-4.208 0 .681.681 0 0 0-.614-.255 2.681 2.681 0 0 1-2.976-2.975.681.681 0 0 0-.255-.615 2.681 2.681 0 0 1 0-4.208.681.681 0 0 0 .255-.615 2.681 2.681 0 0 1 2.976-2.975.681.681 0 0 0 .614-.255ZM12 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"
            clip-rule="evenodd" />
          <path
            d="M5.395 15.055 4.07 19a1 1 0 0 0 1.264 1.267l1.95-.65 1.144 1.707A1 1 0 0 0 10.2 21.1l1.12-3.18a4.641 4.641 0 0 1-2.515-1.208 4.667 4.667 0 0 1-3.411-1.656Zm7.269 2.867 1.12 3.177a1 1 0 0 0 1.773.224l1.144-1.707 1.95.65A1 1 0 0 0 19.915 19l-1.32-3.93a4.667 4.667 0 0 1-3.4 1.642 4.643 4.643 0 0 1-2.53 1.21Z" />
        </svg>
        <span class="ml-2">Missões</span>
      </router-link>

      <!-- Ranking -->
      <router-link to="/rank" class="flex items-center py-2 px-3 rounded hover:bg-gray-100" @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
          fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
            d="M4.37 7.657c2.063.528 2.396 2.806 3.202 3.87 1.07 1.413 2.075 1.228 3.192 2.644 1.805 2.289 1.312 5.705 1.312 6.705M20 15h-1a4 4 0 0 0-4 4v1M8.587 3.992c0 .822.112 1.886 1.515 2.58 1.402.693 2.918.351 2.918 2.334 0 .276 0 2.008 1.972 2.008 2.026.031 2.026-1.678 2.026-2.008 0-.65.527-.9 1.177-.9H20M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="ml-2">Ranking</span>
      </router-link>

      <!-- Loja -->
      <router-link to="/loja" class="flex items-center py-2 px-3 rounded hover:bg-gray-100" @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
        </svg>
        <span class="ml-2">Loja</span>
      </router-link>

      <!-- Amigos -->
      <router-link to="/amigos" class="flex items-center py-2 px-3 rounded hover:bg-gray-100" @click="handleLinkClick">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
          fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd"
            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
            clip-rule="evenodd" />
        </svg>
        <span class="ml-2">Amigos</span>
      </router-link>

      
    </nav>
  </div>
</template>
