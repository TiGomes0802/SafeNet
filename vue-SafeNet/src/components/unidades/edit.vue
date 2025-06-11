<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useUnidadeStore } from '@/stores/unidade'
import Sidebar from '@/components/SideBar/Sidebar.vue'


const props = defineProps(['idUnidade'])
const unidadeStore = useUnidadeStore()

const titulo = ref('')
const descricao = ref('')
const estado = ref('0') // string para facilitar o v-model com <select>

const carregarUnidade = async () => {
    const success = await unidadeStore.loadUnidade(route.params.id)
    if (success && unidadeStore.unidade) {
        titulo.value = unidadeStore.unidade.titulo || ''
        descricao.value = unidadeStore.unidade.descricao || ''
        estado.value = unidadeStore.unidade.estado === 1 ? '1' : '0'
    }
}

const atualizarUnidade = async () => {
    const data = {
        titulo: titulo.value,
        descricao: descricao.value,
        estado: parseInt(estado.value),
    }

    const success = await unidadeStore.updateUnidade(props.idUnidade, data)
    if (success) {
        alert('Unidade atualizada com sucesso!')
    } else {
        alert('Erro ao atualizar unidade')
    }
}

onMounted(() => {
    carregarUnidade()
})
</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar class="h-screen" />

        <main class="flex-1 p-6 bg-gray-50 overflow-auto">
            <h1 class="text-2xl font-bold mb-6">Editar Unidade</h1>

            <form @submit.prevent="atualizarUnidade" class="bg-white shadow-md rounded-lg p-6 space-y-4">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                    <input id="titulo" v-model="titulo" type="text"
                        class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required />
                </div>

                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea id="descricao" v-model="descricao"
                        class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" rows="4" required></textarea>
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="estado" v-model="estado"
                        class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <button type="submit" class="bg-gray-300 hover:bg-green-500 text-black font-semibold py-2 px-4 rounded">
                    Salvar
                </button>
            </form>
        </main>
    </div>
</template>
