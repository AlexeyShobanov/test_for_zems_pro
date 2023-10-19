<template>
  <div v-if="projects.length > 0">
    <transition-group name="project-list">
      <project-item
          v-for="project in projects"
          :key="project.id"
          :project="project"
      ></project-item>
    </transition-group>
  </div>
  <h3 v-else>Список проектов пуст</h3>
</template>

<script>
import ProjectItem from "./ProjectItem.vue";
export default {
  components: { ProjectItem },
  props: {
    projects: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>