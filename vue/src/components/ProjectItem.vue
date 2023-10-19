<template>
  <div class="mb-5 pb-5 lg:flex lg:items-center lg:justify-between border-b-2 border-gray-200 ">
    <div class="min-w-0 flex-1">
      <h2 class="text-xl font-bold leading-7 text-gray-900 sm:truncate sm:text-2xl sm:tracking-tight">{{ project.title }}</h2>
      <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
        <div class="mt-2 flex items-center text-sm text-gray-500">
          <BriefcaseIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
          Количество задач: {{ project.task_count ?? 0 }}
        </div>
        <div class="mt-2 flex items-center text-sm text-gray-500">
          <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
          Дата создания: {{ project.date }}
        </div>
      </div>
    </div>
    <div class="mt-5 flex lg:ml-4 lg:mt-0">
      <span class="hidden sm:block">
        <item-button @click="showUpdateProjectForm">
          <PencilIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
          Править
        </item-button>
      </span>

      <span class="ml-3 hidden sm:block">
        <item-button @click="$router.push(`/projects/${project.id}`)">
          <LinkIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
          Подробно
        </item-button>
      </span>

      <span class="sm:ml-3">
        <item-button @click="createTaskForProject">
          <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
          Добавить задачу
        </item-button>
      </span>
    </div>
  </div>
</template>

  <script>
  import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon,
    CurrencyDollarIcon,
    LinkIcon,
    MapPinIcon,
    PencilIcon,
    PlusIcon
  } from '@heroicons/vue/20/solid'

  import {mapActions, mapMutations, mapState} from "vuex";

  export default {
    components: {
      BriefcaseIcon,
      CalendarIcon,
      CheckIcon,
      CurrencyDollarIcon,
      LinkIcon,
      MapPinIcon,
      PencilIcon,
      PlusIcon
    },
    props: {
      project: {
        type: Object,
        required: true,
      },
    },
    methods: {
      ...mapMutations({
        setCurrentProject: "project/setCurrentProject",
        setUpdateFormVisible: "project/setUpdateFormVisible",
        setCreateTaskFormVisible: "project/setCreateTaskFormVisible",
      }),
      ...mapActions({
        showCreateTaskForm: "project/showCreateTaskForm",
      }),
      showUpdateProjectForm() {
        this.setCurrentProject(this.project);
        this.setUpdateFormVisible(true);
      },
      createTaskForProject() {
        this.setCurrentProject(this.project);
        this.showCreateTaskForm();
      }
    },
    computed: {
      ...mapState({
        currentProject: (state) => state.project.currentProject,
      }),
    }
};
</script>