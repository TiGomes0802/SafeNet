import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useErrorStore } from '@/stores/error'
import { useUnidadeStore } from '@/stores/unidade'

export const useCursoStore = defineStore('cursos', () => {

  const router = useRouter()
  const storeError = useErrorStore()
  const storeUnidade = useUnidadeStore()

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
        "Erro ao buscar cursos!"
      );
      return false;
    }
  }

  const getCurso = async (id) => {
    try {
      const response = await axios.get(`/cursos/${id}`)
      curso.value = response.data
      storeUnidade.unidades = response.data.unidades
      return true
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Erro ao buscar curso!"
      );
      return false
    }
  }

  const createCurso = async (nome) => {
    try {
      const response = await axios.post('/cursos', { nome: nome })
      router.push({ name: "CursosIndex" });
      if (response.status === 201) {
        return true
      }
      return false
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Erro ao criar curso!"
      );
      return false
    }
  }

  const updateCurso = async (id, nome, estado) => {
    try {
      const response = await axios.put(`/cursos/${id}`, { nome, estado })
      router.push({ name: "CursosIndex" });
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Erro ao atualizar curso!"
      );
      return false
    }
  }

  const alterarEstadoCurso = async (id) => {
    try {
      const response = await axios.put(`/cursos/${id}/alterarEstado`)
      if (response.status === 200) {
        const cursoSelecionado = cursos.value.find(c => c.id === id)
        if (cursoSelecionado) {
          cursoSelecionado.estado = cursoSelecionado.estado === 1 ? 0 : 1
        }
        return true
      }
      return false
    } catch (error) {
      storeError.setErrorMessages(
        error.response?.data?.message,
        error.response?.data?.errors,
        error.response?.status,
        "Erro ao alterar o estado do curso!"
      );
      return false
    }
  }


  return {
    curso,
    cursos,
    getCurso,
    getCursos,
    createCurso,
    updateCurso,
    alterarEstadoCurso
  }
})
