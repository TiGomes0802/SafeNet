<script setup>
    import { ref, onMounted } from 'vue';
    import { useAmigoStore } from '@/stores/amigo';
    import Loading from '@/components/loading/FrontofficeLaoding.vue'
    import Sidebar from '@/components/Sidebar.vue';

    const storeAmigo = useAmigoStore();

    const loading = ref(true);
    const loadingAdicionar = ref(true);
    const loadingAceitar = ref(true);
    const loadingRejeitar = ref(true);
    const loadingRemover = ref(true);
    const removerIndex = ref(null);

    const username = ref('');

    // Função para buscar amigos e pedidos ao montar o componente
    const adicionarAmigo = async () => {
      loadingAdicionar.value = false;

      if (!username.value) {
        storeAmigo.mensagemError = 'Por favor, insira um username válido.';
        return;
      }
      
      await storeAmigo.enviarPedido(username.value)

      username.value = '';
      loadingAdicionar.value = true
    };

    const removerAmigo = async (username, index) => {
      removerIndex.value = index;
      loadingRemover.value = false

      await storeAmigo.removerAmigo(username)
      
      removerIndex.value = null;
      loadingRemover.value = true
    };

    const aceitarPedido = async (username, index) => {
      removerIndex.value = index;
      loadingAceitar.value = false

      await storeAmigo.responderPedido(username, 1)

      loadingAceitar.value = true
      removerIndex.value = null;
    };

    const rejeitarPedido = async (username, index) => {
      removerIndex.value = index;
      loadingRejeitar.value = false

      await storeAmigo.responderPedido(username, -1)

      loadingRejeitar.value = true
      removerIndex.value = null;
    };

    onMounted(async () => {
      await storeAmigo.getAmigos();
      await storeAmigo.getPedidos()
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
      <div class="flex h-screen">
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
                    <tr v-for="(pedido, index) in storeAmigo.pedidos.pedidosRecebidos" :key="pedido.id" class="border-t hover:bg-gray-50">
                      <td class="px-6 py-4">{{ pedido.nome }}</td>
                      <td class="px-6 py-4">{{ pedido.username }}</td>
                      <td class="px-6 py-4 space-x-2">
                        <button @click="aceitarPedido(pedido.username, index)" :disabled="!loadingAceitar"
                          class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-green-500 hover:bg-green-600">
                          <template v-if="!loadingAceitar && removerIndex === index">
                            <div class="flex items-center justify-center px-4 py-2">
                              <span class="spinner2 w-3 h-3"></span>
                            </div>
                          </template>
                          <template v-else="loadingAceitar">Aceitar</template>
                        </button>
                        <button @click="rejeitarPedido(pedido.username, index)" :disabled="!loadingRejeitar"
                          class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-red-500 hover:bg-red-600">
                          <template v-if="!loadingRejeitar && removerIndex === index">
                            <div class="flex items-center justify-center px-4 py-2">
                              <span class="spinner2 w-3 h-3"></span>
                            </div>
                          </template>
                          <template v-else="loadingRejeitar">Rejeitar</template>
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
                    <button @click="adicionarAmigo" :disabled="!loadingAdicionar" class="w-full bg-blue-500 text-white p-2 rounded">
                      <template v-if="loadingAdicionar">Adicionar Amigo</template>
                      <template v-else>
                        <div class="flex items-center justify-center px-4 py-2">
                          <span class="spinner2 w-3 h-3"></span>
                        </div>
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
                    <tr v-for="(amigo, index) in storeAmigo.amigos" :key="amigo.id" class="border-t hover:bg-gray-50">
                      <td class="px-6 py-4">{{ amigo.nome }}</td>
                      <td class="px-6 py-4">{{ amigo.username }}</td>
                      <td class="px-6 py-4">{{ amigo.xp }}</td>
                      <td class="px-6 py-4 justify-end space-x-2">
                        <button @click="removerAmigo(amigo.username, index)" :disabled="!loadingRemover"
                                class="px-4 py-2 rounded font-semibold transition-colors duration-200 focus:outline-none text-white bg-red-500 hover:bg-red-600">
                        <template v-if="!loadingRemover && removerIndex === index">
                          <div class="flex items-center justify-center px-4 py-2">
                            <span class="spinner2 w-3 h-3"></span>
                          </div>
                        </template>
                        <template v-else >Remover</template>
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