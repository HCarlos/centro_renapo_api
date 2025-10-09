<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import SearchByDataModal from '../Components/SearchByDataModal.vue'
import SearchByCurpModal from '../Components/SearchByCurpModal.vue'

// Definir props
const props = defineProps({
    consultas: {
        type: Array,
        default: () => []
    }
})

// Estados reactivos para modales
const modalByData = ref(false)
const modalByCurp = ref(false)

// Métodos
const openModal = (type) => {
    console.log('Opening modal:', type) // Para debug
    if (type === 'byData') {
        modalByData.value = true
    } else if (type === 'byCurp') {
        modalByCurp.value = true
    }
}

const closeModal = () => {
    console.log('Closing modals') // Para debug
    modalByData.value = false
    modalByCurp.value = false
}

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Menú lateral -->
        <div class="flex">
            <div class="w-64 bg-white shadow-md min-h-screen">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">Menú</h2>
                </div>
                <nav class="mt-4">
                    <Link :href="route('home')" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Home
                    </Link>
                    <button @click="openModal('byData')" class="block w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Búsqueda por datos
                    </button>
                    <button @click="openModal('byCurp')" class="block w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-blue-500 hover:text-white">
                        Búsqueda por CURP
                    </button>
                    <button @click="logout" class="block w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-red-500 hover:text-white mt-4">
                        Cerrar Sesión
                    </button>
                </nav>
            </div>

            <!-- Contenido principal -->
            <div class="flex-1 p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Historial de Búsquedas</h1>

                <!-- Mensaje si no hay consultas -->
                <div v-if="consultas.length === 0" class="bg-white shadow-md rounded-lg p-6 text-center">
                    <p class="text-gray-600">No hay consultas realizadas aún.</p>
                    <p class="text-gray-500 text-sm mt-2">Utiliza las opciones del menú para realizar tu primera búsqueda.</p>
                </div>

                <!-- Tabla de consultas -->
                <div v-else class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Datos de la solicitud
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Respuesta
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="consulta in consultas" :key="consulta.id">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                              :class="consulta.tipo === 'datos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                            {{ consulta.tipo === 'datos' ? 'Por Datos' : 'Por CURP' }}
                                        </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    {{ new Date(consulta.created_at).toLocaleString('es-MX') }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <pre class="text-xs whitespace-pre-wrap">{{ JSON.stringify(consulta.datos_consulta, null, 2) }}</pre>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <pre class="text-xs whitespace-pre-wrap">{{ JSON.stringify(consulta.resultado, null, 2) }}</pre>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales -->
        <SearchByDataModal
            :show="modalByData"
            :errors="errors"
            @close="closeModal"
        />
        <SearchByCurpModal
            :show="modalByCurp"
            :errors="errors"
            @close="closeModal"
        />
    </div>
</template>




