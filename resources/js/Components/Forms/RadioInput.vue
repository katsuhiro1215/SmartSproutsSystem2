<script setup>
const modelValue = defineModel({
  type: String,
  required: true,
});

const emit = defineEmits(['update:modelValue']);

defineProps({
  name: String,
  options: Array,
});
</script>

<template>
  <div class="flex items-center h-9">
    <div
      v-for="(option, index) in options"
      :key="index"
      class="flex items-center gap-2"
    >
      <input
        type="radio"
        class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 font-normal"
        :name="name"
        :value="option.value"
        :checked="option.value === modelValue"
        @change="emit('update:modelValue', $event.target.value)"
      />
      <label :for="option.label" class="mr-4">{{ option.label }}</label>
    </div>
  </div>
</template>