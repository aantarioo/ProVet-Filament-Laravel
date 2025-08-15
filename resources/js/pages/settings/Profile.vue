<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Avatar, AvatarImage } from '@/components/ui/avatar'

import { Toaster } from '@/components/ui/sonner'
import { toast } from "vue-sonner"
import 'vue-sonner/style.css'

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
    userAvatar: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
});

const formAvatar = useForm({
    avatar: user.avatar,

});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};

const submitAvatar = () => {
    formAvatar.post(route('profile.updateAvatar'), {
        preserveScroll: true,
        onSuccess: () => { toast.success('Success', {
            description: 'Avatar has been updated',
            richColors: true,
            position: 'top-right',
        }) },
        onError: () => { toast.error('Error', {
            description: formAvatar.errors.avatar,
            richColors: true,
            position: 'top-right',
        }) },
    })
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <Toaster />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Update your name and email address" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>


                </form>

                <form @submit.prevent="submitAvatar" class="space-y-6">
                    <div class="grid gap-2">
                        <div class="flex">
                        <Label for="avatar">Avatar</Label>
                        <p v-if="formAvatar.recentlySuccessful" class="ml-5 text-sm text-green-400 dark:text-green-300">
                            Avatar has been updated
                        </p>
                        <InputError class="ml-5"  :message="formAvatar.errors.avatar" />
                        </div>
                        <div class="flex">
                            <div class="w-full">
                        <Avatar class="mt-2 h-[150px] w-[150px]">
                            <AvatarImage :src="userAvatar && `/storage/${userAvatar}`" />
                        </Avatar>
                             </div>
<!--                        <img :src="user.avatar && `/storage/${user.avatar}`" class="h-[150px] rounded-full mt-2">-->
                            <div class="text-left">
                                <p>If you want to change the avatar for your account, you can do it here</p>
                                <p class="text-sm text-muted-foreground">Maximum file size: 4 MB</p>
                            </div>
                        </div>
                        <Input type="file" accept="image/png, image/jpeg, image/jpg" id="avatar" class="mt-2  w-full" @change="e => formAvatar.avatar = e.target.files[0]" required autocomplete="avatar"  />
                    </div>


                    <div class="flex items-center gap-4">
                        <Button
                            :disabled="formAvatar.processing"
                            type="submit">Update Avatar</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>


                </form>
            </div>

<!--            <DeleteUser />-->
        </SettingsLayout>
    </AppLayout>
</template>
