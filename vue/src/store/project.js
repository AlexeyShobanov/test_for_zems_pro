import axios from "axios";

export default {
    state: () => ({
        projects: [],
        projectStats: null,
        tasks: [],
        currentProject: null,
        currentTask: null,
        isProjectsLoading: false,
        page: 1,
        totalPages: 0,
        createFormVisible: false,
        updateFormVisible: false,
        createTaskFormVisible: false,
        // pageTasks: 1,
        // totalPagesTasks: 0,
    }),
    getters: {},
    mutations: {
        setProjects(state, projects) {
            state.projects = projects;
        },
        setCurrentProject(state, project) {
            state.currentProject = project;
        },
        setCurrentTask(state, task) {
            state.currentTask = task;
        },
        setLoading(state, bool) {
            state.isProjectsLoading = bool
        },
        setPage(state, page) {
            state.page = page
        },
        setTotalPages(state, totalPages) {
            state.totalPages = totalPages
        },
        setProjectStats(state, projectStats) {
            state.projectStats = projectStats
        },
        incrementProjectCount(state) {
            state.currentProject.task_count += 1;
        },
        setTasks(state, tasks) {
            state.tasks = tasks
        },
        setCreateFormVisible(state, createFormVisible) {
            state.createFormVisible = createFormVisible
        },
        setUpdateFormVisible(state, updateFormVisible) {
            state.updateFormVisible = updateFormVisible
        },
        setCreateTaskFormVisible(state, createTaskFormVisible) {
            state.createTaskFormVisible = createTaskFormVisible
        },
        renameProject(state, newTitleProject) {
            state.projects.map((project) => {
                if (project.id === newTitleProject.id) {
                    project.title = newTitleProject.title;
                }
                return project;
            })
        },
        updateTasks(state, updatedTask) {
            state.tasks = state.tasks.map((task) => {
                if (task.id === updatedTask.id) {
                    return updatedTask;
                }
                return task;
            });
        },
        updateProjectStats(state, taskStats) {
            state.projectStats.agrDuration += taskStats.duration;
            state.projectStats.finishTasks += taskStats.finishTask;
            state.projectStats.startTasks += taskStats.startTask;
        },
    },
    actions: {
        async fetchProjects({state, commit}) {
            commit("setLoading", true);
            try {
                const response = await axios
                    .get("api/v1/projects", {
                            params: {
                                page: state.page,
                            },
                        }
                    );
                commit('setTotalPages', response.data.meta.last_page);
                if (!state.projects.length) {
                    commit('setProjects', response.data.data);
                }
                commit("setCurrentProject", null);
                commit("setTasks", null);
                commit("setProjectStats", null);
            } catch (e) {
                console.log(e);
            } finally {
                commit('setLoading', false);
            }
        },
        async loadMoreProjects({state, commit}) {
            if (state.page < state.totalPages) {
                commit('setPage', state.page + 1)
                try {
                    const response = await axios.get(
                        "api/v1/projects",
                        {
                            params: {
                                page: state.page,
                            },
                        }
                    );
                    commit('setProjects', [...state.projects, ...response.data.data]);
                } catch (e) {
                    console.log(e);
                }
            }
        },
        async createProject({state, commit}, project) {
            try {
                const response = await axios.post("api/v1/projects", project, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                commit('setProjects', [response.data.data, ...state.projects]);
            } catch (e) {
                console.log(e);
            } finally {
                commit("setCreateFormVisible", false);
            }
        },
        async updateProject({state, commit}, newData) {
            try {
                const response = await axios.put("api/v1/projects/" + state.currentProject.id, newData);
                commit('renameProject', response.data.data);
            } catch (e) {
                console.log(e);
            } finally {
                commit("setUpdateFormVisible", false);
            }
        },
        async fetchProject({state, commit}, params) {
            commit("setLoading", true);
            try {
                const response = await axios
                    .get("api/v1/projects/" + params.id);
                commit('setTasks', response.data.data.tasks.sort(function (a, b) {
                        if (a.id < b.id) {
                            return 1;
                        }
                        if (a.id > b.id) {
                            return -1;
                        }
                        return 0;
                    })
                );
                commit('setProjectStats', response.data.meta);
                delete response.data.data.tasks;
                delete response.data.meta;
                commit('setCurrentProject', response.data.data);
            } catch (e) {
                console.log(e);
            } finally {
                commit('setLoading', false);
            }
        },
        showCreateForm({commit}) {
            commit('setCreateFormVisible', true);
        },
        showCreateTaskForm({commit}) {
            commit('setCreateTaskFormVisible', true);
        },
        async createTask({state, commit}, task) {
            try {
                const response = await axios.post("api/v1/tasks", {
                    title: task.title,
                    project: state.currentProject.id
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                commit('setTasks', [response.data.data, ...state.tasks]);
                commit('incrementProjectCount');
                console.log(state.projectStats);
            } catch (e) {
                console.log(e);
            } finally {
                commit("setCreateTaskFormVisible", false);
            }
        },
        async updateTask({state, commit}, status) {
            try {
                const response = await axios.put("api/v1/tasks/" + state.currentTask.id, {status: status});
                console.log(response);
                commit('updateTasks', response.data.data);
                commit('updateProjectStats', response.data.meta);
                console.log(state.projectStats);
            } catch (e) {
                console.log(e);
            }
        },
    },
    namespaced: true
}