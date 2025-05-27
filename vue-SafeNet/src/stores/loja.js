import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useLojaStore = defineStore('loja', () => {
    const produtos = ref([])
    const tiposProdutos = ref([])

    const fetchTiposProdutos = async () => {
        try {
            const response = await axios.get('/tipos-produtos')
            tiposProdutos.value = response.data
        } catch (e) {
            console.error('Erro ao buscar tipos de produtos:', e)
        }
    }

    const fetchProdutos = async () => {
        try {
            const response = await axios.get('/loja')
            produtos.value = response.data
        } catch (e) {
            console.error('Erro ao buscar produtos:', e)
        }
    }

    const alterarEstadoProduto = async (id) => {
        try {
            const response = await axios.put(`/loja/${id}/alterarEstado`)
            if (response.status === 200) {
                const produtoSelecionado = produtos.value.find(p => p.id === id)
                if (produtoSelecionado) {
                    produtoSelecionado.estado = produtoSelecionado.estado === 1 ? 0 : 1
                }
                return true
            }
            return false
        } catch (error) {
            console.error('Erro ao alterar estado do produto:', error)
            return false
        }
    }

    const createProduto = async (produto) => {
        try {
            const response = await axios.post('/loja', produto)
            if (response.status === 201) {
                produtos.value.push(response.data)
                return true
            }
            return false
        } catch (error) {
            console.error('Erro ao criar produto:', error)
            return false
        }
    }


    return {
        produtos,
        tiposProdutos,
        fetchTiposProdutos,
        fetchProdutos,
        alterarEstadoProduto,
        createProduto
    }
})
