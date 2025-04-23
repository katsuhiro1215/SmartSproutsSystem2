<script setup>
import { Head, useForm } from "@inertiajs/vue3";
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
  password: "",
});

const submit = () => {
  form.post(route("admin.password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <AdminLayout>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      This is a secure area of the application. Please confirm your password
      before continuing.
    </div>

    <form @submit.prevent="submit">
      <div class="space-y-4">
        <FormGroup>
          <InputLabel for="password" value="Password" required />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
            autofocus
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </FormGroup>
        <FormGroup>
          <PrimaryButton
            buttonActionType="submit"
            buttonType="primary"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Confirm
          </PrimaryButton>
        </FormGroup>
      </div>
    </form>
  </AdminLayout>
</template>
