<script setup>
import { computed, ref, watch } from "vue";
import axios from "axios";
import CloudUpload from "vue-material-design-icons/CloudUpload.vue";

const props = defineProps({
  modelValue: File,
});

const emit = defineEmits(["update:modelValue"]);

const inputFile = ref(null);
const imageSrc = ref("");
const active = ref(false);
const dragCount = ref(0);

const imageStyle = computed(() => {
  return {
    backgroundImage: imageSrc.value ? `url(${imageSrc.value})` : "",
    backgroundColor: active.value ? "pink" : "",
    border: imageSrc.value ? "none" : "2px dashed #5a67d8",
    backgroundSize: "cover",
    backgroundPosition: "center",
    width: "100%",
    height: "100%",
    objectFit: imageSrc.value ? "cover" : "contain",
  };
});

const onDragEnter = (e) => {
  e.preventDefault();
  dragCount.value++;
  active.value = true;
};

const onDragLeave = (e) => {
  e.preventDefault();
  dragCount.value--;
  if (dragCount.value === 0) {
    active.value = false;
  }
};

const uploadImage = (e) => {
  const file = e.target.files[0] || e.dataTransfer.files[0];
  if (file) {
    imageSrc.value = URL.createObjectURL(file);
    emit("update:modelValue", file);
  }
};

const onDrop = (e) => {
  e.preventDefault();
  e.stopPropagation();
  inputFile.value.files = e.dataTransfer.files;
  uploadImage({ target: { files: e.dataTransfer.files } });
  active.value = false;
};

watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue) {
      imageSrc.value = URL.createObjectURL(newValue);
    }
  }
);
</script>

<template>
  <div class="w-full flex justify-center">
    <label
      for="input-file"
      id="drop-area"
      class="w-full h-80 p-8 text-center rounded-xl cursor-pointer"
      @dragenter="onDragEnter"
      @dragleave="onDragLeave"
      @dragover.prevent
      @drop="onDrop"
    >
      <input
        type="file"
        accept="image/*"
        id="input-file"
        @change="uploadImage"
        ref="inputFile"
        class="hidden"
      />
      <div
        :style="imageStyle"
        class="w-full h-full rounded-xl border-2 border-dashed border-indigo-500 bg-slate-50 hover:bbg-slate-100 transition object-contain object-center focus:bg-slate-800"
      >
        <CloudUpload
          v-if="!imageSrc"
          class="text-indigo-500 mt-8 inline-block"
          size="80"
        />
        <p v-if="!imageSrc" class="text-base text-slate-700 mt-2">
          Srag and drop or click here <br />
          to upload image
        </p>
        <span v-if="!imageSrc" class="block text-sm text-slate-600 mt-2">
          Upload any images from desktop
        </span>
      </div>
    </label>
  </div>
</template>
