import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useJogoStore = defineStore('jogo', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const jogos = ref(null)
    const jogo = ref(null)

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

    const getJogo = async (idJogo) => {
        try {
            const response = await axios.get("jogo/"+ idJogo);
            jogo.value = response.data;
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

    const createJogo = async (jogo) => {
        try {
            console.log("Creating game with data:", { jogo });
            const response = await axios.post("unidade/" + jogo.idUnidade + "/jogo", jogo);
            if (response.status === 201) {
                router.push({ name: "Jogos", params: { idUnidade: jogo.idUnidade } });
            }
            return true;
        } catch (e) {
            console.log("Error creating game:", e);
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error creating game!"
            );
        }
    }

    const updateJogo = async (newjogo) => {
        try {
            const response = await axios.put("jogo/" + jogo.value.id, newjogo);
            if (response.status === 200) {
                router.push({ name: "Jogos", params: { idUnidade: jogo.value.idUnidade } });
            }
            jogo.value = ref(null);
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error updating game!"
            );
        }
    }

    const mudarEstadoJogo = async (idJogo, idUnidade) => {
        try {
            const response = await axios.put("jogo/" + idJogo + "/estado");
            if (response.status === 200) {
                getJogos(idUnidade);
            }
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error updating game!"
            );
        }
    }

    return{
        jogos,
        jogo,
        getJogo,
        getJogos,
        createJogo,
        updateJogo,
        mudarEstadoJogo
    }
})