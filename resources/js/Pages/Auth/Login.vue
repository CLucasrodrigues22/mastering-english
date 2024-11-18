<script setup>

import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import Button from "../../Components/Button.vue";
import {useForm} from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import CheckBox from "../../Components/CheckBox.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import FormOneCol from "../../Components/FormAuth.vue";

const form = useForm({
    email: "",
    password: "",
    remember: null,
})

defineProps({message: String})

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title=" - Login" />
    <Container class="w-4/4 md:w-2/4">
        <div class="mb-8 text-center">
            <Title>
                Login with a existent account
            </Title>
            <p>
                Haven't an account?
                <TextLink routeName="register" label="Register" />
            </p>
        </div>

        <!-- Errors messages -->
        <ErrorMessages :errors="form.errors"/>

        <SessionMessages :status="message" />

        <FormOneCol @submit.prevent="submit">

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

            <div class="flex items-center justify-between">
                <CheckBox name="remember" v-model="form.remember">Remember me</CheckBox>
                <TextLink routeName="password.request" label="Forgot Password?"/>
            </div>

            <Button :disabled="form.processing">Login</Button>
        </FormOneCol>
    </Container>
</template>
