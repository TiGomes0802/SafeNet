import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'
import { useAuthStore } from './auth.js'

export const useCoinsStore = defineStore('coins', () => {
  const storeAuth = useAuthStore();

  const getCoins = async () => {
    try {
      const response = await axios.get('users/me/coins');
      storeAuth.user.moedas = response.data.coins;
    } catch (error) {
      console.error('Error in Getting Coins:', error);
    }
  };

  const comprarProduto = async (produtoId) => {
    try {
      const response = await axios.post(`/comprar/${produtoId}`);

      // Colocar pop up mais bonito
      alert(response.data.message);

      storeAuth.getUser();

    } catch (error) {
      alert(error.response?.data?.message || 'Erro na compra');
    }
  };

  // APAGAR FUTURAMENTE-------------------------------------------------------------------------------------
  const ganharMoedas = async (quantidade) => {
    try {
      const response = await axios.post('/users/me/ganhar-moedas', {
        quantidade: quantidade
      });

      storeAuth.user.moedas = response.data.moedas;

      // Colocar pop up mais bonito
      alert(`Ganhaste ${quantidade} moedas!`);

    } catch (error) {
      alert(error.response?.data?.message || 'Erro ao ganhar moedas');
    }
  };

  return {
    getCoins,
    comprarProduto,
    ganharMoedas
  }
});
