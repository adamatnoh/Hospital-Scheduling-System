<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScheduleCalendar from '@/Components/ScheduleCalendar.vue';

defineProps({
    events: { type: Array, default: () => [] },
});
</script>

<template>
    <AppLayout>
        <template #header>Your Schedule</template>
        <ScheduleCalendar :events="events" />
    </AppLayout>
</template>
