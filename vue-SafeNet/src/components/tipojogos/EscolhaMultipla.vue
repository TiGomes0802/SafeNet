<script setup>
    import { ref, watch } from 'vue'

    const props = defineProps({
        modelValue: Object,
        erros: Object
    })

    const emit = defineEmits(['update:modelValue'])

    const jogoLocal = ref({
        respostas: ['', '', '', ''],
        respostaCerta: '',
        indexRespostaCerta: '',
    })

    watch([
        () => jogoLocal.value.indexRespostaCerta, 
        () => jogoLocal.value.respostas[jogoLocal.value.indexRespostaCerta]
        ], () => {
            jogoLocal.value.respostaCerta = jogoLocal.value.respostas[jogoLocal.value.indexRespostaCerta]
        }
    )

    // Sempre que jogoLocal muda, emitimos para o pai
    watch(jogoLocal, (novoValor) => {
        emit('update:modelValue', novoValor)
    }, { deep: true, immediate: true })

    const letras = ['A', 'B', 'C', 'D']
</script>
<template>
    <div class="mb-4">
        <label class="block font-semibold mb-1">Respostas:</label>
        <div v-for="(letra, index) in letras" :key="index" class="flex items-center mb-2">
        <span class="w-6 font-bold">{{ letra }})</span>
        <input
            v-model="jogoLocal.respostas[index]" class="w-full pl-5 py-2 border-1 border-black rounded-md" :class="props.erros?.respostas?.includes(index) ? 'border-red-500' : 'border-gray-300'"
        />
        </div>
    </div>
    
    <div class="mb-4">
        <label class="block font-semibold mb-1">Resposta Certa:</label>
        <select v-model="jogoLocal.indexRespostaCerta" class="w-full pl-5 py-2 border-1 border-black rounded-md" :class="props.erros.respostaCerta ? 'border-red-500' : 'border-black'">
            <option value="" disabled>Selecione a resposta certa</option>
        <option v-for="(letra, index) in letras" :key="index" :value="index">{{ letra }})</option>
        </select>
    </div>

</template>