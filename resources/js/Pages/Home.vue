<script setup>
    import Card from "../Components/Card.vue";
    import PaginationLink from "../Components/PaginationLink.vue";

    defineProps({
        listings: Object
    })
</script>

<template>
    <Head title="- Latest Listings"/>

    <div v-if="Object.keys(listings).length">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing" />
            </div>
        </div>
        <div class="mt-8">
            <PaginationLink :paginator="listings" />
        </div>
    </div>
</template>
