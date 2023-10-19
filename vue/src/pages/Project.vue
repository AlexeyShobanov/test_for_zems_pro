<template>
  <div>
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">Проекты</h1>
        </div>
        <div class="mt-5 flex lg:ml-4 lg:mt-0">
          <span class="sm:ml-3">
            <item-button @click="showCreateForm">
              <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
              Новый проект
            </item-button>
          </span>
        </div>
      </div>

    </header>
    <main>
      <create_form
          :show="createFormVisible"
          @update:show="setCreateFormVisible"
      >
        <project-create-form></project-create-form>
      </create_form>

      <create_form
          :show="updateFormVisible"
          @update:show="setUpdateFormVisible"
      >
        <project-update-form></project-update-form>
      </create_form>

      <create_form
          :show="createTaskFormVisible"
          @update:show="setCreateTaskFormVisible"
      >
        <item-create-form></item-create-form>
      </create_form>

      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <project-list
            :projects="projects"
            v-if="!isProjectsLoading"
        ></project-list>
        <div v-else>
          <div class="loader">
            <pulse-loader :loading="isProjectsLoading" :color="color" :size="size"></pulse-loader>
          </div>
        </div>
        <div v-intersection="loadMoreProjects" class="observer">
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import ProjectList from "../components/ProjectList.vue";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import { PlusIcon } from '@heroicons/vue/20/solid'
import { mapActions, mapMutations, mapState } from "vuex";
import ProjectUpdateForm from "../components/ProjectUpdateForm.vue";
import ProjectCreateForm from "../components/ProjectCreateForm.vue";
import ItemCreateForm from '../components/ItemCreateForm.vue';
export default {
  components: { ProjectList, ProjectCreateForm, ProjectUpdateForm, PulseLoader, PlusIcon, ItemCreateForm },
  data() {
    return {
      color: '#6366f1',
      size: '45px',
    };
  },
  methods: {
    ...mapMutations({
      setPage: "project/setPage",
      setCreateFormVisible: "project/setCreateFormVisible",
      setUpdateFormVisible: "project/setUpdateFormVisible",
      setCreateTaskFormVisible: "project/setCreateTaskFormVisible",
    }),
    ...mapActions({
      loadMoreProjects: "project/loadMoreProjects",
      fetchProjects: "project/fetchProjects",
      showCreateForm: "project/showCreateForm",
    }),
  },
  async mounted() {
    await this.fetchProjects();
  },
  computed: {
    ...mapState({
      projects: (state) => state.project.projects,
      isProjectsLoading: (state) => state.project.isProjectsLoading,
      page: (state) => state.project.page,
      totalPages: (state) => state.project.totalPages,
      createFormVisible: (state) => state.project.createFormVisible,
      updateFormVisible: (state) => state.project.updateFormVisible,
      createTaskFormVisible: (state) => state.project.createTaskFormVisible,
    }),
  },
}
</script>

<style scoped>
.observer {
  height: 10px;
}
.loader{
  position: fixed;
  left: 50%;
  top: 50%;
  width: 100%;
  height: 100%;
  z-index: 10;
}
</style>
