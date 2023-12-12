<template>
  <b-container>
    <b-row v-for="(flag, index) in this.flags" :key="index" class="table-active">
      <b-col lg="2"></b-col>
      <b-col lg="4">
        <b-img :count="increment()" v-bind:src="flag.flag" />
        <p>{{index+'.) '+ flag.name }}</p>
      </b-col>
      <b-col lg="4">
        <b-img v-bind:src="flag.flag" />
        <p>{{ index+'.) '+ flag.name}}</p>
      </b-col>
      <b-col lg="2"></b-col>
    </b-row>

    <div
      class="pagination-area d-md-flex mt-15 mt-sm-20 mt-md-25 justify-content-between align-items-center"
    >
      <p class="mb-0 text-paragraph">
        Showing
        <span class="fw-bold"> from {{ this.from }} to {{ this.to }}</span>
        out of <span class="fw-bold">{{ this.total }}</span> results
      </p>
      <nav class="mt-15 mt-md-0">
        <ul class="pagination mb-0">
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
    </div>
  </b-container>
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
    async getData(url="") {
      try {
        const apiUrl = `${import.meta.env.VITE_API_URL}/${constants.API_FLAG_LIST}${url}`
        console.log('apiUrl',apiUrl)
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
        return 'page-item active'
      }
      return 'page-item'
    },
    linkPage(index) {
      this.getData(this.links[index].url)
    },
    increment() {
      // console.log('this.count',this.count)
      // console.log('this.flags.length-1',(this.flags.length-1))
      if (this.count < (this.flags.length*2)-1) {
        this.count++
      }
    }
  }
}
</script>
