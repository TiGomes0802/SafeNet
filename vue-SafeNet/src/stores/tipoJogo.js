import { ref } from 'vue'
import { defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useTipoJogoStore = defineStore('tipojogo', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const tiposjogos = ref(null)

    const getTipoJogos = async (idUnidade) => {
        try {
            const response = await axios.get("tipojogo/getTiposJogos");
            tiposjogos.value = response.data;
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

    return{
        tiposjogos,
        getTipoJogos
    }
})