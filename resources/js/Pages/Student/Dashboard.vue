<template>
    <StudentLayout title="Dashboard">
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-xs text-gray-500 mb-1">Wallet Balance</p>
                <p class="text-2xl font-bold text-gray-800">R {{ stats.balance.toFixed(2) }}</p>
                <Link :href="route('student.wallet.index')" class="text-xs text-teal-600 hover:underline mt-1 inline-block">Top up →</Link>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-xs text-gray-500 mb-1">Sessions Attended</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.total_sessions }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-xs text-gray-500 mb-1">Pending Requests</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.pending_bookings }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <!-- Upcoming sessions -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-700">Upcoming Sessions</h2>
                    <Link :href="route('student.bookings.index')" class="text-xs text-teal-600 hover:underline">View all</Link>
                </div>
                <div v-if="upcoming.length" class="space-y-3">
                    <div v-for="b in upcoming" :key="b.id"
                        class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="font-medium text-gray-800">{{ b.subject }}</p>
                            <p class="text-xs text-gray-500">{{ b.tutor_name }} · {{ b.duration }}min</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">{{ formatDate(b.scheduled_at) }}</p>
                            <Link
                                v-if="b.session_id && (b.status === 'in_progress' || b.status === 'accepted')"
                                :href="route('student.session.join', b.session_id)"
                                class="text-xs text-teal-600 font-semibold hover:underline"
                            >{{ b.status === 'in_progress' ? 'Join now →' : 'Join →' }}</Link>
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-400 text-center py-4">
                    No upcoming sessions.
                    <Link :href="route('student.discover')" class="text-teal-600 hover:underline">Find a tutor →</Link>
                </p>
            </div>

            <!-- Recent sessions needing review -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Recent Sessions</h2>
                <div v-if="recent_completed.length" class="space-y-3">
                    <div v-for="b in recent_completed" :key="b.id"
                        class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="font-medium text-gray-800">{{ b.subject }}</p>
                            <p class="text-xs text-gray-500">{{ b.tutor_name }} · {{ formatDate(b.scheduled_at) }}</p>
                        </div>
                        <Link
                            :href="route('student.bookings.show', b.id)"
                            :class="!b.has_review ? 'bg-teal-600 text-white hover:bg-teal-700' : 'text-gray-400 hover:underline'"
                            class="text-xs font-medium px-2.5 py-1 rounded-lg transition-colors"
                        >{{ !b.has_review ? 'Leave Review' : 'View' }}</Link>
                    </div>
                </div>
                <p v-else class="text-gray-400 text-center py-4">No completed sessions yet.</p>
            </div>
        </div>

        <!-- Recommended tutors -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Recommended Tutors</h2>
                <Link :href="route('student.discover')" class="text-xs text-teal-600 hover:underline">Browse all →</Link>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <Link
                    v-for="t in recommended" :key="t.id"
                    :href="route('student.tutor.profile', t.id)"
                    class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-teal-300 hover:shadow-sm transition-all"
                >
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                            {{ t.name.charAt(0) }}
                        </div>
                        <span v-if="t.tier"
                            class="px-2 py-0.5 rounded-full text-xs font-bold text-white"
                            :style="{ background: '#' + t.tier_colour }">
                            {{ t.tier }}
                        </span>
                    </div>
                    <p class="font-semibold text-gray-800 text-sm">{{ t.name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ (t.subjects || []).slice(0,2).join(', ') }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-yellow-500 font-medium">★ {{ t.average_rating.toFixed(1) }}</span>
                        <span class="font-bold text-gray-800">R{{ t.hourly_rate }}/hr</span>
                    </div>
                </Link>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { Link }         from '@inertiajs/vue3'
import StudentLayout    from '@/Layouts/StudentLayout.vue'
import { fmtDateShort } from '@/utils/time'

defineProps({ stats: Object, upcoming: Array, recent_completed: Array, recommended: Array })

const formatDate = fmtDateShort
</script>