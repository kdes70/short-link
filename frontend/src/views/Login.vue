<template>

  <div class="auth_wrapper">
    <!-- Login Form -->
    <div class="container mx-auto p-8">
      <div class="mx-auto max-w-sm">

        <div class="auth_form_wrapper rounded shadow">
          <div class="border-b py-8 font-bold text-black text-center text-xl tracking-widest uppercase">
            Login
          </div>

          <form class="bg-white px-10 py-10">

            <div class="mb-3">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="email" type="text" placeholder="E-Mail">
            </div>
            <div class="mb-6">
              <input
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="password" type="password" placeholder="**************">
            </div>
            <div class="flex">
              <button
                  class="bg-primary hover:bg-primary-dark w-full rounded-md p-4 text-sm text-white uppercase font-bold tracking-wider">
                Login
              </button>
            </div>
          </form>

          <div class="border-t px-10 py-6">
            <div class="flex justify-between">
              <router-link  class="font-bold text-primary hover:text-primary-dark no-underline"
                           :to="{name: 'Register'}">Don't have an account?
              </router-link>
<!--              <a href="#" class="text-grey-darkest hover:text-black no-underline">Forgot Password?</a>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
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
