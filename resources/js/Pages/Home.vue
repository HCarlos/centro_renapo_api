<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'
import SearchByDataModal from '../Components/SearchByDataModal.vue'
import SearchByCurpModal from '../Components/SearchByCurpModal.vue'

const page = usePage()

const props = defineProps({
    consultas: Array,
    consulta_reciente: Object
})

const modalByData = ref(false)
const modalByCurp = ref(false)
const userMenuOpen = ref(false)
const userMenu = ref(null)

// Computed properties para los mensajes flash
const flashSuccess = computed(() => {
    return page.props.flash?.success
})

const flashError = computed(() => {
    return page.props.flash?.error
})

// Computed para obtener las iniciales del usuario
const userInitials = computed(() => {
    const userName = page.props.auth?.user?.name || 'Usuario'
    return userName
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2)
})

const userName = computed(() => {
    return page.props.auth?.user?.name || 'Usuario'
})

// Métodos
const openModal = (type) => {
    if (type === 'byData') {
        modalByData.value = true
    } else if (type === 'byCurp') {
        modalByCurp.value = true
    }
    // Cerrar menú de usuario si está abierto
    userMenuOpen.value = false
}

const closeModal = () => {
    modalByData.value = false
    modalByCurp.value = false
}

const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value
}

const logout = () => {
    router.post(route('logout'))
}

// Cerrar menú de usuario al hacer clic fuera
const handleClickOutside = (event) => {
    if (userMenu.value && !userMenu.value.contains(event.target)) {
        userMenuOpen.value = false
    }
}

// Agregar event listener para cerrar el menú al hacer clic fuera
onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>


<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <!-- Navbar Superior -->
        <nav class="bg-white shadow-lg border-b border-blue-100 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo y título -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                RENAPO Query
                            </span>
                        </div>
                    </div>
                    <!-- Menú de usuario -->
                    <div class="flex items-center">
                        <!-- Botones de búsqueda en desktop -->
                        <div class="hidden md:flex space-x-2 mr-4">
                            <button @click="openModal('byData')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Por Datos
                            </button>
                            <button @click="openModal('byCurp')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Por CURP
                            </button>
                        </div>

                        <!-- Menú de usuario dropdown - CORREGIDO -->
                        <div class="ml-3 relative" ref="userMenu">
                            <div>
                                <button @click="toggleUserMenu"
                                        class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 hover:bg-gray-100 px-2 py-1"
                                        id="user-menu-button">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                        {{ userInitials }}
                                    </div>
                                    <span class="hidden md:block ml-2 text-gray-700 font-medium">{{ userName }}</span>
                                    <svg class="ml-1 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div v-show="userMenuOpen"
                                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100">
                                    <div class="px-4 py-3">
                                        <p class="text-sm text-gray-900 font-medium">{{ userName }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ page.props.auth.user.curp }}</p>
                                    </div>
                                    <div class="py-1">
                                        <Link :href="route('profile.edit')"
                                              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150 w-full text-left"
                                              @click="userMenuOpen = false">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Mi Perfil
                                        </Link>
                                    </div>
                                    <div class="py-1">
                                        <button @click="logout"
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150 text-left">
                                            <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Cerrar Sesión
                                        </button>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de búsqueda para móviles -->
            <div class="md:hidden bg-blue-50 border-t border-blue-100">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 flex flex-col">
                    <button @click="openModal('byData')"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Búsqueda por Datos
                    </button>
                    <button @click="openModal('byCurp')"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Búsqueda por CURP
                    </button>
                </div>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Historial de Consultas</h1>
                <p class="text-gray-600">Revisa todas las consultas RENAPO que has realizado</p>
            </div>

            <!-- Mensajes Flash CORREGIDOS -->
            <div v-if="flashSuccess"
                 class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start animate-fade-in">
                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-green-800">{{ flashSuccess }}</span>
            </div>

            <div v-if="flashError"
                 class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start animate-fade-in">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-800">{{ flashError }}</span>
            </div>

            <!-- Tarjeta de contenido -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <!-- Mensaje si no hay consultas -->
                <div v-if="consultas.length === 0" class="p-8 text-center">
                    <div class="mx-auto w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay consultas realizadas</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">
                        Realiza tu primera consulta utilizando los botones de búsqueda por datos o por CURP.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <button @click="openModal('byData')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            Búsqueda por Datos
                        </button>
                        <button @click="openModal('byCurp')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            Búsqueda por CURP
                        </button>
                    </div>
                </div>

                <!-- Tabla de consultas -->
                <div v-else class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Tus consultas recientes</h2>
                        <div class="text-sm text-gray-500">
                            Total: <span class="font-semibold text-gray-700">{{ consultas.length }}</span> consultas
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <!-- Vista de tabla para desktop -->
                        <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Datos de consulta
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Resultado
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="consulta in consultas" :key="consulta.id"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="consulta.tipo === 'datos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                                <svg v-if="consulta.tipo === 'datos'" class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                <svg v-else class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                {{ consulta.tipo === 'datos' ? 'Por Datos' : 'Por CURP' }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ new Date(consulta.created_at).toLocaleString('es-MX') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                        <div class="bg-gray-50 rounded-md p-2 max-h-32 overflow-y-auto">
                                            <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ JSON.stringify(consulta.datos_consulta, null, 2) }}</pre>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                        <div class="bg-gray-50 rounded-md p-2 max-h-32 overflow-y-auto">
                                            <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ JSON.stringify(consulta.resultado, null, 2) }}</pre>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista de tarjetas para móviles -->
                        <div class="md:hidden space-y-4">
                            <div v-for="consulta in consultas" :key="consulta.id"
                                 class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          :class="consulta.tipo === 'datos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                        {{ consulta.tipo === 'datos' ? 'Por Datos' : 'Por CURP' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ new Date(consulta.created_at).toLocaleString('es-MX') }}
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 mb-1">Datos de consulta</h4>
                                        <div class="bg-gray-50 rounded-md p-2 max-h-32 overflow-y-auto">
                                            <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ JSON.stringify(consulta.datos_consulta, null, 2) }}</pre>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 mb-1">Resultado</h4>
                                        <div class="bg-gray-50 rounded-md p-2 max-h-32 overflow-y-auto">
                                            <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ JSON.stringify(consulta.resultado, null, 2) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modales -->
        <SearchByDataModal
            :show="modalByData"
            @close="closeModal"
        />
        <SearchByCurpModal
            :show="modalByCurp"
            @close="closeModal"
        />
    </div>
</template>




<style scoped>
/* Animación personalizada para el fade-in */
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar personalizado */
pre::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

pre::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

pre::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

pre::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
