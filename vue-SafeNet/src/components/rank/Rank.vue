<script setup>
    import { ref, onMounted, computed } from 'vue';
    import { useRankStore } from '@/stores/rank';
    import Sidebar from '@/components/Sidebar.vue';
    
    const storeRank = useRankStore();
    const loading = ref(true);
    
    const amigosPorPagina = 10;
    const paginaActual = ref(1);
    const todosOsAmigos = ref([]);

    // Computar os amigos paginados conforme a página actual
    const amigosPaginados = computed(() => {
        const inicio = (paginaActual.value - 1) * amigosPorPagina;
        return todosOsAmigos.value.slice(inicio, inicio + amigosPorPagina);
    });

    const paginaSeguinte = () => {
        if (paginaActual.value * amigosPorPagina < todosOsAmigos.value.length) {
            paginaActual.value++;
        }
    };

    onMounted(() => {
        storeRank.getRank().then(() => {
            console.log("Dados carregados:", storeRank.rank);
            todosOsAmigos.value = Array.isArray(storeRank.rank.amigos) ? storeRank.rank.amigos : [];
            loading.value = false;
        });
    });
</script>


<template>
    <div v-if="loading">
        <Loading />
    </div>
    <transition
        name="fade"
        appear
        enter-active-class="transition-opacity duration-700"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100">
        <div v-if="!loading" class="flex">
            <Sidebar />
            <div class="flex-1 bg-gray-200 w-screen h-screen overflow-y-scroll">
                <h2>Ranking Mundial</h2>
                <ul>
                    <li v-for="jogador in storeRank.rank.mundial" :key="jogador.username">
                        {{ jogador.posicao }} - {{ jogador.username }} ({{ jogador.rank }}) - {{ jogador.xp }}
                    </li>
                </ul>

                <h2>Ranking dos Amigos</h2>
                <ul>
                    <li v-for="amigo in amigosPaginados" :key="amigo.username">
                        {{ amigo.posicao }} - {{ amigo.username }} ({{ amigo.rank }}) - {{ amigo.xp }}
                    </li>
                </ul>

                <button @click="paginaActual--" :disabled="paginaActual === 1">Anterior</button>
                <span>Página {{ paginaActual }}</span>
                <button 
                @click="paginaSeguinte">
                    Seguinte
                </button>
            </div>
        </div>
    </transition>
</template>