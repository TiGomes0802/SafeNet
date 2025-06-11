<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import Sidebar from '@/components/SideBar/Sidebar.vue'
import { useCursoStore } from '@/stores/curso'
import { useUnidadeStore } from '@/stores/unidade'
import draggable from 'vuedraggable'
import Loading from '@/components/loading/BackofficeLoading.vue'

const route = useRoute()
const storeCurso = useCursoStore()
const storeUnidade = useUnidadeStore()

const cursoId = route.params.idCurso
const ordemAlterada = ref(false)
const loading = ref(true);

onMounted(async () => {
    if (storeCurso.cursos.length == 0) {
        await storeCurso.getCurso(cursoId)
    } else {
        for (const curso of storeCurso.cursos) {
            if (curso.id == cursoId) {
                storeCurso.curso = curso
                storeUnidade.unidades = curso.unidades
                break
            }
        }
    }

    loading.value = false
})

const guardarNovaOrdem = async () => {
    const novaOrdem = storeUnidade.unidades.map((u, index) => ({
        id: u.id,
        ordem: index + 1
    }))

    const success = await storeUnidade.updateUnidadeOrder(cursoId, novaOrdem)

    if (success) {
        ordemAlterada.value = false
    }
}



const onOrderChange = () => {
    ordemAlterada.value = true
}

</script>

<template>
    <div v-if="loading">
        <Loading />
    </div>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
        enter-to-class="opacity-100">
        <div class="flex h-screen">
            <Sidebar class="h-screen" />
            <main class="flex-1 p-6 bg-gray-50 overflow-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold mb-6" v-if="storeCurso.curso">
                        {{ storeCurso.curso.nome }} - Unidades
                    </h1>

                    <div class="flex gap-4">
                        <button v-if="ordemAlterada" @click="guardarNovaOrdem"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                            Guardar
                        </button>
                        <router-link :to="`/backoffice/cursos/${cursoId}/unidades/create`"
                            class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                            Criar Unidade
                        </router-link>
                    </div>
                </div>


                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-6 py-3">Título</th>
                            <th class="px-6 py-3">Descrição</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <draggable v-model="storeUnidade.unidades" tag="tbody" item-key="id" handle=".drag-handle"
                        @end="onOrderChange">
                        <template #item="{ element }">
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4 flex items-center gap-2">
                                    <span class="drag-handle cursor-move text-gray-400">⠿</span>
                                    {{ element.titulo }}
                                </td>
                                <td class="px-6 py-4">{{ element.descricao }}</td>
                                <td class="px-6 py-4 flex justify-end space-x-2">
                                    <router-link :to="`/backoffice/unidade/${element.id}/edit`"
                                        class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                        Editar
                                    </router-link>
                                    <router-link :to="`/backoffice/unidade/${element.id}/paginas/`"
                                        class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                        Páginas
                                    </router-link>
                                    <router-link :to="`/backoffice/unidade/${element.id}/jogos/`"
                                        class="bg-gray-300 hover:bg-red-400 text-black font-semibold py-2 px-4 rounded">
                                        Jogos
                                    </router-link>
                                </td>
                            </tr>
                        </template>
                    </draggable>
                </table>
            </main>
        </div>
    </transition>
</template>
