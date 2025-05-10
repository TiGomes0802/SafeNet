<script setup>
    import { useRouter } from 'vue-router'

    const router = useRouter()

    const emit = defineEmits(['fecharSairJogo'])

    const { idUnidade, idCurso } = defineProps({
      idUnidade: Number,
      idCurso: Number
    })

    console.log('ID Unidade:', idUnidade)
    console.log('ID Curso:', idCurso)

    const desistirJogo = () => {
      // Redireciona para a página de unidades
      router.push(`/curso/${idCurso}/unidade/${idUnidade}`)
    }
</script>

<template>
  <div class="fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white pt-6 px-6 rounded-2xl shadow-lg max-w-sm w-full relative">
      <h2 class="text-xl font-semibold mb-4">Desistir do Jogo</h2> 
      <!-- Dropdown -->
      <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Tem a certeza que quer sair do jogo</label>
      <div class="flex flex-row mb-4 gap-5 pt-5">
        <!-- Botão de Confirmar -->
        <button @click="desistirJogo"
          class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition-colors duration-200 mb-2">
          Sair do Jogo
        </button> 

        <button @click="emit('fecharSairJogo')"
          class="w-full bg-gray-600 text-white py-2 rounded-md hover:bg-gray-700 transition-colors duration-200 mb-2">
          Cancelar
        </button> 
      </div>
      <!-- Botão Fechar -->
      <button
        @click="emit('fecharSairJogo')"
        class="absolute top-2 right-2 text-gray-500 hover:text-red-500 transition-colors duration-200"
        aria-label="Fechar">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
      </button>
    </div>
  </div>
</template>
