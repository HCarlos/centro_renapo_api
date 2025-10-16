<script setup>
import { useForm, router } from '@inertiajs/vue3'

// Opción alternativa: si quieres recibir errors como prop
const props = defineProps({
    show: Boolean,
    errors: {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['close'])

const form = useForm({
    curp: '',
})

const submit = () => {
    form.post(route('consulta-curp'), {
        preserveScroll: true,
        onSuccess: () => {
            close()
            form.reset()
            router.reload({ only: ['consultas'] })
        },
        onError: (err) => {
            // form.errors = err
        }
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
                <h2 class="text-2xl font-bold mb-4">Búsqueda por CURP</h2>
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label for="curp" class="block text-gray-700 text-sm font-bold mb-2">CURP</label>
                        <input
                            id="curp"
                            type="text"
                            v-model="form.curp"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline uppercase"
                            :class="{ 'border-red-500': form.errors.curp }"
                            placeholder="Ej: PEGF900115HDFXYZ01"
                            maxlength="18"
                        />
                        <p v-if="form.errors.curp" class="text-red-500 text-xs italic">{{ form.errors.curp[0] }}</p>
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

