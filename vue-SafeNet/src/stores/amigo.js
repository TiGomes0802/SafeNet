import { ref } from 'vue'
import axios from 'axios'
import { defineStore } from 'pinia'
import { useErrorStore } from '@/stores/error'

export const useAmigoStore = defineStore('amigo', () => {

  const storeError = useErrorStore()

  const amigos = ref([]);
  const pedidos = ref([]);

  const mensagemError = ref(null);

  const getAmigos = async () => {
    try {
      const response = await axios.get('/amigos');
      amigos.value = response.data;
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching course!"
      );
      return false
    }
  };

  const getPedidos = async () => {
    try {
      const response = await axios.get('/amigos/pedidos');
      pedidos.value = response.data;
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching course!"
      );
      return false
    }
  }

  const responderPedido = async (username, resposta) => {
    try {
      const response = await axios.post('/amigos/responderPedido', { username: username, resposta: resposta });
      if (response.status === 200) {
        amigos.value = response.data.amigos;
        pedidos.value = response.data.pedidos;
        return true;
      }
      return false;
    } catch (error) {
      console.log(error)
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error responding to friend request!"
      );
      return false;
    }
  }

  const enviarPedido = async (nome) => {
    mensagemError.value = null;
    console.log(nome);
    try {
      const response = await axios.post("/amigos/pedido", { username: nome });
      if (response.status === 200) {
        await getPedidos();
        return true;
      }
      return true;
    } catch (error) {
      if (error.response.status === 400) {
        mensagemError.value = error.response.data.message;
        return false;
      }
      console.error(`Error sending friend request: ${error}`);
      console.log(error);
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error sending friend request!"
      );
      return false;
    }
  }

  const removerAmigo = async (username) => {
    const amigo = { username: username };

    try {
      const response = await axios.delete('/amigos/removerAmigo', { data: amigo });
      if (response.status === 200) {
        await getAmigos();
        return true;
      }
      return false;
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error removing friend!"
      );
      return false;
    }
  }

  return {
    amigos,
    pedidos,
    mensagemError,
    getAmigos,
    getPedidos,
    responderPedido,
    enviarPedido,
    removerAmigo
  }
});
