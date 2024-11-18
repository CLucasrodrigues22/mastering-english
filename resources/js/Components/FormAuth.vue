<script setup>
defineEmits(["submit"]);
</script>

<template>
    <form
        @submit.prevent="(event) => $emit('submit', event)"
        class="space-y-6"
    >
        <slot />
    </form>
</template>
