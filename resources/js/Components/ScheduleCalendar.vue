<script setup>
import { router } from '@inertiajs/vue3';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { ref, watch } from 'vue';

const props = defineProps({
    events: { type: Array, default: () => [] },
    editable: { type: Boolean, default: false },
    updateRoute: { type: String, default: null },
    deleteRoute: { type: String, default: null },
});

const calendarEvents = ref(props.events.map(formatEvent));

watch(() => props.events, (newEvents) => {
    calendarEvents.value = newEvents.map(formatEvent);
}, { deep: true });

function formatEvent(event) {
    return {
        id: String(event.id ?? ''),
        title: event.title,
        start: event.start,
        end: event.end,
        allDay: event.allDay ?? true,
        backgroundColor: event.backgroundColor,
        borderColor: event.backgroundColor,
    };
}

const calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek',
    },
    editable: props.editable,
    eventDrop: handleEventChange,
    eventResize: handleEventChange,
    eventClick: handleEventClick,
};

function handleEventChange(info) {
    if (!props.updateRoute) return;

    router.patch(route(props.updateRoute, info.event.id), {
        start_date: info.event.startStr,
        end_date: info.event.endStr ?? info.event.startStr,
    }, { preserveScroll: true });
}

function handleEventClick(info) {
    if (!props.editable || !props.deleteRoute) return;

    if (confirm('Delete this schedule entry?')) {
        router.delete(route(props.deleteRoute, info.event.id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <FullCalendar :options="{ ...calendarOptions, events: calendarEvents }" />
    </div>
</template>
