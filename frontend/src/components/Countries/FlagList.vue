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
        <div>
          <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <a
              @click="prevPage"
              href="#"
              class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
            >
              <span class="sr-only">Previous</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                  fill-rule="evenodd"
                  d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
            <div v-for="(link, index) in this.links" :key="index">
              <a
                v-if="index > 0 && index < this.max_items"
                v-bind:class="this.isActive(index)"
                href="#"
                @click="linkPage(index)"
                class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold  focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >{{ index }}</a
              >
            </div>

            <a
              @click="nextPage"
              href="#"
              class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
            >
              <span class="sr-only">Next</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                  fill-rule="evenodd"
                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
          </nav>
        </div>
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
        return 'bg-indigo-600 focus-visible:outline-indigo-600 text-white'
      }
      return 'bg-white text-black'
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
