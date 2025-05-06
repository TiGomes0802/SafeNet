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

  const getCurso = (id) => {
    return cursos.value.find(curso => curso.id === id)
  }

  return {
    cursos,
    cursosCarregados,
    getCursos,
    getCurso
  }
})
