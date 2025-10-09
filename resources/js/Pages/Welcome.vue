<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a la Plataforma de Consultas RENAPO</h1>
            <p class="text-gray-600 mb-4">
                Esta plataforma te permite consultar información de la CURP de los ciudadanos de manera rápida y segura.
                Utiliza la API de RENAPO para obtener datos confiables y actualizados.
            </p>
            <p class="text-gray-600 mb-6">
                Características principales:
            </p>
            <ul class="list-disc list-inside text-gray-600 mb-6">
                <li>Consultas por datos personales</li>
                <li>Consultas directas por CURP</li>
                <li>Historial de consultas realizadas</li>
                <li>Interfaz moderna y responsive</li>
                <li>Seguridad con autenticación por CURP</li>
            </ul>
            <Link href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Iniciar Sesión
            </Link>
        </div>
    </div>
</template>
