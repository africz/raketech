<template>
  <div class="container mx-auto">
    <div class="grid grid-cols-3 gap-2">
      <div v-for="(flag, index) in this.flags" :key="index" class="table-active">
        <img v-bind:src="flag.flag" alt="" />
        <p>{{ flag.name }}</p>
      </div>
    </div>

    <div
      class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
    >
      <div class="flex flex-1 justify-between sm:hidden">
        <a
          href="#"
          class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
          >Previous</a
        >
        <a
          href="#"
          class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
          >Next</a
        >
      </div>
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
              @click="prevPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">Prev Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-3 w-3"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
          </li>

          <div v-for="(link, index) in this.links" :key="index">
            <li v-if="index > 0 && index < this.max_items" v-bind:class="this.isActive(index)">
              <a 
              class="block h-8 w-8 rounded border  text-center leading-8"
              href="#" @click="linkPage(index)">{{ index }}</a>
            </li>
          </div>

          <li>
            <a
              href="#"
              @click="nextPage"
              class="inline-flex h-8 w-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180"
            >
              <span class="sr-only">Next Page</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-3 w-3"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
          </li>
        </ol>

      </div>
    </div>

    <!-- <div class="pagination-area justify-content-between align-items-center">
      <p class="text-paragraph">
        Showing
        <span class="fw-bold"> from {{ this.from }} to {{ this.to }}</span>
        out of <span class="fw-bold">{{ this.total }}</span> results
      </p>
      <nav class="pagination">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="#" @click="firstPage" aria-label="First"> &lt;&lt; </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#" @click="prevPage" aria-label="Previous"> &lt; </a>
          </li>

          <div v-for="(link, index) in this.links" :key="index">
            <li v-if="index > 0 && index < this.max_items" v-bind:class="this.isActive(index)">
              <a class="page-link" href="#" @click="linkPage(index)">{{ index }}</a>
            </li>
          </div>
          <li class="page-item">
            <a class="page-link" href="#" @click="nextPage" aria-label="Next"> &gt; </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#" @click="lastPage" aria-label="Last"> &gt;&gt; </a>
          </li>
        </ul>
      </nav>
    </div> -->
  </div>
</template>
<script>
import axios from 'axios'
import constants from '../../constants'
export default {
  name: 'FlagList',
  count: 0,
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
      max_items: 0,
      count: -1,
      perPage: 3,
      currentPage: 1
    }
  },
  computed: {
    rows() {
      return this.flags.length
    }
  },
  created() {
    this.getData()
  },
  methods: {
    async getData(url = '') {
      try {
        const apiUrl = `${import.meta.env.VITE_API_URL}/${constants.API_FLAG_LIST}${url}`
        console.log('apiUrl', apiUrl)
        let fetchedData = await axios.get(apiUrl)
        this.flags = fetchedData.data.data.data
        console.log('fetchedData:', fetchedData)
        console.log('this flags:', this.flags)

        this.first_page_url = fetchedData.data.data.first_page_url
        console.log('this.first_page_url:', this.first_page_url)
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
      //alert(index+'-'+this.current_page)
      if (index === this.current_page) {
        return 'border-indigo-600 bg-indigo-600  text-white'
      }
      return 'border-gray-100 bg-white  text-gray-900'
    },
    linkPage(index) {
      this.getData(this.links[index].url)
    },
    increment(index) {
      this.count = index + 1
    }
  }
}
</script>

<style scoped></style>
