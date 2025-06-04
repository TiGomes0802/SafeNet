import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useAuthStore } from "@/stores/auth";

export const useVidasStore = defineStore('vidas', () => {
    const storeError = useErrorStore();
    const storeAuth = useAuthStore();

    const errorVidas = ref(null)

    const getVidas = async () => {
        try {
            const response = await axios.get("/users/getVidas");
            storeAuth.user.vida = response.data.vidas;
            storeAuth.user.ultima_vida_update = response.data.ultimaReposicao;
            return true;
        } catch (e) {
            errorVidas.value = e.response.data.message;
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Vidas Error!"
            );
            return false;
        }
    }

    const perderVida = async () => {
        try {
            const response = await axios.post("/users/perderVida");
            storeAuth.user.vida = response.data.vidas;
            storeAuth.user.ultima_vida_update = response.data.ultimaReposicao;
            return true;
        } catch (e) {
            errorVidas.value = e.response.data.message;
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Vidas Error!"
            );
            return false;
        }
    }

    const ganharVidas = async (vidas) => {
        try {
            const response = await axios.post("/users/ganharVidas", {numVidas:vidas});
            storeAuth.user.vida = response.data.vidas;
            storeAuth.user.ultima_vida_update = response.data.ultimaReposicao;
            return true;
        } catch (e) {
            errorVidas.value = e.response.data.message;
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Vidas Error!"
            );
            return false;
        }
    }

    return {
        getVidas,
        perderVida,
        ganharVidas
    }

})