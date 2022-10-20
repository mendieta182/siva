<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { ref, toRefs, inject, reactive, watch } from 'vue'
import Icon from '@/Shared/Icon.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

const props = defineProps({
  roles: Object,
  permissions: Object,
  search: String,
  perPage: Number,
})

const roles = toRefs(props).roles
const permissions = toRefs(props).permissions
const swal = inject('$swal')
const loading = ref(false)

const load = () => {
  loading.value = true
}

const search = ref(props.search);
const perPage = ref(props.perPage);
const estadoModalCreate = ref(false);
const estadoModalShow = ref(false)
const estadoModalEdit = ref(false)
const selectedPermissions = ref([])

watch(search, (value) => {
  Inertia.get(route('admin.roles.index'),
    { search: value, perPage: perPage.value },
    {
      preserveState: true,
      replace: true
    });
});



function getRoles() {
  Inertia.get(route('admin.roles.index'),
    { perPage: perPage.value, search: search.value },
    {
      preserveState: true,
      replace: true
    });
}

const destroy = (role) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, eliminar!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      formRole.delete(route('admin.roles.destroy', role));
      swal.fire(
        "Eliminado",
        "Rol ha sido eliminado.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Rol esta a salvo :)",
        "error"
      )
    }
  })
}

const openModalCreate = () => {
  formRole.reset()
  error.name = ''
  error.permissions = ''
  estadoModalCreate.value = true
}

const closeModal = () => {
  estadoModalCreate.value = false
  estadoModalEdit.value = false
  estadoModalShow.value = false
  formRole.reset()
  error.name = ''
  error.permissions = ''
  loading.value = false
}

const showModal = (role) => {
  estadoModalCreate.value = false
  estadoModalShow.value = true
  estadoModalEdit.value = false
  formRole.name = role.name
  selectedPermissions.value = role.permissions.map(item => item.id)
}

const editModal = (role) => {
  estadoModalCreate.value = false
  estadoModalShow.value = false
  estadoModalEdit.value = true
  error.name = ''
  error.permissions = ''
  formRole.id = role.id
  formRole.name = role.name
  selectedPermissions.value = role.permissions.map(item => item.id)
}

const formRole = useForm({
  id: '',
  name: '',
  permissions: []
})

const error = reactive({
  name: '',
  permissions: ''
})

const createRole = () => {
  Inertia.post(route('admin.roles.store'), formRole, {
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
        title: 'Successfully created role'
      })
    },
    onError: errors => {
      error.name = errors.name
      error.permissions = errors.permissions
      loading.value = false
    }
  })
}

const updateRole = () => {
  Inertia.patch(route('admin.roles.update',formRole.id,formRole.permissions=selectedPermissions),formRole, {
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
        title: 'Successfully updated role'
      })
    },
    onError: errors => {
      error.name = errors.name
      error.permissions = errors.permissions
      loading.value = false
    }
  })
}

</script>
  
<template>
  <AdminLayout title="AdminLayout">
    <!-- Content -->
    <div class="container px-6 mx-auto grid">
      <div class="w-full overflow-hidden shadow-xs mt-2">
        <div class="w-full overflow-x-auto">
          <div class="shadow-lg p-4 bg-white dark:bg-gray-700 w-full">
            <!-- Head -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <span class="rounded-xl relative p-2 bg-blue-100">
                  <svg width="25" height="25" viewBox="0 0 256 262" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="xMidYMid">
                    <path
                      d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                      fill="#4285F4">
                    </path>
                    <path
                      d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                      fill="#34A853">
                    </path>
                    <path
                      d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                      fill="#FBBC05">
                    </path>
                    <path
                      d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                      fill="#EB4335">
                    </path>
                  </svg>
                </span>
                <div class="flex flex-col">
                  <span class="font-bold text-md text-black dark:text-white ml-2">
                    {{ $t('Roles') }}
                  </span>
                </div>
              </div>
              <div @click.prevent="openModalCreate"
                class="flex items-center text-gray-400 dark:text-white font-semibold hover:font-bold dark:hover:font-bold hover:text-green-900">
                <button class="p-1 rounded-full text-green-500 dark:text-white">
                  <svg class="h-6 w-6" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                    style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <g>
                      <g>
                        <path
                          d="M257,0C116.39,0,0,114.39,0,255s116.39,257,257,257s255-116.39,255-257S397.61,0,257,0z M392,285H287v107
                                                c0,16.54-13.47,30-30,30c-16.54,0-30-13.46-30-30V285H120c-16.54,0-30-13.46-30-30c0-16.54,13.46-30,30-30h107V120
                                                c0-16.54,13.46-30,30-30c16.53,0,30,13.46,30,30v105h105c16.53,0,30,13.46,30,30S408.53,285,392,285z" />
                      </g>
                    </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                    <g> </g>
                  </svg>
                </button>
                <button class="text-sm uppercase">
                  <span class="">
                    {{ $t('Add') }}
                  </span>
                </button>
              </div>
            </div>
            <!-- End Head -->
            <!-- Search -->
            <div class="flex items-center justify-between mt-2">
              <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Icon name="search" class="h-4 w-4" />
                </div>
                <input
                  class="w-1/3 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                  id="Name" type="text" :placeholder="$t('Name')" v-model="search" />
              </div>
              <div class="flex space-x-3 ml-3">
                <div class="relative">
                  <select v-model="perPage" @change="getRoles"
                    class="inline-flex items-center transition-default whitespace-nowrap text-sm  pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- End Search -->
          </div>
          <!-- Table -->
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3 w-56">{{ $t('Name') }}</th>
                <th class="px-4 py-3">{{ $t('Guard_name') }}</th>
                <th class="px-4 py-3">{{ $t('Created_at') }}</th>
                <th class="px-4 py-3">{{ $t('Permisions') }}</th>
                <th class="px-4 py-3">{{ $t('Actions') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400" v-for="(role,index) in roles.data" key="role.id">
                <td class="px-4 py-3 text-sm">
                  {{ (index+1) + $page.props.roles.current_page * $page.props.roles.per_page -
                  $page.props.roles.per_page }}
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <!-- Avatar with inset shadow -->
                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                      <img class="object-cover w-full h-full rounded-full"
                        src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                        alt="" loading="lazy">
                      <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                    </div>
                    <div>
                      <p class="font-semibold">{{ role.name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ role.guard_name }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ role.created_at }}
                </td>
                <td class="px-4 py-3 text-xs justify-between">
                  <span v-for="(permission,index) in role.permissions" :key="index"
                    class="inline-flex items-center justify-center px-2 py-1 mr-2  font-semibold leading-tight text-amber-700 bg-amber-100 rounded-full dark:bg-amber-700 dark:text-amber-100 md:mb-1">
                    {{ permission.name }}
                  </span>
                </td>
                <td class="py-3 text-sm flex space-x-4">
                  <Icon name="eye" class="h-5 w-5 cursor-pointer text-blue-500" @click="showModal(role)" />
                  <Icon name="edit" class="h-5 w-5 cursor-pointer text-orange-500" @click="editModal(role)" />
                  <Icon name="trash" class="h-5 w-5 cursor-pointer text-red-500" @click="destroy(role)" />
                </td>
              </tr>
            </tbody>
          </table>
          <!-- End Table -->
          <!-- Pagination -->
          <Pagination :data="roles"></Pagination>
          <!-- End Pagination -->
        </div>
      </div>
    </div>
    <!-- End Content -->
    <!-- Create Modal -->
    <jet-dialog-modal v-if="estadoModalCreate == true" :show="estadoModalCreate" @close="estadoModalCreate = false"
      max-width="lg">
      <template #title>
        <button @click="closeModal" type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <div class="flex justify-center">
          <h3 class="ml-2 text-2xl font-bold text-center">New role</h3>
        </div>
      </template>
      <template #content>
        <form class="px-2 bg-white dark:bg-gray-700 rounded" @submit.prevent="createRole">
          <div class="mb-2">
            <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="Name">
              {{ $t('Name') }}
            </label>
            <input v-model="formRole.name" :class="error.name ? 'border-red-500':''"
              class="capitalize bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              id="Name" type="text" :placeholder="$t('Name')" />
            <p v-if="error.name" class="text-xs italic text-red-500">{{ error.name }}</p>
          </div>
          <div class="mb-2">
            <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="role">{{ $t('Permissions') }}</label>
            <div class="grid grid-cols-3 gap-2 bg-gray-100 dark:bg-gray-800 rounded">
              <div v-for="permission in permissions" :key="permission.id">
                <label class="inline-flex items-center text-xs m-2">
                  <input type="checkbox" v-model="formRole.permissions" :class="error.permissions ? 'border-red-500':''"
                    class="form-checkbox rounded" :value="permission.id">
                  <span class="mx-2">{{ permission.name }}</span>
                </label>
              </div>
            </div>
            <p v-if="error.permissions" class="text-xs italic text-red-500 dark:text-red-400">{{ error.permissions }}
            </p>
          </div>
          <div class="flex items-center justify-center">
            <button type="button"
              class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
              @click="closeModal">
              Cancel
            </button>
            <button type="submit" @click="load"
              :disabled="!formRole.name||formRole.processing"
              :class="!formRole.name ? 'disabled:opacity-50 disabled cursor-not-allowed':''"
              class="flex ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Create
            </button>
          </div>
        </form>
      </template>
    </jet-dialog-modal>
    <!-- End Create Modal -->
    <!--  Show Modal -->
    <jet-dialog-modal v-if="estadoModalShow == true" :show="estadoModalShow" @close="estadoModalShow = false"
      max-width="lg">
      <template #title>
        <p class="text-lg flex items-center justify-center font-bold uppercase">Show role</p>
      </template>
      <template #content>
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="Name">
            Name
          </label>
          <span
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
            {{formRole.name}} </span>
        </div>
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="role">Role</label>
          <div class="grid grid-cols-3 gap-2 bg-gray-100 dark:bg-gray-800 rounded">
            <div v-for="role in permissions" :key="role.id">
              <label class="inline-flex items-center text-xs m-2">
                <input type="checkbox" v-model="selectedPermissions" :value="role.id" class="form-checkbox rounded"
                  disabled />
                <span class="mx-2">{{ role.name }}</span>
              </label>
            </div>
          </div>
        </div>
        <div class='flex items-center justify-center'>
          <button
            class="flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full"
            @click="closeModal">
            <span class="text-sm">Close</span>
          </button>
        </div>
      </template>
    </jet-dialog-modal>
    <!-- End Show Modal -->
    <!--  Edit Modal -->
    <jet-dialog-modal v-if="estadoModalEdit == true" :show="estadoModalEdit" @close="estadoModalEdit = false"
      max-width="lg">
      <template #title>
        <p class="text-lg flex items-center justify-center font-bold uppercase">Edit role</p>
      </template>
      <template #content>
        <form class="px-2 bg-white dark:bg-gray-700 rounded" @submit.prevent="updateRole">
          <div class="mb-2">
            <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="Name">
              {{ $t('Name') }}
            </label>
            <input v-model="formRole.name" :class="error.name ? 'border-red-500':''"
              class="capitalize bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              id="Name" type="text" :placeholder="$t('Name')" />
            <p v-if="error.name" class="text-xs italic text-red-500">{{ error.name }}</p>
          </div>
          <div class="mb-2">
            <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="role">Role</label>
            <div class="grid grid-cols-3 gap-2 bg-gray-100 dark:bg-gray-800 rounded">
              <div v-for="role in permissions" :key="role.id">
                <label class="inline-flex items-center text-xs m-2">
                  <input type="checkbox" v-model="selectedPermissions" :class="error.permissions ? 'border-red-500':''"
                    class="form-checkbox rounded" :value="role.id">
                  <span class="mx-2">{{ role.name }}</span>
                </label>
              </div>
            </div>
            <p v-if="error.permissions" class="text-xs italic text-red-500 dark:text-red-400">{{ error.permissions }}
            </p>
          </div>
          <div class="flex items-center justify-center">
            <button type="button"
              class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
              @click="closeModal">
              Cancel
            </button>
            <button type="submit" @click="load"
              :disabled="!formRole.name||formRole.processing"
              :class="!formRole.name ? 'disabled:opacity-50 disabled cursor-not-allowed':''"
              class="flex ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              Update
            </button>
          </div>
        </form>
      </template>
    </jet-dialog-modal>
    <!-- End Edit Modal -->
  </AdminLayout>
</template>
  
  