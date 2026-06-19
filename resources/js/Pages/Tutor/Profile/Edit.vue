<template>
    <TutorLayout title="My Profile">
        <div class="max-w-3xl space-y-5">

            <!-- Flash message -->
            <div v-if="$page.props.flash?.success"
                 class="px-4 py-3 rounded-xl text-sm font-medium text-white"
                 style="background:#007B43;">
                {{ $page.props.flash.success }}
            </div>

            <!-- Avatar -->
            <button type="button" @click="$refs.avatarInput.click()"
                    class="relative w-20 h-20 rounded-2xl border-4 border-white shadow-md shrink-0 overflow-hidden group focus:outline-none">
                <img v-if="currentAvatar"
                    :src="currentAvatar"
                    class="w-full h-full object-cover" alt="Avatar" />
                <div v-else
                    class="w-full h-full flex items-center justify-center text-white text-2xl font-bold"
                    style="background:#007B43;">
                    {{ initials }}
                </div>
                <div class="absolute inset-0 flex items-center justify-center transition-opacity"
                    :class="avatarUploading ? 'bg-black/50 opacity-100' : 'bg-black/40 opacity-0 group-hover:opacity-100'">
                    <svg v-if="!avatarUploading" class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg v-else class="w-5 h-5 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                </div>
            </button>
            <p class="text-xs text-gray-400 pt-1">Click photo to change · uploads immediately · max 2 MB</p>
            <input ref="avatarInput" type="file" accept="image/*" class="hidden" @change="onAvatarPicked" />

            <!-- ── Main profile form ───────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-5">Profile Details</h2>
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Name + Email (read-only email) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Field label="Full Name">
                            <input v-model="form.name" type="text" v-bind="inp" />
                            <FieldError :message="form.errors.name" />
                        </Field>
                        <Field label="Email">
                            <input :value="user.email" type="email" disabled
                                   class="w-full border border-gray-100 rounded-lg px-3 py-2.5 bg-gray-50 text-gray-400 cursor-not-allowed" />
                        </Field>
                    </div>

                    <!-- Bio -->
                    <Field label="Bio">
                        <textarea v-model="form.bio" rows="4" v-bind="inp"
                                  placeholder="Tell students about yourself, your teaching style and experience…" />
                        <FieldError :message="form.errors.bio" />
                    </Field>

                    <!-- Experience -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Field label="Years of Experience">
                            <input v-model="form.years_of_experience" type="number" min="0" max="60" v-bind="inp" />
                        </Field>
                    </div>

                    <!-- Education + Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Field label="Education Level">
                            <select v-model="form.education_level" v-bind="inp">
                                <option value="">Select…</option>
                                <option>Matric / Grade 12</option>
                                <option>Diploma</option>
                                <option>Bachelor's Degree</option>
                                <option>Honours Degree</option>
                                <option>Master's Degree</option>
                                <option>PhD</option>
                            </select>
                        </Field>

                        <Field label="Phone Number">
                            <input v-model="form.phone_number" type="tel" v-bind="inp" />
                        </Field>
                    </div>

                    <!-- Timezone + Language -->
                     <!--
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Field label="Timezone">
                            <select v-model="form.timezone" v-bind="inp">
                                <option value="Africa/Johannesburg">Africa/Johannesburg (SAST)</option>
                                <option value="UTC">UTC</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="America/New_York">America/New_York</option>
                            </select>
                        </Field>

                        <Field label="Language Preference">
                            <select v-model="form.language_preference" v-bind="inp">
                                <option value="en">English</option>
                                <option value="af">Afrikaans</option>
                                <option value="zu">Zulu</option>
                                <option value="xh">Xhosa</option>
                            </select>
                        </Field>
                    </div>
-->
                   <!-- ── Institutions ─────────────────────────── -->
                    <Field label="Institutions">
                        <MultiSelect
                            v-model="form.institution_ids"
                            :options="institutions.map(i => ({ value: i.id, label: i.abbreviation || i.name, sub: i.name }))"
                            placeholder="Search institutions…"
                        />
                        <FieldError :message="form.errors.institution_ids" />
                    </Field>

                    <!-- ── Subjects ───────────────────────────────── -->
                    <Field label="Subjects">
                        <MultiSelect
                            v-model="form.subject_ids"
                            :options="filteredSubjects.map(s => ({ value: s.id, label: s.code ? s.code + ' – ' + s.name : s.name, sub: s.faculty || '' }))"
                            placeholder="Search subjects…"
                            pill-color="indigo"
                        />
                        <p v-if="!form.institution_ids.length" class="text-xs text-gray-400 mt-1">
                            Select an institution above to filter subjects.
                        </p>
                        <FieldError :message="form.errors.subject_ids" />
                    </Field>
                    <!-- Availability toggle -->
                    <label class="flex items-center gap-3 cursor-pointer select-none p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="relative w-10 h-6 shrink-0">
                            <input v-model="form.is_available" type="checkbox" class="sr-only peer" />
                            <div class="w-10 h-6 rounded-full border-2 border-gray-300 peer-checked:border-transparent transition-colors"
                                 :style="form.is_available ? 'background:#007B43' : 'background:#e5e7eb'"></div>
                            <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform"
                                 :class="form.is_available ? 'translate-x-4' : 'translate-x-0'"></div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-800">Available for bookings</span>
                            <p class="text-xs text-gray-400">Students can discover and book you when enabled</p>
                        </div>
                    </label>

                    <!-- Save -->
                    <div class="pt-1 flex items-center gap-3">
                        <button type="submit" :disabled="form.processing"
                                class="px-6 py-2.5 text-white font-semibold rounded-lg disabled:opacity-50 transition-opacity hover:opacity-90"
                                style="background:#007B43;">
                            {{ form.processing ? 'Saving…' : 'Save Changes' }}
                        </button>
                        <span v-if="form.recentlySuccessful" class="text-sm text-green-600 font-medium">Saved!</span>
                    </div>
                </form>
            </div>

        </div>
    </TutorLayout>
</template>

<script setup>
import { ref, computed, h, onMounted, onUnmounted, nextTick } from 'vue'
import { useForm, router, usePage }       from '@inertiajs/vue3'
import TutorLayout       from '@/Layouts/TutorLayout.vue'
import FieldError        from '@/Components/FieldError.vue'

const Field = {
    props: ['label'],
    setup(props, { slots }) {
        return () => h('div', [
            h('label', { class: 'block text-xs font-medium text-gray-600 mb-1' }, props.label),
            slots.default?.(),
        ])
    },
}
const MultiSelect = {
    props: {
        modelValue:  { type: Array,  default: () => [] },
        options:     { type: Array,  default: () => [] }, // [{ value, label, sub? }]
        placeholder: { type: String, default: 'Search…' },
        pillColor:   { type: String, default: 'green' },
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
        const query  = ref('')
        const open   = ref(false)
        const inputEl = ref(null)

        const filtered = computed(() => {
            const q = query.value.toLowerCase()
            return props.options.filter(o =>
                !props.modelValue.includes(o.value) &&
                (o.label.toLowerCase().includes(q) || (o.sub || '').toLowerCase().includes(q))
            )
        })

        const selectedOptions = computed(() =>
            props.options.filter(o => props.modelValue.includes(o.value))
        )

        const toggle = (val) => {
            const current = [...props.modelValue]
            const idx = current.indexOf(val)
            if (idx === -1) current.push(val)
            else current.splice(idx, 1)
            emit('update:modelValue', current)
            query.value = ''
        }

        const remove = (val) => {
            emit('update:modelValue', props.modelValue.filter(v => v !== val))
        }

        const pillStyle = computed(() => props.pillColor === 'indigo'
            ? { background: '#4f46e5', color: '#fff' }
            : { background: '#007B43', color: '#fff' }
        )

        // Close on outside click
        const container = ref(null)
        const onOutside = (e) => { if (container.value && !container.value.contains(e.target)) open.value = false }
        onMounted(() => document.addEventListener('mousedown', onOutside))
        onUnmounted(() => document.removeEventListener('mousedown', onOutside))

        return () => h('div', { ref: container, class: 'relative' }, [

            // Pills + input row
            h('div', {
                class: 'min-h-[42px] w-full border border-gray-200 rounded-lg px-2 py-1.5 flex flex-wrap gap-1.5 cursor-text focus-within:ring-2',
                style: '--tw-ring-color:#007B43',
                onClick: () => { open.value = true; nextTick(() => inputEl.value?.focus()) },
            }, [
                // Selected pills
                ...selectedOptions.value.map(o =>
                    h('span', {
                        key: o.value,
                        class: 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium',
                        style: pillStyle.value,
                    }, [
                        o.label,
                        h('button', {
                            type: 'button',
                            class: 'ml-0.5 opacity-70 hover:opacity-100',
                            onClick: (e) => { e.stopPropagation(); remove(o.value) },
                        }, '×'),
                    ])
                ),
                // Text input
                h('input', {
                    ref: inputEl,
                    value: query.value,
                    placeholder: selectedOptions.value.length ? '' : props.placeholder,
                    class: 'flex-1 min-w-[120px] outline-none bg-transparent text-sm py-0.5 px-1',
                    onInput: (e) => { query.value = e.target.value; open.value = true },
                    onFocus: () => { open.value = true },
                }),
            ]),

            // Dropdown list
            open.value && filtered.value.length
                ? h('ul', {
                    class: 'absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-52 overflow-y-auto py-1',
                }, filtered.value.map(o =>
                    h('li', {
                        key: o.value,
                        class: 'flex items-start gap-2 px-3 py-2 hover:bg-gray-50 cursor-pointer',
                        onMousedown: (e) => { e.preventDefault(); toggle(o.value) },
                    }, [
                        h('div', [
                            h('p', { class: 'text-sm font-medium text-gray-800 leading-none' }, o.label),
                            o.sub ? h('p', { class: 'text-xs text-gray-400 mt-0.5' }, o.sub) : null,
                        ]),
                    ])
                ))
                : open.value && !filtered.value.length
                    ? h('div', { class: 'absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-xl shadow-lg px-3 py-3 text-sm text-gray-400' },
                        query.value ? 'No matches found.' : 'All options selected.')
                    : null,
        ])
    },
}
const props = defineProps({
    profile:      Object,
    user:         Object,
    institutions: Array,
    subjects:     Array,
})

// ── Shared input style ─────────────────────────────────────────────────
const inp = {
    class: 'w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2',
    style: '--tw-ring-color:#007B43',
}

// ── Initials for avatar fallback ───────────────────────────────────────
const initials = computed(() =>
    props.user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
)
// ── Avatar ────────────────────────────────────────────────────────────
const page         = usePage()
const avatarPreview = ref(null)
const avatarUploading = ref(false)

// Primary source: shared auth prop (updated on every Inertia visit)
// Fallback: page prop passed by the controller
const currentAvatar = computed(() =>
    avatarPreview.value
    || page.props.auth?.user?.avatar
    || props.user?.avatar_url
    || null
)

const onAvatarPicked = (e) => {
    const file = e.target.files[0]
    if (!file) return
    avatarPreview.value = URL.createObjectURL(file)

    avatarUploading.value = true
    router.post(
        route('tutor.profile.avatar'),   // ← change to 'student.profile.avatar' in the student page
        { avatar: file },
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                avatarPreview.value = null   // clear local preview — shared prop now has the real URL
            },
            onError: () => {
                avatarPreview.value = null   // clear broken preview on failure
            },
            onFinish: () => {
                avatarUploading.value = false
            },
        }
    )
}

// ── Main profile form ──────────────────────────────────────────────────
const form = useForm({
    name:                     props.user.name,
    bio:                      props.profile.bio ?? '',
    institution_ids:          (props.profile.institution_ids ?? []).map(Number),
    subject_ids:              (props.profile.subject_ids ?? []).map(Number),
    is_available:             props.profile.is_available ?? false,
    phone_number:             props.profile.phone_number ?? '',
    timezone:                 props.profile.timezone ?? 'Africa/Johannesburg',
    teaching_specializations: props.profile.teaching_specializations ?? [],
    education_level:          props.profile.education_level ?? '',
    years_of_experience:      props.profile.years_of_experience ?? '',
    language_preference:      props.profile.language_preference ?? 'en',
})

// Subjects filtered to selected institutions + universal (null institution_id)
const filteredSubjects = computed(() => {
    if (!form.institution_ids.length) return props.subjects
    return props.subjects.filter(s =>
        s.institution_id === null || form.institution_ids.includes(s.institution_id)
    )
})

const submit = () => form.post(route('tutor.profile.update'))
</script>