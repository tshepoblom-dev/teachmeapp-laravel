<template>
    <AdminLayout title="Financial Reports">
        <!-- Date range filter -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex items-center gap-3">
            <label class="text-gray-600">From</label>
            <input
                v-model="from"
                type="date"
                class="border border-gray-200 rounded-lg px-3 py-1.5"
            />
            <label class="text-gray-600">To</label>
            <input
                v-model="to"
                type="date"
                class="border border-gray-200 rounded-lg px-3 py-1.5"
            />
            <button
                @click="applyFilters"
                class="px-4 py-1.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700"
            >
                Apply
            </button>
        </div>

        <!-- Summary cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
            <StatCard label="Platform Commission" :value="`R ${summary.commission?.toFixed(2)}`" icon-bg="bg-indigo-50">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </StatCard>
            <StatCard label="Total Deposited" :value="`R ${summary.deposited?.toFixed(2)}`" icon-bg="bg-green-50">
                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                </svg>
            </StatCard>
            <StatCard label="Paid to Tutors" :value="`R ${summary.paid_to_tutors?.toFixed(2)}`" icon-bg="bg-blue-50">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 8.25H9m6 3H9m3 6l-3-3h1.5a3 3 0 100-6M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </StatCard>
            <StatCard label="Refunded" :value="`R ${summary.refunded?.toFixed(2)}`" icon-bg="bg-red-50">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
            </StatCard>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Payment method breakdown -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-3">By Payment Method</h2>
                <div class="space-y-3">
                    <div v-for="m in byMethod" :key="m.code" class="flex items-center justify-between text-sm">
                        <div>
                            <p class="font-medium text-gray-800">{{ m.method }}</p>
                            <p class="text-xs text-gray-400">{{ m.count }} transactions</p>
                        </div>
                        <p class="font-semibold">R {{ m.total?.toFixed(2) }}</p>
                    </div>
                    <p v-if="!byMethod.length" class="text-gray-400 text-center py-4">No data.</p>
                </div>
            </div>

            <!-- Recent releases -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700">Recent Escrow Releases</h2>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Tutor</th>
                            <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Gross</th>
                            <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Fee</th>
                            <th class="px-4 py-2 text-right text-xs text-gray-500 font-medium">Net</th>
                            <th class="px-4 py-2 text-left text-xs text-gray-500 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="r in recentReleases" :key="r.id" class="hover:bg-gray-50">
                            <td class="px-4 py-2.5 font-medium text-gray-800">{{ r.tutor }}</td>
                            <td class="px-4 py-2.5 text-right text-gray-600">R {{ r.gross?.toFixed(2) }}</td>
                            <td class="px-4 py-2.5 text-right text-red-500">-R {{ r.commission?.toFixed(2) }}</td>
                            <td class="px-4 py-2.5 text-right font-semibold text-green-700">R {{ r.net_to_tutor?.toFixed(2) }}</td>
                            <td class="px-4 py-2.5 text-xs text-gray-400">{{ r.released_at }}</td>
                        </tr>
                        <tr v-if="!recentReleases.length">
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">
                                No releases in this period.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'

const props = defineProps({
    summary:        { type: Object, default: () => ({}) },
    dailyRevenue:   { type: Array,  default: () => [] },
    byMethod:       { type: Array,  default: () => [] },
    recentReleases: { type: Array,  default: () => [] },
    filters:        { type: Object, default: () => ({}) },
})

const from = ref(props.filters.from || '')
const to   = ref(props.filters.to || '')

const applyFilters = () => {
    router.get(route('admin.financials.index'), { from: from.value, to: to.value })
}
</script>