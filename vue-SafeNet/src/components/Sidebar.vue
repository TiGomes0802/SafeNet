<template>
    <aside class="w-64 bg-white shadow-md p-4 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-6">SafeNet</h1>
            <nav class="space-y-2">
                <router-link to="/unidade/Engenharia Social" class="block py-2 px-3 rounded hover:bg-gray-100">Engenharia Social
                    </router-link>
                <router-link to="/unidade/Autenticação" class="block py-2 px-3 rounded hover:bg-gray-100">Autenticação
                    </router-link>
                <router-link to="/unidade/Malware" class="block py-2 px-3 rounded hover:bg-gray-100">Malware
                    </router-link>
                <router-link to="/unidade/Redes Sociais" class="block py-2 px-3 rounded hover:bg-gray-100">Redes Sociais
                    </router-link>
                <router-link to="/unidade/Sistemas Operativos" class="block py-2 px-3 rounded hover:bg-gray-100">Sistemas Operativos
                    </router-link>
                <router-link to="/unidade/Navegação" class="block py-2 px-3 rounded hover:bg-gray-100">Navegação na Internet
                    </router-link>
            </nav>
            <nav class="space-y-2 mt-12">
                <router-link to="/missoes" class="block py-2 px-3 rounded hover:bg-gray-100">Missões</router-link>
                <router-link to="/estatisticas" class="block py-2 px-3 rounded hover:bg-gray-100">Estatísticas</router-link>
                <router-link to="/loja" class="block py-2 px-3 rounded hover:bg-gray-100">Loja</router-link>

            </nav>
        </div>
        <div class="border-t pt-6 space-y-5">
            <div class="block text-sm text-gray-700 font-semibold">120 🪙 </div>
            <router-link to="#" class="block text-sm text-gray-500 hover:underline">Perfil</router-link>
            <router-link to="#" class="block text-sm text-gray-500 hover:underline">Logout</router-link>
        </div>
    </aside>
</template>