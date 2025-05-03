import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useCursosStore = defineStore('cursos', () => {
  const cursos = ref([])
  const cursosCarregados = ref(false)

  const getCursos = async () => {
    if (!cursosCarregados.value) {  // Cursos já foram carregados
      try {
        const response = await axios.get('/cursos')
        cursos.value = response.data
        cursosCarregados.value = true
      } catch (error) {
        console.error("Erro ao buscar cursos:", error)
      }
    }
  }

  return {
    cursos,
    cursosCarregados,
    getCursos
  }
})
