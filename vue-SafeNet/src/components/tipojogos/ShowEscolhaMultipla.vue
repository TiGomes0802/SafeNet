<script setup>
    const props = defineProps({
        respostas: {
            type: Array,
            required: true
        }
    })
</script>
<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 w-full gap-4">
        <div v-for="(resposta, index) in respostas" :key="index" class="bg-gray-200 p-2 w-full rounded-lg shadow-md" :class="resposta.certa ? 'bg-green-200' : 'bg-red-200'">
            <p>{{ resposta.resposta }}</p>
        </div>
    </div>
</template>
  