<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    phonenumber: '',
});

const props = defineProps({
    generatedLink: String,
})

const submit = () => {
    form.post(route('registerUser'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mt-4">
                <VuePhoneNumberInput v-model="form.phonenumber" />

                <InputLabel for="phonenumber" value="Phonenumber" />

                <TextInput
                    id="phonenumber"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phonenumber"
                    required
                />

                <InputError class="mt-2" :message="form.errors.phonenumber" />
            </div>

            <div class="mt-4 flex items-center justify-end">

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Generate Link
                </PrimaryButton>
            </div>
        </form>

        <div class="mt-4 text-sm text-gray-600">
            <a :href="generatedLink" target="_blank">{{ generatedLink }}</a>
        </div>
    </GuestLayout>
</template>
