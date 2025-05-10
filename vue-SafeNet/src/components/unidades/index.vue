<script setup>
    import { ref, onMounted } from 'vue'
    import { useRoute } from 'vue-router'
    import Sidebar from '@/components/Sidebar.vue'
    import { useCursoStore } from '@/stores/curso'
    import { useUnidadeStore } from '@/stores/unidade'

    const route = useRoute()
    const storeCurso = useCursoStore()
    const storeUnidade = useUnidadeStore()

    const cursoId = route.params.idCurso

    onMounted(async () => {
        if (storeCurso.cursos.length == 0) {
            await storeCurso.getCurso(cursoId)
        }else{
            for (const curso of storeCurso.cursos) {
                if (curso.id == cursoId) {
                    storeCurso.curso = curso
                    storeUnidade.unidades = curso.unidades
                    break
                }
            }
        }
    })

</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar class="h-screen" />
        <main class="flex-1 p-6 bg-gray-50 overflow-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold mb-6" v-if="storeCurso.curso">
                    {{ storeCurso.curso.nome }} - Unidades
                </h1>

                <router-link :to="`/backoffice/cursos/${cursoId}/unidades/create`"
                    class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                    Criar Unidade
                </router-link>
            </div>


            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-6 py-3">Título</th>
                        <th class="px-6 py-3">Descrição</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="unidade in storeUnidade.unidades" :key="unidade.id" class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ unidade.titulo }}</td>
                        <td class="px-6 py-4">{{ unidade.descricao }}</td>
                        <td class="px-6 py-4 flex justify-end space-x-2">
                            <router-link :to="`/backoffice/`"
                                class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                Editar
                            </router-link>
                            <router-link :to="`/backoffice/unidade/${unidade.id}/paginas/`"
                                class="bg-gray-300 hover:bg-green-400 text-black font-semibold py-2 px-4 rounded">
                                Páginas
                            </router-link>
                            <router-link :to="`/backoffice/unidade/${unidade.id}/jogos/`"
                                class="bg-gray-300 hover:bg-red-400 text-black font-semibold py-2 px-4 rounded">
                                jogos
                            </router-link>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </main>
    </div>
</template>
