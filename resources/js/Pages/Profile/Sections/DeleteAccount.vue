<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/Button.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const showConfirmPassword = ref(false);

const props = defineProps({
    user: Object,
})

const form = useForm({
    id: props.user.id,
    password: "",
});

const submit = () => {
    form.delete(route("profile.destroy"), {
        onFinish: () => form.reset(),
        preserveScroll: true,
    });
};
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>
                Once your account is deleted, all of its resources data will be
                permanently deleted. This action cannot be undone.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <div v-if="showConfirmPassword">
            <form @submit.prevent="submit" class="flex items-end gap-4">
                <InputField
                    label="Confirm Password"
                    icon="key"
                    type="password"
                    class="w-1/2"
                    v-model="form.password"
                />

                <PrimaryBtn color_btn="bg-green-500" color_text="text-white" :disabled="form.processing">
                    Confirm
                </PrimaryBtn>

                <PrimaryBtn
                    @click="showConfirmPassword = false"
                    color_btn="bg-slate-500" color_text="text-white" :disabled="form.processing"
                >
                    Cancel
                </PrimaryBtn>
            </form>
        </div>

        <PrimaryBtn
            v-if="!showConfirmPassword"
            @click="showConfirmPassword = true"
            color_btn="bg-red-500" color_text="text-white" :disabled="form.processing"
        >
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
            Delete Account
        </PrimaryBtn>
    </Container>
</template>
