<template>
  <div class="container mx-auto">
    <h1 v-if="this.logged_in" class="text-3xl font-bold">Country flags of the world</h1>
    <!-- flaglist -->
    <div class="grid grid-cols-3 gap-2">
      <div v-for="(flag, index) in this.flags" :key="index" class="flag">
        <img v-bind:src="flag.flag" alt="" />
        <p class="title">{{ flag.name }}</p>
      </div>
    </div>

    <!-- paging -->
    <div v-if="this.logged_in"
      class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
    >
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ this.from }}</span>
            to
            <span class="font-medium">{{ this.to }}</span>
            of
            <span class="font-medium">{{ this.total }}</span>
            results
          </p>
        </div>

        <ol class="flex justify-center gap-1 text-xs font-medium">
          <li>
            <a
              href="#"
              @click="firstPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">First Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"
                />
              </svg>
            </a>
          </li>

          <li>
            <a
              href="#"
              @click="prevPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">Prev Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 19.5L8.25 12l7.5-7.5"
                />
              </svg>
            </a>
          </li>

          <div v-for="(link, index) in this.links" :key="index">
            <li v-if="index > 0 && index < this.max_items" v-bind:class="this.isActive(index)">
              <a
                class="block h-8 w-8 rounded border text-center leading-8"
                href="#"
                @click="linkPage(index)"
                >{{ index }}</a
              >
            </li>
          </div>

          <li>
            <a
              href="#"
              @click="nextPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">Next Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8.25 4.5l7.5 7.5-7.5 7.5"
                />
              </svg>
            </a>
          </li>
          <li>
            <a
              href="#"
              @click="lastPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">Last Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"
                />
              </svg>
            </a>
          </li>
        </ol>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import constants from '../../constants'
import { useAuth0 } from '@auth0/auth0-vue'
export default {
  name: 'FlagList',
  accessToken: null,
  logged_in: false,
  data() {
    return {
      flags: [],
      first_page_url: null,
      last_page_url: null,
      from: 0,
      to: 0,
      current_page: 0,
      next_page_url: null,
      prev_page_url: null,
      first_page: 0,
      last_page: 0,
      links: [],
      path: null,
      per_page: 0,
      total: 0,
      max_items: 0
    }
  },
  computed: {
    rows() {
      return this.flags.length
    }
  },
  async created() {
    const auth0 = useAuth0()
    this.accessToken = await auth0.getAccessTokenSilently()
    this.getData()
  },
  methods: {
    async getData(url = '') {
      try {
        const apiUrl = `${import.meta.env.VITE_API_URL}/${constants.API_FLAG_LIST}${url}`
        let fetchedData = await axios.get(apiUrl, {
          headers: {
            Authorization: 'Bearer ' + this.accessToken
          }
        })
        this.logged_in = true
        this.flags = fetchedData.data.data.data
        this.first_page_url = fetchedData.data.data.first_page_url
        this.last_page_url = fetchedData.data.data.last_page_url
        this.total = fetchedData.data.data.total
        this.per_page = fetchedData.data.data.per_page
        this.next_page_url = fetchedData.data.data.next_page_url
        this.prev_page_url = fetchedData.data.data.prev_page_url
        this.links = fetchedData.data.data.links
        this.max_items = fetchedData.data.data.links.length - 1
        this.current_page = fetchedData.data.data.current_page
        this.from = fetchedData.data.data.from
        this.to = fetchedData.data.data.to
      } catch (error) {
        console.log(error)
      }
    },
    nextPage() {
      if (this.next_page_url) {
        this.getData(this.next_page_url)
      }
    },
    prevPage() {
      if (this.prev_page_url) {
        this.getData(this.prev_page_url)
      }
    },
    firstPage() {
      if (this.first_page_url) {
        this.getData(this.first_page_url)
      }
    },
    lastPage() {
      if (this.last_page_url) {
        this.getData(this.last_page_url)
      }
    },
    isActive(index) {
      if (index === this.current_page) {
        return 'border-indigo-600 bg-indigo-600  text-white'
      }
      return 'border-gray-100 bg-white  text-gray-900'
    },
    linkPage(index) {
      this.getData(this.links[index].url)
    }
  }
}
</script>
<style scoped>
h1 {
  padding: 2rem;
}
.flag{
  padding-top:2rem;
}
.title{
  padding-top: 1rem;
  inline-size:320px;
  overflow-wrap: break-word;
}
</style>
