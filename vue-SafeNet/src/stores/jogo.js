import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useJogoStore = defineStore('jogo', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const jogos = ref(null)

    const getJogos = async (idUnidade) => {
        try {
            const response = await axios.get("unidade/"+ idUnidade +"/getJogos");
            jogos.value = response.data;
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
        jogos,
        getJogos
    }
})