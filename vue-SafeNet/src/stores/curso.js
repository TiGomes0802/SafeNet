import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useErrorStore } from '@/stores/error'

export const useCursosStore = defineStore('cursos', () => {
 
  const storeError = useErrorStore()
  const router = useRouter()

  const curso = ref()
  const cursos = ref([])

  const getCursos = async () => {
    try {
      const response = await axios.get('/cursos')
      cursos.value = response.data
      return true
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching units!"
      );
      return false;
    }
  }

  const getCursosAtivos = async () => {
    try {
      const response = await axios.get('/cursos/ativos')
      cursos.value = response.data
      return true
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching active courses!"
      );
    }
  }

  const getCurso = async (id) => {
    try {
      const response = await axios.get(`/cursos/${id}`)
      curso.value = response.data
      return true
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching course!"
      );
      return false
    }
  }

  const createCurso = async (nome) => {
    try {
      const response = await axios.post('/cursos', nome)
      router.push({name: "CursosIndex"});
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error creating course!"
      );
      return false
    }
  }

  const updateCurso = async (id, nome, estado) => {
    try {
      const response = await axios.put(`/cursos/${id}`, { nome, estado })
      router.push({name: "CursosIndex"});
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error updating course!"
      );
      return false
    }
  }

  return {
    curso,
    cursos,
    getCurso,
    getCursos,
    getCursosAtivos,
    createCurso,
    updateCurso,
  }
})
