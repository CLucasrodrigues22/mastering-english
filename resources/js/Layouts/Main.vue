<script setup>
import { switchTheme } from "../theme";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

// Acesso à página e ao usuário
const page = usePage();
const user = computed(() => page.props.auth.user);

// Estado do menu
const show = ref(false);

// Alternância do menu para telas pequenas
const toggleMenu = () => {
    show.value = !show.value;
};
</script>

<template>
    <!-- Overlay para fechar o menu quando clicado fora -->
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>

    <header class="bg-slate-800 text-white">
        <nav class="p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
                <!-- Logo -->
                <a href="#" class="text-2xl font-bold">Logo</a>

                <!-- Menu para telas maiores -->
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">Início</a>
                    <a href="#" class="text-gray-400 hover:text-white">Sobre</a>
                    <a href="#" class="text-gray-400 hover:text-white">Serviços</a>
                    <a href="#" class="text-gray-400 hover:text-white">Contato</a>
                </div>

                <!-- Botão de perfil e alternar tema -->
                <div class="hidden md:block space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">Perfil</a>
                    <button @click="switchTheme" class="text-gray-400 hover:text-white">
                        <i class="fas fa-moon"></i> <!-- ícone para alternar tema -->
                    </button>
                </div>

                <!-- Menu para telas pequenas -->
                <div class="md:hidden flex items-center">
                    <!-- Ícone de menu (hamburguer) -->
                    <button @click="toggleMenu" class="text-gray-400 hover:text-white">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Menu dropdown (para telas pequenas) -->
    <div v-show="show" class="md:hidden bg-gray-700 text-white space-y-4 py-4 px-10">
        <!-- Botão de perfil com destaque -->
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center">
                <a href="#" class="block text-gray-400 hover:bg-blue-600 hover:text-white py-2 rounded-md transition-all duration-300">
                    Olá, Lucas Rod... <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <button @click="switchTheme" class="text-gray-400 hover:text-white">
                    <i class="fas fa-moon"></i> <!-- ícone para alternar tema -->
                </button>
            </div>
        </div>

        <a href="#" class="block text-gray-400 hover:text-white">Home</a>
        <a href="#" class="block text-gray-400 hover:text-white">Sobre</a>
        <a href="#" class="block text-gray-400 hover:text-white">Serviços</a>
        <a href="#" class="block text-gray-400 hover:text-white">Contato</a>
    </div>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
