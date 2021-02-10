<template>
  <div id="app">
    <VueLoading
        :active.sync="loading"
        :can-cancel="false"
        :color="'#4f46e5'"
        :background-color="'#121622'"
    />
    <component :is="layout">
      <router-view/>
    </component>
  </div>
</template>

<script>

import Vue from 'vue'
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.use(VueLoading)

import DefaultLayout from './views/layouts/DefaultLayout'
import EmptyLayout from './views/layouts/EmptyLayout'
import {mapGetters} from "vuex";
import {GET_IP} from "@/store/actions/other";

const defaultLayout = "default";

export default {
  components: {
    VueLoading,
    DefaultLayout,
    EmptyLayout
  },
  computed: {
    ...mapGetters(['loading']),
    loading() {
      return this.$store.state.loading;
    },
    layout() {
      return (this.$route.meta.layout || defaultLayout) + '-layout'
    },
  },
};
</script>
