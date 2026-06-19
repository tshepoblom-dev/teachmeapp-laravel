<template>
    <AdminLayout title="Session Monitor">
        <!-- Active sessions badge -->
        <div class="mb-4 flex items-center gap-3">
            <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse" />
                <span class="font-semibold text-green-700">{{ activeSessions }} active</span>
            </div>
            <select
                v-model="statusFilter"
                @change="applyFilter"
                class="border border-gray-200 rounded-lg px-3 py-2"
            >
                <option value="">All sessions</option>
                <option value="waiting">Waiting</option>
                <option value="active">Active</option>
                <option value="ended">Ended</option>
                <option value="abandoned">Abandoned</option>
                <option value="disputed">Disputed</option>
            </select>
        </div>

        <DataTable
            :columns="columns"
            :rows="sessions.data"
            :pagination="sessions"
            :searchable="false"
        >
            <template #default="{ row }">
                <td class="px-5 py-3 text-xs text-gray-400">#{{ row.id }}</td>
                <td class="px-5 py-3">
                    <StatusBadge :status="row.status" />
                </td>
                <td class="px-5 py-3 text-gray-700">{{ row.student }}</td>
                <td class="px-5 py-3 text-gray-700">{{ row.tutor }}</td>
                <td class="px-5 py-3 text-xs text-gray-400">
                    {{ row.started_at ? fmtDateLong(row.started_at) : '—' }}
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">
                    {{ row.duration_seconds ? `${Math.round(row.duration_seconds / 60)} min` : '—' }}
                </td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ row.last_keepalive || '—' }}</td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a
                            v-if="row.recording_url"
                            :href="row.recording_url"
                            target="_blank"
                            class="text-xs text-indigo-600 hover:underline"
                        >
                            Recording
                        </a>
                        <button
                            v-if="row.status === 'active'"
                            @click="forceEnd(row)"
                            class="text-xs text-red-500 hover:underline"
                        >
                            Force End
                        </button>
                    </div>
                </td>
            </template>
        </DataTable>

        <!-- Force end modal -->
        <div
            v-if="endingSession"
            class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        >
            <div class="bg-white rounded-2xl p-6 w-full max-w-md">
                <h3 class="font-semibold text-gray-900 mb-3">Force End Session #{{ endingSession.id }}</h3>
                <textarea
                    v-model="forceEndReason"
                    placeholder="Reason for forced end *"
                    rows="3"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-4 focus:outline-none"
                />
                <div class="flex gap-3">
                    <button
                        @click="confirmForceEnd"
                        :disabled="!forceEndReason"
                        class="flex-1 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 disabled:opacity-50"
                    >
                        End Session
                    </button>
                    <button
                        @click="endingSession = null; forceEndReason = ''"
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
import { fmtDateLong } from '@/utils/time'

const props = defineProps({
    sessions:       { type: Object, required: true },
    activeSessions: { type: Number, default: 0 },
    filters:        { type: Object, default: () => ({}) },
})

const columns = [
    { key: 'id',         label: '#' },
    { key: 'status',     label: 'Status' },
    { key: 'student',    label: 'Student' },
    { key: 'tutor',      label: 'Tutor' },
    { key: 'started',    label: 'Started' },
    { key: 'duration',   label: 'Duration' },
    { key: 'keepalive',  label: 'Last Ping' },
    { key: 'actions',    label: '' },
]

const statusFilter  = ref(props.filters.status || '')
const endingSession = ref(null)
const forceEndReason = ref('')

const applyFilter = () => {
    router.get(route('admin.sessions.index'), { status: statusFilter.value }, { preserveState: true })
}

const forceEnd = (session) => {
    endingSession.value = session
}

const confirmForceEnd = () => {
    router.post(
        route('admin.sessions.force-end', endingSession.value.id),
        { reason: forceEndReason.value },
        {
            onSuccess: () => {
                endingSession.value  = null
                forceEndReason.value = ''
            },
        }
    )
}
</script>