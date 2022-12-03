<template>
    <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
        <div class="container flex items-center justify-between h-full px-6 mx-auto text-blue-600 dark:text-blue-300">
            <!-- Mobile hamburger -->
            <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-blue"
                @click="toggleSideMenu" aria-label="Menu">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <!-- Search input -->
            <div class="flex justify-center flex-1 lg:mr-32">
                <div class="relative w-full max-w-xl mr-6 focus-within:text-blue-500">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input
                        class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-input"
                        type="text" :placeholder="$t('Search')" aria-label="Search" />
                </div>
            </div>
            <ul class="flex items-center flex-shrink-0 space-x-6">
                <!-- Project menu -->
                <!-- <pre>{{ selected_project_id }}</pre> -->
                <li class="relative" v-role:any="'support'">
                    <select v-if="usePage().props.value.auth.user.selected_project_id != null" id="projects" v-model="selectProject" @change="getProject()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="project in $page.props.auth.user.list_of_projects" :key="project.id"
                            :value="project.id" :selected="selectProject.value === project.id">
                            {{ project.name }}
                        </option>
                    </select>
                </li>
                <!-- <li class="relative" v-role="'client'">
                    <select v-if="usePage().props.value.auth.user.selected_project_id != null" id="projects" v-model="selectProject" @change="getProject()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="project in $page.props.auth.user.list_of_projects" :key="project.id"
                            :value="project.id" :selected="selectProject.value === project.id">
                            {{ project.name }}
                        </option>
                    </select>
                </li> -->
                <span>{{ usePage().props.value.auth.user.name }}</span>
                <li class="relative">
                    <select id="projects" v-role:any="'client|super-admin'" v-model="selectProject" @change="getProject()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="project in $page.props.list_projects" :key="project.id"
                            :value="project.id" :selected="selectProject.value === project.id">
                            {{ project.name }}
                        </option>
                    </select>
                </li>
                <!-- Theme toggler -->
                <Darkmode />
                <!-- Notifications menu -->
                <li class="relative">
                    <button class="align-middle rounded-full focus:shadow-outline-blue focus:outline-none"
                        @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                        v-click-outside="closeNotificationsMenu" aria-label="Notifications" aria-haspopup="true">
                        <Icon name="bell" class="h-5 w-5" />
                        <!-- Notification badge -->
                        <span aria-hidden="true"
                            class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800">
                        </span>
                    </button>
                    <template v-if="isNotificationsMenuOpen">
                        <ul @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                            class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                            aria-label="submenu">
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <span>Messages</span>
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                        13
                                    </span>
                                </a>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <span>Sales</span>
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                        2
                                    </span>
                                </a>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <span>Alerts</span>
                                </a>
                            </li>
                        </ul>
                    </template>
                </li>
                <!-- Language menu -->
                <li class="relative">
                    <button class="align-middle rounded-full focus:shadow-outline-blue focus:outline-none"
                        @click="toggleLanguageMenu" @keydown.escape="closeLanguageMenu"
                        v-click-outside="closeLanguageMenu" aria-label="Language" aria-haspopup="true">
                        <Icon name='es' class="h-5 w-5" v-if="$page.props.lang == 'es'" />
                        <Icon name='en' class="h-5 w-5" v-if="$page.props.lang == 'en'" />
                    </button>
                    <template v-if="isLanguageMenuOpen">
                        <ul @click.away="closeLanguageMenu" @keydown.escape="closeLanguageMenu"
                            class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                            aria-label="submenu">
                            <li class="flex" v-if="$page.props.lang !== 'es'">
                                <Link @click="loadLanguageAsync('es')"
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    :href="route('lang', 'es')">
                                <Icon name="es" class="h-5 w-5" /><span class="ml-1">ES</span>
                                </Link>
                            </li>
                            <li class="flex" v-if="$page.props.lang !== 'en'">
                                <Link @click="loadLanguageAsync('en')"
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    :href="route('lang', 'en')">
                                <Icon name="en" class="h-5 w-5" />
                                <span class="ml-1">EN</span>
                                </Link>
                            </li>
                        </ul>
                    </template>
                </li>
                <!-- Profile menu -->
                <li class="relative">
                    <button class="align-middle rounded-full focus:shadow-outline-blue focus:outline-none"
                        @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                        v-click-outside="closeProfileMenu" aria-haspopup="true">
                        <img class="object-cover w-8 h-8 rounded-full"
                            src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82"
                            alt="" aria-hidden="true" />
                    </button>
                    <template v-if="isProfileMenuOpen">
                        <ul @keydown.escape="closeProfileMenu"
                            class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                            aria-label="submenu">
                            <li class="flex bg-gray-50">
                                <label class="text-center items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="#">                        
                                    <span>{{ usePage().props.value.auth.user.name }}</span>
                                </label>
                            </li>
                            <li class="flex">
                                <Link
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    :href="route('profile.show')">
                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                <span>Profile</span>
                                </Link>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="flex">
                                <Link
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    :href="route('logout')" method="post" as="button">
                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Salir
                                </Link>
                            </li>
                        </ul>
                    </template>
                </li>

                <!-- Dropdown toggle button -->
                <!-- <div class="relative">
                        <JetDropdownCustom align="right" width="30">
                            <template #trigger>
                                <button
                                class="bg-white dark:bg-gray-700 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
                                >
                                    <span class="text-left text-sm flex">
                                        <span class="dark:text-white">ES</span>
                                    </span>
                                    <span v-if="$page.props.locale =='es'" class="text-left text-sm flex">
                                        <span class="dark:text-white">ES</span>
                                    </span>
                                    <span v-if="$page.props.locale =='en'" class="text-left text-sm flex">
                                        <span class="dark:text-white">EN</span>
                                    </span>
                                    <span v-if="$page.props.locale =='fr'" class="text-left text-sm flex">
                                        <span class="dark:text-white">FR</span>
                                    </span>
                                    <svg stroke-width="1.5" viewBox="0 0 24 24" class="line-icon -mr-1 ml-1" style="width: 20px; height: 20px;">             
                                        <path d="M8 10l4 4 4-4"></path>
                                    </svg>
                                </button>
                            </template>

                            <template #content>

                                <Link  class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="text-left">
                                       
                                    </span>
                                    <span class="mx-3 text-sm font-normal">Español</span>
                                </Link>

                                <hr v-if="$page.props.locale =='fr'" class="border-gray-200 dark:border-gray-700 ">
                                <hr v-if="$page.props.locale =='en'" class="border-gray-200 dark:border-gray-700 ">

                                <Link  class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="text-left">
                                       
                                    </span>
                                    <span class="mx-3 text-sm font-normal">Inglés</span>
                                </Link>

                                <hr  class="border-gray-200 dark:border-gray-700 ">

                                <Link class="flex items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="text-left">
                                        
                                    </span>
                                    <span class="mx-3 text-sm font-normal">Francés</span>
                                </Link>

                            </template>
                        </JetDropdownCustom>
                    </div> -->

            </ul>
        </div>
    </header>
</template>
<script setup>

import { Link } from '@inertiajs/inertia-vue3'
import Darkmode from "@/Components/Darkmode.vue"
import Icon from '@/Shared/Icon.vue'
import { loadLanguageAsync } from 'laravel-vue-i18n'
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

const selectProject = computed({
  get() {
    return usePage().props.value.auth.user.selected_project_id
  },
  set(val) {
    usePage().props.value.auth.user.selected_project_id = val
  }
})

const isNotificationsMenuOpen = ref(false)
const isProfileMenuOpen = ref(false)
const isLanguageMenuOpen = ref(false)
// const selectProject = ref(null)


const getProject = () => {
    // Inertia.get(route('admin.projects.selectProject', selected_project_id))
    Inertia.get(route('admin.projects.selectProject', selectProject.value))
}

const toggleNotificationsMenu = () => {
    isNotificationsMenuOpen.value = !isNotificationsMenuOpen.value
}

const toggleLanguageMenu = () => {
    isLanguageMenuOpen.value = !isLanguageMenuOpen.value
}


const toggleProfileMenu = () => {
    isProfileMenuOpen.value = !isProfileMenuOpen.value
}

const closeNotificationsMenu = () => {
    isNotificationsMenuOpen.value = false
}

const closeLanguageMenu = () => {
    isLanguageMenuOpen.value = false
}

const closeProfileMenu = () => {
    isProfileMenuOpen.value = false
}

const closeOnEscape = (e) => {
    if (isNotificationsMenuOpen.value && e.key === 'Escape') {
        isNotificationsMenuOpen.value = false;
    }
    if (isProfileMenuOpen.value && e.key === 'Escape') {
        isProfileMenuOpen.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));


const logout = () => {
    Inertia.post(route('logout'));
};

</script>