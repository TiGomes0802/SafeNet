<script setup>
    import { useMissaoStore } from '@/stores/missao';

    const storeMissao = useMissaoStore();

</script>

<template>
    <div class="p-4">
        <h2 class="text-2xl font-bold">Missões</h2>
    </div>
    {{ (storeMissao.missoes) }}
    {{ (storeMissao.conquistas) }}
</template>