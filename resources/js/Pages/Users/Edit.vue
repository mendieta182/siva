<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { ref, toRefs, inject, reactive, watch } from 'vue'
import Icon from '@/Shared/Icon.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

const props = defineProps({
    user: Object,
    projects: Object,
    projects_user: Object
})

const user = toRefs(props.user)
// const projectsUser = toRefs(props.projects_user)
const categories = toRefs(props).categories
// const levels = toRefs(props).levels
const swal = inject('$swal')
const loading = ref(false)

const load = () => {
    loading.value = true
}

const estadoModalEditCategory = ref(false)
const estadoModalEditLevel = ref(false)
const selectedProject = ref(0)
const selectedLevel = ref(0)
const levels = ref([])


const getLevels = () => {
    selectedLevel.value = 0
    axios.get('/api/project/' + selectedProject.value + '/levels').then(response => (levels.value = response.data))
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

const formUser = useForm({
    id: user.id,
    name: user.name,
    lastname: user.lastname,
    status: user.status,
    email: user.email
})

const formCategory = useForm({
    id: '',
    // project_id: project.id,
    name: ''
})

const formCategoryModal = useForm({
    id: '',
    // project_id: project.id,
    name: ''
})

const formLevelModal = useForm({
    id: '',
    // project_id: project.id,
    name: ''
})

const formLevel = useForm({
    id: '',
    // project_id: project.id,
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

const formProjectUser = useForm({
    // id: '',
    project_id: selectedProject,
    user_id: user.id,
    level_id: selectedLevel,
})

const assignProjectUser = () => {
    Inertia.post(route('admin.project-user.store'), formProjectUser, {
        preserveScroll: true,
        loading: true,
        onSuccess: () => {
            selectedLevel.value = 0
            selectedProject.value = 0
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
            alert('ya existe un proyecto asociado a usuario.')
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

const destroyProjectUser = (project_user) => {
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
      Inertia.delete(route('admin.project-user.destroy', project_user));
      swal.fire(
        "Eliminado",
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
                                        {{ $t('User') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- End Head -->
                    </div>
                    <!-- Form Update Project -->
                    <div class="grid grid-cols-2 gap-6 mb-6 bg-white p-2.5">
                        <div class="relative h-10 input-component">
                            <input v-model="formUser.name"
                                class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
                            <label for="name" class="absolute left-2 transition-all bg-white px-1">
                                {{ $t('Name') }}
                            </label>
                        </div>
                        <div class="relative h-10 input-component">
                            <input v-model="formUser.lastname"
                                class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
                            <label for="lastname" class="absolute left-2 transition-all bg-white px-1">
                                {{ $t('Lastname') }}
                            </label>
                        </div>
                        <div class="relative h-10 input-component">
                            <input v-model="formUser.email"
                                class="h-full w-full text-sm text-gray-900 border-gray-300 px-2 transition-all border-blue rounded-md" />
                            <label for="email" class="absolute left-2 transition-all bg-white px-1">
                                {{ $t('Email') }}
                            </label>
                        </div>
                        <div class="relative h-10 input-component p-1.5">
                            <label v-if="formUser.status == 1"
                                class="px-2 py-1 text-sm font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ $t('Active') }}
                            </label>
                            <label v-else
                                class="px-2 py-1 text-sm font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                {{ $t('Inactive') }}
                            </label>
                        </div>
                    </div>
                    <!-- End Form Update Project -->

                    <div class="bg-white mb-6">
                        <form class="grid grid-cols-5 gap-4" @submit.prevent="assignProjectUser">
                            <div class="col-span-2 relative h-10 input-component m-4">
                                <select v-model="selectedProject" @change="getLevels"
                                    class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
                                    >
                                    <option selected disabled value='0' class="text-gray-300">--Seleccione--</option>
                                    <option v-for="project in projects" :key="project.id" :value="project.id">{{
                                            project.name
                                    }}</option>
                                </select>
                                <label for="name" class="absolute left-2 transition-all bg-white px-1">
                                    {{ $t('Project') }}
                                </label>
                            </div>
                            <div class="col-span-2 relative h-10 input-component m-4">
                                <select v-model="selectedLevel"
                                    class="inline-flex text-gray-900 items-center transition-default whitespace-nowrap text-sm pl-4 pr-7 py-2 border leading-5 font-medium shadow-sm rounded-md border-gray-300 bg-white">
                                    >
                                    <option selected disabled value='0' class="text-gray-300">--Seleccione--</option>
                                    <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}
                                    </option>
                                </select>
                                <label for="name" class="absolute left-2 transition-all bg-white px-1">
                                    {{ $t('Level') }}
                                </label>
                            </div>
                            <div class="m-4 col-span-1">
                                <div class="mb-3 flex w-full">
                                    <button type="submit" 
                                        class="rounded-md py-2 px-6 ml-2 cursor-pointer tracking-wider text-sm inline-table
                            items-center
                            text-center bg-blue-600 text-white font-bold hover:bg-blue-600 hover:shadow-purple
                            ">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">{{ $t('Project') }}</th>
                                <th class="px-4 py-3">{{ $t('Level') }}</th>
                                <th class="px-4 py-3 text-center">{{ $t('Actions') }}</th>
                            </tr>
                        </thead>
                        <!-- <pre>{{ projects_user }}</pre> -->
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr class="text-gray-700 dark:text-gray-400" v-for="(project_user, index) in projects_user"
                                key="category.id">
                                <td class="px-4 py-3 text-sm">
                                    {{ project_user.project.name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ project_user.level.name }}
                                </td>
                                <td class="py-3 text-sm flex space-x-4 justify-center">
                                    <Icon v-if="project_user.deleted_at === null" name="edit" title="Edit"
                                        class="h-5 w-5 cursor-pointer text-orange-500"
                                        @click="editproject_userModal(project_user)" />
                                    <Icon name="trash" class="h-5 w-5 cursor-pointer text-red-500"
                                        @click="destroyProjectUser(project_user)" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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