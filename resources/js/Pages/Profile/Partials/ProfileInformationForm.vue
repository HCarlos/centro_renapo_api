<template>
    <form @submit.prevent="submit">
        <div class="space-y-6">
            <!-- Avatar y Información básica -->
            <div class="flex items-center space-x-6 mb-6">
                <div class="h-20 w-20 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                    {{ userInitials }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ form.name }}</h3>
                    <p class="text-gray-600">{{ form.curp }}</p>
                    <p class="text-sm text-gray-500 mt-1">Miembro desde {{ formatDate(user.created_at) }}</p>
                </div>
            </div>

            <!-- Campo Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    :class="{ 'border-red-500': form.errors.name }"
                />
                <p v-if="form.errors.name" class="text-red-500 text-sm mt-2">{{ form.errors.name[0] }}</p>
            </div>

            <!-- Campo CURP -->
            <div>
                <label for="curp" class="block text-sm font-medium text-gray-700 mb-2">CURP</label>
                <input
                    id="curp"
                    v-model="form.curp"
                    type="text"
                    maxlength="18"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 uppercase"
                    :class="{ 'border-red-500': form.errors.curp }"
                />
                <p v-if="form.errors.curp" class="text-red-500 text-sm mt-2">{{ form.errors.curp[0] }}</p>
                <p class="text-gray-500 text-sm mt-2">Tu Clave Única de Registro de Población</p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <Link :href="route('home')"
                      class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 font-medium">
                    Cancelar
                </Link>
                <button
                    type="submit"
                    :disabled="form.processing || !form.isDirty"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="form.processing">Guardando...</span>
                    <span v-else>Guardar Cambios</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const props = defineProps({
    user: Object,
})

const form = useForm({
    name: props.user.name,
    curp: props.user.curp,
})

const userInitials = computed(() => {
    return props.user.name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2)
})

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-MX', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const submit = () => {
    form.put(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    })
}
</script>
