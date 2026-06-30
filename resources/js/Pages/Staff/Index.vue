<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    staff: { type: Array, default: () => [] },
});

const editingId = ref(null);

const editForm = useForm({
    user_id: null,
    name: '',
    email: '',
    department: '',
    role: '',
});

const startEdit = (member) => {
    editingId.value = member.id;
    editForm.user_id = member.id;
    editForm.name = member.name;
    editForm.email = member.email;
    editForm.department = member.department;
    editForm.role = member.role;
};

const saveEdit = () => {
    editForm.post(route('updateStaff'), {
        preserveScroll: true,
        onSuccess: () => { editingId.value = null; },
    });
};

const deleteStaff = (id) => {
    if (confirm('Delete this staff member?')) {
        router.delete(route('deleteStaff', id), { preserveScroll: true });
    }
};
</script>

<template>
    <AppLayout>
        <template #header>Manage Staff</template>

        <div class="mb-4">
            <Link
                :href="route('staff-form')"
                class="inline-flex rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700"
            >
                Add Staff
            </Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="member in staff" :key="member.id">
                        <template v-if="editingId === member.id">
                            <td class="px-4 py-2"><input v-model="editForm.name" class="w-full rounded border-slate-300 text-sm" /></td>
                            <td class="px-4 py-2"><input v-model="editForm.email" class="w-full rounded border-slate-300 text-sm" /></td>
                            <td class="px-4 py-2"><input v-model="editForm.department" class="w-full rounded border-slate-300 text-sm" /></td>
                            <td class="px-4 py-2">
                                <select v-model="editForm.role" class="w-full rounded border-slate-300 text-sm">
                                    <option value="scheduler">Scheduler</option>
                                    <option value="regular">Regular</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button class="text-sm text-emerald-600 hover:underline" @click="saveEdit">Save</button>
                                <button class="text-sm text-slate-500 hover:underline" @click="editingId = null">Cancel</button>
                            </td>
                        </template>
                        <template v-else>
                            <td class="px-4 py-3 text-sm">{{ member.name }}</td>
                            <td class="px-4 py-3 text-sm">{{ member.email }}</td>
                            <td class="px-4 py-3 text-sm">{{ member.department }}</td>
                            <td class="px-4 py-3 text-sm capitalize">{{ member.role }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <button class="text-sm text-sky-600 hover:underline" @click="startEdit(member)">Edit</button>
                                <button class="text-sm text-red-600 hover:underline" @click="deleteStaff(member.id)">Delete</button>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
