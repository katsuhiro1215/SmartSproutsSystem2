<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
// Layouts
import AdminLayout from "@/Layouts/AdminLayout.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const form = useForm({
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("admin.register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <AdminLayout>
    <Head title="Register" />

    <h2 class="text-center dark:text-white my-4">Register</h2>
    <form @submit.prevent="submit">
      <div class="space-y-4">
        <FormGroup>
          <InputLabel for="username" value="Username" required />
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
        </FormGroup>
        <FormGroup>
          <InputLabel for="email" value="Email" required />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </FormGroup>
        <FormGroup>
          <InputLabel for="password" value="Password" required />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </FormGroup>
        <FormGroup>
          <InputLabel
            for="password_confirmation"
            value="Confirm Password"
            required
          />
          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
          <InputError
            class="mt-2"
            :message="form.errors.password_confirmation"
          />
        </FormGroup>
        <FormGroup>
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Register
          </PrimaryButton>
        </FormGroup>
        <div class="flex items-center justify-end mt-4">
          <Link
            :href="route('admin.login')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-white dark:focus:ring-offset-gray-800"
          >
            Already registered?
          </Link>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
