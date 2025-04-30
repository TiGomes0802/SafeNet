<script setup>
    import { ref } from 'vue'
    import { usePaginaStore } from '@/stores/pagina'

    const paginaStore = usePaginaStore()

    const props = defineProps(['idUnidade'])

    const descricao = ref('')

    const erros = ref({
        descricao: false,
    })

    const criarPagina = () =>{
        erros.value.descricao = false

        if (!descricao.value.trim()) {
            erros.value.descricao = true
        }

        if (erros.value.descricao) {
            return
        }

        descricao.value = descricao.value.trim()

        paginaStore.createPagina(props.idUnidade, descricao.value)
    }

</script>
<template>
    <div class="mb-4">
        <label class="block font-semibold mb-1">Página:</label>
        <textarea v-model="descricao" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" :class="erros.descricao ? 'border-red-500' : 'border-black'" rows="3" />
    </div>
    <p v-if="erros.descricao" class="text-red-600 text-md font-bold mt-4 mb-4">
        Por favor preencha todos os campos antes de criar a pergunta.
    </p>
    <div class="mb-4">
        <button @click="criarPagina" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
            Criar página
        </button>
    </div>
</template>