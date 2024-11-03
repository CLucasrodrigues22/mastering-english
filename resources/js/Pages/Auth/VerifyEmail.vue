<script setup>

import Container from "../../Components/Container.vue";
import PrimaryBtn from "../../Components/Button.vue";
import {useForm} from "@inertiajs/vue3";
import SessionMessages from "../../Components/SessionMessages.vue";

const form = useForm({})

defineProps({
    user: Object,
    status: String,
})

const submit = () => {
    form.post(route('verification.send'))
}
</script>

<template>
    <Head title="- E-mail Verification"/>
    <Container class="w-1/2">
        <div v-if="user.email_verified_at === null">
            <div class="mb-8">
                <p>
                    Thanks for signing up! Before getting started, could you verify
                    your email address by clicking on the link we just emailed to
                    you? If you didn't receive the email, we will gladly send you
                    another.
                </p>
            </div>

            <SessionMessages :status="status" />

            <form
                @submit.prevent="submit"
            >
                <PrimaryBtn :desabled="form.precessing">Resend Verification E-mail</PrimaryBtn>
            </form>
        </div>

        <div v-else>
            <div class="mb-8">
                <p>
                    Your e-mail has already been successfully verified!<br/>
                    Click on the button below to be redirected to the Home.
                </p>
            </div>
            <Link
                :href="route('dashboard')"
                class="px-6 py-2 rounded-lg bg-blue-500 text-white disabled:bg-slate-300 disabled:cursor-wait"
            >
                Home
            </Link>
        </div>
    </Container>
</template>
