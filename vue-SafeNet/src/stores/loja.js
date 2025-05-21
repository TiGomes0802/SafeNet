import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useLojaStore = defineStore('loja', () => {
    const produtos = ref([])

    const fetchProdutos = async () => {
        try {
            const response = await axios.get('/loja')
            produtos.value = response.data
            console.log('Produtos carregados:', produtos.value) 
        } catch (e) {
            console.error('Erro ao buscar produtos:', e)
        }
    }

    return {
        produtos,
        fetchProdutos
    }
})
