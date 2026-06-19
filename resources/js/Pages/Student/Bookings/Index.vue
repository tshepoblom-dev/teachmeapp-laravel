<template>
    <StudentLayout title="My Bookings">
        <div class="flex gap-2 mb-5 flex-wrap">
            <Link
                v-for="s in ['all', ...statuses]" :key="s"
                :href="s === 'all' ? route('student.bookings.index') : route('student.bookings.index', { status: s })"
                class="px-3 py-1.5 rounded-full text-xs font-medium border transition-colors"
                :class="(filter ?? 'all') === s
                    ? 'bg-teal-600 text-white border-teal-600'
                    : 'bg-white text-gray-600 border-gray-200 hover:border-teal-300'"
            >{{ s.charAt(0).toUpperCase() + s.slice(1).replace('_',' ') }}</Link>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-200">
        <div class="bg-white min-w-[640px]">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Tutor</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Subject</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Date</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Duration</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Amount</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-if="!bookings.data.length">
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400">No bookings found.</td>
                    </tr>
                    <tr v-for="b in bookings.data" :key="b.id" class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-800">{{ b.tutor_name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ b.subject }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ fmtDateOnly(b.scheduled_at) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ b.duration }}min</td>
                        <td class="px-4 py-3 font-medium text-gray-800">R{{ b.total.toFixed(2) }}</td>
                        <td class="px-4 py-3">
                            <span :class="statusClass(b.status)" class="px-2 py-0.5 rounded-full text-xs font-medium">
                                {{ b.status.replace('_',' ') }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <Link :href="route('student.bookings.show', b.id)"
                                class="text-teal-600 hover:underline text-xs">
                                {{ !b.has_review && b.status === 'completed' ? 'Review' : 'View' }}
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="bookings.last_page > 1" class="px-4 py-3 border-t border-gray-100 flex gap-2">
                <Link v-for="link in bookings.links" :key="link.label" :href="link.url ?? '#'"
                    class="px-2.5 py-1 rounded text-xs border"
                    :class="link.active ? 'bg-teal-600 text-white border-teal-600' : 'border-gray-200 text-gray-600'"
                    v-html="link.label" />
            </div>
        </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { Link }      from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'
import { fmtDateOnly } from '@/utils/time'

defineProps({ bookings: Object, filter: String, statuses: Array })

const statusClass = (s) => ({
    pending:     'bg-yellow-100 text-yellow-700',
    accepted:    'bg-blue-100 text-blue-700',
    in_progress: 'bg-teal-100 text-teal-700',
    completed:   'bg-green-100 text-green-700',
    cancelled:   'bg-gray-100 text-gray-500',
    disputed:    'bg-red-100 text-red-700',
}[s] || 'bg-gray-100 text-gray-600')
</script>