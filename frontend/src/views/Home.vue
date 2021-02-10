<template>
  <div class="mt-8">
    <div class="mt-6">
      <h2 class="text-xl font-semibold text-gray-700 leading-tight">Link List</h2>

      <div class="mt-3 flex flex-col sm:flex-row">

        <div class="flex">
          <div class="relative">
            <button @click="toggleModal"
                    class="bg-indigo-800 hover:bg-indigo-700 focus:outline-none rounded px-6 py-2 text-white font-semibold shadow">
              <span class="w-5 h-5 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24px" height="24px" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round"
                     class="feather feather-plus w-4 h-4 w-4 h-4"><line
                    x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
            </button>
          </div>
        </div>
      </div>

      <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden" :ref="'links_list'">

          <table class="min-w-full leading-normal">
            <thead>
            <tr>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                ID
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                Code
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                Visits
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                Created at
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                Status
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                Actions
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(link, index) in getLinks.data" :key="index">
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <div class="flex items-center">
                  <div class="flex-shrink-0 w-10 h-10">
                    {{ link.id }}
                  </div>
                </div>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <a class="whitespace-no-wrap text-indigo-600" href="#" @click="showCode(link)">{{ link.code }}</a>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ link.visits_count }}</p>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ link.created_at | formatDate }}</p>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <span v-if="link.state > 0"
                      class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                  <span aria-hidden="" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                  <span class="relative">Active</span>
                </span>
                <span v-else class="relative inline-block px-3 py-1 font-semibold text-gray-500 leading-tight">
                  <span aria-hidden="" class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                  <span class="relative">InActive</span>
                </span>
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <div class="flex justify-center items-center">
                  <a class="flex items-center mr-3 text-blue-500" href="javascript:;" @click.prevent="editItem(link)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-edit">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit </a>
                  <a class="flex items-center text-theme-6 text-red-500" @click.prevent="deleteItem(link)"
                     href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-trash-2">
                      <polyline points="3 6 5 6 21 6"/>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                      <line x1="10" y1="11" x2="10" y2="17"/>
                      <line x1="14" y1="11" x2="14" y2="17"/>
                    </svg>
                    Delete </a>
                </div>
              </td>
            </tr>
            </tbody>
          </table>

          <Pagination :pagination="getLinks.meta" @paginate="getList" :offset="5"></Pagination>

        </div>
      </div>
    </div>

    <!-- Modal-->
    <FormModal v-if="openModal" :outside="true" @handle_close="toggleModal()" @handle_submit="submit()">
      <template slot="header">
        <h3 class="text-sm" v-if="modal === 'new'">Add Link</h3>
        <h3 class="text-sm" v-if="modal === 'edit'">Edit Link</h3>
        <h3 class="text-sm" v-if="modal === 'show'">Show Link</h3>
      </template>
      <template slot="body">
        <div v-if="modal !== 'show'">
          <label class="text-xs">Link</label>
          <div class="mt-2 relative rounded-md shadow-sm">
          <span
              class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
            <svg class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 32 32"
                 style="enable-background:new 0 0 32 32;"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 stroke-miterlimit="10"
            >
             <path class="st0" d="M10.3,17.4l-4.9-4.9c-2-2-2-5.1,0-7.1l0,0c2-2,5.1-2,7.1,0l4.9,4.9"/>
  <path class="st0" d="M21.7,14.6l4.9,4.9c2,2,2,5.1,0,7.1l0,0c-2,2-5.1,2-7.1,0l-4.9-4.9"/>
  <line class="st0" x1="11.8" y1="11.8" x2="20.2" y2="20.2"/>
            </svg>
          </span>

            <input type="text"
                   class="form-input w-full px-12 py-2 appearance-none rounded-md focus:border-indigo-600"
                   v-model="form.link">
          </div>
          <small class="bg-red-100" v-if="getErrors.has('link')" v-text="getErrors.get('link')"></small>
        </div>

        <div v-if="modal !== 'show'">
          <div class="flex rounded-md py-4 px-4 overflow-x-auto">
            <label class="inline-flex items-center 0">
              <input type="radio" class="form-radio h-5 w-5 text-green-600" value="1" v-model.number="form.state">
              <span class="ml-2 text-gray-700">Active</span>
            </label>
            <label class="inline-flex items-center ml-3 ">
              <input type="radio" class="form-radio h-5 w-5 text-gray-600" value="0" v-model.number="form.state">
              <span class="ml-2 text-gray-700">Inactive</span>
            </label>
          </div>
        </div>

        <div v-if="modal === 'show'">
          <p class="text-xs">
            <router-link :to="{name:'Go', params: { code: form.link}}" v-slot="{href}">
              <span v-text="pathPrint(href)" ref="fullLink"></span>
            </router-link>
          </p>
        </div>

      </template>
      <template slot="footer">
        <button class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500 focus:outline-none"
                v-if="modal === 'new'">
          Add
        </button>
        <button class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500 focus:outline-none"
                v-if="modal === 'edit'">
          Edit
        </button>
        <button class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500 focus:outline-none"
                v-if="modal === 'show'" @click="copyUrl">
          Copy
        </button>
      </template>
    </FormModal>
  </div>

</template>

<script>
import {ADD_LINK, DELETE_LINK, EDIT_LINK, GET_LINKS} from "@/store/actions/links";
import FormModal from "@/components/FormModal";
import Pagination from "@/components/Pagination";
import {mapGetters} from "vuex";
import {MODAL_SHOW} from "@/store/actions/other";
import formatDate from "@/utils/formatDate";

export default {
  name: 'Home',
  components: {
    FormModal,
    Pagination
  },
  filters: {
    formatDate
  },
  data() {
    return {
      form: {
        link: null,
        state: 0,
      },
      modal: null,
      activeItem: null
    }
  },
  computed: {
    ...mapGetters(['getLinks', 'openModal', 'getErrors']),
  },
  mounted() {
    this.getList(this.page)
  },
  methods: {
    copyUrl() {
      var fullLink = this.$refs.fullLink;

      console.log('copyUrl', fullLink)

      this.selectText(fullLink)
      document.execCommand("copy");

      alert('Ссылка скопированна!')
    },
    pathPrint(href) {
      return window.location.origin + href
    },
    getList() {

      console.log('$refs', this.$refs.links_list)
      console.log('$refs', this.$refs['links_list'])

      let current_page = this.getLinks.meta.current_page
      let page = current_page ? current_page : 1

      this.$store.dispatch(GET_LINKS, page)
    },
    toggleModal() {
      this.$store.dispatch(MODAL_SHOW).then(() => {
        this.modal = 'new'
        this.form.link = null
        this.form.state = 0
      })
    },
    submit() {
      if (this.form.link) {
        if (this.modal === 'new') {
          this._addLink()
        }
        if (this.modal === 'edit') {
          this._editLink()
        }
      }
    },
    editItem(link) {
      this.$store.dispatch(MODAL_SHOW).then(() => {
        this.modal = 'edit'
        this.form.link = link.link
        this.form.state = link.state
        this.activeItem = link
      })
    },
    showCode(link) {
      this.$store.dispatch(MODAL_SHOW).then(() => {
        this.modal = 'show'
        this.form.link = link.code
      })
    },
    deleteItem(link) {

      this.$swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete these records? This process cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {

          this.$store.dispatch(DELETE_LINK, link.id).then(() => {
            this.$swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
          })
        }
      })


    },
    _addLink() {
      this.$store.dispatch(ADD_LINK, this.form).then(response => {
        this._clearForm()
        this.$store.dispatch(MODAL_SHOW)
      })
    },
    _editLink() {

      if (this.activeItem) {
        this.$store.dispatch(EDIT_LINK, [this.activeItem, this.form]).then(response => {
          this._clearForm()
          this.$store.dispatch(MODAL_SHOW)
        })
      }

    },
    _clearForm() {
      this.form.link = null
      this.form.state = 0
      this.activeItem = null
    },
    selectText(element) {
      let range;
      if (document.selection) {
        // IE
        range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
      } else if (window.getSelection) {
        range = document.createRange();
        range.selectNode(element);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
      }
    }

  }
}
</script>
