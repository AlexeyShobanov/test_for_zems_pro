<template>
  <div v-if="tasks.length > 0">
    <transition-group name="task-list">
      <task-item
          v-for="task in tasks"
          :key="task.id"
          :task="task"
       project="">
      </task-item>
    </transition-group>
  </div>
  <h3 v-else>Список задач проекта пуст</h3>
</template>

<script>
import TaskItem from "./TaskItem.vue";
export default {
  components: { TaskItem },
  props: {
    tasks: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>