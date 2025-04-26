<template>
    <div class="max-w-md mx-auto">
      <h2 class="text-xl font-semibold mb-4">Ordena as respostas</h2>
      <draggable v-model="respostas" class="space-y-2" item-key="id">
        <template #item="{ element }">
          <div class="bg-white shadow rounded p-2 border cursor-move">
            {{ element.texto }}
          </div>
        </template>
      </draggable>
      <button
        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        @click="guardar"
      >
        Guardar Ordem
      </button>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import draggable from 'vuedraggable' // <- Isto tem de estar assim!
  
  const respostas = ref([
    { id: 1, texto: 'Primeira' },
    { id: 2, texto: 'Segunda' },
    { id: 3, texto: 'Terceira' }
  ])
  
  function guardar() {
    console.log('Nova ordem:', respostas.value)
  }
  </script>
  