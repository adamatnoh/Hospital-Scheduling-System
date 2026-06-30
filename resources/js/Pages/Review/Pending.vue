<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    applications: { type: Array, default: () => [] },
});

const rejectionReason = ref({});

const updateStatus = (app, status) => {
    const routeName = app.application_type === 'Leave' ? 'updateReviewLeave' : 'updateReviewOnCall';
    router.patch(route(routeName, app.id), {
        status,
        rejection: rejectionReason.value[app.id] ?? '',
    }, { preserveScroll: true });
};
</script>

<template>
    <AppLayout>
        <template #header>Review Pending Applications</template>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Dates</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Reason</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Rejection Note</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr v-for="app in applications" :key="`${app.application_type}-${app.id}`">
                        <td class="px-4 py-3 text-sm">{{ app.application_type }}</td>
                        <td class="px-4 py-3 text-sm">{{ app.title }}</td>
                        <td class="px-4 py-3 text-sm">{{ app.start_date }} – {{ app.end_date }}</td>
                        <td class="px-4 py-3 text-sm">{{ app.reason }}</td>
                        <td class="px-4 py-3">
                            <input
                                v-model="rejectionReason[app.id]"
                                type="text"
                                placeholder="Optional rejection reason"
                                class="w-full rounded border-slate-300 text-sm"
                            />
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <button
                                class="rounded bg-emerald-600 px-3 py-1 text-xs font-medium text-white hover:bg-emerald-700"
                                @click="updateStatus(app, 'Yes')"
                            >
                                Approve
                            </button>
                            <button
                                class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700"
                                @click="updateStatus(app, 'No')"
                            >
                                Reject
                            </button>
                        </td>
                    </tr>
                    <tr v-if="applications.length === 0">
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">No pending applications.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
