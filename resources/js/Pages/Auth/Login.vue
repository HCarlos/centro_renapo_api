<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    curp: '',
    password: '',
})

const props = defineProps({
    errors: Object,
})

const submit = () => {
    form.post(route('login'))
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Iniciar Sesión</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="curp" class="block text-gray-700 text-sm font-bold mb-2">CURP</label>
                    <input
                        id="curp"
                        type="text"
                        v-model="form.curp"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        :class="{ 'border-red-500': errors.curp }"
                    />
                    <p v-if="errors.curp" class="text-red-500 text-xs italic">{{ errors.curp }}</p>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        :class="{ 'border-red-500': errors.password }"
                    />
                    <p v-if="errors.password" class="text-red-500 text-xs italic">{{ errors.password }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        :disabled="form.processing"
                    >
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

