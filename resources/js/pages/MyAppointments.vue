<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'

import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

import { Check, Clock, Speech } from "lucide-vue-next"

defineProps({ appointments: Array })

const form = useForm({
    description: '',
    name_of_patient: '',
});

const editAppointment = (id: number) => {
    form.put(route('myappointments.update', id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onFinish: () => form.reset(),
    });
};
const deleteAppointment = (id: number) => {
    form.delete(route('myappointments.destroy', id), {
        preserveScroll: true,
    });
};

const accordionItems = [
    {
        value: 'item-1',
        title: 'How can I change the date or time of my appointment?',
        content:
            'Click the "Edit" button next to your appointment and confirm the changes.',
    },
    {
        value: 'item-2',
        title: 'What if I’m running late?',
        content:
            'Let us know by phone or messenger — we’ll do our best to move you to the nearest available time.',
    },
    {
        value: 'item-3',
        title: 'What documents or information do I need for the appointment?',
        content:
            'Bring the owner’s ID and, if necessary, the pet’s medical record.',
    },
    {
        value: 'item-4',
        title: 'How should I prepare my animal for the check-up?',
        content:
            'Place your animal in a suitable carrier or container, ensuring proper ventilation and a comfortable temperature.',
    },
    {
        value: 'item-5',
        title: 'Can I cancel my appointment?',
        content:
            'Yes, click "Cancel Appointment" and confirm the action.',
    },
];

const defaultValue = 'item-1';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Appointments',
        href: '/myappointments',
    },
];

</script>

<template>
    <Head title="My Appointments" />

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
                        <div v-if="appointments?.length === 0" class="text-center mb-20">
                            <h1 class="mb-2">To view your own appointments. You need to create it</h1>
                            <Link :href="route('appointments')">
                                <Button variant="default">Make new appointment</Button>
                            </Link>
                        </div>
                        <Card v-for="appointment in appointments" :key="appointment.id" class="mb-6">
                            <CardHeader>
                                <div class="flex justify-between">
                                    <CardTitle>Appointment with ID: {{appointment.id}}</CardTitle>
                                    <CardDescription v-if="appointment.status === 'pending'" class="text-xl"><Clock /></CardDescription>
                                    <CardDescription v-else-if="appointment.status === 'confirmed'" class="text-sky-400 text-xl"><Speech /></CardDescription>
                                    <CardDescription v-else-if="appointment.status === 'completed'" class="text-green-400 text-xl"><Check /></CardDescription>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div v-if="appointment.status === 'pending'">
                                <p>
                                    Monitor the status of the appointment and wait for information to be provided to you.
                                </p>
                                <p class="text-muted-foreground">
                                    Appointments are checked within 24 hours.
                                </p>
                                <p class="text-sm text-muted-foreground">
                                    The appointment can be edited only if its current status is pending.
                                </p>
                                </div>

                                <div v-if="appointment.status === 'confirmed'">
                                    <p class="text-sky-400 text-xl">
                                        Your appointment is confirmed.
                                    </p>
                                    <p class="text-sky-400 text-sm">
                                        We are ready to help you. Visit our clinic.
                                    </p>
                                </div>

                                <div v-if="appointment.status === 'completed'">
                                    <p class="text-green-400 text-xl mb-2">
                                        Your appointment is completed.
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
                                <div class="flex">
                                    <Link :href="route('appointments')">
                                        <Button  v-if="appointment.status === 'completed'" variant="outline" class="mr-2">Make new appointment</Button>
                                    </Link>
                                    <Dialog>
                                        <DialogTrigger as-child>
                                            <Button v-if="appointment.status === 'pending'" variant="outline" class="mr-2">Edit</Button>
                                        </DialogTrigger>
                                        <DialogContent>
                                            <form class="space-y-6" @submit.prevent="() => editAppointment(appointment.id)">
                                                <DialogHeader class="space-y-3">
                                                    <DialogTitle>Edit Appointment</DialogTitle>
                                                    <DialogDescription>
                                                        If you want to change something, do it here
                                                        <div class="mt-4">
                                                            <Label for="description" class="mb-1">Description</Label>
                                                            <Textarea id="description" v-model="form.description" :model-value="appointment.description" />
                                                        </div>
                                                        <div class="mt-4">
                                                            <Label for="name_of_pacient" class="mb-1">Patient</Label>
                                                            <Select v-model="form.name_of_patient" required>
                                                                <SelectTrigger id="name_of_pacient">
                                                                    <SelectValue :placeholder="appointment.name_of_patient" />
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
                                                        </div>
                                                    </DialogDescription>
                                                </DialogHeader>

                                                <DialogFooter class="gap-2">
                                                    <DialogClose as-child>
                                                        <Button variant="secondary"> Cancel </Button>
                                                    </DialogClose>
                                                        <Button type="submit" variant="default" :disabled="form.processing"> Confirm </Button>
                                                </DialogFooter>
                                            </form>
                                        </DialogContent>
                                    </Dialog>
                                    <Dialog>
                                        <DialogTrigger as-child>
                                            <Button variant="destructive">Cancel Appointment</Button>
                                        </DialogTrigger>
                                        <DialogContent>
                                            <form class="space-y-6" @submit.prevent="() => deleteAppointment(appointment.id)">
                                                <DialogHeader class="space-y-3">
                                                    <DialogTitle>Are you sure you want to delete your appointment?</DialogTitle>
                                                    <DialogDescription>
                                                        Deleting this appointment will permanently remove all associated details. This action cannot be undone. Please confirm your decision to proceed.
                                                    </DialogDescription>
                                                </DialogHeader>

                                                <DialogFooter class="gap-2">
                                                    <DialogClose as-child>
                                                        <Button variant="secondary" @click="closeModal"> Cancel </Button>
                                                    </DialogClose>

                                                    <Button type="submit" variant="destructive" :disabled="form.processing"> Cancel Appointment </Button>
                                                </DialogFooter>
                                            </form>
                                        </DialogContent>
                                    </Dialog>
                                </div>
                            </CardFooter>
                        </Card>
                    </div>
                    <div class="mt-6">
                        <Accordion type="single" class="text-center ml-2" collapsible :default-value="defaultValue">
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
        </div>
    </AppLayout>
</template>
