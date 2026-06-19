<template>
    <TutorLayout title="Dashboard">
        <!-- KYC banner -->
        <div
            v-if="kyc_status !== 'approved'"
            class="mb-6 flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800"
        >
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <span>
                Your KYC verification is <strong>{{ kyc_status.replace('_', ' ') }}</strong>.
                <Link :href="route('tutor.kyc.index')" class="underline ml-1">Complete verification →</Link>
            </span>
        </div>

        <!-- Stats grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <StatCard label="Wallet Balance" :value="'R ' + stats.balance.toFixed(2)" colour="indigo" />
            <StatCard label="In Escrow"      :value="'R ' + stats.escrow_balance.toFixed(2)" colour="amber" />
            <StatCard label="Earned (30d)"   :value="'R ' + stats.earnings_this_month.toFixed(2)" colour="green" />
            <StatCard label="Sessions"       :value="String(stats.total_sessions)" colour="purple" />
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Earnings chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Earnings — last 7 days</h2>
                <div class="flex items-end gap-2 h-32">
                    <template v-for="day in earnings_chart" :key="day.date">
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div
                                class="w-full rounded-t bg-indigo-500 transition-all"
                                :style="{ height: barHeight(day.total) + 'px' }"
                                :title="'R ' + day.total.toFixed(2)"
                            />
                            <span class="text-xs text-gray-400">{{ day.label }}</span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tier progress -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-3">Tier Progress</h2>
                <div v-if="tier" class="flex items-center gap-2 mb-3">
                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-bold text-white"
                        :style="{ background: '#' + tier.colour }"
                    >{{ tier.name }}</span>
                    <span class="text-xs text-gray-500">{{ tier.commission_rate }}% commission</span>
                </div>
                <div v-if="next_tier">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>→ {{ next_tier.name }}</span>
                        <span>{{ next_tier.remaining }} sessions to go</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div
                            class="h-full bg-indigo-500 rounded-full transition-all"
                            :style="{ width: next_tier.progress + '%' }"
                        />
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ next_tier.progress }}% to {{ next_tier.name }}</p>
                </div>
                <p v-else class="text-xs text-gray-400">You've reached the highest tier!</p>

                <!-- Rating -->
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Average Rating</p>
                    <div class="flex items-center gap-1">
                        <span class="text-xl font-bold text-gray-800">{{ stats.average_rating.toFixed(1) }}</span>
                        <span class="text-yellow-400 text-lg">★</span>
                        <span class="text-xs text-gray-400">({{ stats.total_reviews }} reviews)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming bookings + Recent reviews -->
        <div class="grid lg:grid-cols-2 gap-6 mt-6">
            <!-- Upcoming -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-700">Upcoming Sessions</h2>
                    <Link :href="route('tutor.bookings.index')" class="text-xs text-indigo-600 hover:underline">View all</Link>
                </div>
                <div v-if="upcoming.length" class="space-y-3">
                    <div
                        v-for="b in upcoming" :key="b.id"
                        class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0"
                    >
                        <div>
                            <p class="font-medium text-gray-800">{{ b.subject }}</p>
                            <p class="text-xs text-gray-500">{{ b.student_name }} · {{ b.duration }}min</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-700">R {{ b.total.toFixed(2) }}</p>
                            <p class="text-xs text-gray-400">{{ formatDate(b.scheduled_at) }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-400">No upcoming sessions.</p>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Recent Reviews</h2>
                <div v-if="reviews.length" class="space-y-3">
                    <div
                        v-for="r in reviews" :key="r.reviewer"
                        class="py-2 border-b border-gray-50 last:border-0"
                    >
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-medium text-gray-800">{{ r.reviewer }}</span>
                            <span class="text-yellow-400 text-sm">{{ '★'.repeat(r.rating) }}<span class="text-gray-200">{{ '★'.repeat(5 - r.rating) }}</span></span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ r.comment || 'No comment left.' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ r.date }}</p>
                    </div>
                </div>
                <p v-else class="text-gray-400">No reviews yet.</p>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { Link }          from '@inertiajs/vue3'
import TutorLayout       from '@/Layouts/TutorLayout.vue'
import StatCard          from '@/Components/Admin/StatCard.vue'
import { fmtDateShort }  from '@/utils/time'

const props = defineProps({
    stats:          Object,
    tier:           Object,
    next_tier:      Object,
    upcoming:       Array,
    earnings_chart: Array,
    reviews:        Array,
    kyc_status:     String,
    is_available:   Boolean,
})

const maxEarning = Math.max(...props.earnings_chart.map(d => d.total), 1)
const barHeight  = (val) => Math.max(4, Math.round((val / maxEarning) * 112))

const formatDate = fmtDateShort
</script>