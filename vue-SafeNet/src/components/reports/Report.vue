<script setup>
    import { ref } from 'vue'
    import { useReportStore } from '@/stores/report.js'

    const reportStore = useReportStore() 

    const props = defineProps({
        idJogo: {
            type: Number,
            required: true
        }
    })


    const mostrar = ref(false)
    const motivoSelecionado = ref('')
    const mensagemSucesso = ref(false)
    const mensagemFalha = ref(false)
    const motivos = [
        { id: 1, nome: 'Pergunta mal estruturada.' },
        { id: 2, nome: 'Resposta "correta" é incorreta.' },
        { id: 3, nome: 'Um caractere não foi exibido corretamente.' },
        { id: 4, nome: 'Conteúdo ofensivo.' },
        { id: 5, nome: 'Conteúdo enganoso.' },
        { id: 6, nome: 'Outro' }
    ]

    async function confirmarReport() {
        if (motivoSelecionado.value) {
            try {
            const sucesso = await reportStore.reportarJogo(1, motivoSelecionado.value)
            if (sucesso) {
                mensagemSucesso.value = true
                setTimeout(() => {
                mensagemSucesso.value = false
                mostrar.value = false
                motivoSelecionado.value = ''
                }, 1000)
            } else {
                mensagemFalha.value = true
                setTimeout(() => mensagemFalha.value = false, 2000)
            }
            } catch (e) {
            mensagemFalha.value = true
            console.error('Erro ao reportar:', e)
            setTimeout(() => mensagemFalha.value = false, 2000)
            }
        }
    }

</script>

<template>
  <div class="relative h-screen bg-[url(https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/d9/fa/1b/lost-valley.jpg?w=1200&h=-1&s=1)] bg-cover bg-center flex items-center justify-center">
    <!-- Botão para abrir o popup -->
    <button @click="mostrar = true"
      class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" >
      Abrir Card
    </button>

    <!-- Card / Popup -->
    <div v-if="mostrar"
      class="fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full relative">
        <h2 class="text-xl font-semibold mb-4">Reportar Conteúdo</h2>

        <!-- Dropdown -->
        <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
        <select
          id="motivo"
          v-model="motivoSelecionado"
          class="w-full mb-4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option disabled value="">Seleciona um motivo</option>
            <option v-for="motivo in motivos" :key="motivo.id" :value="motivo.nome">
                {{ motivo.nome }}   
            </option>
        </select>

        <!-- Botão de Confirmar -->
        <button @click="confirmarReport"
          class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition-colors duration-200 mb-2"
          :disabled="!motivoSelecionado">
          Confirmar Report
        </button>

        <!-- Mensagem de Sucesso -->
        <p v-if="mensagemSucesso" class="text-green-600 text-sm text-center mt-2">
          Report enviado com sucesso!
        </p>

        <!-- Mensagem de Falha -->
        <p v-if="mensagemFalha" class="text-red-600 text-sm text-center mt-2">
          Erro ao enviar o report. Tente novamente.
        </p>

        <!-- Botão Fechar -->
        <button
          @click="mostrar = false"
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
  </div>
</template>
