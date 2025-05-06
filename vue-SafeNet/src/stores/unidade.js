import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";
import { useErrorStore } from "@/stores/error";
import { useRouter } from "vue-router";

export const useUnidadeStore = defineStore("unidade", () => {
    const router = useRouter();
    const storeError = useErrorStore();

    const unidades = ref(null);
    const unidade = ref(null);

    const concluirUnidade = async (idUnidade, jogos) => {
        const data = {
            idUnidade: idUnidade,
            jogos: jogos,
        };

        try {
            const response = await axios.post("unidade/concluir", data);
            if (response.status === 200) {
                //router.push({ name: "Unidades" });
            }
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error concluding unit!"
            );
            return false;
        }
    }

    return{
        unidades,
        unidade,
        concluirUnidade,
    }
});