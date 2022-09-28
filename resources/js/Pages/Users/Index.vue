<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { toRefs, inject } from 'vue'
import Icon from '@/Shared/Icon.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
    users: Object,
})

const form = useForm();
const users = toRefs(props).users
const swal = inject('$swal')

function destroy(user) {
    // if (confirm("Are you sure you want to Delete")) {
    //     form.delete(route('admin.users.destroy', user));
    // }
    swal.fire({        
        // title: frenchkiss.t('title', {}, lang),
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        width: '400px',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: "¡No, cancelar!"
    }).then((result)=>{
        if (result.isConfirmed){
          // Inertia.patch(route('admin.users.inactivate',user)),
          form.delete(route('admin.users.destroy', user));
          swal.fire(
                "Eliminado",
                "Usuario ha sido eliminado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelado",
                "Usuario esta a salvo :)",
                "error"
            )
        }
    })
}

// function inactivateUser(user) {
//   form.patch(route('admin.users.inactivate',user), {
//     preserveScroll:true                            
//   })
// frenchkiss.set('en', { 
//   title: 'Are you sure?',
//   text: "User will not be able to login!",
//   confirmButtonText: 'Yes, inactivate it!',
//   cancelButtonText: "No, cancel!",
//   Inactivated: "Inactivated!"
// })
// frenchkiss.set('es', { 
//   title: 'Estas seguro?',
//   text: "Usuario no podrá iniciar sesión!",
//   confirmButtonText: '¡Sí, desactívalo!',
//   cancelButtonText: "¡No, cancelar!" ,
//   Inactivated: "Inactivado!"
// })
// frenchkiss.locale('es');
// frenchkiss.fallback('en');

// const inactivateUser = (user, lang) => {
const inactivateUser = (user) => {
  // Inertia.patch(route('admin.users.inactivate',user))
  swal.fire({        
        // title: frenchkiss.t('title', {}, lang),
        title: 'Estas seguro?',
        text: "Usuario no podrá iniciar sesión!",
        width: '400px',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, desactívalo!',
        cancelButtonText: "¡No, cancelar!"
    }).then((result)=>{
        if (result.isConfirmed){
          Inertia.patch(route('admin.users.inactivate',user)),
          swal.fire(
                "Inactivado",
                "Usuario ha sido inactivado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelado",
                "Usuario esta a salvo :)",
                "error"
            )
        }
    })
}

const activateUser = (user) => {
  // Inertia.patch(route('admin.users.activate',user))
  swal.fire({
        title: 'Estas seguro?',
        text: "Usuario ya podrá iniciar sesión!",
        width: '400px',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, actívalo!',
        cancelButtonText: "¡No, cancelar!"
    }).then((result)=>{
        if (result.isConfirmed){
          Inertia.patch(route('admin.users.activate',user)),
          swal.fire(
                "Activado",
                "Usuario ha sido activado.",
                "success"
            )
        }
        if (result.dismiss === "cancel") {
          swal.fire(
                "Cancelado",
                "Usuario esta a salvo :)",
                "error"
            )
        }
    })
}

// function activateUser(user) {
//   form.patch(route('admin.users.activate',user), {
//     preserveScroll:true                            
//   })
// }

</script>

<template>
    <AdminLayout title="AdminLayout">
        <div class="container px-6 mx-auto grid">
            <!-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              {{ $t('Users') }}
            </h2>             -->
            <!-- CTA -->
            <!-- <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple" href="https://github.com/estevanmaito/windmill-dashboard">
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span>Star this project on GitHub</span>
              </div>
              <span>View more →</span>
            </a> -->
            

            <!-- New Table -->
            <div class="w-full overflow-hidden shadow-xs mt-2">
              <div class="w-full overflow-x-auto">
                <div class="shadow-lg p-4 bg-white dark:bg-gray-700 w-full">
                  <div class="flex items-center justify-between">
                      <div class="flex items-center">
                          <span class="rounded-xl relative p-2 bg-blue-100">
                              <svg width="25" height="25" viewBox="0 0 256 262" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                                  <path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4">
                                  </path>
                                  <path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853">
                                  </path>
                                  <path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05">
                                  </path>
                                  <path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335">
                                  </path>
                              </svg>
                          </span>
                          <div class="flex flex-col">     
                              <span class="font-bold text-md text-black dark:text-white ml-2">
                                  {{ $t('Users') }}
                              </span>
                              <span class="text-sm text-gray-500 dark:text-white ml-2">
                                  Showing {{$page.props.users.from}} - {{$page.props.users.to}} of {{$page.props.users.total}}
                              </span>
                          </div>
                      </div>
                      <div @click.prevent="openModalCreate" class="flex items-center text-gray-400 dark:text-white font-semibold hover:font-bold dark:hover:font-bold hover:text-green-900">
                          <button class="p-1 rounded-full text-green-500 dark:text-white">
                              <svg class="h-6 w-6" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                  <g>
                                      <g>
                                          <path d="M257,0C116.39,0,0,114.39,0,255s116.39,257,257,257s255-116.39,255-257S397.61,0,257,0z M392,285H287v107
                                              c0,16.54-13.47,30-30,30c-16.54,0-30-13.46-30-30V285H120c-16.54,0-30-13.46-30-30c0-16.54,13.46-30,30-30h107V120
                                              c0-16.54,13.46-30,30-30c16.53,0,30,13.46,30,30v105h105c16.53,0,30,13.46,30,30S408.53,285,392,285z"/>
                                      </g>
                                  </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g>
                              </svg>
                          </button>
                          <button class="text-sm uppercase">
                              <span class="">
                                  {{ $t('Add') }}
                              </span>
                          </button>
                      </div>
                  </div>
                </div>




                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      <th class="px-4 py-3">#</th>
                      <th class="px-4 py-3">{{ $t('Name') }}</th>
                      <th class="px-4 py-3">{{ $t('Created_at') }}</th>
                      <th class="px-4 py-3">{{ $t('Status') }}</th>
                      <th class="px-4 py-3">{{ $t('Actions') }}</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400" v-for="(user,index) in users.data" key="user.id">
                      <td class="px-4 py-3 text-sm">
                        <!-- {{ user.id }} -->
                        {{ (index+1) + $page.props.users.current_page * $page.props.users.per_page - $page.props.users.per_page }}
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                            <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE3Nzg0fQ" alt="" loading="lazy">
                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                          </div>
                          <div>
                            <p class="font-semibold">{{ user.name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                              {{ user.email }}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ user.created_at }}
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <!-- <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> -->
                          <!-- {{ user.status }} -->
                          <button v-if="user.status==1" @click="inactivateUser(user)"
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                          >
                          Active
                          </button>
                          <button v-else @click="activateUser(user)"
                          class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100"
                          >
                          Inactive
                          </button>
                        <!-- </span> -->
                      </td>
                      <td class="py-3 text-sm flex space-x-4">
                        <Icon name="eye" class="h-5 w-5 cursor-pointer text-blue-500"/> 
                        <Icon name="edit" class="h-5 w-5 cursor-pointer text-orange-500"/> 
                        <Icon name="trash" class="h-5 w-5 cursor-pointer text-red-500" @click="destroy(user)" />                      
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- <pre>{{ users }}</pre> -->
                <Pagination :data="users"></Pagination>
              </div>
            </div>
          </div>       
    </AdminLayout>
</template>

