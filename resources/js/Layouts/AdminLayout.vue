<template>
    <div class="min-h-screen flex bg-surface">

        <!-- ── Sidebar ─────────────────────────────────────── -->
        <aside
            class="w-64 flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-200"
            style="background: #141F3E;"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- Logo -->
            <div class="flex items-center h-16 px-6 shrink-0" style="background: rgba(0,0,0,.2);">
                <span class="text-xl font-bold text-white tracking-tight">TeachMe App</span>
                <span class="ml-2 text-xs font-semibold uppercase tracking-widest px-1.5 py-0.5 rounded"
                      style="background:rgba(0,123,67,.35); color:#4ade80;">
                    Admin
                </span>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
                <NavItem :href="route('admin.dashboard')" icon="home">Dashboard</NavItem>

                <p class="section-title">People</p>
                <NavItem :href="route('admin.users.index')" icon="users">Users</NavItem>
                <NavItem :href="route('admin.kyc.index')" icon="shield-check">
                    KYC Review
                    <template #badge v-if="$page.props.pendingKyc > 0">
                        <span class="ml-auto text-xs font-bold bg-red-500 text-white rounded-full min-w-[1.25rem] h-5 flex items-center justify-center px-1.5">
                            {{ $page.props.pendingKyc }}
                        </span>
                    </template>
                </NavItem>
                <NavItem :href="route('admin.notifications.broadcast')" icon="megaphone">Broadcast</NavItem>

                <p class="section-title">Operations</p>
                <NavItem :href="route('admin.bookings.index')" icon="calendar">Bookings</NavItem>
                <NavItem :href="route('admin.sessions.index')" icon="video-camera">Sessions</NavItem>
                <NavItem :href="route('admin.reports.index')" icon="flag">Reports</NavItem>

                <p class="section-title">Finance</p>
                <NavItem :href="route('admin.financials.index')" icon="currency-dollar">Financials</NavItem>
                <NavItem :href="route('admin.payouts.index')" icon="banknotes">Payouts</NavItem>

                <p class="section-title">Config</p>
                <NavItem :href="route('admin.tiers.index')" icon="star">Tiers</NavItem>
                <NavItem :href="route('admin.gateways.index')" icon="credit-card">Gateways</NavItem>
                <NavItem :href="route('admin.settings.index')" icon="cog-6-tooth">Settings</NavItem>
                <NavItem :href="route('admin.institutions.index')" icon="building">Institutions</NavItem>
                <NavItem :href="route('admin.subjects.index')" icon="book-open">Subjects</NavItem>
                <p class="section-title">Audit</p>
                <NavItem :href="route('admin.audit.index')" icon="clipboard-document-list">Audit Logs</NavItem>
            </nav>

            <!-- User footer -->
            <div class="p-4 shrink-0" style="border-top: 1px solid rgba(255,255,255,.1);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white shrink-0"
                         style="background:#007B43;">
                        {{ $page.props.auth.user?.name?.charAt(0)?.toUpperCase() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white truncate">{{ $page.props.auth.user?.name }}</p>
                        <p class="text-xs truncate" style="color:rgba(255,255,255,.45);">Administrator</p>
                    </div>
                    <Link :href="route('logout')" method="post" as="button"
                          class="p-1.5 rounded-lg transition-colors"
                          style="color:rgba(255,255,255,.4);"
                          title="Sign out">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- ── Main ────────────────────────────────────────── -->
        <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

            <!-- Topbar -->
            <header class="h-16 bg-white flex items-center px-6 gap-4 sticky top-0 z-40"
                    style="border-bottom: 1px solid #E2E5EE; box-shadow: 0 1px 4px rgba(20,31,62,.06);">

                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <h1 class="text-base font-semibold" style="color:#141F3E;">{{ title }}</h1>

                <div class="ml-auto flex items-center gap-2">
                    <NotificationBell />
                    <slot name="topbar-right" />
                </div>
            </header>

            <!-- Page -->
            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>

        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/40 z-40 lg:hidden backdrop-blur-sm" />

        <!-- Toasts -->
        <ToastContainer />
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import NavItem from '@/Components/NavItem.vue'
import ToastContainer from '@/Components/ToastContainer.vue'
import NotificationBell from '@/Components/NotificationBell.vue'
import { useToast } from '@/composables/useToast'
import { useRealTimeNotifications } from '@/composables/useRealTimeNotifications'

defineProps({ title: { type: String, default: '' } })

const sidebarOpen = ref(false)
const page        = usePage()
const toast       = useToast()

// Real-time notification listener (auto-starts/stops on mount/unmount)
useRealTimeNotifications()

// Convert Inertia flash → toast
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) toast.success(flash.success)
        if (flash?.error)   toast.error(flash.error)
    },
    { immediate: true }
)
</script>