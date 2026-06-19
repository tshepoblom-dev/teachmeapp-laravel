<template>
    <TutorLayout title="Availability">
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Add slot form -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Add Availability Slot</h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Day of Week</label>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="(d, i) in days"
                                :key="i"
                                type="button"
                                @click="form.day_of_week = i"
                                :class="[
                                    'px-3 py-1.5 rounded-full text-sm font-medium transition-colors duration-150 border',
                                    form.day_of_week === i
                                        ? 'bg-indigo-600 text-white border-indigo-600'
                                        : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-400 hover:text-indigo-600'
                                ]"
                            >{{ d }}</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Start Time</label>
                            <input v-model="form.start_time" type="time" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">End Time</label>
                            <input v-model="form.end_time" type="time" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-gray-600">
                        <input v-model="form.is_recurring" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
                        Recurring weekly
                    </label>
                    <p v-if="form.errors.end_time" class="text-xs text-red-600">{{ form.errors.end_time }}</p>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 disabled:opacity-50"
                    >Add Slot</button>
                </form>
            </div>

            <!-- Current slots -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Current Schedule</h2>
                <div v-if="!slots.length" class="text-gray-400 text-center py-8">
                    No slots set yet. Add your first availability window.
                </div>
                <div v-else class="space-y-2">
                    <div
                        v-for="s in slots" :key="s.id"
                        class="flex items-center justify-between py-2 px-3 rounded-lg bg-gray-50"
                    >
                        <div>
                            <span class="font-medium text-gray-800">{{ days[s.day_of_week] }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ s.start_time }} – {{ s.end_time }}</span>
                            <span v-if="s.is_recurring" class="ml-2 text-xs text-indigo-600">↻ weekly</span>
                        </div>
                        <button
                            @click="remove(s.id)"
                            class="text-red-400 hover:text-red-600 text-xs"
                        >Remove</button>
                    </div>
                </div>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import TutorLayout         from '@/Layouts/TutorLayout.vue'

const props = defineProps({ slots: Array, days: Array })

const form = useForm({
    day_of_week:  0,
    start_time:   '08:00',
    end_time:     '10:00',
    is_recurring: true,
})

const submit = () => form.post(route('tutor.availability.store'), { onSuccess: () => form.reset() })
const remove = (id) => router.delete(route('tutor.availability.destroy', id))
</script>
