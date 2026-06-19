<template>
    <StudentLayout :title="tutor.name">
        <div class="max-w-4xl space-y-5">

            <!-- ── Hero card ─────────────────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

                <!-- Cover band -->
                <div class="h-28 relative" :style="coverStyle">
                    <!-- Availability pill – top right -->
                    <span v-if="!tutor.is_available"
                          class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold bg-black/40 text-white backdrop-blur-sm">
                        Not accepting bookings
                    </span>
                </div>

                <!-- Avatar + top info row -->
                <div class="px-6 pb-6">
                    <div class="flex items-end gap-4 -mt-10 mb-4">
                        <!-- Avatar -->
                        <div class="w-20 h-20 rounded-2xl border-4 border-white shadow-md shrink-0 overflow-hidden flex items-center justify-center"
                             :style="{ background: tutor.tier_colour ? '#' + tutor.tier_colour : '#007B43' }">
                            <img v-if="tutor.avatar_url && !avatarError"
                                 :src="tutor.avatar_url"
                                 :alt="tutor.name"
                                 class="w-full h-full object-cover"
                                 @error="avatarError = true" />
                            <span v-else class="text-white text-2xl font-bold select-none">
                                {{ initials }}
                            </span>
                        </div>

                        <!-- Name / tier / book -->
                        <div class="flex-1 flex items-start justify-between flex-wrap gap-3 pt-10">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h1 class="text-xl font-bold text-gray-900">{{ tutor.name }}</h1>
                                    <span v-if="tutor.tier"
                                          class="px-2.5 py-0.5 rounded-full text-xs font-bold text-white"
                                          :style="{ background: '#' + tutor.tier_colour }">
                                        {{ tutor.tier }}
                                    </span>
                                </div>
                                <p v-if="tutor.education_level" class="text-sm text-gray-500 mt-0.5">
                                    {{ tutor.education_level }}
                                </p>
                            </div>

                            <div class="text-right shrink-0">
                                <p class="text-2xl font-bold text-gray-900">R{{ tutor.hourly_rate }}<span class="text-sm font-normal text-gray-400">/hr</span></p>
                                <Link v-if="tutor.is_available"
                                      :href="route('student.bookings.create', tutor.id)"
                                      class="mt-2 inline-block px-5 py-2 text-white text-sm font-semibold rounded-lg transition-opacity hover:opacity-90"
                                      style="background:#007B43;">
                                    Book Session
                                </Link>
                                <span v-else class="mt-2 inline-block px-5 py-2 bg-gray-100 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">
                                    Unavailable
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ tutor.bio || 'This tutor has not added a bio yet.' }}
                    </p>

                    <!-- Tags row -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span v-for="s in tutor.subjects" :key="s.id"
                              class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium">
                            {{ s.name }}
                        </span>
                        <span v-for="sp in tutor.teaching_specializations" :key="sp"
                              class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs">
                            {{ sp }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- ── Stats row ──────────────────────────────────────────── -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div v-for="stat in stats" :key="stat.label"
                     class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ stat.value }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ stat.label }}</p>
                </div>
            </div>

            <!-- ── Two-column lower section ───────────────────────────── -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Left column: About + Institutions -->
                <div class="md:col-span-1 space-y-5">

                    <!-- About card -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-5 space-y-3">
                        <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">About</h2>
                        <InfoRow v-if="tutor.education_level"   icon="🎓" :text="tutor.education_level" />
                        <InfoRow v-if="tutor.years_of_experience" icon="⏳" :text="tutor.years_of_experience + ' years experience'" />
                        <InfoRow v-if="tutor.subjects.length"   icon="📚" :text="tutor.subjects.map(s => s.name).join(', ')" />
                        <p v-if="!tutor.education_level && !tutor.years_of_experience"
                           class="text-xs text-gray-400">No details added yet.</p>
                    </div>

                    <!-- Institutions card -->
                    <div v-if="tutor.institutions?.length"
                         class="bg-white rounded-2xl border border-gray-200 p-5">
                        <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Institutions</h2>
                        <div class="space-y-2">
                            <div v-for="inst in tutor.institutions" :key="inst.id"
                                 class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 text-xs font-bold flex items-center justify-center shrink-0">
                                    {{ inst.abbreviation?.slice(0,3) || '🏫' }}
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-800 leading-none">{{ inst.abbreviation || inst.name }}</p>
                                    <p v-if="inst.abbreviation" class="text-xs text-gray-400">{{ inst.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column: Availability + Reviews -->
                <div class="md:col-span-2 space-y-5">

                    <!-- Availability card -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-5">
                        <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-4">Weekly Availability</h2>
                        <div v-if="availability.length" class="grid grid-cols-7 gap-1 text-xs">
                            <div v-for="(day, i) in dayLabels" :key="i" class="text-center">
                                <p class="text-gray-400 font-medium mb-1.5">{{ day }}</p>
                                <template v-if="slotsForDay(i).length">
                                    <div v-for="slot in slotsForDay(i)" :key="slot.start_time"
                                         class="rounded-md py-1 mb-1 text-center font-medium"
                                         style="background:#e6f4ee; color:#007B43;">
                                        {{ slot.start_time }}
                                    </div>
                                </template>
                                <div v-else class="h-7 rounded-md bg-gray-50"></div>
                            </div>
                        </div>
                        <p v-else class="text-sm text-gray-400">No availability set.</p>
                    </div>

                    <!-- Reviews card -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-5">
                        <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-4">
                            Reviews <span class="text-gray-400 font-normal">({{ tutor.total_reviews }})</span>
                        </h2>

                        <div v-if="reviews.length" class="space-y-4">
                            <div v-for="r in reviews" :key="r.reviewer + r.date"
                                 class="pb-4 border-b border-gray-50 last:border-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <!-- Reviewer avatar initials -->
                                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 text-xs font-bold flex items-center justify-center shrink-0">
                                            {{ r.reviewer.charAt(0) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 leading-none">{{ r.reviewer }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ r.date }}</p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0">
                                        <span v-for="n in 5" :key="n"
                                              class="text-sm"
                                              :class="n <= r.rating ? 'text-yellow-400' : 'text-gray-200'">★</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2 ml-10">{{ r.comment || 'No comment.' }}</p>
                                <div v-if="r.tags?.length" class="flex gap-1 mt-1.5 ml-10 flex-wrap">
                                    <span v-for="tag in r.tags" :key="tag"
                                          class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">
                                        {{ tag }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p v-else class="text-sm text-gray-400">No reviews yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { computed, ref, h }  from 'vue'
import { Link }      from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'

// Tiny inline sub-component to avoid a separate file
const InfoRow = {
    props: ['icon', 'text'],
    setup(props, { slots }) {
        return () => h('div', { class: 'flex items-start gap-2 text-sm text-gray-600' }, [
            h('span', { class: 'mt-0.5 shrink-0' }, props.icon),
            h('span', {}, props.text)
        ])
    }
}

const props = defineProps({
    tutor:        Object,
    availability: Array,
    reviews:      Array,
})

const avatarError = ref(false)

const dayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

const initials = computed(() =>
    props.tutor.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
)

// Generate a subtle gradient cover from the tier colour (or default green)
const coverStyle = computed(() => {
    const c = props.tutor.tier_colour ? '#' + props.tutor.tier_colour : '#007B43'
    return {
        background: `linear-gradient(135deg, ${c}cc 0%, ${c}66 60%, #f0fdf4 100%)`,
    }
})

const stats = computed(() => [
    {
        value: props.tutor.average_rating > 0 ? props.tutor.average_rating.toFixed(1) + ' ★' : '—',
        label: 'Rating',
    },
    { value: props.tutor.total_reviews,  label: 'Reviews'  },
    { value: props.tutor.total_sessions, label: 'Sessions' },
    {
        value: props.tutor.years_of_experience ? props.tutor.years_of_experience + ' yrs' : '—',
        label: 'Experience',
    },
])

const slotsForDay = (day) => props.availability.filter(s => s.day_of_week === day)
</script>