<template>
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Форма редактирования</h2>
  </div>
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" @submit.prevent>
      <form-input
          type="text"
          name="title"
          id="title"
          label="Название проекта"
          placeholder="Название проекта"
          :modelValue=currentProject.title
          @input="newData.title = $event.target.value"
          autocomplete=""
      ></form-input>

      <form-button @click="update">Сохранить изменения</form-button>
    </form>
  </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";

export default {
  // emits: ["update-project"],
  data() {
    return {
      newData: {
        title: "",
      }
    };
  },
  methods: {
    ...mapMutations({
      setUpdateFormVisible: "project/setUpdateFormVisible",
    }),
    ...mapActions({
      updateProject: "project/updateProject",
    }),
    update() {
      this.updateProject(this.newData);
    },
  },
  computed: {
    ...mapState({
      currentProject: (state) => state.project.currentProject,
    }),
  },
};
</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
}
</style>
