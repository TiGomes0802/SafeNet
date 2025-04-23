<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6 text-center animate-fade-in">
      <div class="flex justify-center">
        <img src="@/assets/safenet-logo.png" alt="SafeNet" class="h-16 mb-4">
      </div>

      <h1 class="text-3xl font-bold text-gray-800">Sê bem-vindo ao SafeNet!</h1>

      <p class="text-gray-600 text-lg">
        Antes de começares, podes fazer um teste para descobrirmos o teu nível! 🚀
      </p>

      <div class="py-4">
        <p class="font-medium text-gray-700">Estás preparado?</p>
      </div>

      <div class="flex space-x-4 pt-2">
        <button @click="$emit('response', false)"
          class="flex-1 py-3 px-4 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
          Não...
        </button>
        <button @click="$emit('response', true)"
          class="flex-1 py-3 px-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-md">
          Sim!
        </button>
      </div>
    </div>
  </div>
</template>
