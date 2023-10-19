<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Форма регистарции</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent>
        <form-input
            v-model="registerFormData.email"
            type="email"
            name="email"
            id="email"
            label="Email"
            placeholder="ivanov@mail.ru"
            autocomplete="new-email"
        ></form-input>
        <form-input
            v-model="registerFormData.name"
            type="text"
            name="email"
            id="name"
            label="Имя"
            placeholder="Иванов Иван"
            autocomplete="new-name"
        ></form-input>
        <form-input
            v-model="registerFormData.password"
            type="password"
            name="password"
            id="password"
            label="Пароль"
            placeholder="не менее 8 символов"
            autocomplete="new-password"
        ></form-input>
        <form-input
            v-model="registerFormData.password_confirmation"
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            label="Повторите пароль"
            placeholder="не менее 8 символов"
            autocomplete="new-password"
        ></form-input>
        <form-button @click="submit" >
          Зарегистрироваться
        </form-button>
      </form>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Alert from "../components/Alert.vue";
import axios from "axios";
import router from "../router/index.js";

export default {
  components: { Alert },
  data() {
    return {
      registerFormData: {
        email: "",
        name: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    ...mapActions({
      register: "auth/register",
    }),
    async submit() {
      try {
        await this.register(this.registerFormData);
        await router.push({ name: "Projects" });
      } catch (e) {
        console.log(e.message);
      }
    },
  },
};
</script>

<style scoped></style>