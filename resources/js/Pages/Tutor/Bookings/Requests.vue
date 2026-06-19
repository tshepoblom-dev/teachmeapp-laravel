<template>
    <TutorLayout title="Booking Requests">
        <div class="max-w-3xl space-y-4">
            <p v-if="!requests.length" class="text-gray-500 bg-white rounded-2xl border border-gray-200 p-8 text-center">
                No pending requests. Share your profile to attract students!
            </p>

            <div
                v-for="b in requests" :key="b.id"
                class="bg-white rounded-2xl border border-gray-200 p-5"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-gray-800">{{ b.subject }}</p>
                        <p class="text-gray-500 mt-0.5">
                            {{ b.student?.name }} · {{ b.duration }}min · R{{ b.total.toFixed(2) }}
                        </p>
                        <p class="text-gray-600 mt-1">
                            📅 {{ fmtDateShort(b.scheduled_at) }}
                        </p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button
                            @click="respond(b.id, 'accept')"
                            :disabled="processing === b.id"
                            class="px-3 py-1.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50"
                        >Accept</button>
                        <button
                            @click="respond(b.id, 'decline')"
                            :disabled="processing === b.id"
                            class="px-3 py-1.5 border border-gray-200 text-gray-600 font-medium rounded-lg hover:bg-gray-50 disabled:opacity-50"
                        >Decline</button>
                    </div>
                </div>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { ref }      from 'vue'
import { router }   from '@inertiajs/vue3'
import TutorLayout  from '@/Layouts/TutorLayout.vue'
import { fmtDateShort } from '@/utils/time'

defineProps({ requests: Array })

const processing = ref(null)

const respond = (id, action) => {
    processing.value = id
    router.post(route(`tutor.bookings.${action}`, id), {}, {
        onFinish: () => processing.value = null,
    })
}
</script>