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
} from '@/components/ui/card'
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



// const form = useForm({
//    description: '',
//    name_of_patient: '',
//    date_of_appointment: '',
// });
//
// const submit = () => {
//     form.post(route('appointments'), {
//         onFinish: () => form.reset('description', 'name_of_patient', 'date_of_appointment')
//     });
// };


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Appointment',
        href: '/appointments',
    },
];

defineProps({ appointments: Array })
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
                    <div class="text-center mt-6">
                    <h1 class="mb-2 text-3xl font-medium">My Appointments</h1>
                        <p class="text-xl text-muted-foreground">
                            Here you can view your appointments.
                        </p>
                    </div>

                    <div class="mt-6">
                        <Card v-for="appointment in appointments" :key="appointment.id" class="mb-6">
                            <CardHeader>
                                <div class="flex justify-between">
                                    <CardTitle>Appointment with ID: {{appointment.id}}</CardTitle>
                                    <CardDescription v-if="appointment.status === 'pending'">Pending</CardDescription>
                                    <CardDescription v-else-if="appointment.status === 'confirmed'" class="text-sky-400">Confirmed</CardDescription>
                                    <CardDescription v-else-if="appointment.status === 'completed'" class="text-green-400">Completed</CardDescription>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div>
                                <p>
                                    Monitor the status of the appointment and wait for information to be provided to you.
                                </p>
                                <p class="text-muted-foreground">
                                    Appointments are checked within 24 hours.
                                </p>
                                </div>

                                <div class="mt-6">
                                    <h1>Information about the appointment:</h1>
                                    <div class="flex">
                                        <p class="text-sm text-muted-foreground">Description: </p>
                                        <p class="text-sm text-muted-foreground ml-0.5">{{appointment.description}}</p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm text-muted-foreground">Patient: </p>
                                        <p class="text-sm text-muted-foreground ml-0.5">{{appointment.name_of_patient}}</p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm text-muted-foreground">The day for which you are registered: </p>
                                        <p class="text-sm text-muted-foreground ml-0.5">{{appointment.date_of_appointment}}</p>
                                    </div>
                                </div>

                            </CardContent>
                            <CardFooter class="flex justify-between">
                                <div>
                                <div class="flex">
                                    <p class="text-sm text-muted-foreground">The appointment has been created: </p>
                                    <p class="text-sm text-muted-foreground ml-0.5">{{appointment.created_at_formatted}}</p>
                                </div>
                                <div class="flex">
                                    <p class="text-sm text-muted-foreground">The appointment has been updated: </p>
                                    <p class="text-sm text-muted-foreground ml-0.5">{{appointment.updated_at_formatted}}</p>
                                </div>
                                </div>
                                <div>
                                <Button
                                    variant="outline"
                                    class="mr-2"
                                >Edit</Button>
                                <Button
                                    variant="destructive"
                                >Cancel Appointment</Button>
                                </div>
                            </CardFooter>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
