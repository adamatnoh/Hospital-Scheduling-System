<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScheduleCalendar from '@/Components/ScheduleCalendar.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    events: { type: Array, default: () => [] },
    generated: { type: Boolean, default: false },
});
</script>

<template>
    <AppLayout>
        <template #header>Shift Schedule Editor</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <Link
                :href="route('assign-shift')"
                class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 transition-colors"
            >
                Generate Schedule
            </Link>
            <span v-if="generated" class="text-sm text-emerald-600 font-medium">
                Schedule generated successfully.
            </span>
        </div>

        <ScheduleCalendar
            :events="events"
            :editable="true"
            update-route="shift.update"
            delete-route="shift.delete"
        />
    </AppLayout>
</template>
