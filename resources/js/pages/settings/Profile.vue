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
    avatar: '',

});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};

const submitAvatar = () => {
    formAvatar.post(route('profile.updateAvatar'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

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
                        </div>
                        <Avatar class="mt-2 h-[150px] w-[150px]">
                            <AvatarImage :src="userAvatar && `/storage/${userAvatar}`" />
                        </Avatar>
<!--                        <img :src="user.avatar && `/storage/${user.avatar}`" class="h-[150px] rounded-full mt-2">-->
                        <Input type="file" id="avatar" class="mt-2 block w-full" @change="e => formAvatar.avatar = e.target.files[0]" required autocomplete="avatar"  />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>


                    <div class="flex items-center gap-4">
                        <Button :disabled="formAvatar.processing" type="submit">Save</Button>

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
