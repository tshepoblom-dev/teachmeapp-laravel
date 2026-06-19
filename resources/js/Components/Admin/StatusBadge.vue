<template>
    <span
        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
        :class="classes"
    >
        {{ label }}
    </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: { type: String, required: true },
})

const map = {
    active:      ['bg-green-100 text-green-700', 'Active'],
    completed:   ['bg-blue-100 text-blue-700', 'Completed'],
    pending:     ['bg-yellow-100 text-yellow-700', 'Pending'],
    accepted:    ['bg-indigo-100 text-indigo-700', 'Accepted'],
    declined:    ['bg-gray-100 text-gray-600', 'Declined'],
    cancelled:   ['bg-red-100 text-red-600', 'Cancelled'],
    disputed:    ['bg-orange-100 text-orange-700', 'Disputed'],
    in_progress: ['bg-indigo-100 text-indigo-700', 'In Progress'],
    approved:    ['bg-green-100 text-green-700', 'Approved'],
    rejected:    ['bg-red-100 text-red-600', 'Rejected'],
    under_review:['bg-blue-100 text-blue-700', 'Under Review'],
    resubmitted: ['bg-purple-100 text-purple-700', 'Resubmitted'],
    suspended:   ['bg-orange-100 text-orange-700', 'Suspended'],
    banned:      ['bg-red-100 text-red-700', 'Banned'],
    waiting:     ['bg-gray-100 text-gray-600', 'Waiting'],
    ended:       ['bg-gray-100 text-gray-600', 'Ended'],
    held:        ['bg-yellow-100 text-yellow-700', 'Held'],
    released:    ['bg-green-100 text-green-700', 'Released'],
    refunded:    ['bg-blue-100 text-blue-700', 'Refunded'],
}

const classes = computed(() => (map[props.status] ?? ['bg-gray-100 text-gray-600'])[0])
const label   = computed(() => (map[props.status] ?? ['', props.status])[1])
</script>