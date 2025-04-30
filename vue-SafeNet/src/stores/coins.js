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

  return {
    gameCoins,
    getCoins
  }
});
