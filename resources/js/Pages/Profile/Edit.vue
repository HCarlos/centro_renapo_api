<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <!-- Navbar Superior (igual que en Home.vue) -->
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
                        <Link :href="route('home')"
                              class="hidden md:flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 mr-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Inicio
                        </Link>

                        <!-- Menú de usuario dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button @click="toggleUserMenu"
                                        class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
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
                            <div v-if="userMenuOpen"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 animate-fade-in">
                                <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                    Conectado como<br>
                                    <span class="font-medium text-gray-700">{{ userName }}</span>
                                </div>
                                <Link :href="route('profile.edit')"
                                      class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Mi Perfil
                                </Link>
                                <button @click="logout"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Configuración de Perfil</h1>
                <p class="text-gray-600">Actualiza tu información personal y configuración de seguridad</p>
            </div>

            <!-- Mensajes de estado -->
            <div v-if="status"
                 class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center animate-fade-in">
                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-green-800">{{ status }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna izquierda - Navegación -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <nav class="space-y-2">
                            <button @click="activeTab = 'profile'"
                                    class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
                                    :class="activeTab === 'profile' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Información Personal
                            </button>
                            <button @click="activeTab = 'password'"
                                    class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
                                    :class="activeTab === 'password' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Cambiar Contraseña
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Columna derecha - Contenido -->
                <div class="lg:col-span-2">
                    <!-- Información Personal -->
                    <div v-if="activeTab === 'profile'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Información Personal</h2>

                        <ProfileInformationForm :user="user" />
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div v-if="activeTab === 'password'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Cambiar Contraseña</h2>

                        <UpdatePasswordForm />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'
import ProfileInformationForm from './Partials/ProfileInformationForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'

const page = usePage()

const props = defineProps({
    user: Object,
    status: String,
})

const activeTab = ref('profile')
const userMenuOpen = ref(false)

// Computed properties
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
const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value
}

const logout = () => {
    router.post(route('logout'))
}

// Cerrar menú de usuario al hacer clic fuera
const closeUserMenu = (event) => {
    if (!event.target.closest('#user-menu-button')) {
        userMenuOpen.value = false
    }
}

// Agregar event listener para cerrar el menú al hacer clic fuera
onMounted(() => {
    document.addEventListener('click', closeUserMenu)
})

onUnmounted(() => {
    document.removeEventListener('click', closeUserMenu)
})
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
