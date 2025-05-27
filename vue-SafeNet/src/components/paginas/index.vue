<script setup>
import { ref, onMounted, watch } from 'vue'
import { usePaginaStore } from '@/stores/pagina'
import Sidebar from '@/components/Sidebar.vue'
import CreatePagina from '@/components/paginas/create.vue'
import Loading from '@/components/loading/BackofficeLoading.vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const paginaStore = usePaginaStore()

const paginas = ref([])
const edicao = ref(false)
const paginasAnteriores = ref([])

const props = defineProps(['idUnidade'])

const loading = ref(true);

const ativarEdicao = () => {
    edicao.value = true
}

const cancelarEdicao = () => {
    edicao.value = false
    paginas.value = paginaStore.paginas
    console.log('cancelarEdicao', paginaStore.paginas)
    console.log('cancelarEdicao', paginas.value)
}

const desativarEdicao = () => {
    edicao.value = false
    paginaStore.updatePaginas(paginas.value, props.idUnidade)
}

watch(paginas, (novasPaginas) => {
    novasPaginas.forEach((pagina, i) => {
        const ordemAntiga = paginasAnteriores.value[i]?.ordem
        const ordemNova = pagina.ordem

        // Verifica se houve mudança na ordem
        if (ordemAntiga !== ordemNova) {
            // Encontrar a página com a ordem nova para trocar
            const paginaEmConflito = paginas.value.find(p => p.ordem === ordemNova && p !== pagina)

            if (paginaEmConflito) {
                // Troca as ordens entre páginas
                paginaEmConflito.ordem = ordemAntiga
            }
        }
    })

    // Atualiza a cópia profunda após as mudanças
    paginasAnteriores.value = JSON.parse(JSON.stringify(paginas.value))
}, { deep: true })


watch(
    () => paginaStore.paginas,
    (novasPaginas) => {
        console.log('paginaStore.paginas foi atualizado:', novasPaginas)
        paginas.value = novasPaginas
    }
)

onMounted(async () => {
    await paginaStore.getPaginas(props.idUnidade);
    paginas.value = JSON.parse(JSON.stringify(paginaStore.paginas))
    paginasAnteriores.value = JSON.parse(JSON.stringify(paginas.value))
    loading.value = false
});

</script>

<template>

    <div v-if="loading">
        <Loading />
    </div>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
        enter-to-class="opacity-100">
        <div v-if="!loading" class="flex">
            <Sidebar />
            <div class="flex-1 bg-gray-200 w-screen h-screen overflow-y-scroll">
                <div class="row w-5/6 justify-center mx-auto mt-4 pt-10">
                    <h1 class="text-2xl font-bold">Páginas</h1>
                    <p class="text-3xl mb-3"></p>
                    <div v-if="paginas.length > 0">
                        <div v-if="edicao" class="flex justify-end mb-3">
                            <button @click="cancelarEdicao"
                                class="bg-gray-300 hover:bg-red-400 text-black font-semibold py-2 px-4 rounded mr-2">
                                Cancelar Edição
                            </button>
                            <button @click="desativarEdicao"
                                class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                Salvar Edição
                            </button>
                        </div>
                        <div v-else>
                            <button @click="ativarEdicao"
                                class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
                                Ativar Edição
                            </button>
                        </div>
                    </div>
                    <div v-else class="flex justify-center mb-3">
                        <p class="text-lg"> Ainda não foram criadas páginas para esta unidade </p>
                    </div>
                    <div v-if="edicao" class="flex flex-col gap-y-7 px-5 pt-3">
                        <div v-for="(pagina, index) in paginas" :key="pagina.id">
                            <div class="bg-white p-4 rounded-lg shadow-xl flex flex-col gap-y-1">
                                <p class="text-2xl">{{ index + 1 }}º Página</p>
                                <div class="flex justify-between items-center gap-x-2 mb-3">
                                    <div class="mb-4 w-9/10">
                                        <label class="block font-semibold mb-1">Descrição:</label>
                                        <QuillEditor v-model:content="descricao" content-type="html"
                                            toolbar="essentials" />
                                    </div>
                                    <div class="mb-4 w-1/10 flex justify-center items-center">
                                        <select v-model="pagina.ordem"
                                            class="w-full pl-5 py-2 border-1 border-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                                            <option v-for="n in paginas.length" :key="n" :value="n">{{ n }}º</option>
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
                                <div content-html class="py-2" v-html="pagina.descricao"></div>
                            </div>
                        </div>
                        <div>
                            <CreatePagina :idUnidade="props.idUnidade" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>