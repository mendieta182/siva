<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Icon from '@/Shared/Icon.vue'
import { Link } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import { ref, toRefs, inject, computed, reactive, watch, useTransitionState } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'





const props = defineProps({
  users_count: Number,
  roles_count: Number,
  permissions_count: Number,
  my_incidents: Object,
  pending_incidents: Object,
  incidents_by_me: Object,
  categories: Object
})

const estadoModalShow = ref(false);
const estadoModalEdit = ref(false);
const swal = inject('$swal')
const loading = ref(false)

const load = () => {
  loading.value = true
}

const showModal = (incident) => {
  estadoModalShow.value = true
  estadoModalEdit.value = false
  formIncident.id = incident.id
  formIncident.title = incident.title
  formIncident.description = incident.description
  formIncident.created_at = incident.created_at
  formIncident.severity = incident.severity_full
  formIncident.category_id = incident.category.name
  formIncident.project_id = incident.project.name
  formIncident.support_id = incident.support_full
  formIncident.active = incident.state
  formIncident.state = incident.state
  formIncident.level_id = incident.level.name
}

const editModal = (incident) => {
  error.title = ''
  error.description = ''
  error.category_id = ''
  error.severity = ''
  loading.value = false
  estadoModalShow.value = false
  estadoModalEdit.value = true
  formIncident.id = incident.id
  formIncident.title = incident.title
  formIncident.description = incident.description
  formIncident.severity = incident.severity
  formIncident.category_id = incident.category.id
  formIncident.category_name = incident.category.name
}

const formIncident = useForm({
  id: '',
  title: '',
  description: '',
  severity: '',
  category_id: '',
  support_id: '',
  level_id: '',
  active: '',
})

const error = reactive({
  title: '',
  description: '',
  severity: '',
  category_id: ''
})

const attend = (incident) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, atender!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      closeModal()
      formIncident.patch(route('incidents.attend', incident));
      swal.fire(
        "Atendido",
        "Incidente ha sido atendido.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Incidente esta a salvo :)",
        "error"
      )
    }
  })
}

const solve = (incident) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, resuelto!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      closeModal()
      formIncident.patch(route('incidents.solve', incident));
      swal.fire(
        "Resuelto",
        "Incidente ha sido resuelto.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Incidente esta a salvo :)",
        "error"
      )
    }
  })
}

const open = (incident) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, abrir!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      closeModal()
      formIncident.patch(route('incidents.open', incident));
      swal.fire(
        "Abierto",
        "Incidente ha sida abierta.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Incidente esta a salvo :)",
        "error"
      )
    }
  })
}

const nextLevel = (incident) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, derivar!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      closeModal()
      formIncident.patch(route('incidents.nextLevel', incident));
      swal.fire(
        "Derivado",
        "Incidente ha sido derivado.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Incidente esta a salvo :)",
        "error"
      )
    }
  })
}

const closeModal = () => {
  estadoModalShow.value = false
  estadoModalEdit.value = false
  formIncident.reset()
  error.title = ''
  error.description = ''
  error.category_id = ''
  error.severity = ''
  loading.value = false
}

const updateIncident = () => {
  Inertia.patch(route('incidents.update',formIncident.id),formIncident, {
    preserveScroll: true,
    loading: true,
    onSuccess: () => {
      closeModal()
      const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', swal.stopTimer)
          toast.addEventListener('mouseleave', swal.resumeTimer)
        }
      })
      Toast.fire({
        icon: 'success',
        title: 'Successfully updated incident'
      })
    },
    onError: errors => {
      error.title = errors.title
      error.description = errors.description
      error.severity = errors.severity
      error.category_id = errors.category_id
      loading.value = false
    }
  })
}

</script>
    
<template>
  <AdminLayout title="AdminLayout">
    <div class="container px-6 mx-auto grid">
      <!-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ $t('Dashboard') }}
      </h2> -->
      <!-- Cards -->
      <div v-role="'super-admin'" class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
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
      <div v-role="'support'" class="items-center w-full mt-2 p-4 bg-white rounded-lg shadow-md">
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
                  <th class="px-4 py-3 border-b-2 border-blue-500">{{ $t('Title') }}</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr v-for="incident in my_incidents" key="incident.id"
                  class="py-10 border-b border-gray-200 hover:bg-gray-100">
                  <td class="px-4 py-4">
                    <!-- {{ incident.id }} -->
                    <button class="p-1 text-white bg-blue-500 rounded-md hover:bg-blue-600" alt="Show"
                      @click="showModal(incident)">
                      <Icon name="eye" class="h-4 w-4" />
                    </button>
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.category.name }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.severity_full }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.state }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.created_at }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.title_short }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Incidents sin asignar -->
      <div v-role:any="'client|support'" class="mt-3 items-center w-full px-4 py-4 bg-white rounded-lg shadow-md">
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
                  <th class="px-4 py-3 border-b-2 border-red-500">Título</th>
                  <th class="px-4 py-3 border-b-2 border-red-500">Acción</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr v-for="incident in pending_incidents" key="incident.id"
                  class="py-10 border-b border-gray-200 hover:bg-gray-100">
                  <td class="px-4 py-4">
                    <!-- {{ incident.id }} -->
                    <button class="p-1 text-white bg-orange-500 rounded-md hover:bg-orange-600"
                      @click="showModal(incident)">
                      <Icon name="eye" class="h-4 w-4" />
                    </button>
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.category.name }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.severity_full }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.state }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.created_at }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.title_short }}
                  </td>
                  <td class="px-4 py-4 flex">
                    <button class="p-2 rounded text-white font-bold bg-orange-500 text-sm" @click="showModal(incident)">
                      <Icon name="eye" class="h-5 w-5 items-center justify-around" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Incidents asignadas por mi -->
      <div v-role:any="'super-admin|support|client'"
        class="mt-3 items-center w-full px-4 py-4 bg-white rounded-lg shadow-md">
        <div class="container">
          <div class="flex justify-between w-full px-4 py-2">
            <div class="text-lg font-bold text-amber-500">
              Incidencias asignadas por mi
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
                  <th class="px-4 py-3 border-b-2 border-amber-500">Título</th>
                  <th class="px-4 py-3 border-b-2 border-amber-500">Responsable</th>
                </tr>
              </thead>
              <tbody class="text-sm font-normal text-gray-700">
                <tr v-for="incident in incidents_by_me" key="incident.id"
                  class="py-10 border-b border-gray-200 hover:bg-gray-100">
                  <td class="px-4 py-4 flex">
                    <button class="p-1 text-white bg-amber-500 rounded-md hover:bg-amber-600"
                      @click="showModal(incident)">
                      <Icon name="eye" class="h-4 w-4" />
                    </button>
                    <button class="ml-1 p-1 text-white bg-indigo-500 rounded-md hover:bg-indigo-600"
                      @click="editModal(incident)">
                      <Icon name="edit" class="h-4 w-4" />
                    </button>
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.category.name }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.severity_full }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.state }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.created_at }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.title_short }}
                  </td>
                  <td class="px-4 py-4">
                    {{ incident.support_full }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!--  Show Modal -->
    <jet-dialog-modal v-if="estadoModalShow == true" :show="estadoModalShow" @close="estadoModalShow = false"
      max-width="lg">
      <template #title>
        <p class="text-lg flex items-center justify-center font-bold uppercase">Show incident</p>
      </template>
      <template #content>
        <div class="grid grid-cols-4">
          <div class="border border-r-0 p-1 font-bold bg-gray-50">{{ $t('Project') }}</div>
          <div class="border p-2">{{ formIncident.project_id }}</div>
          <div class="border border-l-0 border-r-0 p-2 font-bold bg-gray-50">{{ $t('Category') }}</div>
          <div class="border p-2">{{ formIncident.category_id }}</div>
          <div class="border border-t-0 border-r-0 p-2 font-bold bg-gray-50">{{ $t('Severity') }}</div>
          <div class="border border-t-0 p-2">{{ formIncident.severity }}</div>
          <div class="border border-l-0 border-t-0 border-r-0 p-2 font-bold bg-gray-50">{{ $t('State') }}</div>
          <div class="border border-t-0 p-2">{{ formIncident.active }}</div>
          <div class="border border-t-0 border-r-0 p-2 font-bold bg-gray-50">Nivel</div>
          <div class="border border-t-0 p-2">{{ formIncident.level_id }}</div>
          <div class="border border-l-0 border-t-0 border-r-0 p-2 font-bold bg-gray-50">Fecha envío</div>
          <div class="border border-t-0 p-2">{{ formIncident.created_at }}</div>
          <div class="border border-t-0 border-r-0 p-2 font-bold bg-gray-50">Asignada a:</div>
          <div class="border border-t-0 p-2 col-span-3">{{ formIncident.support_id }}</div>
        </div>
        <div class="grid grid-cols-4 my-3">
          <div class="border border-r-0 p-2 font-bold bg-gray-50">{{ $t('Title') }}</div>
          <div class="border p-2 col-span-3">{{ formIncident.title }}</div>
          <div class="border border-r-0 border-t-0 p-2 font-bold bg-gray-50">{{ $t('Description') }}</div>
          <div class="border border-t-0 p-2 col-span-3">{{ formIncident.description }}</div>
        </div>
        <div class='flex items-center justify-center p-2 space-x-1'>
          <button v-permission="'incident_update'" v-if="formIncident.state != 'Asignado' && formIncident.state != 'Resuelto'"
            class="flex items-center justify-center  bg-violet-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            @click="attend(formIncident.id)">
            <span class="text-sm">Atender</span>
          </button>
          <button v-role:any="'client|support'" v-if="formIncident.state == 'Resuelto'"
            class="flex items-center justify-center bg-orange-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            @click="open(formIncident.id)">
            <span class="text-sm">Abrir</span>
          </button>
          <button v-if="formIncident.state != 'Resuelto' && formIncident.state != 'Pendiente'"
            class="flex items-center justify-center bg-green-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            @click="solve(formIncident.id)">
            <span class="text-sm">Resuelto</span>
          </button>
          <!-- <button v-role="'support'"
            class="flex items-center justify-center bg-amber-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            @click="closeModal">
            <span class="text-sm">Editar</span>
          </button> -->
          <button v-role="'support'" v-if="formIncident.state == 'Asignado'"
            class="flex items-center justify-center bg-red-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            @click="nextLevel(formIncident.id)">
            <span class="text-sm">Derivar</span>
          </button>
        </div>
      </template>
    </jet-dialog-modal>
    <!-- End Show Modal -->
    <!--  Edit Modal -->
    <jet-dialog-modal v-if="estadoModalEdit == true" :show="estadoModalEdit" @close="estadoModalEdit = false"
      max-width="lg">
      <template #title>
        <p class="text-lg flex items-center justify-center font-bold uppercase">Edit incident</p>
      </template>
      <template #content>
        <!-- <div class="flex justify-center"> -->
        <form class="h-max w-full" @submit.prevent="updateIncident">
          <!-- <div
              class='border-2 border-t-blue-500 mt-2 max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto flex flex-col p-5'> -->
          <!-- <h3 class="text-2xl text-center font-bold mb-4">{{ $t('Incident') }}</h3> -->
          <!-- This is the select category -->
          <div class="relative h-10 input-component mb-6">
            <select v-model="formIncident.category_id"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
              >
              <option disabled value='' class="text-gray-300">--Seleccione--</option>
              <option v-for="category in categories" key="category.id" :value="category.id"
              :selected="selected = formIncident.category_id">{{ category.name }}</option>
            </select>
            <label for="name" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Category') }}
            </label>
          </div><!-- This is the select severity -->
          <div class="relative h-10 input-component mb-6">
            <select v-model="formIncident.severity"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
              >
              <option disabled value='' class="text-gray-300">--Seleccione--</option>
              <option value="B" :selected="formIncident.severity === 'B'">Baja</option>
              <option value="N" :selected="formIncident.severity === 'N'">Normal</option>
              <option value="A" :selected="formIncident.severity === 'A'">Alta</option>
            </select>
            <label for="name" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Severity') }}
            </label>
          </div>
          <!-- This is the input title -->
          <div class="relative h-10 input-component mb-6">
            <input v-model="formIncident.title" :class="error.title ? 'border-red-500 bg-red-50' : ''"
              class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
            <p v-if="error.title" class="text-xs italic text-red-900">{{ error.title }}</p>
            <label for="title" class="absolute left-2 transition-all bg-white px-1"
              :class="error.title ? 'text-red-500' : ''">
              {{ $t('Title') }}
            </label>
          </div>
          <!-- This is the textarea description -->
          <div class="relative input-component mb-6">
            <textarea id="description" v-model="formIncident.description"
              :class="error.description ? 'border-red-500 bg-red-50' : ''"
              class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              rows="3" />
            <p v-if="error.description" class="text-xs italic text-red-900">{{ error.description }}</p>
            <label for="description" class="absolute left-2 transition-all bg-white px-1"
              :class="error.description ? 'text-red-500' : ''">
              {{ $t('Description') }}
            </label>
          </div>
          <!-- This is the button -->
          <div class="flex items-center justify-center space-x-4">
            <button type="button"
              class="w-full px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
              @click="closeModal">
              {{ $t('Cancel') }}
            </button>
            <button type="submit" @click="load"
              :disabled="!formIncident.category_id || !formIncident.severity || !formIncident.title || !formIncident.description || formIncident.processing"
              :class="!formIncident.category_id || !formIncident.severity || !formIncident.title || !formIncident.description ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
              class="w-full uppercase justify-center text-white leading-tight bg-blue-600 hover:bg-blue-800 focus:outline-none font-medium rounded text-xs inline-flex items-center px-6 py-2.5 text-center">
              <svg v-if="loading" aria-hidden="true" role="status"
                class="inline mr-2 w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                  fill="currentColor" />
                <path
                  d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                  fill="#1C64F2" />
              </svg>
              {{ $t('Update') }}
            </button>
          </div>
          <!-- </div> -->
        </form>
      </template>
    </jet-dialog-modal>
    <!-- End Edit Modal -->
  </AdminLayout>
</template>

<style>
label {
  top: 0%;
  transform: translateY(-50%);
  font-size: 11px;
  color: rgba(37, 99, 235, 1);
  font-weight: bold;
}

.empty input:not(:focus)+label {
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
}

input:not(:focus)+label {
  /* color: rgba(70, 70, 70, 1); */
  color: rgba(37, 99, 235, 1);
  font-weight: bold;
}

input {
  border-width: 1px;
}

input:focus {
  outline: none;
  border-color: rgba(37, 99, 235, 1);
  /* font-weight: bold; */
}

.empty textarea:not(:focus)+label {
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
}

textarea:not(:focus)+label {
  /* color: rgba(70, 70, 70, 1); */
  color: rgba(37, 99, 235, 1);
  font-weight: bold;
}

textarea {
  border-width: 1px;
}

textarea:focus {
  outline: none;
  border-color: rgba(37, 99, 235, 1);
  /* font-weight: bold; */
}

.empty select:not(:focus)+label {
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
}

select:not(:focus)+label {
  /* color: rgba(70, 70, 70, 1); */
  color: rgba(37, 99, 235, 1);
  font-weight: bold;
}

select {
  border-width: 1px;
}

select:focus {
  outline: none;
  border-color: rgba(37, 99, 235, 1);
  /* font-weight: bold; */
}
</style>