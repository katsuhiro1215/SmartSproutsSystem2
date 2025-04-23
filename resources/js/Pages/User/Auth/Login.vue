<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
// Layouts
import GuestLayout from "@/Layouts/GuestLayout.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import InputError from "@/Components/Forms/InputError.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("user.login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <h2 class="text-center dark:text-white my-4">Login</h2>
    <form @submit.prevent="submit">
      <div class="space-y-4">
        <FormGroup>
          <InputLabel for="email" value="Email" required />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
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
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </FormGroup>
        <FormGroup>
          <label class="flex items-center">
            <Checkbox name="remember" v-model:checked="form.remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-white"
              >Remember me</span
            >
          </label>
        </FormGroup>
        <FormGroup>
          <PrimaryButton
            buttonActionType="submit"
            buttonType="primary"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Log in
          </PrimaryButton>
        </FormGroup>
        <div class="flex items-center justify-end mt-4">
          <Link
            v-if="canResetPassword"
            :href="route('user.password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-white dark:focus:ring-offset-gray-800"
          >
            Forgot your password?
          </Link>
        </div>
      </div>
    </form>
  </GuestLayout>
</template>
