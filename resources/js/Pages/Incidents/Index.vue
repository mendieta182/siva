<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, toRefs, inject, reactive, watch} from 'vue'
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
    <div class="flex justify-center h-screen">
      <form class="h-max w-full" @submit.prevent="createIncident">
        <div
          class='border-2 border-t-blue-500 mt-2 max-w-sm bg-white shadow-md rounded-lg overflow-hidden mx-auto flex flex-col p-5'>
          <h3 class="text-2xl text-center font-bold mb-4">{{ $t('Incident') }}</h3>
          <!-- This is the select category -->
          <div class="relative h-10 input-component mb-5">
            <select v-model="formIncident.category_id"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 text-gray-500 bg-white">
              >
              <option selected disabled value='' class="text-gray-300">--Seleccione--</option>
              <option v-for="category in categories" key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            <label for="name" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Category') }}
            </label>
          </div><!-- This is the select severity -->
          <div class="relative h-10 input-component mb-5">
            <select v-model="formIncident.severity"
              class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 text-gray-500 bg-white">
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
          <div class="relative h-10 input-component mb-5">
            <input v-model="formIncident.title" :class="error.title ? 'border-red-500 bg-red-50':''"
              class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
            <p v-if="error.title" class="text-xs italic text-red-500">{{ error.title }}</p>
            <label for="name" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Title') }}
            </label>
          </div>
          <!-- This is the textarea description -->
          <div class="relative h-10 input-component mb-5">
            <textarea id="description" v-model="formIncident.description"
              :class="error.description ? 'border-red-500 bg-red-50':''"
              class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              rows="3" />
            <p v-if="error.description" class="text-xs italic text-red-500">{{ error.description }}</p>
            <label for="description" class="absolute left-2 transition-all bg-white px-1">
              {{ $t('Description') }}
            </label>
          </div>
          <!-- This is the button -->
          <div class="flex items-center justify-center mt-10">
            <button type="button"
              class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
              @click="closeModal">
              {{ $t('Cancel') }}
            </button>
            <button type="submit" @click="load"
              :disabled="!formIncident.category_id||!formIncident.severity||!formIncident.title||!formIncident.description||formIncident.processing"
              :class="!formIncident.category_id||!formIncident.severity||!formIncident.title||!formIncident.description ? 'disabled:opacity-50 disabled cursor-not-allowed':''"
              class="text-white bg-blue-600 hover:bg-blue-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
              <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
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
  