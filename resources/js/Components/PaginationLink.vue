<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    paginator: Object,
});

// Função para gerar links de paginação com base no paginator
const getPaginationLinks = () => {
    const totalPages = props.paginator.last_page;
    const currentPage = props.paginator.current_page;

    let links = [];

    // Mostrar apenas os links de "Anterior" e "Próximo" se for dispositivo pequeno
    if (window.innerWidth <= 768) {
        links.push({
            label: "Previous",
            url: props.paginator.prev_page_url,
            isCurrent: false
        });
        links.push({
            label: "Next",
            url: props.paginator.next_page_url,
            isCurrent: false
        });
    } else {
        // Mostrar todos os números de página, mas limitar a quantidade visível (por exemplo, 4 páginas)
        const maxVisiblePages = 4;
        let start = Math.max(1, currentPage - 2);
        let end = Math.min(totalPages, currentPage + 2);

        // Ajustar os limites de visualização se necessário
        if (end - start < maxVisiblePages) {
            if (start === 1) {
                end = Math.min(totalPages, start + maxVisiblePages - 1);
            } else {
                start = Math.max(1, end - maxVisiblePages + 1);
            }
        }

        // Adicionar os links de páginas
        for (let page = start; page <= end; page++) {
            links.push({
                label: String(page),
                url: `?page=${page}`,
                isCurrent: page === currentPage
            });
        }
    }

    return links;
};
</script>

<template>
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <!-- Exibe somente para dispositivos pequenos -->
        <div class="flex flex-1 justify-between sm:hidden">
            <a
                :href="paginator.prev_page_url"
                class="relative inline-flex items-center rounded-md bg-white dark:bg-slate-500 px-4 py-2 text-sm font-medium hover:bg-gray-50"
                :class="{ 'cursor-not-allowed opacity-50': !paginator.prev_page_url }"
            >
                Anterior
            </a>
            <a
                :href="paginator.next_page_url"
                class="relative ml-3 inline-flex items-center rounded-md bg-white dark:bg-slate-500 px-4 py-2 text-sm font-medium hover:bg-gray-50"
                :class="{ 'cursor-not-allowed opacity-50': !paginator.next_page_url }"
            >
                Próximo
            </a>
        </div>

        <!-- Exibe para dispositivos grandes -->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-slate-300">
                    Exibindo
                    <span class="font-medium">{{paginator.from}}</span>
                    para
                    <span class="font-medium">{{paginator.to}}</span>
                    de
                    <span class="font-medium">{{paginator.total}}</span>
                    resultados
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Botão "Anterior" -->
                    <a
                        :href="paginator.prev_page_url"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 bg-slate-200 text-slate-700 dark:bg-slate-500 dark:text-gray-100 ring-inset hover:bg-gray-50 hover:text-slate-500 focus:z-20 focus:outline-offset-0"
                        :class="{ 'cursor-not-allowed opacity-50': !paginator.prev_page_url }"
                    >
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </a>

                    <!-- Links das páginas -->
                    <a
                        v-for="(link, index) in getPaginationLinks()"
                        :key="index"
                        :href="link.url"
                        :aria-current="link.isCurrent ? 'page' : null"
                        :class="[
                            'relative inline-flex items-center px-4 py-2 text-sm font-semibold hover:bg-gray-50 hover:text-slate-500 focus:z-20 focus:outline-offset-0',
                            link.isCurrent ? 'bg-slate-200 text-slate-700 dark:bg-slate-500 dark:text-gray-100' : 'bg-white text-slate-500 dark:bg-slate-900 dark:text-slate-200'
                        ]"
                    >
                        {{ link.label }}
                    </a>

                    <!-- Botão "Próximo" -->
                    <a
                        :href="paginator.next_page_url"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 bg-slate-200 text-slate-700 dark:bg-slate-500 dark:text-gray-100 ring-inset hover:bg-gray-50 hover:text-slate-500 focus:z-20 focus:outline-offset-0"
                        :class="{ 'cursor-not-allowed opacity-50': !paginator.next_page_url }"
                    >
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>
