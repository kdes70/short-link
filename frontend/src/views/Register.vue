<template>
  <div class="auth_wrapper">
    <!-- Login Form -->
    <div class="container mx-auto p-8">
      <div class="mx-auto max-w-sm">

        <div class="auth_form_wrapper rounded shadow">
          <div class="border-b py-8 font-bold text-black text-center text-xl tracking-widest uppercase">
            Register
          </div>

          <div v-if="errors.length">
            <b>Пожалуйста исправьте указанные ошибки:</b>
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>

          <form class="bg-white px-10 py-10" @submit.prevent="submit">

            <div class="mb-3">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="name" type="text" v-model="form.name" placeholder="Name">
              <small class="bg-red-100" v-if="getErrors.has('name')" v-text="getErrors.get('name')"></small>
            </div>
            <div class="mb-3">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="email" type="email" v-model="form.email" placeholder="E-Mail">
              <small class="bg-red-100" v-if="getErrors.has('email')" v-text="getErrors.get('email')"></small>
            </div>
            <div class="mb-3">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="password" type="password" v-model="form.password" placeholder="Password">
              <small class="bg-red-100" v-if="getErrors.has('password')" v-text="getErrors.get('password')"></small>
            </div>
            <div class="mb-6">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="password_confirm" type="password" v-model="form.password_confirm"
                  placeholder="Confirm Password">
            </div>
            <div class="flex">
              <button
                  class="bg-primary hover:bg-primary-dark w-full rounded-md p-4 text-sm text-white uppercase font-bold tracking-wider">
                Create Account
              </button>
            </div>
          </form>

          <div class="border-t px-10 py-6">
            <div class="flex justify-between">
              <router-link class="font-bold text-primary hover:text-primary-dark no-underline" :to="{name: 'Login'}">You
                already have an account?
              </router-link>
              <!--              <a href="#" class="text-grey-darkest hover:text-black no-underline">Forgot Password?</a>-->
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {AUTH_REGISTER} from "@/store/actions/auth";
import {mapGetters} from "vuex";

export default {
  name: 'RegisterForm',
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        password_confirm: null,
      },
      errors: [],
    }
  },
  computed: {
    ...mapGetters(['getErrors', 'isAuth'])
  },
  methods: {
    submit(e) {
      e.preventDefault();

      this.validate()

      if (!this.errors.length) {
        this.$store.dispatch(AUTH_REGISTER, this.form)
            .then(response => {
              if (response.data.status === "success") {
                if (this.isAuth) {
                  this.$router.push({name: 'Home'})
                } else {
                  this.$router.push({name: 'Login'})
                }
              }
            })
            .catch(error => {
              console.log('submit catch error', error)
            })
      }
    },
    validate() {
      this.errors = []

      for (const [key, value] of Object.entries(this.form)) {
        if (value === '' || value === null) {
          this.errors.push(key + " is required.");
        }
      }
    }
  }
}
</script>

<style>
.auth_wrapper {
  width: 100%;
  height: 100vh;
  @apply bg-gray-100;
}

.auth_form_wrapper {
  @apply bg-white;
}
</style>
