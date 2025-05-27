import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";
import { useErrorStore } from "@/stores/error";
import { useRouter } from "vue-router";

export const useUnidadeStore = defineStore("unidade", () => {
    const router = useRouter();
    const storeError = useErrorStore();

    const unidades = ref([]);
    const unidade = ref(null);

    const getUnidades = async (idCurso) => {
        try {
            const response = await axios.get(`/cursos/${idCurso}/unidades`);
            unidades.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Erro ao buscar unidades!"
            );
            return false;
        }
    }

    const getUnidade = async (idUnidade) => {
        try {
            const response = await axios.get(`/unidades/${idUnidade}`);
            unidade.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response?.data?.message,
                e.response?.data?.errors,
                e.response?.status,
                "Erro ao carregar unidade!"
            );
            return false;
        }
    };


    const concluirUnidade = async (idUnidade, jogos) => {
        const data = {
            idUnidade: idUnidade,
            jogos: jogos,
        };
        try {
            const response = await axios.post("unidade/concluir", data);
            if (response.status === 200) {
                router.push({ name: "Sucesso", state: { data: response.data } })
            }
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Erro a concluir unidade!"
            );
            return false;
        }
    }

    const updateUnidadeOrder = async (idCurso, newOrder) => {
        try {
            const response = await axios.post(`/cursos/${idCurso}/unidades/order`, {
                ordem: newOrder,
            });

            if (response.status === 200) {
                unidades.value = response.data.unidades;
                return true;
            }
        } catch (e) {
            storeError.setErrorMessages(
                e.response?.data?.message,
                e.response?.data?.errors,
                e.response?.status,
                "Erro a atualizar ordem das unidades!"
            );
            return false;
        }
    }

    const updateUnidade = async (idUnidade, data) => {
        try {
            const response = await axios.put(`/unidades/${idUnidade}`, data);
            unidade.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response?.data?.message,
                e.response?.data?.errors,
                e.response?.status,
                "Erro ao atualizar unidade!"
            );
            return false;
        }
    };


    return {
        unidades,
        unidade,
        getUnidades,
        getUnidade,
        concluirUnidade,
        updateUnidadeOrder,
        updateUnidade
    }
});