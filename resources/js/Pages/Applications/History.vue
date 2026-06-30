<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    applications: { type: Array, default: () => [] },
});

const statusColor = (status) => {
    if (status === 'Yes') return 'bg-emerald-100 text-emerald-800';
    if (status === 'No') return 'bg-red-100 text-red-800';
    return 'bg-amber-100 text-amber-800';
};
</script>

<template>
    <AppLayout>
        <template #header>Application History</template>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Dates</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Reason</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="app in applications" :key="`${app.application_type}-${app.id}`" class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-sm text-slate-900">{{ app.application_type }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ app.title }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ app.start_date }} – {{ app.end_date }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ app.reason }}</td>
                        <td class="px-4 py-3">
                            <span :class="['inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium', statusColor(app.status)]">
                                {{ app.status }}
                            </span>
                        </td>
                    </tr>
                    <tr v-if="applications.length === 0">
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">No applications yet.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
