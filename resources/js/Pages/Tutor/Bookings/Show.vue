<template>
    <TutorLayout title="Booking Detail">
        <div class="max-w-2xl space-y-5">
            <!-- Header card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ booking.subject }}</h2>
                        <p class="text-gray-500 mt-0.5">with {{ booking.student.name }}</p>
                    </div>
                    <span :class="statusClass(booking.status)"
                          class="px-2.5 py-1 rounded-full text-xs font-semibold">
                        {{ booking.status.replace('_',' ') }}
                    </span>
                </div>

                <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-xs text-gray-400">Date & Time</dt>
                        <dd class="font-medium text-gray-700">{{ fmtDateLong(booking.scheduled_at) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Duration</dt>
                        <dd class="font-medium text-gray-700">{{ booking.duration_minutes }} minutes</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Hourly Rate</dt>
                        <dd class="font-medium text-gray-700">R{{ booking.hourly_rate_snapshot.toFixed(2) }}/hr</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Total Amount</dt>
                        <dd class="font-bold text-gray-800">R{{ booking.total_amount.toFixed(2) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Escrow status -->
            <div v-if="booking.escrow" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-3">Payment / Escrow</h3>
                <div class="grid grid-cols-3 gap-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Held Amount</p>
                        <p class="font-medium">R{{ booking.escrow.amount.toFixed(2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Your Earnings</p>
                        <p class="font-semibold text-green-600">
                            R{{ (booking.escrow.net_to_tutor || booking.escrow.amount).toFixed(2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Escrow Status</p>
                        <span :class="{
                            'text-amber-600': booking.escrow.status === 'held',
                            'text-green-600': booking.escrow.status === 'released',
                            'text-blue-600':  booking.escrow.status === 'refunded',
                        }" class="font-medium capitalize">{{ booking.escrow.status }}</span>
                    </div>
                </div>
            </div>

            <!-- Session actions -->
            <div v-if="booking.session" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-3">Session</h3>
                <div class="flex items-center gap-3">
                    <span :class="{
                        'bg-yellow-100 text-yellow-700': booking.session.status === 'waiting',
                        'bg-green-100 text-green-700':   booking.session.status === 'active',
                        'bg-gray-100 text-gray-600':     booking.session.status === 'ended',
                    }" class="px-2 py-0.5 rounded-full text-xs font-medium capitalize">
                        {{ booking.session.status }}
                    </span>
                    <Link
                        v-if="['waiting','active'].includes(booking.session.status)"
                        :href="route('tutor.sessions.show', booking.session.id)"
                        class="px-4 py-1.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700"
                    >
                        {{ booking.session.status === 'waiting' ? 'Start Session' : 'Rejoin Session' }}
                    </Link>
                </div>
            </div>

            <!-- Review received -->
            <div v-if="booking.review" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-2">Student Review</h3>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-yellow-400">{{ '★'.repeat(booking.review.rating) }}<span class="text-gray-200">{{ '★'.repeat(5 - booking.review.rating) }}</span></span>
                    <span class="font-medium text-gray-700">{{ booking.review.rating }}/5</span>
                </div>
                <p class="text-gray-600">{{ booking.review.comment || 'No comment left.' }}</p>
            </div>

            <!-- Cancel (only when accepted/pending) -->
            <div v-if="['pending','accepted'].includes(booking.status)">
                <button
                    @click="showCancel = !showCancel"
                    class="text-red-500 hover:text-red-700"
                >Cancel this booking</button>
                <div v-if="showCancel" class="mt-3 bg-white rounded-xl border border-red-100 p-4">
                    <p class="text-xs text-gray-500 mb-2">Optional reason:</p>
                    <textarea v-model="cancelReason" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300 mb-3" />
                    <button
                        @click="doCancel"
                        class="px-4 py-1.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700"
                    >Confirm Cancellation</button>
                </div>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { ref }     from 'vue'
import { Link, router } from '@inertiajs/vue3'
import TutorLayout from '@/Layouts/TutorLayout.vue'
import { fmtDateLong } from '@/utils/time'

const props       = defineProps({ booking: Object })
const showCancel  = ref(false)
const cancelReason= ref('')

const statusClass = (s) => ({
    pending:     'bg-yellow-100 text-yellow-700',
    accepted:    'bg-blue-100 text-blue-700',
    in_progress: 'bg-indigo-100 text-indigo-700',
    completed:   'bg-green-100 text-green-700',
    declined:    'bg-gray-100 text-gray-500',
    cancelled:   'bg-gray-100 text-gray-500',
    disputed:    'bg-red-100 text-red-700',
}[s] || 'bg-gray-100 text-gray-600')

const doCancel = () => router.post(route('tutor.bookings.cancel', props.booking.id), {
    reason: cancelReason.value,
})
</script>