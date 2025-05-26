<script setup>
import { ref } from 'vue'
import { useLojaStore } from '@/stores/loja'
import Sidebar from '@/components/Sidebar.vue'
import { useRouter } from 'vue-router'

const lojaStore = useLojaStore()
const router = useRouter()

const nome = ref('')
const descricao = ref('')
const preco = ref(0)

const criarProduto = async () => {
  const sucesso = await lojaStore.createProduto({
    nome: nome.value,
    descricao: descricao.value,
    preco: preco.value
  })

  if (sucesso) {
    router.push({ name: 'ProdutosIndex' }) // redireciona para lista de produtos
  }
}
</script>

<template>
  <div class="flex min-h-screen">
    <Sidebar class="h-screen" />

    <main class="flex-1 p-6 bg-gray-50 overflow-auto">
      <h1 class="text-2xl font-bold mb-6">Criar Produto</h1>

      <form @submit.prevent="criarProduto" class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <div>
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            id="nome"
            v-model="nome"
            type="text"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            required
          />
        </div>

        <div>
          <label for="preco" class="block text-sm font-medium text-gray-700">Preço (🪙)</label>
          <input
            id="preco"
            v-model="preco"
            type="number"
            step="1"
            min="0"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            required
          />
        </div>

        <div>
          <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
          <input
            id="valor"
            v-model="valor"
            type="number"
            step="1"
            min="0"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
            required
          />
        </div>

        <button
          type="submit"
          class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded"
        >
          Criar
        </button>
      </form>
    </main>
  </div>
</template>
