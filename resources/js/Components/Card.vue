<script setup>
import { router } from "@inertiajs/vue3";
import {ref} from "vue";

const params = route().params;

defineProps({
    listing: Object,
});

// Mantenha um array de tags selecionadas
const selectedTags = ref(params.tag ? params.tag.split(',') : []);

const selectUser = (id) => {
    router.get(route('home'), {
        user_id: id,
        search: params.search,
        tag: selectedTags.value.join(','),
    });
};

const selectTag = (tag) => {
    // Verifique se a tag já está na lista
    if (selectedTags.value.includes(tag)) {
        // Se já estiver selecionada, remova
        selectedTags.value = selectedTags.value.filter((t) => t !== tag);
    } else {
        // Caso contrário, adicione à lista
        selectedTags.value.push(tag);
    }

    // Atualize os parâmetros da rota com as tags selecionadas
    router.get(route('home'), {
        user_id: params.user_id,
        search: params.search,
        tag: selectedTags.value.join(','),
    });
};
</script>

<template>
    <div
        class="bg-white rounded-lg shadow-lg overflow-hidden dark:bg-slate-800 flex flex-col justify-between h-full sm:max-w-md sm:mx-auto"
    >
        <div>
            <!-- Imagem -->
            <Link :href="route('listing.show', listing.id)">
                <img
                    :src="
                        listing.image
                            ? `/storage/${listing.image}`
                            : 'assets/images/defaults/listing-default.jpg'
                    "
                    class="w-full h-48 object-cover object-center bg-slate-300 sm:h-40"
                    alt=""
                />
            </Link>

            <!-- Título e usuário -->
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2 sm:text-base">
                    {{ listing.title.substring(0, 30) }}...
                </h3>
                <p class="text-sm">
                    Listed on
                    {{ new Date(listing.created_at).toLocaleDateString() }} by
                    <button
                        @click="selectUser(listing.user.id)"
                        class="text-link"
                    >
                        {{ listing.user.name }}
                    </button>
                </p>
            </div>
        </div>

        <!-- Tags -->
        <div v-if="listing.tags" class="flex flex-wrap gap-2 px-4 pb-4">
            <div
                v-for="tag in listing.tags.split(',')"
                :key="tag"
                class="text-xs"
            >
                <button
                    @click="selectTag(tag)"
                    :class="{
                        'bg-slate-700 dark:bg-slate-900': selectedTags.includes(tag),
                        'bg-slate-500': !selectedTags.includes(tag),
                    }"
                    class="text-white px-2 py-1 rounded-full hover:bg-slate-700 dark:hover:bg-slate-900"
                >
                    {{ tag }}
                </button>
            </div>
        </div>
    </div>
</template>
