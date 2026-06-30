<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import {
    CalendarDaysIcon,
    ClipboardDocumentListIcon,
    HomeIcon,
    UserGroupIcon,
    Bars3Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';

const page = usePage();
const user = computed(() => page.props.auth.user);
const sidebarOpen = ref(false);

const navigation = computed(() => {
    const role = user.value?.role;
    const items = [
        { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon },
        { name: 'Your Schedule', href: route('calendar.yourschedule'), icon: CalendarDaysIcon },
    ];

    if (['regular', 'scheduler', 'admin'].includes(role)) {
        items.push(
            { name: 'Leave Application', href: route('calendar.leave'), icon: ClipboardDocumentListIcon },
            { name: 'On-Call Application', href: route('calendar.oncall'), icon: ClipboardDocumentListIcon },
            { name: 'Application History', href: route('calendar.history'), icon: ClipboardDocumentListIcon },
        );
    }

    if (['scheduler', 'admin'].includes(role)) {
        items.push(
            { name: 'On-Call Schedule', href: route('create-oncall'), icon: CalendarDaysIcon },
            { name: 'Ward Schedule', href: route('create-ward'), icon: CalendarDaysIcon },
            { name: 'Shift Schedule', href: route('create-shift'), icon: CalendarDaysIcon },
            { name: 'Review Applications', href: route('review'), icon: ClipboardDocumentListIcon },
            { name: 'Review History', href: route('reviewHistory'), icon: ClipboardDocumentListIcon },
        );
    }

    if (role === 'admin') {
        items.push({ name: 'Manage Staff', href: route('manageStaff'), icon: UserGroupIcon });
    }

    items.push(
        { name: 'Dept. On-Call', href: route('calendar.depschedule'), icon: CalendarDaysIcon },
        { name: 'Dept. Ward', href: route('calendar.view-ward'), icon: CalendarDaysIcon },
        { name: 'Dept. Shift', href: route('calendar.view-shift'), icon: CalendarDaysIcon },
    );

    return items;
});

const isActive = (href) => {
    try {
        return route().current(href.split('/').pop()) || window.location.pathname === new URL(href).pathname;
    } catch {
        return window.location.pathname === href;
    }
};
</script>

<template>
    <div class="min-h-screen bg-slate-50">
        <!-- Mobile sidebar backdrop -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false" />

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 transform transition-transform duration-200 ease-in-out lg:translate-x-0',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
        >
            <div class="flex h-16 items-center justify-between px-6 border-b border-slate-700">
                <span class="text-lg font-bold text-white">HSS</span>
                <button class="lg:hidden text-slate-400 hover:text-white" @click="sidebarOpen = false">
                    <XMarkIcon class="h-6 w-6" />
                </button>
            </div>

            <nav class="mt-4 px-3 space-y-1 overflow-y-auto max-h-[calc(100vh-4rem)]">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                    :class="isActive(item.href)
                        ? 'bg-sky-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'"
                >
                    <component :is="item.icon" class="h-5 w-5 shrink-0" />
                    {{ item.name }}
                </Link>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
                <div class="text-sm text-slate-400">{{ user?.name }}</div>
                <div class="text-xs text-slate-500 capitalize">{{ user?.role }} · {{ user?.department }}</div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="lg:pl-64">
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-4 sm:px-6">
                <button class="lg:hidden text-slate-600" @click="sidebarOpen = true">
                    <Bars3Icon class="h-6 w-6" />
                </button>
                <h1 v-if="$slots.header" class="text-lg font-semibold text-slate-900">
                    <slot name="header" />
                </h1>
                <div class="ml-auto flex items-center gap-4">
                    <Link :href="route('profile.show')" class="text-sm text-slate-600 hover:text-sky-600">
                        Profile
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-sm text-slate-600 hover:text-red-600"
                    >
                        Logout
                    </Link>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                <div v-if="page.props.flash?.success" class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                    {{ page.props.flash.success }}
                </div>
                <div v-if="page.props.flash?.error" class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                    {{ page.props.flash.error }}
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
