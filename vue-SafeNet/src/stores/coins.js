import { defineStore } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'

export const useCoinsStore = defineStore('coins', () => {

  const gameCoins = ref();

  const getCoins = async () => {
    try {
      const response = await axios.get('users/me/coins');
      gameCoins.value = response.data.coins;
    } catch (error) {
      console.error('Error in Getting Coins:', error);
    }
  };

  const comprarProduto = async (produtoId) => {
    try {
      const response = await axios.post(`/comprar/${produtoId}`);
      alert(response.data.message);

      gameCoins.value = response.data.moedas;

    } catch (error) {
      alert(error.response?.data?.message || 'Erro na compra');
    }
  };

  const ganharMoedas = async (quantidade) => {
    try {
      const response = await axios.post('/users/me/ganhar-moedas', {
        quantidade: quantidade
      });
      gameCoins.value = response.data.moedas;
      alert(`Ganhaste ${quantidade} moedas!`);
    } catch (error) {
      alert(error.response?.data?.message || 'Erro ao ganhar moedas');
    }
  };

  return {
    gameCoins,
    getCoins,
    comprarProduto,
    ganharMoedas
  }
});
