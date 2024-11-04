<script setup>
defineProps({
    status: String,
    message: String,
    color_txt: {
        type: String,
        default: 'text-green-500',
    }
});
</script>

<template>
    <div v-if="status" :class="`mb-4 font-medium text-sm ${color_txt}`">
        {{ status }}
    </div>
    <div v-if="message" :class="`mb-4 font-medium text-sm ${color_txt}`">
        {{ message }}
    </div>
</template>
