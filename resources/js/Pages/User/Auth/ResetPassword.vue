<script setup>
import { Head, useForm } from "@inertiajs/vue3";
// Layouts
import GuestLayout from "@/Layouts/GuestLayout.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("user.password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <h2 class="text-center dark:text-white my-4">Reset Password</h2>
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
            buttonActionType="submit"
            buttonType="primary"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Reset Password
          </PrimaryButton>
        </FormGroup>
      </div>
    </form>
  </GuestLayout>
</template>
