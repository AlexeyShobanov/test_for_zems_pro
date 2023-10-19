<template>
  <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "item-button"
}
</script>

<style scoped>

</style>