<script setup>
  import { computed  } from 'vue'
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const data = history.state.data

  if (!data) {
    // Redirecionar para a página inicial ou outra página apropriada
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
    router.push({ name: 'curso', params: { idCurso: data.idCurso } }) // Altere o idCurso conforme necessário
  }
</script>

<template>
  <div class="h-screen flex flex-col items-center justify-center">
    <p class="font-extrabold text-6xl pb-20">Parabéns!🎉</p>
    <div class="flex flex-col items-center">
      <p class="font-bold text-4xl pb-12">🥳 Concluiste mais um nível! 🥳</p>
      <p class="font-semibold text-2xl text-gray-600 pb-20">{{ mensagemFinal }}</p>
    </div>
    <button @click="voltarUnidade" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
      Voltar ao curso
    </button>
  </div>
</template>