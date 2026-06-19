<template>
    <AdminLayout title="Payouts">
        <!-- Summary -->
        <div class="grid grid-cols-3 gap-4 mb-5">
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Pending</p>
                <p class="text-xl font-bold text-yellow-600">R {{ Number(summary.pending).toFixed(2) }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Processing</p>
                <p class="text-xl font-bold text-blue-600">R {{ Number(summary.processing).toFixed(2) }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Completed</p>
                <p class="text-xl font-bold text-green-600">R {{ Number(summary.completed).toFixed(2) }}</p>
            </div>
        </div>

        <DataTable
            :columns="columns"
            :rows="payouts.data"
            :pagination="payouts"
            :searchable="false"
        >
            <template #filters>
                <select
                    v-model="statusFilter"
                    @change="applyFilter"
                    class="border border-gray-200 rounded-lg px-3 py-1.5"
                >
                    <option value="">All statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="failed">Failed</option>
                </select>
            </template>

            <template #default="{ row }">
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.reference }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ row.tutor }}</td>
                <td class="px-5 py-3 text-gray-500">{{ row.tutor_email }}</td>
                <td class="px-5 py-3 font-bold text-gray-900">R {{ Number(row.amount).toFixed(2) }}</td>
                <td class="px-5 py-3 text-gray-500 capitalize">
                    {{ row.bank_name || row.account_type || '—' }}
                </td>
                <td class="px-5 py-3">
                    <StatusBadge :status="row.status" />
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.created_at }}</td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <button
                            v-if="row.status === 'pending'"
                            @click="markProcessing(row)"
                            class="text-xs text-blue-600 hover:underline"
                        >
                            Processing
                        </button>
                        <button
                            v-if="row.status === 'processing'"
                            @click="openComplete(row)"
                            class="text-xs text-green-600 hover:underline"
                        >
                            Complete
                        </button>
                        <button
                            v-if="['pending','processing'].includes(row.status)"
                            @click="openFail(row)"
                            class="text-xs text-red-500 hover:underline"
                        >
                            Fail
                        </button>
                    </div>
                </td>
            </template>
        </DataTable>

        <!-- Complete modal -->
        <div
            v-if="completingPayout"
            class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm">
                <h3 class="font-semibold text-gray-900 mb-4">Mark Payout Completed</h3>
                <input
                    v-model="externalId"
                    type="text"
                    placeholder="External payout ID (optional)"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-4"
                />
                <div class="flex gap-3">
                    <button
                        @click="confirmComplete"
                        class="flex-1 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700"
                    >
                        Mark Completed
                    </button>
                    <button
                        @click="completingPayout = null"
                        class="flex-1 py-2 border border-gray-200 text-gray-600 rounded-lg"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Fail modal -->
        <div
            v-if="failingPayout"
            class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl p-6 w-full max-w-sm">
                <h3 class="font-semibold text-gray-900 mb-4">Mark Payout Failed</h3>
                <textarea
                    v-model="failReason"
                    placeholder="Failure reason *"
                    rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-4"
                />
                <div class="flex gap-3">
                    <button
                        @click="confirmFail"
                        :disabled="!failReason"
                        class="flex-1 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 disabled:opacity-50"
                    >
                        Mark Failed
                    </button>
                    <button
                        @click="failingPayout = null"
                        class="flex-1 py-2 border border-gray-200 text-gray-600 rounded-lg"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    payouts:  { type: Object, required: true },
    summary:  { type: Object, default: () => ({}) },
    filters:  { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'ref',      label: 'Reference' },
    { key: 'tutor',    label: 'Tutor' },
    { key: 'email',    label: 'Email' },
    { key: 'amount',   label: 'Amount' },
    { key: 'account',  label: 'Account' },
    { key: 'status',   label: 'Status' },
    { key: 'date',     label: 'Requested' },
    { key: 'actions',  label: '' },
]

const statusFilter    = ref(props.filters.status || '')
const completingPayout = ref(null)
const failingPayout   = ref(null)
const externalId      = ref('')
const failReason      = ref('')

const applyFilter = () => {
    router.get(route('admin.payouts.index'), { status: statusFilter.value }, { preserveState: true })
}

const markProcessing = (payout) => {
    router.post(route('admin.payouts.processing', payout.id))
}

const openComplete = (payout) => { completingPayout.value = payout }
const openFail     = (payout) => { failingPayout.value = payout }

const confirmComplete = () => {
    router.post(
        route('admin.payouts.complete', completingPayout.value.id),
        { external_payout_id: externalId.value },
        { onSuccess: () => { completingPayout.value = null; externalId.value = '' } }
    )
}

const confirmFail = () => {
    router.post(
        route('admin.payouts.fail', failingPayout.value.id),
        { failure_reason: failReason.value },
        { onSuccess: () => { failingPayout.value = null; failReason.value = '' } }
    )
}
</script>