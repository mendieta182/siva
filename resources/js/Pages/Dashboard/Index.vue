<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Icon from '@/Shared/Icon.vue'
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  users_count: Number,
  roles_count: Number,
  permissions_count: Number
})

</script>
    
<template>
  <AdminLayout title="AdminLayout">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ $t('Dashboard') }}
      </h2>
      <!-- Cards -->
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <Link :href="route('admin.users.index')"
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $t('Users') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ users_count }}
          </p>
        </div>
        </Link>
        <!-- Card -->
        <Link :href="route('admin.roles.index')"
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"></path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $t('Roles') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ roles_count }}
          </p>
        </div>
        </Link>
        <!-- Card -->
        <Link :href="route('admin.roles.index')"
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $t('Permissions') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ permissions_count }}
          </p>
        </div>
        </Link>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                clip-rule="evenodd"></path>
            </svg>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Pending contacts
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              35
            </p>
          </div>
        </div>
      </div>
      <!-- Incidents asignadas a mí -->
      <div class="items-center w-full px-4 py-4 bg-white rounded-lg shadow-md">
        <div class="container">
          <div class="flex justify-between w-full px-4 py-2">
            <div class="text-lg font-bold text-blue-500">
              Incidencias asignadas a mí
            </div>
            <div class="px-2 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
            </div>
          </div>
          <div class="mt-2 overflow-x-auto">
            <table class="w-full border border-collapse table-auto">
              <thead class="">
                <tr class="text-base font-bold text-left bg-gray-50">
                  <th class="px-4 py-3 border-b-2 border-blue-500">#</th>
                  <th class="px-4 py-3 border-b-2 border-blue-500">Categoría</th>
                  <th class="px-4 py-3 border-b-2 border-blue-500">Severidad</th>
                  <th class="px-4 py-3 border-b-2 border-blue-500">{{ $t('Status') }}</th>
                  <th class="px-4 py-3 border-b-2 border-blue-500">Fecha creación</th>
                  <th class="px-4 py-3 border-b-2 border-blue-500">Resumen</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr class="py-10 border-b border-gray-200 hover:bg-gray-100">                  
                  <td class="px-4 py-4">
                    1
                  </td>
                  <td class="px-4 py-4">
                    480-570-3413
                  </td>
                  <td class="px-4 py-4">
                    MX-8523537435
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Incidents sin asignar -->
      <div class="mt-3 items-center w-full px-4 py-4 bg-white rounded-lg shadow-md">
        <div class="container">
          <div class="flex justify-between w-full px-4 py-2">
            <div class="text-lg font-bold text-red-500">
              Incidencias sin asignar
            </div>
            <div class="px-2 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
            </div>
          </div>
          <div class="mt-2 overflow-x-auto">
            <table class="w-full border border-collapse table-auto">
              <thead class="">
                <tr class="text-base font-bold text-left bg-gray-50">
                  <th class="px-4 py-3 border-b-2 border-red-500">#</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Categoría</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Severidad</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">{{ $t('Status') }}</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Fecha creación</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Resumen</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Acción</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr class="py-10 border-b border-gray-200 hover:bg-gray-100">                  
                  <td class="px-4 py-4">
                    1
                  </td>
                  <td class="px-4 py-4">
                    480-570-3413
                  </td>
                  <td class="px-4 py-4">
                    MX-8523537435
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Incidents asignadas a otros -->
      <div class="mt-3 items-center w-full px-4 py-4 bg-white rounded-lg shadow-md">
        <div class="container">
          <div class="flex justify-between w-full px-4 py-2">
            <div class="text-lg font-bold text-amber-500">
              Incidencias asignadas a otros
            </div>
            <div class="px-2 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
            </div>
          </div>
          <div class="mt-2 overflow-x-auto">
            <table class="w-full border border-collapse table-auto">
              <thead class="">
                <tr class="text-base font-bold text-left bg-gray-50">
                  <th class="px-4 py-3 border-b-2 border-amber-500">#</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Categoría</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Severidad</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">{{ $t('Status') }}</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Fecha creación</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Resumen</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Responsable</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr class="py-10 border-b border-gray-200 hover:bg-gray-100">                  
                  <td class="px-4 py-4">
                    1
                  </td>
                  <td class="px-4 py-4">
                    480-570-3413
                  </td>
                  <td class="px-4 py-4">
                    MX-8523537435
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                  <td class="px-4 py-4">
                    Just Now
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
    
    