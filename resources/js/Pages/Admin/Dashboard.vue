<template>
    <AdminLayout title="Dashboard">
        <!-- Stats grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <StatCard label="Total Users" :value="stats.total_users" icon-bg="bg-blue-50">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </StatCard>

            <StatCard label="Active Sessions" :value="stats.active_sessions" icon-bg="bg-green-50">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </StatCard>

            <StatCard label="Pending KYC" :value="stats.pending_kyc" icon-bg="bg-yellow-50">
                <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </StatCard>

            <StatCard
                label="Revenue (30d)"
                :value="`R ${revenue.toFixed(2)}`"
                icon-bg="bg-indigo-50"
            >
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </StatCard>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Revenue chart -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Revenue — Last 14 Days</h2>
                <div class="h-48 flex items-end gap-1">
                    <template v-if="revenueChart.length">
                        <div
                            v-for="day in revenueChart"
                            :key="day.date"
                            class="flex-1 flex flex-col items-center gap-1"
                        >
                            <div
                                class="w-full bg-indigo-500 rounded-t"
                                :style="{ height: barHeight(day.total) }"
                                :title="`${day.date}: R${day.total.toFixed(2)}`"
                            />
                            <span class="text-[9px] text-gray-400 rotate-45 origin-left">
                                {{ day.date.slice(5) }}
                            </span>
                        </div>
                    </template>
                    <p v-else class="text-gray-400 mx-auto">No revenue data yet.</p>
                </div>
            </div>

            <!-- Quick stats -->
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="font-semibold text-gray-700 mb-3">Breakdown</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Tutors</dt>
                            <dd class="font-medium">{{ stats.total_tutors }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Students</dt>
                            <dd class="font-medium">{{ stats.total_students }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Pending Bookings</dt>
                            <dd class="font-medium">{{ stats.pending_bookings }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Completed Today</dt>
                            <dd class="font-medium text-green-600">{{ stats.completed_today }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">New Users (7d)</dt>
                            <dd class="font-medium">{{ newUsers }}</dd>
                        </div>
                    </dl>
                </div>

                <Link
                    :href="route('admin.kyc.index')"
                    v-if="stats.pending_kyc > 0"
                    class="block bg-yellow-50 border border-yellow-200 rounded-xl p-4 hover:bg-yellow-100 transition-colors"
                >
                    <p class="font-semibold text-yellow-800">
                        {{ stats.pending_kyc }} KYC application{{ stats.pending_kyc > 1 ? 's' : '' }} awaiting review
                    </p>
                    <p class="text-xs text-yellow-600 mt-0.5">Click to review →</p>
                </Link>
            </div>
        </div>

        <!-- Recent bookings -->
        <div class="mt-5 bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-700">Recent Bookings</h2>
                <Link :href="route('admin.bookings.index')" class="text-xs text-indigo-600 hover:underline">
                    View all →
                </Link>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">#</th>
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">Subject</th>
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">Student</th>
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">Tutor</th>
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">Amount</th>
                        <th class="px-5 py-2 text-left text-xs text-gray-500 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr v-for="b in recentBookings" :key="b.id" class="hover:bg-gray-50">
                        <td class="px-5 py-2.5 text-gray-400 text-xs">#{{ b.id }}</td>
                        <td class="px-5 py-2.5 font-medium text-gray-800">{{ b.subject }}</td>
                        <td class="px-5 py-2.5 text-gray-600">{{ b.student }}</td>
                        <td class="px-5 py-2.5 text-gray-600">{{ b.tutor }}</td>
                        <td class="px-5 py-2.5 font-medium">R {{ b.total_amount?.toFixed(2) }}</td>
                        <td class="px-5 py-2.5">
                            <StatusBadge :status="b.status" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    stats:         { type: Object, required: true },
    revenue:       { type: Number, default: 0 },
    revenueChart:  { type: Array,  default: () => [] },
    recentBookings:{ type: Array,  default: () => [] },
    newUsers:      { type: Number, default: 0 },
})

const maxRevenue = computed(() =>
    Math.max(...props.revenueChart.map(d => d.total), 1)
)

const barHeight = (value) => {
    const pct = (value / maxRevenue.value) * 100
    return `${Math.max(pct, 4)}%`
}
</script>