<script setup>
import { switchTheme } from "../theme";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import Logo from "../Components/Logo.vue";

// Acesso à página e ao usuário
const page = usePage();
const user = computed(() => page.props.auth.user);

// Estado do menu
const show = ref(false);

// Alternância do menu para telas pequenas
const toggleMenu = () => {
    show.value = !show.value;
};

// Função para fechar o menu quando um item for clicado
const closeMenu = () => {
    show.value = false;
};
</script>

<template>
    <!-- Overlay para fechar o menu quando clicado fora -->
    <div v-show="show" @click="show = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <header class="bg-slate-800 text-white z-50">
        <nav class="p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
                <!-- Logo -->
                <Logo routeName="home" componentName="Home">Mastering English</Logo>

                <!-- Menu para telas maiores -->
                <div class="hidden md:flex space-x-6">
                    <Link href="#" class="text-gray-400 hover:text-white">Início</Link>
                    <Link href="#" class="text-gray-400 hover:text-white">Cursos</Link>
                    <Link href="#" class="text-gray-400 hover:text-white">Sobre</Link>
                    <Link href="#" class="text-gray-400 hover:text-white">Contato</Link>
                </div>

                <!-- Botão de perfil e alternar tema -->
                <div class="hidden md:block space-x-6">
                    <button @click="switchTheme" class="text-gray-400 hover:text-white">
                        <i class="fas fa-moon"></i> <!-- ícone para alternar tema -->
                    </button>
                    <a href="#" class="text-gray-400 hover:text-white">Olá, Lucas Ro... <i class="fa-solid fa-arrow-right"></i></a>
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
    <div v-show="show" class="fixed top-0 left-0 right-0 bg-gray-700 text-white z-50 py-4 px-10">
        <!-- Botão de perfil com destaque -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center">
                <Link href="#" class="block text-gray-400 hover:bg-blue-600 hover:text-white py-2 rounded-md transition-all duration-300">
                    Olá, <strong>Lucas Ro...</strong><i class="fa-solid fa-arrow-right ml-2"></i>
                </Link>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <button @click="switchTheme" class="text-gray-400 hover:text-white">
                    <i class="fas fa-moon"></i> <!-- ícone para alternar tema -->
                </button>
            </div>
        </div>

        <!-- Itens do menu com fechamento ao clicar -->
        <Link href="#" @click="closeMenu" class="block text-gray-400 hover:text-white py-2">Início</Link>
        <Link href="#" @click="closeMenu" class="block text-gray-400 hover:text-white py-2">Cursos</Link>
        <Link href="#" @click="closeMenu" class="block text-gray-400 hover:text-white py-2">Sobre</Link>
        <Link href="#" @click="closeMenu" class="block text-gray-400 hover:text-white py-2">Contato</Link>
    </div>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
