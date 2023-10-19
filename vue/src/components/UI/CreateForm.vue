<template>
  <div class="dialog" v-if="show" @click="hideForms">
    <div @click.stop class="space-y-12 m-auto">
      <div class="dialog__content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "create_form",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    hideForms() {
      this.$emit("update:show", false);
    },
  },
};
</script>

<style scoped>
.dialog {
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  background: rgb(0, 0, 0, 0.5);
  position: fixed;
  display: flex;
}

.dialog__content {
  margin: auto;
  background: white;
  border-radius: 12px;
  min-height: 50px;
  min-width: 400px;
  padding: 20px;
}
</style>
