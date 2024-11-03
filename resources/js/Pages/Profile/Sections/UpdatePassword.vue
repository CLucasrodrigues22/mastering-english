<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/Button.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import { useForm } from "@inertiajs/vue3";
import SessionMessages from "../../../Components/SessionMessages.vue";

const props = defineProps({
    user: Object,
    update_pwd_message: String,
});

const form = useForm({
    id: props.user.id,
    current_password: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put(route("profile.update.password"), {
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
        preserveScroll: true,
    });
};
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>Ensure your are using a long, random password to stay secure.</p>
        </div>

        <ErrorMessages :errors="form.errors" />
        <SessionMessages :message="update_pwd_message" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Current Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.current_password"
            />

            <InputField
                label="New Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.password"
            />

            <InputField
                label="Confirm New Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.password_confirmation"
            />

            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
