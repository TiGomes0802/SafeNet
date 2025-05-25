<script setup>
    import { ref, onMounted } from 'vue';
    import { useAmigoStore } from '@/stores/amigo';
    import Loading from '@/components/loading/FrontofficeLaoding.vue'
    import Sidebar from '@/components/Sidebar.vue';

    const storeAmigo = useAmigoStore();

    const loading = ref(true);
    const loadingButtom = ref(false);

    const username = ref('');

    // Função para buscar amigos e pedidos ao montar o componente
    const adicionarAmigo = async () => {
      if (!username.value) {
        storeAmigo.mensagemError = 'Por favor, insira um username válido.';
        return;
      }
      storeAmigo.enviarPedido(username.value)
      username.value = '';
    };

    const removerAmigo = async (username) => {
      loadingButtom.value = true
      
      try {
        await storeAmigo.removerAmigo(username)
      } finally {
        loadingButtom.value = false
      }
    };

    const aceitarPedido = async (username) => {
      loadingButtom.value = true
      
      try {
        await storeAmigo.responderPedido(username, -1)
      } finally {
        loadingButtom.value = false
      }
    };

    const rejeitarPedido = async (username) => {
      loadingButtom.value = true

      try {
        await storeAmigo.responderPedido(username, -1)
      } finally {
        loadingButtom.value = false
      }
    };

    onMounted(async () => {
        await storeAmigo.getAmigos();
        await storeAmigo.getPedidos()
        console.log(storeAmigo.amigos);
        console.log(storeAmigo.pedidos);
        loading.value = false;
    });
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
        <main class="flex-1 p-6 bg-gray-50 overflow-y-auto justify-center items-center w-[95%] mt-6">
          <div class="flex flex-col lg:flex-row lg:gap-6 mb-6 space-y-6 lg:space-y-0">
            <!-- Tabela de Pedidos Recebidos -->
            <div class="w-full lg:w-1/2">
              <div class="flex justify-between items-center mb-4">
                <p class="text-2xl font-bold">Pedidos Recebidos</p>
              </div>
              <div class="max-h-[448px] overflow-y-auto"> <!-- 7 linhas * ~64px por linha = 448px -->
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                  <thead class="bg-gray-100 text-left">
                    <tr>
                      <th class="px-6 py-3">Nome</th>
                      <th class="px-6 py-3">Username</th>
                      <th class="px-6 py-3"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="pedido in storeAmigo.pedidos.pedidosRecebidos" :key="pedido.id" class="border-t hover:bg-gray-50">
                      <td class="px-6 py-4">{{ pedido.nome }}</td>
                      <td class="px-6 py-4">{{ pedido.username }}</td>
                      <td class="px-6 py-4 space-x-2">
                        <button @click="aceitarPedido(pedido.username)" :disabled="loadingButtom"
                          class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-green-500 hover:bg-green-600">
                          <template v-if="!loading">Aceitar</template>
                          <template v-else>
                              <span class="spinner"></span>
                          </template>
                        </button>
                        <button @click="rejeitarPedido(pedido.username)" :disabled="loadingButtom"
                          class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-red-500 hover:bg-red-600">
                          <template v-if="!loading">Rejeitar</template>
                          <template v-else>
                              <span class="spinner"></span>
                          </template>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="flex flex-col w-full mt-3">
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-5 mb-2">
                  <div class="w-full sm:w-4/6">
                    <input type="text" v-model="username" placeholder="Escreve o username do teu amigo" class="w-full border p-2 rounded" />
                  </div>
                  <div class="w-full sm:w-2/6">
                    <button @click="adicionarAmigo" :disabled="loadingButtom" class="w-full bg-blue-500 text-white p-2 rounded">
                      <template v-if="!loadingButtom">Adicionar Amigo</template>
                      <template v-else>
                        <span class="spinner"></span>
                      </template>
                    </button>
                  </div>
                </div>
                <div v-if="storeAmigo.mensagemError">
                  <p class="text-red-500 mb-4"> {{ storeAmigo.mensagemError }} </p>
                </div>
              </div>
            </div>

            <!-- Tabela de Pedidos Enviados -->
            <div class="w-full lg:w-1/2">
              <div class="flex justify-between items-center mb-4">
                <p class="text-2xl font-bold">Pedidos Enviados</p>
              </div>
              <div class="max-h-[448px] overflow-y-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                  <thead class="bg-gray-100 text-left">
                    <tr>
                      <th class="px-6 py-3">Nome</th>
                      <th class="px-6 py-3">Username</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="pedido in storeAmigo.pedidos.pedidosEnviados" :key="pedido.id" class="border-t hover:bg-gray-50">
                      <td class="px-6 py-4">{{ pedido.nome }}</td>
                      <td class="px-6 py-4">{{ pedido.username }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="w-full mb-6">
              <div class="flex justify-between items-center mb-4">
                <p class="text-2xl font-bold">Amigos</p>
              </div>
              <div class="max-h-[500px] overflow-y-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                  <thead class="bg-gray-100 text-left">
                    <tr>
                      <th class="px-6 py-3">Nome</th>
                      <th class="px-6 py-3">Username</th>
                      <th class="px-6 py-3">Xp</th>
                      <th class="px-3 py-3"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="amigo in storeAmigo.amigos" :key="amigo.id" class="border-t hover:bg-gray-50">
                      <td class="px-6 py-4">{{ amigo.nome }}</td>
                      <td class="px-6 py-4">{{ amigo.username }}</td>
                      <td class="px-6 py-4">{{ amigo.xp }}</td>
                      <td class="px-6 py-4 justify-end space-x-2">
                        <button @click="rejeitarPedido(amigo.username)" :disabled="loadingButtom"
                                class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-red-500 hover:bg-red-600">
                          <template v-if="!loadingButtom">Remover</template>
                          <template v-else>
                            <span class="spinner"></span>
                          </template>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </main>
      </div>
  </transition>
</template>