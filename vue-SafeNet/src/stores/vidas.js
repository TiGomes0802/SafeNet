import {ref } from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useVidasStore = defineStore('vidas', () => {
    const router = useRouter()
    const storeError = useErrorStore();

    const vidas = ref(null)
    const errorVidas = ref(null)

    const getVidas = async () => {
        try {
            const response = await axios.get("/users/getVidas");
            vidas.value = response.data;
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
            vidas.value = response.data;
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
            const response = await axios.post("/users/ganharVidas", {vidas});
            vidas.value = response.data;
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
        vidas,
        getVidas,
        perderVida,
        ganharVidas
    }

})