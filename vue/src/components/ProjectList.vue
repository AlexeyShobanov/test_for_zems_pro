<template>
  <div v-if="projects.length > 0">
    <transition-group name="project-list">
      <project-item
          v-for="project in projects"
          :key="project.id"
          :project="project"
      ></project-item>
    </transition-group>
  <div v-intersection="loadMoreProjects" class="observer"></div>
  </div>
  <h3 v-else>Список проектов пуст</h3>
</template>

<script>
import ProjectItem from "./ProjectItem.vue";
import {mapActions} from "vuex";
export default {
  components: { ProjectItem },
  props: {
    projects: {
      type: Array,
      required: true,
    },
  },
  methods: {
    ...mapActions({
      loadMoreProjects: "project/loadMoreProjects",
    })
  }
};
</script>

<style scoped>
</style>