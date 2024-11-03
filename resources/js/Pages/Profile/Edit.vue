<script setup>
import UpdateInfo from "./Sections/UpdateInfo.vue";

defineProps({
    user: Object,
    status: String,
    message: String,
})
</script>

<template>
    <Head title=" - Profile" />
  <UpdateInfo :user="user" :status="status" :message="message" />
</template>
