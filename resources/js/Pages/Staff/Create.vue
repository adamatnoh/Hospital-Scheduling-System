<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    department: '',
    role: 'regular',
    password: '',
});

const submit = () => {
    form.post(route('addStaff'));
};
</script>

<template>
    <AppLayout>
        <template #header>Add Staff Member</template>

        <div class="mx-auto max-w-2xl">
            <form @submit.prevent="submit" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input v-model="form.name" type="text" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input v-model="form.email" type="email" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Department</label>
                    <input v-model="form.department" type="text" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select v-model="form.role" class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="regular">Regular Staff</option>
                        <option value="scheduler">Scheduler</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input v-model="form.password" type="password" required minlength="8" class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                </div>
                <div class="flex gap-3">
                    <button type="submit" :disabled="form.processing" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 disabled:opacity-50">
                        Add Staff
                    </button>
                    <Link :href="route('manageStaff')" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
