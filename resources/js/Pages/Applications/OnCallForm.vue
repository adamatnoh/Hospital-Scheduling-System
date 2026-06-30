<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    title: props.user?.name ?? '',
    reason: '',
    start_date: '',
    end_date: '',
});

const submit = () => {
    form.post(route('calendar.storeOnCall'));
};
</script>

<template>
    <AppLayout>
        <template #header>On-Call Application</template>

        <div class="mx-auto max-w-2xl">
            <form @submit.prevent="submit" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input v-model="form.title" type="text" readonly class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Department</label>
                    <input :value="user?.department" type="text" readonly class="w-full rounded-lg border-slate-300 bg-slate-50 text-slate-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Reason</label>
                    <textarea v-model="form.reason" rows="3" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                    <p v-if="form.errors.reason" class="mt-1 text-sm text-red-600">{{ form.errors.reason }}</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Preferred Date</label>
                        <input v-model="form.start_date" type="date" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">End Date</label>
                        <input v-model="form.end_date" type="date" required class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500" />
                    </div>
                </div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-sky-700 disabled:opacity-50 transition-colors"
                >
                    Submit Application
                </button>
            </form>
        </div>
    </AppLayout>
</template>
