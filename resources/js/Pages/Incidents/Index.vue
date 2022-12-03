<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, toRefs, inject, reactive, watch } from 'vue'

import Icon from '@/Shared/Icon.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

const props = defineProps({
  categories: Object,
})

const categories = toRefs(props).categories
const swal = inject('$swal')
const loading = ref(false)

const load = () => {
  loading.value = true
}

const closeModal = () => {
  formIncident.reset()
  error.title = ''
  error.description = ''
  loading.value = false
}

const formIncident = useForm({
  id: '',
  category_id: '',
  severity: '',
  title: '',
  description: ''
})

const error = reactive({
  title: '',
  description: '',
  category_id: '',
  severity: '',
})

const createIncident = () => {
  Inertia.post(route('incidents.store'), formIncident, {
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
        title: 'Successfully created incident'
      })
    },
    onError: errors => {
      error.title = errors.title
      error.description = errors.description
      error.category_id = errors.category_id
      error.severity = errors.severity

      loading.value = false
    }
  })
}
</script>
  
<template>
  <AdminLayout title="AdminLayout">
    <!-- Content -->
    <div class="flex justify-center">
      <form class="h-max w-full" @submit.prevent="createIncident">
        <div
          class='border-2 border-t-blue-500 mt-2 max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto flex flex-col p-5'>
          <h3 class="text-2xl text-center font-bold mb-4">{{ $t('Incident') }}</h3>
          <!-- This is the select category -->
          <div class="relative h-10 input-component mb-6">
            <select v-model="formIncident.category_id"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
              >
              <option selected disabled value='' class="text-gray-300">--Seleccione--</option>
              <option v-for="category in categories" key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            <label for="name" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Category') }}
            </label>
          </div><!-- This is the select severity -->
          <div class="relative h-10 input-component mb-6">
            <select v-model="formIncident.severity"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
              >
              <option selected disabled value='' class="text-gray-300">--Seleccione--</option>
              <option value="B" :selected="selected === 'B'">Baja</option>
              <option value="N" :selected="selected === 'N'">Normal</option>
              <option value="A" :selected="selected === 'A'">Alta</option>
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
              {{ $t('Create') }}
            </button>
          </div>
        </div>
      </form>
    </div>
    <!-- End Content -->
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
  