<template>
  <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
      <div class="py-4 text-gray-500 dark:text-gray-400">
        <div class="flex items-center justify-items-center justify-center">
          <svg class="w-8 h-8 fill-current dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
        </svg>
        <span class="ml-2 text-sm font-bold dark:text-white">The App</span>
        </div>
        <ul class="mt-5">          
          <li class="relative px-6 py-3 hover:text-gray-800" 
            :class="route().current('admin.dashboard.*') ? 'bg-gray-200 text-gray-800':'hover:bg-blue-50'">
            <span v-if="route().current('admin.dashboard.*')" 
              class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true">
            </span>
            <Link :href="route('admin.dashboard.index')"              
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              >
              <Icon name="home" class="h-5 w-5" />
              <span class="ml-4">{{ $t("Dashboard") }}</span>
            </Link>
          </li>
        </ul>
        <p class="p-2 ml-3 items-center text-center font-bold text-xs uppercase text-gray-900 dark:text-blue-200">{{ $t("Administration") }}</p>
        <ul>
          <li class="relative px-6 py-3 hover:text-gray-800"
              :class="route().current('admin.users.*') ? 'bg-gray-200 text-gray-800':'hover:bg-blue-50'">
            <span v-if="route().current('admin.users.*')" 
              class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true">
            </span>
            <Link :href="route('admin.users.index')" 
              class="inline-flex items-center w-full text-sm font-semibold"
              >                
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              <span class="ml-4">{{ $t("Users") }}</span>
            </Link>
          </li>
          <li class="relative px-6 py-3 hover:text-gray-800"
            :class="route().current('admin.roles.*') ? 'bg-gray-200 text-gray-800':'hover:bg-blue-50'">
            <span v-if="route().current('admin.roles.*')" 
              class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true">
            </span>
            <Link :href="route('admin.roles.index')" 
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              >
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
              </svg>
              <span class="ml-4">{{ $t("Roles") }}</span>
            </Link>
          </li>          
          <li class="relative px-6 py-3"
            :class="route().current('admin.permissions.*') ? 'bg-gray-200 text-gray-800':'hover:bg-blue-50'">
            <span v-if="route().current('admin.permissions.*')" 
              class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true">
            </span>
            <Link :href="route('admin.permissions.index')" 
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              > 
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 55.395 57.691" viewBox="0 0 55.395 57.691"><path fill="none" stroke="#44444d" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3.692" d="M33.577,33.803c1.839,5.434,0.878,12.664-3.688,17.229c-6.419,6.42-16.815,6.418-23.231,0.002C0.243,44.619,0.24,34.221,6.66,27.802c4.578-4.575,11.743-5.604,17.184-3.752"/><path fill="none" stroke="#44444d" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3.692" d="M18.01 39.682c1.628 1.627 1.628 4.27 0 5.898-1.628 1.625-4.27 1.625-5.897-.002-1.627-1.627-1.627-4.27 0-5.896C13.741 38.055 16.382 38.055 18.01 39.682zM53.44 9.359c.406 2.838-.39 4.966-1.403 5.978-.981.981-3.402-.403-4.298.495-.806.803.148 3.655-.493 4.295-.966.969-3.188-.613-4.296.491-.651.651.164 3.642-.489 4.295-.594.595-3.327-.477-4.299.494-.933.935.141 3.663-.492 4.298-2.19 2.192-4.048 4.047-4.048 4.047M23.95 24.1c6.629-6.629 18.261-18.259 20.973-20.971 2.156-2.157 5.193-1.559 6.671 1.517"/><line x1="28.822" x2="51.594" y1="27.417" y2="4.646" fill="none" stroke="#44444d" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3.692"/></svg>
              <span class="ml-4">{{ $t("Permissions") }}</span>
          </Link>
          </li>
        </ul>
        <div class="px-6 my-6">
          <button
            class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
            Create account
            <span class="ml-2" aria-hidden="true">+</span>
          </button>
        </div>
      </div>º 
  </aside>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  import Icon from '@/Shared/Icon.vue'    

 
  
</script>