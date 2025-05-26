<script setup>
import { onMounted } from 'vue'
import { useLojaStore } from '@/stores/loja'
import Sidebar from '@/components/Sidebar.vue'

const lojaStore = useLojaStore()

onMounted(async () => {
    lojaStore.fetchProdutos()
})


function alterarEstado(id) {
    lojaStore.alterarEstadoProduto(id)
}

</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar class="h-screen" />

        <main class="flex-1 p-6 bg-gray-50 overflow-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Produtos</h1>

                <router-link to="/backoffice/loja/create"
                    class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                    Criar Produto
                </router-link>
            </div>

            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-6 py-3">Nome</th>
                        <th class="px-6 py-3">Preço</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Alterar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="produto in lojaStore.produtos" :key="produto.id" class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ produto.nome }}</td>
                        <td class="px-6 py-4">{{ produto.preco }} 🪙</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm"
                                :class="produto.estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                {{ produto.estado == 1 ? 'Ativo' : 'Desativo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button @click="alterarEstado(produto.id)" class="px-4 py-2 rounded font-semibold
                                transition-colors duration-200
                                focus:outline-none
                                text-white
                                " :class="produto.estado === 1
                                    ? 'bg-red-400 hover:bg-red-500'
                                    : 'bg-green-400 hover:bg-green-500'">
                                {{ produto.estado === 1 ? 'Desativar' : 'Ativar' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</template>
