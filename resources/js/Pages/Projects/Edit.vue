<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { ref, toRefs, inject, reactive, watch } from 'vue'
import Icon from '@/Shared/Icon.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

const props = defineProps({
    project: Object,
    categories: Object,
    levels: Object,
})

const project = toRefs(props.project)
const categories = toRefs(props).categories
const levels = toRefs(props).levels
const swal = inject('$swal')
const loading = ref(false)

const load = () => {
    loading.value = true
}

const estadoModalEditCategory = ref(false)
const estadoModalEditLevel = ref(false)

const destroyCategory = (category) => {
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
            formCategory.delete(route('admin.categories.destroy', category));
            swal.fire(
                "Eliminado",
                "Categorìa ha sido eliminado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelado",
                "Categorìa esta a salvo :)",
                "error"
            )
        }
    })
}

const destroyLevel = (level) => {
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
            formLevel.delete(route('admin.levels.destroy', level));
            swal.fire(
                "Eliminado",
                "Level ha sido eliminado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelado",
                "Level esta a salvo :)",
                "error"
            )
        }
    })
}

const restore = (project) => {
    swal.fire({
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        width: '400px',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, restaurar!',
        cancelButtonText: "¡No, cancelar!"
    }).then((result) => {
        if (result.isConfirmed) {
            formProject.patch(route('admin.projects.restore', project));
            swal.fire(
                "Restaurado",
                "Proyecto ha sido eliminado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelado",
                "Proyecto esta a salvo :)",
                "error"
            )
        }
    })
}

const closeModal = () => {
    estadoModalEditCategory.value = false
    estadoModalEditLevel.value = false
    // formProject.reset()
    formCategory.name = ''
    formLevel.name = ''
    // formProject.name=''
    // formProject.description=''
    error.name = ''
    error.description = ''
    errorCategory.name = ''
    errorLevel.name = ''
    loading.value = false
}

const editCategoryModal = (category) => {
    estadoModalEditCategory.value = true
    errorCategory.name = ''
    formCategoryModal.id = category.id
    formCategoryModal.project_id = project.id
    formCategoryModal.name = category.name
}

const editLevelModal = (level) => {
    estadoModalEditLevel.value = true
    errorLevel.name = ''
    formLevelModal.id = level.id
    formLevelModal.project_id = project.id
    formLevelModal.name = level.name
}

const formProject = useForm({
    id: project.id,
    name: project.name,
    description: project.description
})

const formCategory = useForm({
    id: '',
    project_id: project.id,
    name: ''
})

const formCategoryModal = useForm({
    id: '',
    project_id: project.id,
    name: ''
})

const formLevelModal = useForm({
    id: '',
    project_id: project.id,
    name: ''
})

const formLevel = useForm({
    id: '',
    project_id: project.id,
    name: ''
})

const error = reactive({
    name: '',
})

const errorCategory = reactive({
    name: '',
})

const errorLevel = reactive({
    name: '',
})

const createLevel = () => {
    Inertia.post(route('admin.levels.store'), formLevel, {
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
                title: 'Successfully created level'
            })
        },
        onError: errors => {
            errorLevel.name = errors.name
            loading.value = false
        }
    })
}

const createCategory = () => {
    Inertia.post(route('admin.categories.store'), formCategory, {
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
                title: 'Successfully created category'
            })
        },
        onError: errors => {
            errorCategory.name = errors.name
            loading.value = false
        }
    })
}

const updateProject = () => {
    Inertia.patch(route('admin.projects.update', formProject.id), formProject, {
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
                title: 'Successfully updated project'
            })
        },
        onError: errors => {
            error.name = errors.name
            error.description = errors.description
            loading.value = false
        }
    })
}

const updateCategory = () => {
    Inertia.patch(route('admin.categories.update', formCategoryModal.id), formCategoryModal, {
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
                title: 'Successfully updated category'
            })
        },
        onError: errors => {
            errorCategory.name = errors.name
            loading.value = false
        }
    })
}

const updateLevel = () => {
    Inertia.patch(route('admin.levels.update', formLevelModal.id), formLevelModal, {
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
                title: 'Successfully updated level'
            })
        },
        onError: errors => {
            errorLevel.name = errors.name
            loading.value = false
        }
    })
}

const restoreCategory = (category) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, restaurar!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      formCategory.patch(route('admin.categories.restore', category));
      swal.fire(
        "Restaurado",
        "Categoría ha sido eliminada.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Categoría esta a salvo :)",
        "error"
      )
    }
  })
}

const restoreLevel = (level) => {
  swal.fire({
    title: 'Estas seguro?',
    text: "¡No podrás revertir esto!",
    width: '400px',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, restaurar!',
    cancelButtonText: "¡No, cancelar!"
  }).then((result) => {
    if (result.isConfirmed) {
      formLevel.patch(route('admin.levels.restore', level));
      swal.fire(
        "Restaurado",
        "Level ha sido eliminado.",
        "success"
      )
    }
    if (result.dismiss === "cancel") {
      swal.fire(
        "Cancelado",
        "Level esta a salvo :)",
        "error"
      )
    }
  })
}

</script>
  
<template>
    <AdminLayout title="AdminLayout">
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
                                        {{ $t('Projects') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- End Head -->
                    </div>
                    <!-- Form Update Project -->
                    <form @submit.prevent="updateProject">
                        <div class="grid gap-6 mb-6 bg-white p-2.5">
                            <div class="relative h-10 input-component">
                                <input v-model="formProject.name" :class="error.name ? 'border-red-500 bg-red-50' : ''"
                                    class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
                                <p v-if="error.name" class="text-xs italic text-red-900">{{ error.name }}</p>
                                <label for="name" class="absolute left-2 transition-all bg-white px-1"
                                    :class="error.name ? 'text-red-500' : ''">
                                    {{ $t('Name') }}
                                </label>
                            </div>
                            <div class="relative h-10 input-component">
                                <input v-model="formProject.description"
                                    :class="error.description ? 'border-red-500 bg-red-50' : ''"
                                    class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
                                <p v-if="error.description" class="text-xs italic text-red-900">{{ error.description }}
                                </p>
                                <label for="description" class="absolute left-2 transition-all bg-white px-1"
                                    :class="error.description ? 'text-red-500' : ''">
                                    {{ $t('Description') }}
                                </label>
                            </div>
                            <div class="flex items-center justify-center mt-1">
                                <button type="button"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                                    @click="closeModal">
                                    Cancel
                                </button>
                                <button type="submit" @click="load"
                                    :disabled="!formProject.name || !formProject.description || formProject.processing"
                                    :class="!formProject.name ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
                                    class="flex ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Form Update Project -->

                    <div class="grid grid-cols-2 gap-4 bg-white">
                        <div class="p-5">
                            <span class="flex font-bold text-md text-black dark:text-white ml-2">
                                {{ $t('Categories') }} <p v-if="errorCategory.name"
                                    class="ml-2 flex items-center text-xs italic text-red-500">({{ errorCategory.name
                                    }})</p>
                            </span>
                            <form @submit.prevent="createCategory">
                                <div class="justify-center mt-2 mb-3 flex w-full">

                                    <input v-model="formCategory.name"
                                        :class="errorCategory.name ? 'border-red-500 bg-red-50' : ''" class="rounded-md py-2 px-6 ml-2 cursor-pointer tracking-wider text-sm inline-table w-3/4
                                    items-center hover:shadow-purple" type="text" :placeholder="$t('Name')" />
                                    <button type="submit" :disabled="!formCategory.name || formCategory.processing"
                                        :class="!formCategory.name ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
                                        class="rounded-md py-2 px-6 ml-2 cursor-pointer tracking-wider text-sm inline-table w-1/4
                                    items-center
                                    text-center bg-blue-600 text-white font-bold hover:bg-blue-600 hover:shadow-purple
                                    ">
                                        Agregar
                                    </button>
                                </div>
                            </form>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">#</th>
                                        <th class="px-4 py-3">{{ $t('Name') }}</th>
                                        <th class="px-4 py-3 text-center">{{ $t('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <tr class="text-gray-700 dark:text-gray-400" v-for="(category, index) in categories"
                                        key="category.id">
                                        <td class="px-4 py-3 text-sm">
                                            <!-- {{ category.id }} -->
                                            {{ (index + 1) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ category.name }}
                                        </td>
                                        <td class="py-3 text-sm flex space-x-4 justify-center">
                                            <Icon v-if="category.deleted_at === null" name="edit" title="Edit"
                                                class="h-5 w-5 cursor-pointer text-orange-500"
                                                @click="editCategoryModal(category)" />
                                            <Icon v-if="category.deleted_at === null" name="trash"
                                                class="h-5 w-5 cursor-pointer text-red-500"
                                                @click="destroyCategory(category)" />
                                            <Icon v-if="category.deleted_at !== null" name="restore"
                                                class="h-5 w-5 cursor-pointer text-green-500"
                                                @click="restoreCategory(category)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-5">
                            <span class="flex font-bold text-md text-black dark:text-white ml-2">
                                {{ $t('Levels') }} <p v-if="errorLevel.name"
                                    class="ml-2 flex items-center text-xs italic text-red-500">({{ errorLevel.name }})
                                </p>
                            </span>
                            <form @submit.prevent="createLevel">
                                <div class="justify-center mt-2 mb-3 flex w-full">

                                    <input v-model="formLevel.name"
                                        :class="errorLevel.name ? 'border-red-500 bg-red-50' : ''" class="rounded-md py-2 px-6 ml-2 cursor-pointer tracking-wider text-sm inline-table w-3/4
                                    items-center hover:shadow-purple" type="text" :placeholder="$t('Name')" />
                                    <button type="submit" 
                                        :disabled="!formLevel.name || formLevel.processing"
                                        :class="!formLevel.name ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
                                        class="rounded-md py-2 px-6 ml-2 cursor-pointer tracking-wider text-sm inline-table w-1/4
                                    items-center
                                    text-center bg-blue-600 text-white font-bold hover:bg-blue-600 hover:shadow-purple
                                    ">
                                        Agregar
                                    </button>
                                </div>
                            </form>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">#</th>
                                        <th class="px-4 py-3">{{ $t('Name') }}</th>
                                        <th class="px-4 py-3 text-center">{{ $t('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <tr class="text-gray-700 dark:text-gray-400" v-for="(level, index) in levels"
                                        key="level.id">
                                        <td class="px-4 py-3 text-sm">
                                            <!-- {{ level.id }} -->
                                            {{ (index + 1) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ level.name }}
                                        </td>
                                        <td class="py-3 text-sm justify-center flex space-x-4">
                                            <Icon v-if="level.deleted_at === null" name="edit" title="Edit"
                                                class="h-5 w-5 cursor-pointer text-orange-500"
                                                @click="editLevelModal(level)" />
                                            <Icon v-if="level.deleted_at === null" name="trash"
                                                class="h-5 w-5 cursor-pointer text-red-500"
                                                @click="destroyLevel(level)" />
                                            <Icon v-if="level.deleted_at !== null" name="restore"
                                                class="h-5 w-5 cursor-pointer text-green-500" @click="restoreLevel(level)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Edit Modal Category -->
        <jet-dialog-modal v-if="estadoModalEditCategory == true" :show="estadoModalEditCategory"
            @close="estadoModalEditCategory = false" max-width="lg">
            <template #title>
                <p class="text-lg flex items-center justify-center font-bold uppercase">Edit Category</p>
            </template>
            <template #content>
                <form class="px-2 bg-white dark:bg-gray-700 rounded" @submit.prevent="updateCategory">
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="Name">
                            {{ $t('Name') }}
                        </label>
                        <input v-model="formCategoryModal.name" :class="errorCategory.name ? 'border-red-500' : ''"
                            class="lowercase  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            id="Name" type="text" :placeholder="$t('Name')" />
                        <p v-if="errorCategory.name" class="text-xs italic text-red-500">{{ errorCategory.name }}</p>
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            @click="closeModal">
                            Cancel
                        </button>
                        <button type="submit" @click="load"
                            :disabled="!formCategoryModal.name || formCategoryModal.processing"
                            :class="!formCategoryModal.name ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
                            class="flex ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
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
        <!-- End Edit Modal Category -->
        <!--  Edit Modal Category -->
        <jet-dialog-modal v-if="estadoModalEditLevel == true" :show="estadoModalEditLevel"
            @close="estadoModalEditLevel = false" max-width="lg">
            <template #title>
                <p class="text-lg flex items-center justify-center font-bold uppercase">Edit Level</p>
            </template>
            <template #content>
                <form class="px-2 bg-white dark:bg-gray-700 rounded" @submit.prevent="updateLevel">
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-white" for="Name">
                            {{ $t('Name') }}
                        </label>
                        <input v-model="formLevelModal.name" :class="errorLevel.name ? 'border-red-500' : ''"
                            class="lowercase  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            id="Name" type="text" :placeholder="$t('Name')" />
                        <p v-if="errorLevel.name" class="text-xs italic text-red-500">{{ errorLevel.name }}</p>
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            @click="closeModal">
                            Cancel
                        </button>
                        <button type="submit" @click="load"
                            :disabled="!formLevelModal.name || formLevelModal.processing"
                            :class="!formLevelModal.name ? 'disabled:opacity-50 disabled cursor-not-allowed' : ''"
                            class="flex ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
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
        <!-- End Edit Modal Category -->
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
  
  s