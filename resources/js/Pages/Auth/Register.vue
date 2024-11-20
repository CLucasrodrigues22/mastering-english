<script setup>

import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/Button.vue";
import {useForm} from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import FormOneCol from "../../Components/FormAuth.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title=" - Register" />
    <Container class="w-4/4 md:w-2/4">
        <div class="mb-8 text-center">
            <Title>
                Register a new account
            </Title>
            <p>
                Already have an account?
                <TextLink routeName="login" label="Login" />
            </p>
        </div>

        <!-- Errors messages -->
        <ErrorMessages :errors="form.errors"/>

        <FormOneCol
            @submit.prevent="submit"
        >
            <InputField
                label="Name"
                icon="id-badge"
                v-model="form.name"
                :required="false"
            />

            <InputField
                label="Email"
                icon="at"
                v-model="form.email"
                :required="false"
            />

            <InputField
                label="Password"
                type="password"
                icon="key"
                v-model="form.password"
                :required="false"
            />

            <InputField
                label="Confirm Password"
                type="password"
                icon="key"
                v-model="form.password_confirmation"
                :required="false"
            />

            <p class="text-slate-500 text-sm dark:text-slate-400">
                By creating an account, you agree to our Terms of Service and
                Privacy Policy.
            </p>

            <PrimaryBtn :disabled="form.processing">Register</PrimaryBtn>
        </FormOneCol>
    </Container>
</template>
