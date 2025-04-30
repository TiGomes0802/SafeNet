<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import Sidebar from '@/components/Sidebar.vue'

const route = useRoute()
const unidades = ref([])
const cursoId = route.params.idCurso
const curso = ref(null)

onMounted(async () => {
    try {
        const response = await axios.get(`/cursos/${cursoId}`)
        curso.value = response.data
        unidades.value = response.data.unidades
    } catch (error) {
        console.error('Erro ao carregar unidades:', error)
    }
})
</script>

<template>
    <div class="flex min-h-screen">
        <Sidebar class="h-screen" />
        <main class="flex-1 p-6 bg-gray-50 overflow-auto">
            <h1 class="text-2xl font-bold mb-6" v-if="curso">
                {{ curso.nome }} - Unidades
            </h1>

            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-6 py-3">Título</th>
                        <th class="px-6 py-3">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="unidade in unidades" :key="unidade.id" class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4">{{ unidade.titulo }}</td>
                        <td class="px-6 py-4">{{ unidade.descricao }}</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</template>
