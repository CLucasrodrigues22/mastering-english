<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/PrimaryBtn.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
    status: String,
    message: String,
});

const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
});

const resendEmail = (e) => {
    router.post(
        route("verification.send"),
        {},
        {
            onStart: () => (e.target.disabled = true),
            onFinish: () => (e.target.disabled = false),
        }
    );
};
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form
            @submit.prevent="form.patch(route('profile.update.info'))"
            class="space-y-6"
        >
            <InputField
                label="Name"
                icon="id-badge"
                class="w-1/2"
                v-model="form.name"
            />

            <InputField
                label="Email"
                icon="at"
                class="w-1/2"
                v-model="form.email"
            />
            <SessionMessages :message="message" />
            <div v-if="user.email_verified_at === null">
                <SessionMessages :status="status" />

                <p class="text-red-600">
                    Your email address is unverified.
                    <button
                        @click="resendEmail"
                        class="text-indigo-500 font-medium underline dark:text-indigo-400 disabled:text-slate-400 disabled:cursor-wait"
                    >
                        Click here to send the verification email.
                    </button>
                </p>
            </div>
            <div v-else>
                <p class="text-green-600">
                    You e-mail is verified.
                </p>
            </div>

            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
