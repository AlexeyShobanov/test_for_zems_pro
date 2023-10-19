<template>
  <div>
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">Проект: {{ !currentProject ? "" : currentProject.title }}</h1>
        </div>
      </div>
      <div class="mx-auto max-w-7xl px-4 pb-5 sm:px-6 lg:px-8 lg:flex lg:items-center sm:space-x-6 lg:items-center lg:justify-between">
        <div class="mt-5 flex lg:mt-0 sm:space-x-6">
          <div class="mt-2 flex items-center text-base text-gray-500">
            <BriefcaseIcon class="mr-1.5 h-7 w-7 flex-shrink-0 text-gray-400" aria-hidden="true" />
            Количество задач: {{ !currentProject ? "" : currentProject.task_count }}
          </div>
          <div class="mt-2 flex items-center text-base text-gray-500">
            <ClockIcon class="mr-1.5 h-7 w-7 flex-shrink-0 text-gray-400" aria-hidden="true" />
            Затраченное время: {{ !projectStats ? "" : projectStats.agrDuration }}
          </div>
        </div>
        <div class="mt-5 flex lg:ml-4 lg:mt-0">
          <span class="sm:ml-3">
            <item-button @click="showCreateTaskForm">
              <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
              Новая задача
            </item-button>
          </span>
          <span class="sm:ml-3">
            <item-button @click="$router.push(`/projects`)">
              <ArrowLeftIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
              К списку проектов
            </item-button>
          </span>
        </div>
      </div>
    </header>
    <main>

      <create_form
          :show="createTaskFormVisible"
          @update:show="setCreateTaskFormVisible"
      >
        <item-create-form></item-create-form>
      </create_form>

      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <task-list
            :tasks="tasks"
            v-if="!isProjectsLoading || tasks"
        ></task-list>
        <div v-else>
          <div class="loader">
            <pulse-loader :loading="isProjectsLoading" :color="color" :size="size"></pulse-loader>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import TaskList from "../components/TaskList.vue";
import ItemCreateForm from '../components/ItemCreateForm.vue';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import { PlusIcon, ArrowLeftIcon, BriefcaseIcon, ClockIcon } from '@heroicons/vue/20/solid'
import { mapActions, mapMutations, mapState } from "vuex";
export default {
  components: {
    TaskList,
    ItemCreateForm,
    PulseLoader,
    PlusIcon,
    ArrowLeftIcon,
    BriefcaseIcon,
    ClockIcon
  },
  data() {
    return {
      color: '#6366f1',
      size: '45px',
    };
  },
  methods: {
    ...mapMutations({
      setPage: "project/setPage",
      setCreateTaskFormVisible: "project/setCreateTaskFormVisible",
      setCurrentProject: "project/setCurrentProject",
    }),
    ...mapActions({
      fetchProject: "project/fetchProject",
      showCreateTaskForm: "project/showCreateTaskForm",
    }),
  },
  async created() {
    await this.fetchProject(this.$route.params);
  },
  computed: {
    ...mapState({
      currentProject: (state) => state.project.currentProject,
      isProjectsLoading: (state) => state.project.isProjectsLoading,
      createTaskFormVisible: (state) => state.project.createTaskFormVisible,
      projectStats: (state) => state.project.projectStats,
      tasks: (state) => state.project.tasks,
    }),
  },
}
</script>

<style scoped>
/*.observer {*/
/*  height: 10px;*/
/*}*/
.loader{
  position: fixed;
  left: 50%;
  top: 50%;
  width: 100%;
  height: 100%;
  z-index: 10;
}
</style>
