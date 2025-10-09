<template>
    <form @submit.prevent="submit">
        <div class="space-y-6">
            <!-- Contraseña Actual -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                <input
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    :class="{ 'border-red-500': form.errors.current_password }"
                    autocomplete="current-password"
                />
                <p v-if="form.errors.current_password" class="text-red-500 text-sm mt-2">{{ form.errors.current_password[0] }}</p>
            </div>

            <!-- Nueva Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    :class="{ 'border-red-500': form.errors.password }"
                    autocomplete="new-password"
                />
                <p v-if="form.errors.password" class="text-red-500 text-sm mt-2">{{ form.errors.password[0] }}</p>
                <p class="text-gray-500 text-sm mt-2">La contraseña debe tener al menos 8 caracteres</p>
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    autocomplete="new-password"
                />
            </div>

            <!-- Indicadores de fortaleza de contraseña -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Requisitos de seguridad</h4>
                <div class="space-y-2">
                    <div class="flex items-center text-sm" :class="passwordLength ? 'text-green-600' : 'text-gray-500'">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="passwordLength" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Mínimo 8 caracteres
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button
                    type="button"
                    @click="form.reset()"
                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 font-medium"
                >
                    Limpiar
                </button>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="form.processing">Actualizando...</span>
                    <span v-else>Actualizar Contraseña</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const passwordLength = computed(() => form.password.length >= 8)

const submit = () => {
    form.put(route('profile.password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
    })
}
</script>
