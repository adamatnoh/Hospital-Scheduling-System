<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScheduleCalendar from '@/Components/ScheduleCalendar.vue';

defineProps({
    events: { type: Array, default: () => [] },
});
</script>

<template>
    <AppLayout>
        <template #header>Department On-Call Schedule</template>
        <ScheduleCalendar :events="events" />
    </AppLayout>
</template>
