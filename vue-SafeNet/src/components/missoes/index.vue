<script setup>
    import { ref, onMounted } from 'vue'
    import { useMissaoStore } from '@/stores/missao'
    import Sidebar from '@/components/Sidebar.vue'
    import Loading from '@/components/loading/BackofficeLoading.vue'

    const storeMissao = useMissaoStore()
    const loading = ref(true);

    onMounted(async () => {
        await storeMissao.getMissoes()
        loading.value = false
    })

    function alterarEstado(id) {
      console.log(`Alterando estado da missão/conquista com ID: ${id}`);
      storeMissao.alterarEstadoMissao(id)
    }

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
      <div class="flex min-h-screen">
        <Sidebar class="h-screen" />
        <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Missões</h1>
          </div>
          <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-left">
              <tr>
                <th class="px-6 py-3">Descrição</th>
                <th class="px-6 py-3 text-center">Recompensa</th>
                <th class="px-6 py-3 text-center">Objetivo</th>
                <th class="px-6 py-3 text-center">Estado</th>
                <th class="px-6 py-3 text-center">Alterar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="missao in storeMissao.missoes" :key="missao.id" class="border-t hover:bg-gray-50">
                <td class="px-6 py-4">{{ missao.descricao }}</td>
                <td class="px-6 py-4 text-center">{{ missao.moedas }}</td>
                <td class="px-6 py-4 text-center">{{ missao.objetivo }}</td>
                <td class="px-6 py-4 text-center">
                  <span class="inline-block px-3 py-1 rounded-full text-sm"
                    :class="missao.estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                    {{ missao.estado == 1 ? 'Ativo' : 'Desativo' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  <button @click="alterarEstado(missao.id)" class="px-4 py-2 rounded font-semibold
                    transition-colors duration-200
                    focus:outline-none
                    text-white
                    " :class="missao.estado == 1
                      ? 'bg-red-400 hover:bg-red-500'
                      : 'bg-green-400 hover:bg-green-500'">
                    {{ missao.estado == 1 ? 'Desativar' : 'Ativar' }}
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Conquistas</h1>
          </div>
          <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-left">
              <tr>
                <th class="px-6 py-3">Descrição</th>
                <th class="px-6 py-3 text-center">Recompensa</th>
                <th class="px-6 py-3 text-center">Objetivo</th>
                <th class="px-6 py-3 text-center">Estado</th>
                <th class="px-6 py-3 text-center">Alterar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="conquista in storeMissao.conquistas" :key="conquista.id" class="border-t hover:bg-gray-50">
                <td class="px-6 py-4">{{ conquista.descricao }}</td>
                <td class="px-6 py-4 text-center">{{ conquista.moedas }}</td>
                <td class="px-6 py-4 text-center">{{ conquista.objetivo }}</td>
                <td class="px-6 py-4 text-center">
                  <span class="inline-block px-3 py-1 rounded-full text-sm"
                    :class="conquista.estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                    {{ conquista.estado == 1 ? 'Ativo' : 'Desativo' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  <button @click="alterarEstado(conquista.id)" class="px-4 py-2 rounded font-semibold
                    transition-colors duration-200
                    focus:outline-none
                    text-white
                    " :class="conquista.estado == 1
                      ? 'bg-red-400 hover:bg-red-500'
                      : 'bg-green-400 hover:bg-green-500'">
                    {{ conquista.estado == 1 ? 'Desativar' : 'Ativar' }}
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </main>
      </div>
  </transition>
</template>
