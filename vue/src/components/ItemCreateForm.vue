<template>
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Новая задача</h2>
  </div>
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent>
      <form-input
          v-model="task.title"
          type="text"
          name="title"
          id="title"
          label="Название задачи"
          placeholder="Название задачи"
          autocomplete=""
      ></form-input>

      <form-button @click="create">Создать</form-button>
    </form>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  data() {
    return {
      task: {
        title: "",
      },
    };
  },
  methods: {
    ...mapActions({
      createTask: "project/createTask",
    }),
    create() {
      this.createTask(this.task);
    },
  },
};
</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
}
</style>
