<script setup>
  import { ref, watch, onMounted, onUnmounted, computed } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import { useAuthStore } from '@/stores/auth'
  import { useCursoStore } from '@/stores/curso'
  import { useUnidadeStore } from '@/stores/unidade'
  import { useMissaoStore } from '@/stores/missao'
  import Sidebar from '@/components/sideBar/Sidebar.vue'
  import UnidadeCard from '@/components/unidades/UnidadeCard.vue'
  import Loading from '@/components/loading/FrontofficeLaoding.vue'

  const route = useRoute()
  const router = useRouter()

  const storeAuth = useAuthStore()
  const storeCurso = useCursoStore()
  const storeUnidade = useUnidadeStore()
  const storeMissao = useMissaoStore()

  const cursoId = ref(route.params.idCurso)
  const loading = ref(true)

  const windowWidth = ref(window.innerWidth)
  const isSidebarOpen = ref(false)

  const updateWidth = () => {
    windowWidth.value = window.innerWidth
  }

  const dynamicPadding = computed(() => {
    return windowWidth.value < 768 && !isSidebarOpen.value ? 'pl-20' : 'pl-10'
  })

  onMounted(async () => {
    window.addEventListener('resize', updateWidth)

    await storeCurso.getCurso(cursoId.value)

    if (storeAuth.user.type === 'J') {
      await storeMissao.getMinhasmissoes()
    }

    loading.value = false
  })

  onUnmounted(() => {
    window.removeEventListener('resize', updateWidth)
  })

  watch(() => route.params.idCurso, async (novoId) => {
    cursoId.value = novoId
    loading.value = true

    await storeCurso.getCurso(cursoId.value)

    if (storeAuth.user.type === 'J') {
      await storeMissao.getMinhasmissoes()
    }

    loading.value = false
  })

  const irParaUnidade = (unidade) => {
    storeUnidade.unidade = unidade
    router.push({ name: 'Unidade', params: { idUnidade: unidade.id } })
  }
</script>

<template>
  <div v-if="loading">
    <Loading />
  </div>
  <div v-else>
    <transition name="fade" appear enter-active-class="transition-opacity duration-700" enter-from-class="opacity-0"
      enter-to-class="opacity-100">
      <div class="flex h-screen">
        <Sidebar :isOpen="isSidebarOpen" @toggle="isSidebarOpen = !isSidebarOpen" />
        <div class="flex-1 bg-gray-100 overflow-y-scroll transition-all duration-300" :class="['p-6', dynamicPadding]">
          <p class="text-3xl font-bold text-blue-600 mb-6">{{ storeCurso?.curso?.nome }}</p>

          <div class="space-y-12">
            <template v-for="unidade in storeUnidade?.unidades" :key="unidade.id">
              <div v-if="unidade.status !== -1" @click="irParaUnidade(unidade)"
                class="cursor-pointer block transform transition duration-300 hover:scale-101 hover:shadow-lg">
                <UnidadeCard :titulo="unidade.titulo" :descricao="unidade.descricao" :status="unidade.status" />
              </div>
              <div v-else>
                <UnidadeCard :titulo="unidade.titulo" :descricao="unidade.descricao" :status="unidade.status" />
              </div>
            </template>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
