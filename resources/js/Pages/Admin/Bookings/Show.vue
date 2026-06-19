<template>
    <AdminLayout :title="`Booking #${booking.id}`">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left: Booking details -->
            <div class="lg:col-span-2 space-y-4">

                <!-- Core info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">{{ booking.subject }}</h2>
                            <p class="text-gray-400 mt-0.5">Booking #{{ booking.id }}</p>
                        </div>
                        <StatusBadge :status="booking.status" />
                    </div>

                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500 mb-0.5">Student</dt>
                            <dd class="font-medium">{{ booking.student?.name }}</dd>
                            <dd class="text-xs text-gray-400">{{ booking.student?.email }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Tutor</dt>
                            <dd class="font-medium">{{ booking.tutor?.name }}</dd>
                            <dd class="text-xs text-gray-400">{{ booking.tutor?.email }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Scheduled</dt>
                            <dd class="font-medium">
                                {{ booking.scheduled_at
                                    ? fmtDateLong(booking.scheduled_at)
                                    : '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Duration</dt>
                            <dd class="font-medium">{{ booking.duration_minutes }} minutes</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Hourly Rate</dt>
                            <dd class="font-medium">R {{ Number(booking.hourly_rate_snapshot).toFixed(2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Total Amount</dt>
                            <dd class="font-bold text-lg text-gray-900">R {{ Number(booking.total_amount).toFixed(2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Platform Fee</dt>
                            <dd class="font-medium">{{ booking.platform_fee_snapshot }}%</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-0.5">Created</dt>
                            <dd>{{ booking.created_at ? fmtDateOnly(booking.created_at) : '—' }}</dd>
                        </div>
                    </dl>

                    <div v-if="booking.description" class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs font-medium text-gray-500 mb-1">Description</dt>
                        <dd class="text-gray-700">{{ booking.description }}</dd>
                    </div>

                    <div
                        v-if="booking.cancellation_reason"
                        class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100"
                    >
                        <p class="text-xs font-medium text-red-600 mb-0.5">Cancellation Reason</p>
                        <p class="text-red-700">{{ booking.cancellation_reason }}</p>
                    </div>
                </div>

                <!-- Session info -->
                <div v-if="booking.session" class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Session</h3>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd><StatusBadge :status="booking.session.status" /></dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Channel</dt>
                            <dd class="font-mono text-xs">{{ booking.session.agora_channel_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Started</dt>
                            <dd>{{ booking.session.started_at
                                ? fmtDateLong(booking.session.started_at)
                                : '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Ended</dt>
                            <dd>{{ booking.session.ended_at
                                ? fmtDateLong(booking.session.ended_at)
                                : '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Escrow info -->
                <div v-if="booking.escrow_transaction" class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Escrow</h3>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd><StatusBadge :status="booking.escrow_transaction.status" /></dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Gross Amount</dt>
                            <dd class="font-medium">R {{ Number(booking.escrow_transaction.amount).toFixed(2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Commission</dt>
                            <dd class="text-red-500">
                                -R {{ Number(booking.escrow_transaction.commission_amount || 0).toFixed(2) }}
                                ({{ booking.escrow_transaction.commission_rate_snapshot }}%)
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Net to Tutor</dt>
                            <dd class="font-bold text-green-700">
                                R {{ Number(booking.escrow_transaction.net_to_tutor || 0).toFixed(2) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="space-y-4">

                <!-- Cancel -->
                <div
                    v-if="['pending','accepted','in_progress'].includes(booking.status)"
                    class="bg-white rounded-xl border border-gray-200 p-5"
                >
                    <h3 class="font-semibold text-gray-700 mb-3">Cancel Booking</h3>
                    <form @submit.prevent="cancel" class="space-y-3">
                        <textarea
                            v-model="cancelReason"
                            placeholder="Cancellation reason *"
                            rows="3"
                            required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                        />
                        <button
                            type="submit"
                            class="w-full py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors"
                        >
                            Cancel Booking
                        </button>
                    </form>
                </div>

                <!-- Dispute Resolution -->
                <div
                    v-if="booking.status === 'disputed'"
                    class="bg-white rounded-xl border border-orange-200 p-5"
                >
                    <h3 class="font-semibold text-orange-700 mb-1">Resolve Dispute</h3>
                    <p class="text-xs text-orange-500 mb-4">
                        Choose whether to release escrow to the tutor or refund to the student.
                    </p>

                    <form @submit.prevent="resolveDispute" class="space-y-3">
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input
                                    v-model="disputeAction"
                                    type="radio"
                                    value="release"
                                    class="text-green-600"
                                />
                                <span class="font-medium text-gray-800">
                                    Release to Tutor
                                    <span class="text-xs text-gray-400 block font-normal">
                                        Tutor receives R {{ Number(booking.escrow_transaction?.net_to_tutor || 0).toFixed(2) }}
                                    </span>
                                </span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input
                                    v-model="disputeAction"
                                    type="radio"
                                    value="refund"
                                    class="text-blue-600"
                                />
                                <span class="font-medium text-gray-800">
                                    Refund to Student
                                    <span class="text-xs text-gray-400 block font-normal">
                                        Student receives R {{ Number(booking.total_amount).toFixed(2) }}
                                    </span>
                                </span>
                            </label>
                        </div>

                        <textarea
                            v-model="disputeReason"
                            placeholder="Resolution reason (for audit log) *"
                            rows="3"
                            required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        />

                        <button
                            type="submit"
                            :disabled="!disputeAction"
                            class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors disabled:opacity-50"
                        >
                            Resolve Dispute
                        </button>
                    </form>
                </div>

                <!-- Back link -->
                <Link
                    :href="route('admin.bookings.index')"
                    class="block text-center text-gray-500 hover:text-gray-700"
                >
                    ← Back to bookings
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'
import { fmtDateLong, fmtDateOnly } from '@/utils/time'

const props = defineProps({
    booking: { type: Object, required: true },
})

const cancelReason  = ref('')
const disputeAction = ref('')
const disputeReason = ref('')

const cancel = () => {
    if (! confirm('Cancel this booking?')) return
    router.post(route('admin.bookings.cancel', props.booking.id), {
        reason: cancelReason.value,
    })
}

const resolveDispute = () => {
    router.post(route('admin.bookings.resolve-dispute', props.booking.id), {
        action: disputeAction.value,
        reason: disputeReason.value,
    })
}
</script>