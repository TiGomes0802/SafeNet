import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const usePaginaStore = defineStore('pagina', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const paginas = ref([])
    const pagina = ref(null)

    const getPaginas = async (idUnidade) => {
        try {
            const response = await axios.get("unidade/"+ idUnidade +"/getPaginas");
            paginas.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching pages!"
            );
            return false;
        }
    }

    const getPagina = async (idPagina) => {
        try {
            const response = await axios.get("pagina/"+ idPagina);
            pagina.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching pages!"
            );
            return false;
        }
    }

    const createPagina = async (idUnidade, descricao) => {
        try {
            const response = await axios.post("unidade/" + idUnidade + "/pagina", {descricao: descricao});
            if (response.status === 201) {
                paginas.value = (response.data);
            }
            return true;
        } catch (e) {
            console.log("Error creating page:", e);
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error creating page!"
            );
            return false;
        }
    }

    const updatePaginas = async (paginas, idUnidade) => {
        try {
            const response = await axios.put("paginas/updatePaginas", {paginas: paginas});
            if (response.status === 200) {
                getPaginas(idUnidade);
            }
            return true;
        } catch (e) {
            console.log("Error updating page:", e);
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error updating page!"
            );
            return false;
        }
    }

    return{
        paginas,
        pagina,
        getPaginas,
        getPagina,
        createPagina,
        updatePaginas,
    }
})