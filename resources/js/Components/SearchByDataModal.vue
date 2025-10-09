<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const props = defineProps({
    show: Boolean,
    errors: {
        type: Object,
        default: () => ({})
    }
})


const emit = defineEmits(['close'])

const form = useForm({
    nombre: '',
    apellido_paterno: '',
    apellido_materno: '',
    fecha_nacimiento: '',
    sexo: 'H',
    clave_estado: '',
})

const states = ref([])

onMounted(async () => {
    // Cargar el JSON de estados
    const response = await fetch('/js/estados.json')
    states.value = await response.json()
})

const submit = () => {
    form.post(route('consulta-datos'), {
        preserveScroll: true,
        onSuccess: () => {1
            close()
            form.reset()
            router.reload({ only: ['consultas'] })
        },
        onError: (err) => {
            // form.errors = err
        },
    })
}

const close = () => {
    form.clearErrors()
    form.reset()
    emit('close')
}
</script>

<template>
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Búsqueda por Datos</h2>
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                        <input
                            id="nombre"
                            type="text"
                            v-model="form.nombre"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.nombre }"
                        />
                        <p v-if="form.errors.nombre" class="text-red-500 text-xs italic">{{ form.errors.nombre[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="apellido_paterno" class="block text-gray-700 text-sm font-bold mb-2">Apellido Paterno</label>
                        <input
                            id="apellido_paterno"
                            type="text"
                            v-model="form.apellido_paterno"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.apellido_paterno }"
                        />
                        <p v-if="form.errors.apellido_paterno" class="text-red-500 text-xs italic">{{ form.errors.apellido_paterno[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="apellido_materno" class="block text-gray-700 text-sm font-bold mb-2">Apellido Materno</label>
                        <input
                            id="apellido_materno"
                            type="text"
                            v-model="form.apellido_materno"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.apellido_materno }"
                        />
                        <p v-if="form.errors.apellido_materno" class="text-red-500 text-xs italic">{{ form.errors.apellido_materno[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento</label>
                        <input
                            id="fecha_nacimiento"
                            type="date"
                            v-model="form.fecha_nacimiento"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.fecha_nacimiento }"
                        />
                        <p v-if="form.errors.fecha_nacimiento" class="text-red-500 text-xs italic">{{ form.errors.fecha_nacimiento[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="sexo" class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                        <select
                            id="sexo"
                            v-model="form.sexo"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.sexo }"
                        >
                            <option value="H">Hombre</option>
                            <option value="M">Mujer</option>
                        </select>
                        <p v-if="form.errors.sexo" class="text-red-500 text-xs italic">{{ form.errors.sexo[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="clave_estado" class="block text-gray-700 text-sm font-bold mb-2">Clave Estado</label>
                        <select
                            id="clave_estado"
                            v-model="form.clave_estado"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.clave_estado }"
                        >
                            <option v-for="(valor, id) in states" :key="id" :value="id">
                                {{ valor }}
                            </option>
                        </select>
                        <p v-if="form.errors.clave_estado" class="text-red-500 text-xs italic">{{ form.errors.clave_estado[0] }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            type="button"
                            @click="close"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            :disabled="form.processing"
                        >
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

