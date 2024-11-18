<script setup>
import { router } from "@inertiajs/vue3";
import Container from "../../Components/Container.vue";

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
});

const deleteListing = () => {
    if (confirm("Are you sure?")) {
        router.delete(route("listing.destroy", props.listing.id));
    }
};

const toggleApprove = () => {
    let msg = props.listing.approved
        ? "Disapprove this listing?"
        : "Approve this listing?";

    if (confirm(msg)) {
        router.put(route("admin.approve", props.listing.id));
    }
};
</script>

<template>
    <Head title="- Listing Detail"/>

    <!-- Admin -->
    <div
        v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'"
        class="bg-slate-800 text-white mb-6 p-6 rounded-md font-medium flex items-center justify-between"
    >
        <p>
            This listing is {{ listing.approved ? "Approved" : "Disapproved" }}.
        </p>
        <button @click.prevent="toggleApprove" class="bg-slate-600 px-3 py-1 rounded-md">
            {{ listing.approved ? 'Disapprove it' : 'Approve it' }}
        </button>
    </div>

    <Container class="md:flex md:gap-4 text-center md:text-left">
        <div class="md:w-1/4 rounded-md overflow-hidden">
            <img
                :src="
                    listing.image
                        ? `/storage/${listing.image}`
                        : '/assets/images/defaults/listing-default.jpg'
                "
                class="w-full h-full object-cover object-center"
                alt=""
            />
        </div>

        <div class="md:w-3/4">
            <!-- Listing info -->
            <div class="mb-6">
                <div class="md:flex md:items-end md:justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Listing detail</p>

                    <!-- Edit and delete buttons desktop-->
                    <div v-if="canModify" class="pl-4 md:flex items-center gap-4 hidden">
                        <Link
                            :href="route('listing.edit', listing.id)"
                            class="bg-blue-500 rounded-md text-white px-6 py-2 hover:outline outline-blue-500 outline-offset-2"
                        >
                            Edit
                        </Link>
                        <button
                            @click="deleteListing"
                            class="bg-red-500 rounded-md text-white px-6 py-2 hover:outline outline-red-500 outline-offset-2"
                            type="button"
                        >
                            Delete
                        </button>
                    </div>
                    <!-- Edit and delete buttons small devices -->
                    <div v-if="canModify" class="grid grid-cols-1 space-y-2 mt-4 md:hidden">
                        <div class="w-full bg-blue-500 rounded-md">
                            <Link
                                :href="route('listing.edit', listing.id)"
                                class="text-white"
                            >
                                Edit
                            </Link>
                        </div>
                        <div class="w-full bg-red-500 rounded-md">
                            <button
                                @click="deleteListing"
                                class="text-white"
                                type="button"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <h3 class="font-bold text-2xl mb-4">{{ listing.title }}</h3>
                <p>{{ listing.desc }}</p>
            </div>

            <!-- Contact info -->
            <div class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Contact info</p>

                <!-- Email -->
                <div v-if="listing.email" class="md:flex items-center mb-2 gap-2 hidden">
                    <i class="fa-solid fa-at"></i>
                    <p>Email:</p>
                    <a :href="`mailto:${listing.email}`" class="text-link">
                        {{ listing.email }}
                    </a>
                </div>

                <!-- Link -->
                <div v-if="listing.link" class="md:flex items-center mb-2 gap-2 hidden">
                    <i class="fa-solid fa-up-right-from-square"></i>
                    <p>External Link:</p>
                    <a :href="listing.link" target="_blank" class="text-link">
                        {{ listing.link }}
                    </a>
                </div>

                <!-- User -->
                <div class="md:flex items-center mb-2 gap-2 hidden">
                    <i class="fa-solid fa-user"></i>
                    <p>Listed by:</p>
                    <Link
                        :href="route('home', { user_id: user.id })"
                        class="text-link"
                    >
                        {{ user.name }}
                    </Link>
                </div>

                <!-- Contact small device -->
                <div class="grid grid-cols-3 text-center md:hidden">
                    <div>
                        <a :href="`mailto:${listing.email}`" class="text-link">
                            <i class="fa-solid fa-at mt-2"></i>
                        </a>
                    </div>
                    <div>
                        <a :href="listing.link" target="_blank" class="text-link">
                            <i class="fa-solid fa-up-right-from-square mt-2"></i>
                        </a>
                    </div>
                    <div>
                        <Link
                            :href="route('home', { user_id: user.id })"
                            class="text-link"
                        >
                            <i class="fa-solid fa-user mt-2"></i>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div v-if="listing.tags" class="md:mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Tags</p>

                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link
                            :href="route('home', { tag })"
                            class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900"
                        >
                            {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>
