<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import InputError from '@/components/InputError.vue';

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { Toaster } from '@/components/ui/sonner'
import { toast } from "vue-sonner"
import 'vue-sonner/style.css'

import type { DateValue } from '@internationalized/date';
import { DateFormatter, getLocalTimeZone } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next';

import { ref, watch } from 'vue';
import { cn } from '@/lib/utils';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';

import ContactInformation from '@/components/ContactInformation.vue';

const form = useForm({
    description: '',
    name_of_patient: '',
    date_of_appointment: '',
});

const submit = () => {
    form.post(route('appointments'), {
        onFinish: () => form.reset('description', 'name_of_patient', 'date_of_appointment'),
        onError: () => { toast.error('Error', {
            description: form.errors.limit,
            richColors: true,
            position: 'top-right',
        }) },
    });
};

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const value = ref<DateValue>();

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

    <Toaster />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div>
                    <div class="text-center p-3">
                        <h1 class="mb-2 text-3xl font-medium">Create Appointment</h1>
                        <p class="text-xl text-muted-foreground">Here you can create an appointment.</p>
                    </div>

                    <div class="p-3">
                        <Card class="w-full">
                            <form @submit.prevent="submit">
                            <CardHeader class="mb-2">
                                <CardTitle>Create appointment</CardTitle>
                                <CardDescription>Create your appointment in a few seconds.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                    <div class="grid w-full items-center gap-4">
                                        <div class="flex flex-col space-y-1.5">
                                            <Label for="description">Description</Label>
                                            <Textarea id="description" placeholder="Symptoms, weight, patient name, breed, age, please indicate previous visits or illnesses." v-model="form.description" required />
                                        </div>
                                        <div>
                                            <Label for="date_of_appointment" class="mb-1.5">Choose a free day</Label>
                                            <Popover id="date_of_appointment">
                                                <PopoverTrigger as-child>
                                                    <Button
                                                        variant="outline"
                                                        :class="
                                                            cn('w-[280px] justify-start text-left font-normal', !value && 'text-muted-foreground')
                                                        "
                                                    >
                                                        <CalendarIcon class="mr-2 h-4 w-4" />
                                                        {{ value ? df.format(value.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                                    </Button>
                                                </PopoverTrigger>
                                                <PopoverContent class="">
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
                                                    <SelectItem value="cat"> cat </SelectItem>
                                                    <SelectItem value="dog"> dog </SelectItem>
                                                    <SelectItem value="rabbit"> rabbit </SelectItem>
                                                    <SelectItem value="bird"> bird </SelectItem>
                                                    <SelectItem value="rodent"> rodent </SelectItem>
                                                    <SelectItem value="reptile"> reptile </SelectItem>
                                                </SelectContent>
                                            </Select>
                                            <InputError v-if="form.errors.limit" :message="form.errors.limit" />
                                        </div>
                                    </div>
                            </CardContent>
                            <CardFooter class="flex justify-end ">
                                <Button
                                    type="submit"
                                    class="mt-3"
                                >Create</Button>
                            </CardFooter>
                            </form>
                        </Card>
                        <p class="p-3 text-sm text-muted-foreground">Please bring your pet's passport and previous medical records to your appointment.</p>
                    </div>

                    <ContactInformation />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
