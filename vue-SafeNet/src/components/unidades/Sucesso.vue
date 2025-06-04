<script setup>
  import { ref, computed, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import { useAuthStore } from '@/stores/auth'

  const router = useRouter()
  const storeAuth = useAuthStore()

  const data = history.state.data
  const progressoVisivel = ref([])
  const missoes = ref(data?.missoes || [])
  if (!data) {
    router.push({ name: 'home' })
  }

  const mensagemFinal = computed(() => {
    const taxa = data.taxaAcerto

    if (taxa === 100) {
      return `Incrível! Respondeste tudo certo à primeira e ganhaste ${data.xpGanho} de XP! 🚀`
    } else if (taxa >= 75) {
      return `Muito bem! Acertaste ${taxa}% das perguntas à primeira e ganhaste ${data.xpGanho} de XP! 👏`
    } else if (taxa >= 50) {
      return `Nada mal! Acertaste ${taxa}% à primeira. Ainda ganhaste ${data.xpGanho} de XP! 💪`
    } else {
      return `Terminaste a unidade com ${taxa}% de acerto à primeira. Continua a praticar! Ganhaste ${data.xpGanho} de XP! 🔁`
    }
  })

  const voltarUnidade = () => {
    router.push({ name: 'curso', params: { idCurso: data.idCurso } })
  }

  onMounted(async () => {
    await storeAuth.getUser();
    progressoVisivel.value = missoes.value.map(m => m.progresso_antes)
    // Anima progressivamente até ao progresso final
    missoes.value.forEach((missao, i) => {
      const intervalo = setInterval(() => {
        if (progressoVisivel.value[i] < missao.progresso_depois) {
          progressoVisivel.value[i]++
        } else {
          clearInterval(intervalo)
        }
      }, 100) // muda a velocidade aqui se quiseres
    })
  })
</script>

<template>
  <div class="flex flex-col items-center justify-center p-10 bg-gray-100 h-min-screen">
    <p class="font-extrabold text-6xl pb-20">Parabéns!🎉</p>
    <div class="flex flex-col items-center">
      <p class="font-bold text-4xl pb-12">🥳 Concluiste mais um nível! 🥳</p>
      <p class="font-semibold text-2xl text-gray-600 pb-10">{{ mensagemFinal }}</p>
    </div>
    <div v-for="(missao, index) in missoes" :key="index" class="flex flex-col border-2 border-gray-400 rounded-lg bg-white p-3 my-4 w-[95%] xs:w-[80%] md:[70%] lg:65%] xl:w-[60%] mb-5">
      <p class="text-lg font-semibold text-center mb-3">{{ missao.descricao }}</p>

      <div class="relative w-full h-6 bg-gray-200 rounded-full overflow-hidden mb-2">
        <div
          class="h-6 rounded-full transition-all duration-1000"
          :class="missao.concluida ? 'bg-yellow-400' : 'bg-green-500'"
          :style="{ width: ((progressoVisivel[index] / missao.objetivo) * 100) + '%' }"
        ></div>
        <p class="absolute inset-0 flex items-center justify-center text-sm font-medium text-gray-700">
          {{ progressoVisivel[index] }} / {{ missao.objetivo }}
        </p>
      </div>

      <!-- Mostrar moedas se a missão foi concluída -->
      <div v-if="missao.concluida" class="text-sm text-center text-yellow-600 font-semibold">
        +{{ missao.moedas }} moedas
      </div>
    </div>
    <button @click="voltarUnidade" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-full transition duration-300 mt-5">
      Voltar ao curso
    </button>
  </div>
</template>