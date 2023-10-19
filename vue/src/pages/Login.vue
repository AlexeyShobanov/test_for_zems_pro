<template>
<!--  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">-->
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Форма авторизации</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent>
        <form-input
          v-model="loginFormData.email"
          type="email"
          name="email"
          id="email"
          label="Логин"
          placeholder="Логин/email"
          autocomplete=""
        ></form-input>
        <form-input
          v-model="loginFormData.password"
          type="password"
          name="password"
          id="password"
          label="Пароль"
          placeholder="Пароль"
          autocomplete="current-password"
        ></form-input>
        <form-button @click="submit" >
          Войти
        </form-button>
      </form>
      <div class="mt-10">
        <form-button @click="this.$router.push('/register')">
          Зарегистрироваться
        </form-button>
      </div>
    </div>
<!--  </div>-->
</template>

<script>
import { mapActions } from "vuex";
import Alert from "../components/Alert.vue";
import router from "../router/index.js";

export default {
  components: { Alert },
  data() {
    return {
      loginFormData: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    async submit() {
      try {
        await this.signIn(this.loginFormData);
        await router.push({ name: "Project" });
      } catch (e) {
        console.log(e.message);
      }
    },
  },
};
</script>

<style scoped></style>