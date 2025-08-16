<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Separator } from '@/components/ui/separator';


const defaultValue = 'item-1';


const accordionItems = [
    {
        value: 'item-1',
        title: 'Preventive Care & Vaccination',
        content:
            'We make sure illnesses don’t catch your pet off guard. Regular check-ups, vaccinations, and consultations help maintain their health and prevent serious diseases.',
    },
    {
        value: 'item-2',
        title: 'Diagnostics & Treatment',
        content:
            'With modern equipment and the expertise of our veterinarians, we can quickly detect health issues and choose the most effective treatment. We handle both urgent cases and chronic conditions.',
    },
    {
        value: 'item-3',
        title: 'Surgery & Rehabilitation',
        content:
            'From minor procedures to complex surgeries, we ensure safety, minimal stress, and a smooth recovery for your pet under our attentive care.',
    },
];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

defineProps({ owners: Array })
</script>

<template>
    <Head title="About" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="relative overflow-hidden rounded-xl border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="p-3">
                        <h1 class="mb-6 text-3xl font-medium">ProVet</h1>
                        <p class="text-xl text-muted-foreground">
                            ProVet is a modern veterinary clinic where compassionate care meets the latest diagnostic and treatment technologies. We
                            understand that every pet is unique, so we tailor our approach to each patient. Our team of experienced veterinarians is
                            ready to help in any situation – from preventive check-ups and vaccinations to complex surgeries and rehabilitation. At
                            ProVet, we don’t just treat pets – we care about their quality of life.
                        </p>
                        <div class="mt-9 flex justify-between">
                            <Link :href="route('appointments')">
                            <Button variant="outline">Make an appointment</Button>
                            </Link>
                            <Button variant="link">Contact us</Button>
                        </div>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border-sidebar-border/70 dark:border-sidebar-border bg-card">
                    <div class="p-3">
                        <Accordion type="single" class="w-full" collapsible :default-value="defaultValue">
                            <AccordionItem v-for="item in accordionItems" :key="item.value" :value="item.value">
                                <AccordionTrigger>{{ item.title }}</AccordionTrigger>
                                <AccordionContent>
                                    {{ item.content }}
                                </AccordionContent>
                            </AccordionItem>
                        </Accordion>
                    </div>
                </div>
            </div>
            <Separator orientation="horizontal" />
            <div class="relative min-h-[100vh] flex-1 rounded-xl  border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <div class="p-3">
                     <img src="/images/ProVetUpdated.png" class="flex m-auto h-[200px] pointer-events-none">
                    </div>
                    <div class=" p-3">
                        <h1>© 2025 ProVet. All rights reserved.</h1>
                        <p class="text-muted-foreground">ProVet Veterinary Clinic, LLC</p>
                        <p class="text-muted-foreground">245 Market Street, San Francisco, CA 94105</p>
                        <p class="text-muted-foreground">+1 (415) 555-0134</p>
                        <p class="text-muted-foreground mt-3 mb-3">This website is for informational purposes only and does not constitute medical advice for your pet. All medical content is provided for general educational purposes and should not be used as a substitute for professional veterinary consultation, diagnosis, or treatment. Always seek the advice of a licensed veterinarian for any questions you may have regarding your pet’s health.</p>
                        <div class="flex justify-end">
                        <Link>
                           <Button variant="link">Privacy Policy</Button>
                        </Link>
                        <Link>
                           <Button variant="link">Terms of Service</Button>
                        </Link>
                        </div>
                    </div>
            </div>
        </div>
    </AppLayout>
</template>
