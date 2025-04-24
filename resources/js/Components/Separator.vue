<script setup>
import {computed} from 'vue';

const props = defineProps({
  orientation: {
    type: String,
    default: 'horizontal',
    validator: value => ['horizontal', 'vertical'].includes(value)
  }
});

const separatorClass = computed(() => {
  if(props.orientation === 'vertical') {
    return 'shrink-0 bg-red-300 h-full w-[1px]';
  } else {
    return 'shrink-0 bg-red-300 h-[1px] w-full my-4'
  }
})

</script>

<template>
  <div :data-orientation="props.orientation" :class="separatorClass"></div>
</template>