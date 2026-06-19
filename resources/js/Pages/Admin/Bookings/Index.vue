<template>
    <AdminLayout title="Bookings">
        <DataTable
            :columns="columns"
            :rows="bookings.data"
            :pagination="bookings"
            search-placeholder="Search by subject..."
            @search="search"
        >
            <template #filters>
                <select
                    v-model="filters.status"
                    @change="applyFilters"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">All statuses</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="disputed">Disputed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </template>

            <template #default="{ row }">
                <td class="px-5 py-3 text-xs text-gray-400">#{{ row.id }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ row.subject }}</td>
                <td class="px-5 py-3 text-gray-600 text-sm">{{ row.student }}</td>
                <td class="px-5 py-3 text-gray-600 text-sm">{{ row.tutor }}</td>
                <td class="px-5 py-3 font-medium">R {{ Number(row.total_amount).toFixed(2) }}</td>
                <td class="px-5 py-3">
                    <StatusBadge :status="row.status" />
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">
                    {{ row.scheduled_at ? fmtDateOnly(row.scheduled_at) : '—' }}
                </td>
                <td class="px-5 py-3">
                    <Link
                        :href="route('admin.bookings.show', row.id)"
                        class="text-indigo-600 hover:underline text-xs font-medium"
                    >
                        View →
                    </Link>
                </td>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'
import { fmtDateOnly } from '@/utils/time'

const props = defineProps({
    bookings: { type: Object, required: true },
    filters:  { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'id',       label: '#' },
    { key: 'subject',  label: 'Subject' },
    { key: 'student',  label: 'Student' },
    { key: 'tutor',    label: 'Tutor' },
    { key: 'amount',   label: 'Amount' },
    { key: 'status',   label: 'Status' },
    { key: 'scheduled',label: 'Scheduled' },
    { key: 'action',   label: '' },
]

const filters = reactive({ ...props.filters })

const applyFilters = () => {
    router.get(route('admin.bookings.index'), filters, { preserveState: true, replace: true })
}

const search = (q) => {
    filters.search = q
    applyFilters()
}
</script>