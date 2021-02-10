<template>
  <div
      :class="`modal ${
        !isOutside && 'opacity-0 pointer-events-none'
      } z-50 fixed w-full h-full top-0 left-0 flex items-center justify-center`"
  >
    <div
        class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
    ></div>

    <div
        class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto"
    >
      <div
          @click="isOutside"
          class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50"
      >
        <svg
            class="fill-current text-white"
            xmlns="http://www.w3.org/2000/svg"
            width="18"
            height="18"
            viewBox="0 0 18 18"
        >
          <path
              d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
          />
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <div class="modal-content text-left">
        <form @submit.prevent="handleSubmit">
          <div class="w-full bg-white shadow-md rounded-md overflow-hidden border">
            <!-- Header-->
            <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
              <!--Title-->
              <slot name="header"/>

              <button @click="isOutside">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
            <!-- Body -->
            <div class="px-5 py-6 bg-gray-200 text-gray-700 border-b">
              <slot name="body"/>
            </div>
            <!-- Footer -->
            <div class="flex justify-between items-center px-5 py-3">
              <button
                  @click="isOutside"
                  class="px-3 py-1 text-gray-700 text-sm rounded-md bg-gray-200 hover:bg-gray-300 focus:outline-none">
                Cancel
              </button>
              <slot name="footer"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FormModal",

  props: {
    outside: {
      type: Boolean,
      require: true,
      default: () => false
    }
  },
  mounted() {
    document.addEventListener("keydown", (e) => {
      if (this.outside && e.keyCode === 27) {
        this.$emit('handle_close')
      }
    });
  },
  methods: {
    isOutside() {
      if (this.outside) {
        this.$emit('handle_close')
      }
    },
    handleSubmit() {
      this.$emit('handle_submit')
    }
  }
}
</script>

<style scoped>
.modal {
  transition: opacity 0.25s ease;
}
</style>