<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-slate-50">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Unauthorized</h1>
            <p class="text-slate-600 mb-6">You don't have permission to access this page.</p>
            <Link :href="route('dashboard')" class="text-sky-600 hover:underline">Return to Dashboard</Link>
        </div>
    </div>
</template>
