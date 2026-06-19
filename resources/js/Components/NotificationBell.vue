<template>
    <div class="relative" ref="bellRef">

        <!-- Bell button -->
        <button
            @click="open = !open"
            class="relative p-2 rounded-lg transition-colors hover:bg-gray-100 focus:outline-none"
            :class="open ? 'bg-gray-100' : ''"
            aria-label="Notifications"
        >
            <!-- Animated bell when there are new unread items -->
            <svg
                class="w-5 h-5 transition-transform"
                :class="hasNew ? 'animate-bell' : ''"
                style="color:#141F3E;"
                fill="none" viewBox="0 0 24 24"
                stroke-width="1.6" stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>

            <!-- Badge -->
            <span
                v-if="unreadCount > 0"
                class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] h-[1.1rem] flex items-center
                       justify-center text-[10px] font-bold text-white rounded-full px-1 leading-none
                       transition-all duration-300"
                style="background:#007B43;"
            >
                {{ unreadCount > 99 ? '99+' : unreadCount }}
            </span>

            <!-- Real-time pulse ring (shows briefly when a new notification arrives) -->
            <span
                v-if="hasNew"
                class="absolute inset-0 rounded-lg animate-ping-once"
                style="background:rgba(0,123,67,.15);"
            />
        </button>

        <!-- Dropdown panel -->
        <Transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 scale-95 translate-y-1"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 translate-y-1"
        >
            <div
                v-if="open"
                class="absolute right-0 mt-2 w-80 rounded-2xl bg-white shadow-xl z-50 overflow-hidden"
                style="border:1px solid #E2E5EE;"
            >
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3"
                     style="border-bottom:1px solid #f3f4f6;">
                    <span class="font-semibold" style="color:#141F3E;">
                        Notifications
                        <span v-if="unreadCount > 0"
                              class="ml-1.5 text-xs font-bold text-white rounded-full px-1.5 py-0.5"
                              style="background:#007B43;">
                            {{ unreadCount }}
                        </span>
                    </span>
                    <button
                        v-if="unreadCount > 0"
                        @click="markAllRead"
                        class="text-xs font-medium transition-colors"
                        style="color:#007B43;"
                        :class="marking ? 'opacity-50 cursor-wait' : 'hover:opacity-75'"
                        :disabled="marking"
                    >
                        Mark all read
                    </button>
                </div>

                <!-- List -->
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                    <template v-if="notifications.length">
                        <button
                            v-for="n in notifications"
                            :key="n.id"
                            @click="handleClick(n)"
                            class="w-full flex items-start gap-3 px-4 py-3.5 text-left
                                   hover:bg-gray-50 transition-colors group"
                            :class="n._new ? 'bg-green-50/60' : ''"
                        >
                            <!-- Icon dot -->
                            <span class="mt-1 w-2 h-2 rounded-full shrink-0"
                                  :style="iconColor(n.type)"/>

                            <div class="flex-1 min-w-0">
                                <p class="leading-snug text-gray-800 line-clamp-2 text-sm">
                                    {{ n.message }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ n.created_at }}</p>
                            </div>

                            <!-- "New" badge for items that arrived via real-time -->
                            <span v-if="n._new"
                                  class="shrink-0 text-[10px] font-bold uppercase tracking-wide
                                         rounded-full px-1.5 py-0.5 mt-0.5"
                                  style="background:#dcfce7;color:#15803d;">
                                New
                            </span>
                        </button>
                    </template>

                    <!-- Empty -->
                    <div v-else class="py-10 text-center">
                        <svg class="w-10 h-10 mx-auto text-gray-200 mb-2" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <p class="text-gray-400">You're all caught up!</p>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page    = usePage()
const open    = ref(false)
const marking = ref(false)
const bellRef = ref(null)
const hasNew  = ref(false)  // triggers the pulse animation

// These are reactive because useRealTimeNotifications mutates page.props directly
const notifications = computed(() => page.props.unreadNotifications ?? [])
const unreadCount   = computed(() => page.props.unreadCount ?? 0)

// When a new notification is injected by useRealTimeNotifications, mark it
// with _new so we can highlight it and trigger the bell animation
watch(
    () => page.props.unreadNotifications?.length,
    (newLen, oldLen) => {
        if (newLen > oldLen) {
            hasNew.value = true
            // Mark the freshly prepended items
            const added = newLen - oldLen
            for (let i = 0; i < added; i++) {
                if (page.props.unreadNotifications[i]) {
                    page.props.unreadNotifications[i]._new = true
                }
            }
            // Clear the animation flag after 3 s
            setTimeout(() => { hasNew.value = false }, 3000)
        }
    }
)

// Close on outside click
function onOutside(e) {
    if (bellRef.value && !bellRef.value.contains(e.target)) open.value = false
}
onMounted(()      => document.addEventListener('mousedown', onOutside))
onBeforeUnmount(() => document.removeEventListener('mousedown', onOutside))

function iconColor(type) {
    const map = {
        booking_accepted:  'background:#007B43',
        booking_cancelled: 'background:#ef4444',
        booking_completed: 'background:#3b82f6',
        booking_request:   'background:#f59e0b',
        payment_received:  'background:#f59e0b',
        kyc_approved:      'background:#007B43',
        kyc_rejected:      'background:#ef4444',
        session_starting:  'background:#8b5cf6',
        session_started:   'background:#8b5cf6',
        session_ended:     'background:#6b7280',
        tier_upgraded:     'background:#f59e0b',
    }
    return (map[type] ?? 'background:#9ca3af') + ';'
}

function handleClick(n) {
    open.value = false
    // Remove the _new flag immediately
    if (n._new) delete n._new
    router.post(route('notifications.read', n.id), {}, { preserveScroll: true })
}

function markAllRead() {
    if (marking.value) return
    marking.value = true
    // Clear all _new flags
    notifications.value.forEach(n => { delete n._new })
    router.post(route('notifications.read-all'), {}, {
        preserveScroll: true,
        onFinish: () => { marking.value = false },
    })
}
</script>

<style scoped>
@keyframes bell-swing {
    0%,100% { transform: rotate(0deg);    }
    20%     { transform: rotate(12deg);   }
    40%     { transform: rotate(-10deg);  }
    60%     { transform: rotate(8deg);    }
    80%     { transform: rotate(-6deg);   }
}
.animate-bell {
    animation: bell-swing 0.6s ease-in-out;
}

@keyframes ping-once {
    0%   { opacity: 0.6; transform: scale(1);    }
    100% { opacity: 0;   transform: scale(1.6);  }
}
.animate-ping-once {
    animation: ping-once 0.8s ease-out forwards;
}
</style>
