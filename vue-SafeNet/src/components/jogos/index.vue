<script setup>
    import { onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useJogoStore } from '@/stores/jogo'

    const router = useRouter()
    const jogoStore = useJogoStore()

    const props = defineProps(['idUnidade'])

    onMounted(async () => {
        console.log('ID da unidade:', props.idUnidade);
        const sucesso = await jogoStore.getJogos(props.idUnidade);
        console.log('Jogos:', jogoStore.jogos);
    });
    
</script>

<template>
    <div class="container">
        <h1>Jogos</h1>
        <div class="row">
            <div class="col-12">
                <h2>Lista de Jogos</h2>
                <ul>
                    <!--<li v-for="jogo in JogoStore.jogos" :key="jogo.id">
                        {{ jogo.nome }}
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-12">
            <h2>Adicionar Jogo</h2>
            <form @submit.prevent="adicionarJogo">
                <input type="text" v-model="novoJogo.nome" placeholder="Nome do Jogo" required>
                <button type="submit">Adicionar</button>
            </form>
        </div>
        <div class="col-12">
            <h2>Remover Jogo</h2>
            <form @submit.prevent="removerJogo">
                <input type="text" v-model="jogoId" placeholder="ID do Jogo" required>
                <button type="submit">Remover</button>
            </form>
        </div>
    </div>-->
</template>