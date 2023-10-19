<template>
  <div>
    <div class="flex items-center justify-between">
      <label
          :for="id"
          class="block text-sm font-medium leading-6 text-gray-900"
      >
        {{ label }}
      </label>
    </div>
    <div>
      <input
          :id="id"
          :name="name"
          :type="type"
          :value="modelValue"
          @input="updateInput"
          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          :placeholder="placeholder"
          :autocomplete="autocomplete"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "form-input",
  props: {
    modelValue: [String, Number],
    type: {
      type: String,
      default: "text",
    },
    errors: Object,
    name: String,
    id: String,
    label: String,
    placeholder: String,
    autocomplete: String,
  },
  methods: {
    updateInput(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
}
</script>

<style scoped></style>