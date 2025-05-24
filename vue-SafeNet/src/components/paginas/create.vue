<script setup>
    import { ref } from 'vue'
    import { usePaginaStore } from '@/stores/pagina'
    import { QuillEditor } from '@vueup/vue-quill' 
    import '@vueup/vue-quill/dist/vue-quill.snow.css';

    const paginaStore = usePaginaStore()

    const props = defineProps(['idUnidade'])

    const descricao = ref('')

    const erros = ref({
        descricao: false,
    })

    const criarPagina = () => {
        erros.value.descricao = false

        // Cria um div temporário para interpretar o HTML e verificar se há conteúdo real
        const tempDiv = document.createElement('div')
        tempDiv.innerHTML = descricao.value
        const textoLimpo = tempDiv.textContent?.trim() || ''

        if (!textoLimpo) {
            erros.value.descricao = true
            return
        }

        paginaStore.createPagina(props.idUnidade, descricao.value)
    }

</script>
<template>
    <div class="mb-4">
        <label class="block font-semibold mb-1">Página:</label>
        <QuillEditor v-model:content="descricao" content-type="html" toolbar="essentials"/>
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