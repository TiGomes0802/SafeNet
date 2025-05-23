import { ref } from 'vue'
import axios from 'axios'
import { defineStore } from 'pinia'
import { useErrorStore } from '@/stores/error'

export const useRankStore = defineStore('Rank', () => {

  const storeError = useErrorStore()

  const rank = ref([])

  const getRank = async () => {
    try {
      const response = await axios.get('/rank')
      rank.value = response.data
      return true
    } catch (error) {
      storeError.setErrorMessages(
        error.response.data.message,
        error.response.data.errors,
        error.response.status,
        "Error fetching units!"
      );
      return false;
    }
  }

  return {
    rank,
    getRank
  }
})
