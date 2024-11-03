<script setup>
import UpdateInfo from "./Sections/UpdateInfo.vue";
import UpdatePassword from "./Sections/UpdatePassword.vue";
import DeleteAccount from "./Sections/DeleteAccount.vue";

defineProps({
    user: Object,
    status: String,
    update_info_message: String,
    update_pwd_message: String,
})
</script>

<template>
    <Head title=" - Profile" />
    <UpdateInfo :user="user" :status="status" :update_info_message="update_info_message" />
    <UpdatePassword :user="user" :update_pwd_message="update_pwd_message" />
    <DeleteAccount :user="user" />
</template>
