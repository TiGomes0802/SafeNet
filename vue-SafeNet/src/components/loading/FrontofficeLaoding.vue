<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        mensagem: {
            type: String,
            default: '',
        }
    })

    const mensagemFinal = computed(() => {
        return props.mensagem.trim() !== '' ? props.mensagem : 'A preparar tudo para si...'
    })
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-white to-blue-100 text-gray-800">
    <!-- Ícone animado -->
    <div class="relative w-20 h-20 mb-6 pb-5">
      <div class="absolute inset-0 rounded-full border-4 border-blue-300 border-t-blue-600 animate-spin"></div>
      <div class="absolute inset-2 rounded-full bg-white flex items-center justify-center shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
      </div>
    </div>

    <!-- Mensagem -->
    <p class="text-xl font-medium animate-pulse pb-3">{{ mensagemFinal }}</p>
    <p class="text-sm mt-2 text-gray-500">Por favor, aguarda um momento</p>
  </div>
</template>