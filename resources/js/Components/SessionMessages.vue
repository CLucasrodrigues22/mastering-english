<script setup>
defineProps({
    status: String,
    message: String,
});
</script>

<template>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-500">
        {{ status }}
    </div>
    <div v-if="message" class="mb-4 font-medium text-sm text-green-500">
        {{ message }}
    </div>
</template>
