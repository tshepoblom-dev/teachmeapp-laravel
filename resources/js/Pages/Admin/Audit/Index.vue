<template>
    <AdminLayout title="Audit Logs">
        <!-- Filters -->
        <div class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex flex-wrap items-center gap-3">
            <input
                v-model="filters.action"
                type="text"
                placeholder="Filter by action..."
                class="border border-gray-200 rounded-lg px-3 py-1.5 w-44 focus:outline-none"
            />
            <select
                v-model="filters.target_type"
                class="border border-gray-200 rounded-lg px-3 py-1.5"
            >
                <option value="">All targets</option>
                <option value="booking">Booking</option>
                <option value="session">Session</option>
                <option value="kyc_application">KYC</option>
                <option value="user">User</option>
            </select>
            <input
                v-model="filters.from"
                type="date"
                class="border border-gray-200 rounded-lg px-3 py-1.5"
            />
            <input
                v-model="filters.to"
                type="date"
                class="border border-gray-200 rounded-lg px-3 py-1.5"
            />
            <button
                @click="applyFilters"
                class="px-4 py-1.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700"
            >
                Apply
            </button>
            <button
                @click="resetFilters"
                class="text-gray-400 hover:text-gray-600"
            >
                Reset
            </button>
        </div>

        <!-- Logs table -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Time</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Target</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Changes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <template v-for="log in logs.data" :key="log.id">
                        <tr
                            class="hover:bg-gray-50 cursor-pointer"
                            @click="expanded = expanded === log.id ? null : log.id"
                        >
                            <td class="px-5 py-3 text-xs text-gray-400 whitespace-nowrap">
                                {{ fmtDateLong(log.created_at) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="font-mono text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                                    {{ log.action }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-500 capitalize">
                                {{ log.target_type }} #{{ log.target_id }}
                            </td>
                            <td class="px-5 py-3 text-gray-700">{{ log.user }}</td>
                            <td class="px-5 py-3 text-xs text-gray-400">
                                {{ expanded === log.id ? '▲ Hide' : '▼ Show' }}
                            </td>
                        </tr>

                        <!-- Expanded diff view -->
                        <tr v-if="expanded === log.id">
                            <td colspan="5" class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div v-if="log.old_values">
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Before</p>
                                        <pre class="text-xs bg-red-50 text-red-700 p-3 rounded-lg overflow-auto">{{ JSON.stringify(log.old_values, null, 2) }}</pre>
                                    </div>
                                    <div v-if="log.new_values">
                                        <p class="text-xs font-semibold text-gray-500 mb-1">After</p>
                                        <pre class="text-xs bg-green-50 text-green-700 p-3 rounded-lg overflow-auto">{{ JSON.stringify(log.new_values, null, 2) }}</pre>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <tr v-if="!logs.data.length">
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            No audit logs found.
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div
                v-if="logs.last_page > 1"
                class="flex items-center justify-between px-5 py-3 border-t border-gray-100"
            >
                <p class="text-xs text-gray-500">
                    Showing {{ logs.from }}–{{ logs.to }} of {{ logs.total }}
                </p>
                <div class="flex gap-1">
                    <Link
                        v-for="link in logs.links"
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="[
                            'px-3 py-1 text-xs rounded-lg border transition-colors',
                            link.active ? 'bg-indigo-600 text-white border-indigo-600' : 'border-gray-200 text-gray-600 hover:bg-gray-50',
                            !link.url ? 'opacity-40 pointer-events-none' : '',
                        ]"
                        preserve-scroll
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { fmtDateLong } from '@/utils/time'

const props = defineProps({
    logs:    { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
})

const expanded = ref(null)

const filters = reactive({
    action:      props.filters.action      || '',
    target_type: props.filters.target_type || '',
    from:        props.filters.from        || '',
    to:          props.filters.to          || '',
})

const applyFilters = () => {
    router.get(route('admin.audit.index'), filters, { preserveState: true })
}

const resetFilters = () => {
    Object.assign(filters, { action: '', target_type: '', from: '', to: '' })
    applyFilters()
}
</script>