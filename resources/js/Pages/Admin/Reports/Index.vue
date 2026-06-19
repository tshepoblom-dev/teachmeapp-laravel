<template>
    <AdminLayout title="Reports">
        <DataTable
            :columns="columns"
            :rows="reports.data"
            :pagination="reports"
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
                    <option value="under_review">Under Review</option>
                    <option value="resolved">Resolved</option>
                    <option value="dismissed">Dismissed</option>
                </select>
            </template>

            <template #default="{ row }">
                <td class="px-5 py-3 text-xs text-gray-400">#{{ row.id }}</td>
                <td class="px-5 py-3 text-gray-800 max-w-xs truncate">{{ row.reason }}</td>
                <td class="px-5 py-3 text-gray-600">{{ row.reporter }}</td>
                <td class="px-5 py-3 text-gray-600">{{ row.reported }}</td>
                <td class="px-5 py-3">
                    <StatusBadge :status="row.status" />
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.created_at }}</td>
                <td class="px-5 py-3">
                    <div v-if="row.status === 'pending' || row.status === 'under_review'" class="flex gap-2">
                        <button
                            @click="resolve(row, 'resolved')"
                            class="text-xs text-green-600 hover:underline font-medium"
                        >
                            Resolve
                        </button>
                        <button
                            @click="resolve(row, 'dismissed')"
                            class="text-xs text-gray-400 hover:underline"
                        >
                            Dismiss
                        </button>
                    </div>
                    <span v-else class="text-xs text-gray-300">{{ row.resolved_by || '—' }}</span>
                </td>
            </template>
        </DataTable>

        <!-- Resolve modal -->
        <div
            v-if="resolvingReport"
            class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl p-6 w-full max-w-md">
                <h3 class="font-semibold text-gray-900 mb-1">
                    {{ resolveAction === 'resolved' ? 'Resolve' : 'Dismiss' }} Report #{{ resolvingReport.id }}
                </h3>
                <p class="text-gray-500 mb-4">{{ resolvingReport.reason }}</p>
                <textarea
                    v-model="adminNotes"
                    placeholder="Admin notes (optional)"
                    rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-4 focus:outline-none"
                />
                <div class="flex gap-3">
                    <button
                        @click="confirmResolve"
                        class="flex-1 py-2 font-semibold rounded-lg text-white transition-colors"
                        :class="resolveAction === 'resolved' ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-600'"
                    >
                        {{ resolveAction === 'resolved' ? 'Mark Resolved' : 'Dismiss' }}
                    </button>
                    <button
                        @click="resolvingReport = null"
                        class="flex-1 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50"
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
    reports: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'id',       label: '#' },
    { key: 'reason',   label: 'Reason' },
    { key: 'reporter', label: 'Reporter' },
    { key: 'reported', label: 'Reported' },
    { key: 'status',   label: 'Status' },
    { key: 'date',     label: 'Date' },
    { key: 'actions',  label: '' },
]

const statusFilter    = ref(props.filters.status || '')
const resolvingReport = ref(null)
const resolveAction   = ref('')
const adminNotes      = ref('')

const applyFilter = () => {
    router.get(route('admin.reports.index'), { status: statusFilter.value }, { preserveState: true })
}

const resolve = (report, action) => {
    resolvingReport.value = report
    resolveAction.value   = action
}

const confirmResolve = () => {
    // Map resolve action to the correct named route
    const actionRoutes = {
        warn:    'admin.reports.warn',
        suspend: 'admin.reports.suspend',
        dismiss: 'admin.reports.dismiss',
    }
    const routeName = actionRoutes[resolveAction.value] ?? 'admin.reports.dismiss'
    router.post(
        route(routeName, resolvingReport.value.id),
        { admin_notes: adminNotes.value },
        {
            onSuccess: () => {
                resolvingReport.value = null
                adminNotes.value      = ''
            },
        }
    )
}
</script>