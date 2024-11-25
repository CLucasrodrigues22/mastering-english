<script setup>
import Card from "../Components/Card.vue";
import PaginationLink from "../Components/PaginationLink.vue";
import InputField from "../Components/InputField.vue";
import { router, useForm } from "@inertiajs/vue3";

let searchParams = new URLSearchParams(window.location.search);

const searchQuery = searchParams.get('search') || '';

const clearSearch = () => {
    searchParams = '';
}

const params = route().params;

const props = defineProps({
    listings: Object,
    searchTerm: String,
})

const username = params.user_id ? props.listings.data.find(i => i.user_id === Number(params.user_id)).user.name : null

const form = useForm({
    search: props.searchTerm
})

const search = () => {
    router.get(route('home'), {
        search: form.search,
        user_id: params.user_id,
        tag: params.tag,
    })
}

// Função para remover uma tag específica
const removeTag = (tag) => {
    const newTags = params.tag.split(',').filter(t => t !== tag);
    router.get(route('home'), {
        user_id: params.user_id,
        search: params.search,
        tag: newTags.join(','),
    });
}
</script>

<template>
    <Head title="- Latest Listings"/>

    <div class="hidden md:flex items-center justify-between mt-4 mb-4">
        <div class="flex items-center gap-2">
            <!-- Exibir links de tags se houver -->
            <span class="md:m-1">Tags:</span>
            <div v-if="params.tag" class="flex gap-2">
                <div v-for="tag in params.tag.split(',')" :key="tag">
                    <Link
                        class="px-2 py-1 rounded-md bg-blue-500 text-white flex items-center gap-2"
                        @click.prevent="removeTag(tag)"
                        :href="route('home', { ...params, tag: params.tag.split(',').filter(t => t !== tag).join(','), page: null })"
                    >
                        {{ tag }}
                        <i class="fa-solid fa-xmark"></i>
                    </Link>
                </div>
            </div>

            <span class="md:m-1 pl-2">Title:</span>
            <Link
                class="px-2 py-1 rounded-md bg-green-500 text-white flex items-center gap-2"
                v-if="params.search"
                :href="route('home', { ...params, search: null, page: null })"
            >
                {{ params.search.substring(0, 7) }}...
                <i class="fa-solid fa-xmark"></i>
            </Link>

            <!-- Exibir link de usuário -->
            <span class="md:m-1 pl-2">Author:</span>
            <Link
                class="px-2 py-1 rounded-md bg-red-500 text-white flex items-center gap-2"
                v-if="params.user_id"
                :href="route('home', { ...params, user_id: null, page: null })"
            >
                {{ username.substring(0, 7) }}...
                <i class="fa-solid fa-xmark"></i>
            </Link>
        </div>

        <div class="w-1/4">
            <form @submit.prevent="search">
                <InputField
                    type="search"
                    label=""
                    icon="magnifying-glass"
                    placeholder="Search..."
                    v-model="form.search"
                />
            </form>
            <p class="text-sm" v-if="searchQuery">
                Você pesquisou por: <strong>{{searchQuery.substring(0, 12)}}...</strong>
            </p>
        </div>
    </div>

    <div class="md:hidden mb-6">
        <div class="mx-auto w-4/4">
            <form @submit.prevent="search">
                <InputField
                    type="search"
                    label=""
                    icon="magnifying-glass"
                    placeholder="Search..."
                    v-model="form.search"
                    @change="clearSearch"
                />
            </form>
            <p class="block text-sm" v-if="searchQuery">
                Você pesquisou por: <strong>{{searchQuery.substring(0, 10)}}...</strong><Link :href="route('home', { ...params, search: null, page: null })"><i class="ml-1 fa-solid fa-xmark"></i></Link>
            </p>
        </div>

        <!-- Exibir links de tags e autores se houver -->
        <div class="mx-auto my-3 space-y-5 grid grid-cols-1">
            <div v-if="params.tag">
                <span class="md:m-1">Tags:</span>
                <div class="flex gap-2">
                    <div v-for="tag in params.tag.split(',')" :key="tag">
                        <Link
                            class="px-2 py-1 rounded-md bg-blue-500 text-white flex items-center gap-2 w-max"
                            @click.prevent="removeTag(tag)"
                            :href="route('home', { ...params, tag: params.tag.split(',').filter(t => t !== tag).join(','), page: null })"
                        >
                            {{ tag }}
                            <i class="fa-solid fa-xmark"></i>
                        </Link>
                    </div>
                </div>
            </div>

            <div v-if="params.user_id">
                <span class="md:m-1">Author:</span>
                <Link
                    class="px-2 py-1 rounded-md bg-red-500 text-white flex items-center gap-2 w-max"
                    :href="route('home', { ...params, user_id: null, page: null })"
                >
                    {{ username.substring(0, 10) }}...
                    <i class="fa-solid fa-xmark"></i>
                </Link>
            </div>
        </div>
    </div>

    <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing"/>
            </div>
        </div>

        <div class="mt-8">
            <PaginationLink :paginator="listings"/>
        </div>
    </div>

    <div v-else class="text-center font-bold text-xl">There are no listings</div>
</template>
