<template>
    <StudentLayout title="Booking Detail">
        <div class="max-w-xl space-y-5">
            <!-- Header -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ booking.subject }}</h2>
                        <p class="text-gray-500 mt-0.5">with {{ booking.tutor.name }}</p>
                    </div>
                    <span :class="statusClass(booking.status)" class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize">
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
                        <dd class="font-medium">{{ booking.duration_minutes }} minutes</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Amount Paid</dt>
                        <dd class="font-bold text-gray-800">R{{ booking.total_amount.toFixed(2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Escrow</dt>
                        <dd class="capitalize text-sm" :class="{
                            'text-amber-600': booking.escrow?.status === 'held',
                            'text-green-600': booking.escrow?.status === 'released',
                        }">{{ booking.escrow?.status || '—' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Join session -->
            <div v-if="booking.session && ['waiting','active'].includes(booking.session.status)"
                class="bg-teal-50 rounded-2xl border border-teal-200 p-5">
                <p class="font-semibold text-teal-800 mb-3">
                    {{ booking.session.status === 'active' ? '🟢 Session is Live!' : '⏳ Session Ready — Waiting for Tutor' }}
                </p>
                <Link :href="route('student.session.join', booking.session.id)"
                    class="inline-block px-5 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">
                    Join Session →
                </Link>
            </div>

            <!-- Leave a review -->
            <div v-if="booking.can_review" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-4">Leave a Review</h3>
                <form @submit.prevent="submitReview" class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Rating</p>
                        <div class="flex gap-2">
                            <button v-for="n in 5" :key="n" type="button"
                                @click="reviewForm.rating = n"
                                :class="n <= reviewForm.rating ? 'text-yellow-400' : 'text-gray-300'"
                                class="text-2xl leading-none transition-colors hover:text-yellow-400">★</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Comment (optional)</label>
                        <textarea v-model="reviewForm.comment" rows="3"
                            placeholder="How was the session?"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Tags (optional)</label>
                        <div class="flex flex-wrap gap-2">
                            <button v-for="tag in suggestedTags" :key="tag" type="button"
                                @click="toggleTag(tag)"
                                :class="reviewForm.tags.includes(tag)
                                    ? 'bg-teal-600 text-white border-teal-600'
                                    : 'bg-white text-gray-600 border-gray-200 hover:border-teal-300'"
                                class="px-3 py-1 text-xs rounded-full border transition-colors">
                                {{ tag }}
                            </button>
                        </div>
                    </div>
                    <button type="submit" :disabled="reviewForm.processing || !reviewForm.rating"
                        class="px-5 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 disabled:opacity-50">
                        Submit Review
                    </button>
                </form>
            </div>

            <!-- Existing review -->
            <div v-else-if="booking.review" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-2">Your Review</h3>
                <div class="flex items-center gap-1 mb-1">
                    <span class="text-yellow-400 text-lg">{{ '★'.repeat(booking.review.rating) }}<span class="text-gray-200">{{ '★'.repeat(5-booking.review.rating) }}</span></span>
                </div>
                <p class="text-gray-600">{{ booking.review.comment || 'No comment.' }}</p>
            </div>

            <!-- Cancel -->
            <div v-if="['pending','accepted'].includes(booking.status)">
                <button @click="showCancel = !showCancel" class="text-red-500 hover:text-red-700">
                    Cancel booking
                </button>
                <div v-if="showCancel" class="mt-3 bg-white rounded-xl border border-red-100 p-4 space-y-3">
                    <textarea v-model="cancelReason" rows="2" placeholder="Reason (optional)"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300" />
                    <button @click="doCancel"
                        class="px-4 py-1.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700">
                        Confirm Cancellation
                    </button>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { ref }          from 'vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import StudentLayout    from '@/Layouts/StudentLayout.vue'
import { fmtDateLong }  from '@/utils/time'

const props      = defineProps({ booking: Object })
const showCancel = ref(false)
const cancelReason = ref('')

const reviewForm = useForm({ rating: 0, comment: '', tags: [] })
const suggestedTags = ['Patient', 'Clear explanations', 'Knowledgeable', 'Punctual', 'Engaging', 'Helpful']

const toggleTag = (tag) => {
    const idx = reviewForm.tags.indexOf(tag)
    idx === -1 ? reviewForm.tags.push(tag) : reviewForm.tags.splice(idx, 1)
}

const submitReview = () => reviewForm.post(route('student.bookings.review', props.booking.id))
const doCancel     = () => router.post(route('student.bookings.cancel', props.booking.id), { reason: cancelReason.value })

const statusClass = (s) => ({
    pending:     'bg-yellow-100 text-yellow-700',
    accepted:    'bg-blue-100 text-blue-700',
    in_progress: 'bg-teal-100 text-teal-700',
    completed:   'bg-green-100 text-green-700',
    cancelled:   'bg-gray-100 text-gray-500',
    disputed:    'bg-red-100 text-red-700',
}[s] || 'bg-gray-100 text-gray-600')
</script>