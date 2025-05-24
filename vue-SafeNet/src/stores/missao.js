import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useMissaoStore = defineStore('missao', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const missoes = ref([])
    const conquistas = ref([])

    const getMissoes = async () => {
        try {
            const response = await axios.get("missoes/");
            missoes.value = response.data.missoes;
            conquistas.value = response.data.conquistas;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching games!"
            );
            return false;
        }
    }

    const getMinhasmissoes = async () => {
        try {
            const [responseMissoes, responseConquistas] = await Promise.all([
                axios.get("missoes/minhasMissoes"),
                axios.get("missoes/minhasConquistas")
            ]);

            missoes.value = responseMissoes.data;
            conquistas.value = responseConquistas.data;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching games!"
            );
            return false;
        }
    }

    const alterarEstadoMissao = async (missaoId) => {
        try {
            const response = await axios.post(`missoes/alterarEstado/${missaoId}`);
            if (response.status === 200) {
                // Update the local state if needed
                if (response.data.tipo === 'missao') {
                    const index = missoes.value.findIndex(m => m.id === missaoId);
                    if (index !== -1) {
                        missoes.value[index] = response.data;
                    }
                }else if (response.data.tipo === 'conquista') {
                    const index = conquistas.value.findIndex(m => m.id === missaoId);
                    if (index !== -1) {
                        conquistas.value[index] = response.data;
                    }
                }
                return true;
            }
        }catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error updating mission state!"
            );
            return false;
        }
    }   

    return{
        missoes,
        conquistas,
        getMissoes,
        getMinhasmissoes,
        alterarEstadoMissao
    }
})