<template>
    <AdminLayout title="KYC Review">
        <!-- Stats row -->
        <div class="grid grid-cols-4 gap-4 mb-5">
            <div
                v-for="(count, label) in stats"
                :key="label"
                class="bg-white rounded-xl border border-gray-200 p-4 text-center cursor-pointer hover:border-indigo-300 transition-colors"
                @click="filterByStatus(label)"
            >
                <p class="text-2xl font-bold text-gray-900">{{ count }}</p>
                <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ label.replace('_', ' ') }}</p>
            </div>
        </div>

        <DataTable
            :columns="columns"
            :rows="applications.data"
            :pagination="applications"
            search-placeholder="Search..."
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
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="resubmitted">Resubmitted</option>
                </select>
            </template>

            <template #default="{ row }">
                <td class="px-5 py-3 font-medium text-gray-800">{{ row.user?.name }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ row.user?.email }}</td>
                <td class="px-5 py-3 text-xs capitalize text-gray-600">
                    {{ row.application_type?.replace('_', ' ') }}
                </td>
                <td class="px-5 py-3"><StatusBadge :status="row.status" /></td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.submitted_at }}</td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.reviewed_by || '—' }}</td>
                <td class="px-5 py-3">
                    <Link
                        :href="route('admin.kyc.show', row.id)"
                        class="text-indigo-600 hover:underline text-xs font-medium"
                    >
                        Review →
                    </Link>
                </td>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Admin/DataTable.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    applications: { type: Object, required: true },
    stats:        { type: Object, default: () => ({}) },
    filters:      { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'name',  label: 'Applicant' },
    { key: 'email', label: 'Email' },
    { key: 'type',  label: 'Type' },
    { key: 'status',label: 'Status' },
    { key: 'date',  label: 'Submitted' },
    { key: 'reviewer', label: 'Reviewer' },
    { key: 'action', label: '' },
]

const statusFilter = ref(props.filters.status || '')

const applyFilter = () => {
    router.get(route('admin.kyc.index'), { status: statusFilter.value }, { preserveState: true })
}

const filterByStatus = (label) => {
    statusFilter.value = label
    applyFilter()
}
</script>