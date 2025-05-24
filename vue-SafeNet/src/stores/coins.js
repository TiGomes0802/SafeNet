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

  /*
  const comprarProduto = async (produtoId) => {
    try {
      const response = await axios.post(`/comprar/${produtoId}`);

      alert(response.data.message);

      // Atualiza as moedas na store
      coinsStore.setCoins(response.data.moedas);

      // Podes também mostrar as novas vidas, se quiseres
      // console.log('Novas vidas:', response.data.vidas)

    } catch (error) {
      alert(error.response?.data?.message || 'Erro na compra');
    }
  };

  const comprarProduto = async (produtoId) => {
        try {
            const response = await axios.post(`/comprar/${produtoId}`);
            alert(response.data.message);
        } catch (error) {
            alert(error.response?.data?.message || 'Erro na compra');
        }
    };
    */

  return {
    gameCoins,
    getCoins
  }
});
