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

// Estado do dropdown de perfil
const showProfileDropdown = ref(false);

// Alternância do menu para telas pequenas
const toggleMenu = () => {
    show.value = !show.value;
};

// Função para fechar o menu quando um item for clicado
const closeMenu = () => {
    show.value = false;
};

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value;
};

// Função para exibir dropdown de perfil
const closeProfileDropdown = () => {
    showProfileDropdown.value = false;
};

</script>

<template>
    <!-- Overlay para fechar o menu quando clicado fora -->
    <div
        v-show="show || showProfileDropdown"
        @click="show = false; closeProfileDropdown()"
        class="fixed inset-0 bg-opacity-50 z-40">
    </div>

    <header class="bg-slate-800 text-white fixed top-0 left-0 w-full z-50 shadow-lg">
        <nav class="p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center md:px-6">
                <!-- Logo -->
                <Logo routeName="home" componentName="Home">Mastering English</Logo>

                <!-- Menu para telas maiores -->
                <div class="hidden md:flex space-x-6">
                    <Link href="#" class="text-gray-200 hover:text-white">Início</Link>
                    <Link href="#" class="text-gray-200 hover:text-white">Cursos</Link>
                    <Link href="#" class="text-gray-200 hover:text-white">Sobre</Link>
                    <Link href="#" class="text-gray-200 hover:text-white">Contato</Link>
                </div>

                <!-- Botão de perfil e alternar tema -->
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Dropdown de perfil -->
                    <div v-if="user" class="relative">
                        <button
                            @click="toggleProfileDropdown"
                            class="text-gray-200 hover:text-white flex items-center">
                            Olá, {{user.name.substring(0, 7)}} ...
                            <i :class="showProfileDropdown ? 'fa-solid fa-arrow-down' : 'fa-solid fa-arrow-right'" class="ml-2"></i>
                        </button>
                        <div
                            v-show="showProfileDropdown"
                            @click.outside="closeProfileDropdown"
                            class="absolute right-0 mt-8 w-48 bg-slate-700 dark:bg-slate-900 text-white rounded-md shadow-lg z-50">
                            <Link
                                v-if="user.role === 'admin'"
                                :href="route('admin.index')"
                                class="block px-4 py-2 rounded-md text-gray-200 hover:text-white mt-1"
                            >
                                Administrativo
                            </Link>
                            <Link
                                :href="route('profile.edit')"
                                class="block px-4 py-2 rounded-md text-gray-200 hover:text-white"
                            >
                                Meu Perfil
                            </Link>
                            <Link
                                :href="route('dashboard')"
                                class="block px-4 py-2 rounded-md text-gray-200 hover:text-white"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="block px-4 py-2 rounded-md text-gray-200 hover:text-white mb-1"
                            >
                                Encerrar Sessão
                            </Link>
                        </div>
                    </div>

                    <!-- Links para visitantes -->
                    <div v-else class="space-x-2">
                        <Link :href="route('login')" class="text-gray-200 hover:text-white bg-slate-600 p-1 rounded-lg">Entrar</Link>
                        <Link :href="route('register')" class="text-gray-200 hover:text-white bg-slate-600 p-1 rounded-lg">Registrar-se</Link>
                    </div>
                    <button @click="switchTheme" class="text-gray-200 hover:text-white">
                        <i class="fas fa-moon"></i> <!-- Ícone para alternar tema -->
                    </button>
                </div>

                <!-- Menu para telas pequenas -->
                <div class="md:hidden flex items-center mr-4">
                    <button @click="toggleMenu" class="text-gray-200 hover:text-white">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Menu dropdown (para telas pequenas) -->
    <div v-show="show" @click="closeMenu" class="fixed top-0 left-0 right-0 bg-gray-700 text-white z-50 py-[1.1rem] px-[2rem]">
        <!-- Botão de perfil com destaque -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div v-if="user" class="flex items-center">
                <Link :href="route('profile.edit')" class="block text-gray-200 py-2">
                    Olá, <strong>{{user.name.substring(0, 7)}} ...</strong><i class="fa-solid fa-arrow-right ml-2"></i>
                </Link>
            </div>
            <div v-else class="flex items-center space-x-4">
                <Link :href="route('login')" class="text-gray-200 hover:text-white bg-slate-600 p-1 rounded-lg">Entrar</Link>
                <Link :href="route('register')" class="text-gray-200 hover:text-white bg-slate-600 p-1 rounded-lg">Registrar</Link>
            </div>
            <div class="flex items-center justify-end space-x-6">
                <button @click="switchTheme" class="text-gray-200 hover:text-white">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="text-gray-200 hover:text-white">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 lg:gap-32 justify-center">
            <div class="mr-12 text-left">
                <h2 class="font-bold mb-2 uppercase">Menu</h2>
                <!-- Itens do menu institucional -->
                <Link :href="route('home')" class="block text-gray-200 hover:text-white py-2">Início</Link>
                <Link href="#" class="block text-gray-200 hover:text-white py-2">Cursos</Link>
                <Link href="#" class="block text-gray-200 hover:text-white py-2">Sobre</Link>
                <Link href="#" class="block text-gray-200 hover:text-white py-2">Contato</Link>
            </div>
            <div v-if="user">
                <h2 class="font-bold mb-2 uppercase">Conteúdo</h2>
                <!-- Itens do menu de conteudo -->
                <Link :href="route('listing.create')" class="block text-gray-200 hover:text-white py-2">Cursos</Link>
                <Link href="#" class="block text-gray-200 hover:text-white py-2">Sobre</Link>
                <Link href="#" class="block text-gray-200 hover:text-white py-2">Contato</Link>
            </div>
            <div class="ml-4" v-if="user">
                <h2 class="font-bold mb-2 uppercase">Usuário</h2>
                <!-- Itens do menu de sessão -->
                <Link
                    v-if="user.role === 'admin'"
                    :href="route('admin.index')"
                    class="block text-gray-200 hover:text-white py-2"
                >
                    Controle
                </Link>
                <Link
                    :href="route('profile.edit')"
                    class="block text-gray-200 hover:text-white py-2"
                >
                    Meu Perfil
                </Link>
                <Link
                    :href="route('dashboard')"
                    class="block text-gray-200 hover:text-white py-2"
                >
                    Painel
                </Link>
            </div>
        </div>
        <div class="flex items-center space-x-4" v-if="user">
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="text-gray-200 hover:text-white bg-slate-600 p-1 rounded-lg w-full text-center"
            >
                Encerrar Sessão <i class="fa-solid fa-right-from-bracket"></i>
            </Link>
        </div>
    </div>

    <main class="p-6 mx-auto max-w-screen-lg min-h-screen mt-16">
        <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Esquerda -->
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">&copy; 2024 Mastering English. Todos os direitos reservados.</p>
                </div>
                <!-- Direita -->
                <div class="space-x-4">
                    <Link href="#" class="text-gray-400 hover:text-white text-sm">Política de Privacidade</Link>
                    <Link href="#" class="text-gray-400 hover:text-white text-sm">Termos de Uso</Link>
                    <Link href="#" class="text-gray-400 hover:text-white text-sm">Contato</Link>
                </div>
            </div>
        </div>
    </footer>
</template>

