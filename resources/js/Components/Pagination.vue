<script setup>
  import { Link }  from '@inertiajs/inertia-vue3';
  
  defineProps({
      data: {
          type: Object,
          default: () => ({}),
      },
  });
  </script>
  
  
  <template>
    <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <span class="flex items-center col-span-3">
        Showing {{ data.from }}-{{ data.to }} of {{ data.total }}
      </span>
      <span class="col-span-2"></span>  
      <!-- Pagination -->
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <nav aria-label="Table navigation">      
          <ul class="inline-flex items-center">
              <Link type="button" v-if="data.current_page > 1" class="px-1 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Previous" :href="data.first_page_url">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7">
                    </polyline>
                </svg>
              </Link>
              <Link type="button" v-if="data.current_page > 1"
                class="px-1 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Previous" :href="data.prev_page_url">
                <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                  <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
              </Link>
            <li v-for="(link, k) in data.links.slice(1,-1)">
            <Link
              type="button"                
              :key="k"
              class="px-1.5 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
              :class="{'text-white transition-colors duration-150 bg-blue-600 border border-r-0 border-blue-600': link.active}"
              :href="link.url"
              v-html="link.label"
            />
            </li>
            <Link v-if="data.current_page<data.last_page" :href="data.next_page_url" type="button" 
              class="px-1 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Next">
              <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
              </svg>
            </Link>
            <Link type="button" v-if="data.current_page<data.last_page" 
              class="px-1 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Last Page"
              :href="data.last_page_url">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                  class="w-4 h-4"><polyline points="13 17 18 12 13 7">
                  </polyline><polyline points="6 17 11 12 6 7">
                  </polyline>
              </svg>
            </Link>
          </ul>
        </nav>
      </span>
    </div>
  </template>
  