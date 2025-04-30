<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRouter } from 'vue-router'
    import { usePaginaStore } from '@/stores/pagina'
    import Sidebar from '@/components/Sidebar.vue'

    const router = useRouter()
    const paginaStore = usePaginaStore()

    const paginas = ref([])
    const edicao = ref(false)
    const paginasAnteriores = ref([])

    const props = defineProps(['idUnidade'])

    onMounted(async () => {
        await paginaStore.getPaginas(props.idUnidade);
        paginas.value = paginaStore.paginas
    });

    const ativarEdicao = () => {
        edicao.value = true
    }

    const cancelarEdicao = () => {
        edicao.value = false
        paginas.value = paginaStore.paginas
    }

    const desativarEdicao = () => {
        edicao.value = false
        paginaStore.updatePaginas(paginas.value)
    }

    watch(paginas, (novasPaginas) => {
        novasPaginas.forEach((pagina, i) => {
            const ordemAntiga = paginasAnteriores.value[i]?.ordem
            const ordemNova = pagina.ordem

            if (ordemAntiga !== ordemNova) {
            const paginaEmConflito = paginas.value.find(p => p.ordem === ordemNova && p !== pagina)

            if (paginaEmConflito) {
                paginaEmConflito.ordem = ordemAntiga
            }
            }
        })
        paginasAnteriores.value = JSON.parse(JSON.stringify(paginas.value))
    }, { deep: true })

    watch(
        () => paginaStore.paginas,
        (novasPaginas) => {
            console.log('paginaStore.paginas foi atualizado:', novasPaginas)
            paginas.value = novasPaginas
        },
        { deep: true }
    )

    onMounted(async () => {
        await paginaStore.getPaginas(props.idUnidade);
        paginas.value = paginaStore.paginas
        paginasAnteriores.value = JSON.parse(JSON.stringify(paginas.value)) // cópia profunda
    });

</script>

<template>
    <div class="flex">
        <Sidebar />
        <div class="flex-1 bg-gray-200 w-screen h-screen overflow-y-scroll">
            <div class="row w-5/6 justify-center mx-auto mt-4 pt-10">
                <p class="text-3xl mb-3">Páginas</p>
                <div v-if="edicao" class="flex justify-end mb-3">
                    <button @click="cancelarEdicao" class="bg-gray-300 hover:bg-red-400 text-black font-semibold py-2 px-4 rounded mr-2">
                        Cancelar Edição
                    </button>
                    <button @click="desativarEdicao" class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                        Salvar Edição
                    </button>
                </div>
                <div v-else>
                    <button @click="ativarEdicao" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
                        Ativar Edição
                    </button>
                </div>    
                <div v-if="edicao" class="flex flex-col gap-y-7 px-5 pt-3">
                    <div v-for="(pagina, index) in paginas" :key="pagina.id">
                        <div class="bg-white p-4 rounded-lg shadow-xl flex flex-col gap-y-1">
                            <p class="text-2xl">{{ index + 1 }}º Página</p>
                            <div class="flex justify-between items-center gap-x-2 mb-3">
                                <div class="mb-4 w-9/10">
                                    <label class="block font-semibold mb-1">Descrição:</label>
                                    <textarea v-model="pagina.descricao" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" rows="3" />
                                </div>
                                <div class="mb-4 w-1/10 flex justify-center items-center">
                                    <select v-model="pagina.ordem" class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                                        <option v-for="n in paginas.length" :key="n" :value="n"> {{ n }}º </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex flex-col gap-y-7 px-5 pt-3">
                    <div v-for="(pagina, index) in paginas" :key="pagina.id">
                        <div class="bg-white w-full p-4 rounded-lg shadow-xl flex flex-col gap-y-1">
                            <p class="text-2xl">{{ index + 1 }}º Página</p>
                            <p class="text-lg py-2">{{ pagina.descricao }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>