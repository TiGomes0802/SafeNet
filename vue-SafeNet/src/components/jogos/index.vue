<script setup>
    import { onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useJogoStore } from '@/stores/jogo'
    import Sidebar from '@/components/Sidebar.vue'

    const router = useRouter()
    const jogoStore = useJogoStore()

    const props = defineProps(['idUnidade'])

    onMounted(async () => {
        await jogoStore.getJogos(props.idUnidade);
    });
</script>

<template>
    <div class="flex h-screen">
        <Sidebar />
        <div class="flex-1 bg-gray-100 p-6 overflow-y-scroll">
            <h1>Jogos</h1>
            <div class="row">
                <div class="col-12">
                    <h2>Lista de Jogos</h2>
                    <table class="blueTable">
                        <thead>
                            <tr>
                                <th>head1</th>
                                <th>head2</th>
                                <th>head3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="jogo in jogoStore.jogos" :key="jogo.id">
                                <tr>
                                    <td>{{ jogo.id }}</td>
                                    <td>{{ jogo.xp }}</td>
                                    <td>{{ jogo.gestor }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <ul v-if="jogo.respostas && jogo.respostas.length">
                                            <li v-for="resposta in jogo.respostas" :key="resposta.id">
                                                {{ resposta.texto }}
                                            </li>
                                        </ul>
                                        <span v-else>Sem respostas</span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
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
    </div>
</template>
