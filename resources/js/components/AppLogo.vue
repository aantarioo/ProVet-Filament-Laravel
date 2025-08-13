<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Cat } from "lucide-vue-next"
</script>

<template>
    <div class="flex aspect-square size-10 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
        <Cat class="size-7" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">ProVet</span>
    </div>
</template>
