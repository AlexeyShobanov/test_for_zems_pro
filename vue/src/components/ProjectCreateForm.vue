<template>
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Новый проект</h2>
  </div>
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent>
      <form-input
          v-model="project.title"
          type="text"
          name="title"
          id="title"
          label="Название проекта"
          placeholder="Название проекта"
          autocomplete=""
      ></form-input>

      <form-button @click="create">Создать</form-button>
  </form>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      project: {
        title: "",
      },
    };
  },
  methods: {
    ...mapActions({
      createProject: "project/createProject",
    }),
    create() {
      this.createProject(this.project);
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
