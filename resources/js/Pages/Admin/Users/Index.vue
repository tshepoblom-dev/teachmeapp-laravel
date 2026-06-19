<template>
    <AdminLayout title="User Management">
        <DataTable
            :columns="columns"
            :rows="users.data"
            :pagination="users"
            search-placeholder="Search by name or email..."
            @search="search"
        >
            <template #filters>
                <select
                    v-model="filters.role"
                    @change="applyFilters"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">All roles</option>
                    <option value="student">Student</option>
                    <option value="tutor">Tutor</option>
                    <option value="admin">Admin</option>
                </select>

                <select
                    v-model="filters.status"
                    @change="applyFilters"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">All statuses</option>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                    <option value="banned">Banned</option>
                    <option value="pending_kyc">Pending KYC</option>
                </select>
            </template>

            <template #default="{ row }">
                <td class="px-5 py-3 font-medium text-gray-800">{{ row.name }}</td>
                <td class="px-5 py-3 text-gray-500">{{ row.email }}</td>
                <td class="px-5 py-3">
                    <span class="capitalize text-xs font-medium text-gray-600">{{ row.role }}</span>
                </td>
                <td class="px-5 py-3">
                    <StatusBadge :status="row.account_status" />
                </td>
                <td class="px-5 py-3">
                    <StatusBadge v-if="row.kyc_status" :status="row.kyc_status" />
                    <span v-else class="text-xs text-gray-400">—</span>
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.created_at }}</td>
                <td class="px-5 py-3">
                    <Link
                        :href="route('admin.users.show', row.id)"
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

const props = defineProps({
    users:   { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'name',  label: 'Name' },
    { key: 'email', label: 'Email' },
    { key: 'role',  label: 'Role' },
    { key: 'status',label: 'Status' },
    { key: 'kyc',   label: 'KYC' },
    { key: 'joined',label: 'Joined' },
    { key: 'action',label: '' },
]

const filters = reactive({ ...props.filters })

const applyFilters = () => {
    router.get(route('admin.users.index'), filters, { preserveState: true, replace: true })
}

const search = (q) => {
    filters.search = q
    applyFilters()
}
</script>