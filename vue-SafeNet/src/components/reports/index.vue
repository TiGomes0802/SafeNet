<script setup>
  import { ref, onMounted } from 'vue'
  import { useReportStore } from '@/stores/report'
  import { useRouter } from 'vue-router'
  import Sidebar from '@/components/Sidebar.vue'
  import Loading from '@/components/loading/BackofficeLoading.vue'

  const storeReport = useReportStore()
  const router = useRouter()

  const loadingReport = ref(true);
  const loading = ref(true)
  const reportIndex = ref(null);

  const reportAnalisado = async (reportId, index) => {
    loadingReport.value = false
    reportIndex.value = index

    try {
      await storeReport.updateEstadoReport(reportId)
    } catch (error) {
      console.error('Erro ao bloquear utilizador:', error)
    } finally {
      loadingReport.value = true
      reportIndex.value = null
    }
  }

  onMounted(async () => {
    storeReport.getReports()
    loading.value = false
  })

  const goToJogo = (idUnidade, idJogo) => {
    router.push({ name: 'EditarJogo', params: { idUnidade: idUnidade, idJogo: idJogo } });
  };

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
          <h1 class="text-2xl font-bold">Reports</h1>
        </div>

        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="px-6 py-3">#</th>
              <th class="px-6 py-3 w-[400px]">Mensagem</th> <!-- largura definida -->
              <th class="px-6 py-3">Data e hora</th>
              <th class="px-6 py-3"></th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(report, index) in storeReport?.reports" :key="report.id" class="border-t hover:bg-gray-50">
              <td class="px-6 py-4">{{ index + 1 }}</td>
              <td class="px-6 py-4">{{ report.mensagem }}</td>
              <td class="px-6 py-4">{{ report.created_at }}</td>
              <td class="px-6 py-4">
                <button
                  @click="goToJogo(report.idUnidade, report.idJogo)"
                  class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded">
                  Ver Jogo
                </button>
              </td>
              <td class="px-6 py-4 flex justify-center space-x-2">
                <button
                  @click="reportAnalisado(report.id, index)"
                  :disabled="!loadingReport"
                  class="flex items-center justify-center px-4 py-2 rounded font-semibold text-white bg-yellow-500 hover:bg-yellow-600 transition-colors duration-200 focus:outline-none"
                  :class="{
                    'opacity-50 cursor-not-allowed': !loadingReport && reportIndex === index
                  }">
                  <span v-if="!loadingReport && reportIndex === index" class="spinner2 w-4 h-4"></span>
                  <span v-else> Report Analisado </span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </main>
    </div>
  </transition>
</template>
