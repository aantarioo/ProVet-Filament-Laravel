<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import { Textarea } from "@/components/ui/textarea"
import InputError from '@/components/InputError.vue';

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"

import type { DateValue } from "@internationalized/date"
import {
    DateFormatter,

    getLocalTimeZone,
} from "@internationalized/date"
import { CalendarIcon } from "lucide-vue-next"

import { ref, watch } from "vue"
import { cn } from "@/lib/utils"
import { Calendar } from "@/components/ui/calendar"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"

const form = useForm({
   description: '',
   name_of_patient: '',
   date_of_appointment: '',
});

const submit = () => {
    form.post(route('appointments'), {
        onFinish: () => form.reset('description', 'name_of_patient', 'date_of_appointment')
    });
};

const df = new DateFormatter("en-US", {
    dateStyle: "long",
})

const value = ref<DateValue>()

watch(value, (newVal) => {
   form.date_of_appointment = newVal ? newVal.toString() : '';
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Appointment',
        href: '/appointments',
    },
];

</script>

<template>
    <Head title="Create Appointment" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
<!--            <div class="grid auto-rows-min gap-4 md:grid-cols-2">-->
<!--                <div class="relative aspect-video overflow-hidden rounded-xl border-sidebar-border/70 dark:border-sidebar-border">-->
<!--                    <div class="p-3">-->
<!--                        <h1 class="mb-6 text-3xl font-medium">ProVet</h1>-->
<!--                        <p class="text-xl text-muted-foreground">-->
<!--                            ProVet is a modern veterinary clinic where compassionate care meets the latest diagnostic and treatment technologies. We-->
<!--                            understand that every pet is unique, so we tailor our approach to each patient. Our team of experienced veterinarians is-->
<!--                            ready to help in any situation – from preventive check-ups and vaccinations to complex surgeries and rehabilitation. At-->
<!--                            ProVet, we don’t just treat pets – we care about their quality of life.-->
<!--                        </p>-->
<!--                        <div class="mt-9 flex justify-between">-->
<!--                            <Button variant="outline">Make an appointment</Button>-->
<!--                            <Button variant="link">Contact us</Button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="relative aspect-video overflow-hidden rounded-xl border-sidebar-border/70 dark:border-sidebar-border bg-neutral-900">-->
<!--                    <div class="p-3">-->
<!--                        <Accordion type="single" class="w-full" collapsible :default-value="defaultValue">-->
<!--                            <AccordionItem v-for="item in accordionItems" :key="item.value" :value="item.value">-->
<!--                                <AccordionTrigger>{{ item.title }}</AccordionTrigger>-->
<!--                                <AccordionContent>-->
<!--                                    {{ item.content }}-->
<!--                                </AccordionContent>-->
<!--                            </AccordionItem>-->
<!--                        </Accordion>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div class="relative min-h-[100vh] flex-1 rounded-xl  border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div>
                    <div class="text-center">
                    <h1 class="mb-6 text-3xl font-medium">Create Appointment</h1>
                        <p class="text-xl text-muted-foreground">
                            Here you can create an appointment.
                        </p>
                    </div>

                    <div class="mt-6">
                        <Card class="w-full">
                            <CardHeader>
                                <CardTitle>Create appointment</CardTitle>
                                <CardDescription>Create your appointment in a few seconds.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form @submit.prevent="submit">
                                    <div class="grid items-center w-full gap-4">
                                        <div class="flex flex-col space-y-1.5">
                                            <Label for="description" required>Describe your problem</Label>
                                            <Input id="description" placeholder="Type your problem." v-model="form.description" required />
<!--                                            <Textarea id="description" placeholder="Type your problem." v-model="form.description" required />-->
                                            <InputError :message="form.errors.description" />
                                        </div>
                                        <div>
                                            <Label for="date_of_appointment" class="mb-1.5">Choose a free day</Label>
                                            <Popover id="date_of_appointment">
                                                <PopoverTrigger as-child>
                                                    <Button
                                                        variant="outline"
                                                        :class="cn(
                                                        'w-[280px] justify-start text-left font-normal',
                                                        !value && 'text-muted-foreground',
                                                        )"
                                                    >
                                                        <CalendarIcon class="mr-2 h-4 w-4" />
                                                        {{ value ? df.format(value.toDate(getLocalTimeZone())) : "Pick a date" }}
                                                    </Button>
                                                </PopoverTrigger>
                                                <PopoverContent class="w-auto p-0">
                                                    <Calendar v-model="value" initial-focus />
                                                </PopoverContent>
                                            </Popover>
                                        </div>
                                        <div class="flex flex-col space-y-1.5">
                                            <Label for="name_of_pacient">Patient</Label>
                                            <Select v-model="form.name_of_patient" required>
                                                <SelectTrigger id="name_of_pacient">
                                                    <SelectValue placeholder="Select" />
                                                </SelectTrigger>
                                                <SelectContent position="popper">
                                                    <SelectItem value="cat">
                                                        cat
                                                    </SelectItem>
                                                    <SelectItem value="dog">
                                                        dog
                                                    </SelectItem>
                                                    <SelectItem value="rabbit">
                                                        rabbit
                                                    </SelectItem>
                                                    <SelectItem value="bird">
                                                        bird
                                                    </SelectItem>
                                                    <SelectItem value="rodent">
                                                        rodent
                                                    </SelectItem>
                                                    <SelectItem value="reptile">
                                                        reptile
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                            <InputError :message="form.errors.name_of_patient" />
                                            <Button type="submit" class="mt-3">Create</Button>
                                        </div>
                                    </div>
                                </form>
                            </CardContent>
<!--                            <CardFooter class="flex justify-end px-6 pb-6">-->
<!--                                <Button type="submit">Create</Button>-->
<!--                            </CardFooter>-->
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
