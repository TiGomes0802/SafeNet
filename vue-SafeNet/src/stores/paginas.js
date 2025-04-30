import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const usePaginasStore = defineStore('pagina', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const paginas = ref(null)
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

    const createPagina = async (pagina) => {
        try {
            const response = await axios.post("unidade/" + pagina.idUnidade + "/pagina", pagina);
            if (response.status === 201) {
                router.push({ name: "Paginas", params: { idUnidade: pagina.idUnidade } });
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

    const updatePagina = async (pagina) => {
        try {
            const response = await axios.put("pagina/" + pagina.id, pagina);
            if (response.status === 200) {
                router.push({ name: "Paginas", params: { idUnidade: pagina.idUnidade } });
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
        updatePagina,
    }
})