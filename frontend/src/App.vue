<template>
  <div id="app">
    <div class="app-loading" v-if="loading"></div>
    <component :is="layout">
      <router-view/>
    </component>
  </div>
</template>

<script>

import DefaultLayout from './views/layouts/DefaultLayout'

const defaultLayout = "default";

export default {
  components: {
    DefaultLayout,
  },
  computed: {
    loading() {
      return this.$store.state.loading;
    },
    layout() {
      return (this.$route.meta.layout || defaultLayout) + '-layout'
    }
  },
};
</script>
