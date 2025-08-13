<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();

const Logo = '/images/ProVetUpdated.png';
</script>

<template>
    <img :src="Logo">
</template>
