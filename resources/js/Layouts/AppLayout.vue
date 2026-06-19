<template>
    <div class="min-h-screen flex bg-gray-50">

        <!-- ── Sidebar ─────────────────────────────────────── -->
        <aside
            class="w-64 flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-200"
            :style="sidebarStyle"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- Logo bar -->
            <div class="flex items-center h-16 px-6 shrink-0" :style="logoBandStyle">
                <span class="text-lg font-bold tracking-tight" :style="logoTextStyle">TeachMe App</span>
                <!-- Tier badge for tutors -->
                <span v-if="role === 'tutor' && tutorTier"
                      class="ml-auto text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded-full"
                      :style="tierBadgeStyle">
                    {{ tutorTier }}
                </span>
                <span v-else
                      class="ml-auto text-xs font-semibold uppercase tracking-widest px-1.5 py-0.5 rounded"
                      :style="roleLabelStyle">
                    {{ roleLabel }}
                </span>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
                <slot name="nav" />
            </nav>

            <!-- User footer -->
            <div class="p-4 shrink-0" :style="footerBorderStyle">
                <div class="flex items-center gap-3">
                    <!-- Avatar with tier ring for tutors -->
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white shrink-0 ring-2"
                         :style="avatarStyle">
                        <img v-if="authAvatar" :src="authAvatar"
                             class="w-full h-full rounded-full object-cover"
                             :alt="$page.props.auth.user?.name"
                             @error="avatarFailed = true" />
                        <span v-else>{{ $page.props.auth.user?.name?.charAt(0)?.toUpperCase() }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate text-sm" :style="nameStyle">{{ $page.props.auth.user?.name }}</p>
                        <p class="text-xs truncate" :style="subTextStyle">{{ tutorTier || roleLabel }}</p>
                    </div>
                    <Link :href="route('logout')" method="post" as="button"
                          :style="logoutStyle"
                          class="p-1.5 rounded-lg transition-colors hover:opacity-100"
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
                    style="border-bottom:1px solid #e9ebf0; box-shadow:0 1px 3px rgba(0,0,0,.06);">

                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Tier accent stripe for tutor pages -->
                <div v-if="role === 'tutor' && tierHex"
                     class="w-1 h-6 rounded-full shrink-0"
                     :style="{ background: tierHex }"></div>

                <h1 class="text-base font-semibold text-gray-800">{{ title }}</h1>

                <div class="ml-auto flex items-center gap-2">
                    <button
                        v-if="showPermissionPrompt"
                        @click="grantPermission"
                        class="hidden sm:flex items-center gap-1.5 text-xs font-medium px-3 py-1.5
                               rounded-full border transition-colors hover:bg-gray-50"
                        style="border-color:#007B43;color:#007B43;"
                        title="Enable desktop notifications"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        Enable alerts
                    </button>

                    <NotificationBell />
                    <slot name="topbar-right" />
                </div>
            </header>

            <!-- Page -->
            <main :class="noPadding ? 'flex-1 overflow-hidden' : 'flex-1 p-6'">
                <slot />
            </main>
        </div>

        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/30 z-40 lg:hidden backdrop-blur-sm" />

        <!-- Toasts -->
        <ToastContainer />
    </div>
</template>

<script setup>
import { ref, computed, watch, provide } from 'vue'
import { Link, usePage }        from '@inertiajs/vue3'
import ToastContainer           from '@/Components/ToastContainer.vue'
import NotificationBell         from '@/Components/NotificationBell.vue'
import { useToast }             from '@/composables/useToast'
import { useRealTimeNotifications } from '@/composables/useRealTimeNotifications'
import { useBrowserNotifications }  from '@/composables/useBrowserNotifications'

const props = defineProps({
    title:    { type: String,  default: '' },
    role:     { type: String,  default: 'student' },
    noPadding: { type: Boolean, default: false },
})

const sidebarOpen = ref(false)
const avatarFailed = ref(false)
const page        = usePage()
const toast       = useToast()

const roleLabel = computed(() =>
    props.role === 'tutor' ? 'Tutor' : 'Student'
)

// ── Tier info (only present for tutors) ──────────────────────────────────────
const tutorTier   = computed(() => page.props.auth?.user?.tier   ?? null)
const tierColour  = computed(() => page.props.auth?.user?.tier_colour ?? null)

// Convert hex string (no #) to full hex colour
const tierHex = computed(() =>
    tierColour.value ? '#' + tierColour.value : null
)

// Helper: lighten a hex colour by mixing with white at a given ratio (0–1)
function lighten(hex, amount) {
    if (!hex) return null
    const n = parseInt(hex.replace('#', ''), 16)
    const r = (n >> 16) & 0xff
    const g = (n >>  8) & 0xff
    const b =  n        & 0xff
    const mix = (c) => Math.round(c + (255 - c) * amount)
    return `rgb(${mix(r)},${mix(g)},${mix(b)})`
}

// ── Dynamic sidebar theme ────────────────────────────────────────────────────
// Tutors: sidebar tinted from their tier colour (very lightly).
// Students / admin: clean slate-white sidebar.
const isTutorWithTier = computed(() => props.role === 'tutor' && tierHex.value)

const sidebarStyle = computed(() => {
    if (isTutorWithTier.value) {
        // Soft tinted sidebar: nearly white with a very faint tier wash
        return { background: lighten(tierHex.value, 0.94) }
    }
    // Dark slate for students (and tutors without a tier) — matches the logo band
    return { background: '#1e293b' }
})

const logoBandStyle = computed(() => {
    if (isTutorWithTier.value) {
        return { background: tierHex.value, borderBottom: 'none' }
    }
    return { background: '#1e293b', borderBottom: 'none' }
})

const logoTextStyle = computed(() => ({ color: '#ffffff' }))

const tierBadgeStyle = computed(() => ({
    background: 'rgba(255,255,255,0.2)',
    color: '#ffffff',
}))

const roleLabelStyle = computed(() => ({
    background: 'rgba(255,255,255,0.18)',
    color: 'rgba(255,255,255,0.9)',
}))

const footerBorderStyle = computed(() => {
    const borderColor = isTutorWithTier.value
        ? lighten(tierHex.value, 0.80)
        : '#e2e8f0'
    return { borderTop: `1px solid ${borderColor}` }
})

const avatarStyle = computed(() => {
    const bg = isTutorWithTier.value ? tierHex.value : '#007B43'
    const ring = isTutorWithTier.value ? lighten(tierHex.value, 0.65) : '#d1fae5'
    return { background: bg, '--tw-ring-color': ring }
})

const nameStyle = computed(() => ({
    color: isTutorWithTier.value ? '#1e293b' : '#1e293b',
}))

const subTextStyle = computed(() => ({
    // Fixed neutral gray — always readable on any light or dark sidebar
    color: isTutorWithTier.value ? '#6b7280' : '#64748b',
}))

const logoutStyle = computed(() => ({
    // Fixed neutral gray — tier-derived colors are too light on pale tinted backgrounds
    color: isTutorWithTier.value ? '#9ca3af' : '#94a3b8',
    opacity: 0.7,
}))

// ── Provide sidebar mode to NavItem children ─────────────────────────────────
provide('sidebarLightMode', isTutorWithTier)

// ── Auth avatar ───────────────────────────────────────────────────────────────
const authAvatar = computed(() =>
    !avatarFailed.value ? (page.props.auth?.user?.avatar ?? null) : null
)

// ── Real-time notification listener ──────────────────────────────────────────
useRealTimeNotifications()

// ── Browser permission prompt ─────────────────────────────────────────────────
const { permitted, requestPermission } = useBrowserNotifications()
const showPermissionPrompt = computed(
    () => typeof Notification !== 'undefined'
       && Notification.permission === 'default'
       && !permitted.value
)

async function grantPermission() {
    await requestPermission()
}

// ── Inertia flash → toast ─────────────────────────────────────────────────────
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) toast.success(flash.success)
        if (flash?.error)   toast.error(flash.error)
    },
    { immediate: true }
)
</script>
<script>
  function loadTawk() {
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/67c5cb6d145462190bce7880/1ilea59ul';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
  }

  if ('requestIdleCallback' in window) {
    requestIdleCallback(loadTawk);
  } else {
    window.addEventListener('load', function () {
      setTimeout(loadTawk, 1000);
    });
  }
</script>

<style>
/* Light-mode nav items for tier-coloured tutor sidebar */
.nav-item--light {
    color: #374151;
}
.nav-item--light:hover {
    color: #111827;
    background: rgba(0, 0, 0, 0.06);
}
.nav-item--light.active {
    color: #111827;
    background: rgba(0, 0, 0, 0.09);
    font-weight: 600;
}
</style>
