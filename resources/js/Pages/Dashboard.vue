<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

defineProps({
    announcements: { type: Array, default: () => [] },
});

const currentSlide = ref(0);
let interval = null;

onMounted(() => {
    interval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % 3;
    }, 5000);
});

onUnmounted(() => {
    clearInterval(interval);
});

const slides = [
    { image: '/images/1.jpg', title: 'Hospital Update' },
    { image: '/images/2.jpg', title: 'Staff Notice' },
    { image: '/images/3.jpg', title: 'Schedule Reminder' },
];
</script>

<template>
    <AppLayout>
        <template #header>Dashboard</template>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Announcements carousel -->
            <div class="lg:col-span-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="relative aspect-[16/7]">
                    <img
                        v-for="(slide, index) in slides"
                        :key="index"
                        :src="slide.image"
                        :alt="slide.title"
                        class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500"
                        :class="index === currentSlide ? 'opacity-100' : 'opacity-0'"
                    />
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                        <h2 class="text-xl font-semibold text-white">{{ slides[currentSlide].title }}</h2>
                    </div>
                    <div class="absolute bottom-4 right-4 flex gap-2">
                        <button
                            v-for="(_, index) in slides"
                            :key="index"
                            class="h-2 w-2 rounded-full transition-colors"
                            :class="index === currentSlide ? 'bg-white' : 'bg-white/50'"
                            @click="currentSlide = index"
                        />
                    </div>
                </div>
            </div>

            <!-- Quick links -->
            <div class="space-y-4">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <Link
                            :href="route('calendar.yourschedule')"
                            class="block rounded-lg bg-sky-50 px-4 py-3 text-sm font-medium text-sky-700 hover:bg-sky-100 transition-colors"
                        >
                            View Your Schedule
                        </Link>
                        <Link
                            :href="route('calendar.leave')"
                            class="block rounded-lg bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors"
                        >
                            Submit Leave Application
                        </Link>
                        <Link
                            :href="route('calendar.oncall')"
                            class="block rounded-lg bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors"
                        >
                            Submit On-Call Request
                        </Link>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900 mb-2">Welcome</h3>
                    <p class="text-sm text-slate-600">
                        Manage your hospital schedules, submit leave and on-call applications, and view department rosters.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
