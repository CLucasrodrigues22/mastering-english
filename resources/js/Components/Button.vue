<script setup>

defineProps({
    color_btn: {
        type: String,
        default: "bg-blue-500",
    },
    color_text: {
        type: String,
        default: "text-white",
    },
});

</script>


<template>
    <button :class="`px-6 py-2 rounded-lg ${color_btn} ${color_text} disabled:bg-slate-300 disabled:cursor-wait w-full`">
        <slot/>
    </button>
</template>
