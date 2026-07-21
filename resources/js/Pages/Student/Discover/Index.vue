<template>
    <StudentLayout title="Find a Tutor">

        <!-- Filter bar -->
        <div class="bg-white rounded-2xl border border-gray-200 p-4 mb-5 space-y-3">
            <div class="flex flex-wrap gap-3">
                <!-- Text search -->
                <input v-model="f.search" @keyup.enter="applyFilters"
                       placeholder="Search by name…"
                       class="flex-1 min-w-48 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                       style="--tw-ring-color:#007B43;" />

                <!-- Institution -->
                <select v-model="f.institution_id" @change="onInstitutionChange"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                        style="--tw-ring-color:#007B43; min-width:200px;">
                    <option value="">All institutions</option>
                    <option v-for="i in institutions" :key="i.id" :value="i.id">
                        {{ i.abbreviation ? `${i.abbreviation} – ` : '' }}{{ i.name }}
                    </option>
                </select>

                <!-- Subject — filtered by selected institution -->
                <select v-model="f.subject_id"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                        style="--tw-ring-color:#007B43; min-width:180px;">
                    <option value="">All subjects</option>
                    <optgroup v-if="filteredSubjects.length" label="Subjects">
                        <option v-for="s in filteredSubjects" :key="s.id" :value="s.id">
                            {{ s.code ? `${s.code} – ` : '' }}{{ s.name }}
                        </option>
                    </optgroup>
                </select>

                <!-- Rating -->
                <select v-model="f.min_rating"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                        style="--tw-ring-color:#007B43;">
                    <option value="">Any rating</option>
                    <option value="4">4+ ★</option>
                    <option value="3">3+ ★</option>
                </select>

                <!-- Sort -->
                <select v-model="f.sort"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                        style="--tw-ring-color:#007B43;">
                    <option value="rating">Top Rated</option>
                    <option value="rate_asc">Rate: Low → High</option>
                    <option value="rate_desc">Rate: High → Low</option>
                </select>

                <button @click="applyFilters"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-lg"
                        style="background:#007B43;">
                    Search
                </button>
                <Link v-if="hasFilters" :href="route('student.discover')"
                      class="px-4 py-2 text-sm border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50">
                    Clear
                </Link>
            </div>

            <!-- Active filter chips -->
            <div v-if="hasFilters" class="flex flex-wrap gap-2">
                <span v-if="f.institution_id" class="flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium"
                      style="background:rgba(0,123,67,.1);color:#005c32;">
                    🏫 {{ institutionLabel(f.institution_id) }}
                    <button @click="f.institution_id = ''; f.subject_id = ''; applyFilters()" class="ml-1 hover:opacity-70">×</button>
                </span>
                <span v-if="f.subject_id" class="flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium"
                      style="background:rgba(0,123,67,.1);color:#005c32;">
                    📚 {{ subjectLabel(f.subject_id) }}
                    <button @click="f.subject_id = ''; applyFilters()" class="ml-1 hover:opacity-70">×</button>
                </span>
            </div>
        </div>

        <!-- Results grid -->
        <div v-if="tutors.data.length" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <Link v-for="t in tutors.data" :key="t.id"
                  :href="route('student.tutor.profile', t.id)"
                  class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-teal-300 hover:shadow-sm transition-all">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden flex items-center justify-center text-white text-lg font-bold"
                         style="background:#007B43;">
                        <img v-if="t.avatar_url && !avatarErrors[t.id]"
                             :src="t.avatar_url"
                             :alt="t.name"
                             class="w-full h-full object-cover"
                             @error="avatarErrors[t.id] = true" />
                        <template v-else>{{ t.name.charAt(0) }}</template>
                    </div>
                    <span v-if="t.tier" class="px-2 py-0.5 rounded-full text-xs font-bold text-white"
                          :style="{ background: '#' + t.tier_colour }">{{ t.tier }}</span>
                </div>

                <p class="font-semibold text-gray-800">{{ t.name }}</p>

                <!-- Institution badges -->
                <div v-if="t.institutions?.length" class="flex flex-wrap gap-1 mt-1">
                    <span v-for="i in t.institutions" :key="i.id"
                          class="px-2 py-0.5 rounded-full text-xs"
                          style="background:#f0f4ff;color:#3b4fa8;">
                        {{ i.abbreviation || i.name }}
                    </span>
                </div>

                <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ t.bio || 'No bio provided.' }}</p>

                <!-- Subject chips -->
                <div class="flex flex-wrap gap-1 mt-2">
                    <span v-for="s in (t.subjects || []).slice(0, 3)" :key="s.id"
                          class="px-2 py-0.5 rounded-full text-xs"
                          style="background:#ecfdf5;color:#065f46;">
                        {{ s.code ? `${s.code}` : s.name }}
                    </span>
                    <span v-if="(t.subjects || []).length > 3"
                          class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-500">
                        +{{ t.subjects.length - 3 }} more
                    </span>
                </div>

                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                    <span class="text-yellow-500 font-medium text-sm">
                        ★ {{ t.average_rating.toFixed(1) }}
                        <span class="text-gray-400 text-xs">({{ t.total_reviews }})</span>
                    </span>
                    <span class="text-base font-bold text-gray-800">R{{ t.hourly_rate }}/hr</span>
                </div>
            </Link>
        </div>

        <p v-else class="text-center text-gray-400 py-16">No tutors found matching your criteria.</p>

        <!-- Pagination -->
        <div v-if="tutors.last_page > 1" class="flex gap-2 justify-center">
            <Link v-for="link in tutors.links" :key="link.label" :href="link.url ?? '#'"
                  class="px-3 py-1.5 rounded-lg border text-sm"
                  :class="link.active ? 'text-white border-teal-600' : 'border-gray-200 text-gray-600'"
                  :style="link.active ? 'background:#007B43' : ''"
                  v-html="link.label" />
        </div>
    </StudentLayout>
</template>

<script setup>
import StudentLayout from '@/Layouts/StudentLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
    tutors:       Object,
    filters:      Object,
    institutions: Array,
    subjects:     Array,
})

const avatarErrors = ref({})

const f = ref({
    search:         props.filters?.search         ?? '',
    institution_id: props.filters?.institution_id ? Number(props.filters.institution_id) : '',
    subject_id:     props.filters?.subject_id     ? Number(props.filters.subject_id)     : '',
    min_rating:     props.filters?.min_rating     ?? '',
    sort:           props.filters?.sort           ?? 'rating',
})

// When institution changes, clear subject if it no longer belongs
function onInstitutionChange() {
    f.value.subject_id = ''
    applyFilters()
}

// Show subjects for selected institution + universal ones
const filteredSubjects = computed(() => {
    if (!f.value.institution_id) return props.subjects
    return props.subjects.filter(s =>
        s.institution_id === null || s.institution_id === f.value.institution_id
    )
})

const hasFilters = computed(() =>
    Object.entries(f.value).some(([k, v]) => v !== '' && !(k === 'sort' && v === 'rating'))
)

function applyFilters() {
    const params = Object.fromEntries(
        Object.entries(f.value).filter(([, v]) => v !== '')
    )
    router.get(route('student.discover'), params, { preserveState: true })
}

function institutionLabel(id) {
    const i = props.institutions.find(x => x.id === Number(id))
    return i ? (i.abbreviation || i.name) : id
}
function subjectLabel(id) {
    const s = props.subjects.find(x => x.id === Number(id))
    return s ? (s.code ? `${s.code} – ${s.name}` : s.name) : id
}
</script>