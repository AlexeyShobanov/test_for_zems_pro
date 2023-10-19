<template>
  <div class="mb-5 pb-5 lg:flex lg:items-center lg:justify-between border-b-2 border-gray-200 ">
    <div class="min-w-0 flex-1">
      <div class="lg:flex lg:items-center lg:justify-start lg:mb-1">
        <div class="text-xl font-bold leading-7 text-gray-900 sm:truncate sm:text-2xl sm:tracking-tight">{{ task.title }}</div>
        <div class="mt-2 ml-5 flex items-center text-lg text-gray-400 leading-7">
          <PowerIcon v-if="!task.start_time" class="ml-1.5 h-8 w-8 flex-shrink-0 text-red-400" aria-hidden="true" />
          <Cog8ToothIcon v-if="task.start_time && !task.finish_time"  class="ml-1.5 h-8 w-8 flex-shrink-0 text-yellow-400" aria-hidden="true" />
          <CheckIcon v-if="task.finish_time" class="ml-1.5 h-10 w-10 flex-shrink-0 text-green-400" aria-hidden="true" />
        </div>
      </div>

      <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
        <div v-if="task.start_time" class="mt-2 flex items-center text-sm text-gray-500">
          <CloudArrowUpIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
          Время начала: {{ task.start_time }}
        </div>
        <div v-if="task.finish_time" class="mt-2 flex items-center text-sm text-gray-500">
          <CloudArrowDownIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
          Время окончания: {{ task.finish_time }}
        </div>
        <div v-if="task.finish_time" class="mt-2 flex items-center text-sm text-gray-500">
          <CogIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
          Время в работа: {{ task.duration }} ч.
        </div>
      </div>
    </div>
    <div class="mt-5 flex lg:ml-4 lg:mt-0">
      <span v-if="!task.start_time" class="ml-3 hidden sm:block">
        <item-button @click="statusTask(0)">
          <HandThumbUpIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-green-400" aria-hidden="true" />
          Старт
        </item-button>
      </span>
      <span v-if="task.start_time  && !task.finish_time" class="sm:ml-3">
        <item-button @click="statusTask(1)">
          <HandThumbUpIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-red-400" aria-hidden="true" />
          Стоп
        </item-button>
      </span>
    </div>
  </div>
</template>

  <script>
  import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon, CloudArrowDownIcon, CloudArrowUpIcon, Cog8ToothIcon, CogIcon,
    CurrencyDollarIcon, HandThumbUpIcon,
    LinkIcon,
    MapPinIcon,
    PencilIcon,
    PlusIcon, PowerIcon
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
      PlusIcon,
      CloudArrowDownIcon,
      CloudArrowUpIcon,
      CogIcon,
      HandThumbUpIcon,
      Cog8ToothIcon,
      PowerIcon
    },
    props: {
      task: {
        type: Object,
        required: true,
      },
    },
    computed: {
      ...mapState({
        currentProject: (state) => state.project.currentProject,
      }),
    },
    methods: {
      ...mapMutations({
        setCurrentTask: "project/setCurrentTask",
      }),
      ...mapActions({
        updateTask: "project/updateTask",
        createTask: "project/createTask",
      }),
      statusTask(status) {
        this.setCurrentTask(this.task);
        this.updateTask(status);
      },
    }
};
</script>