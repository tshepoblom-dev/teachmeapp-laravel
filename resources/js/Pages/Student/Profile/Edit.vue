<template>
    <StudentLayout title="My Profile">
        <div class="max-w-3xl space-y-5">

            <!-- Flash -->
            <div v-if="$page.props.flash?.success"
                 class="px-4 py-3 rounded-xl text-sm font-medium text-white"
                 style="background:#007B43;">
                {{ $page.props.flash.success }}
            </div>

            <!-- ── Profile hero ─────────────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

                <!-- Cover band -->
                <div class="h-24" style="background: linear-gradient(135deg, #007B43cc 0%, #007B4366 60%, #f0fdf4 100%);"></div>

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
                    <!-- Stats strip -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-2">
                        <div v-for="stat in stats" :key="stat.label"
                             class="rounded-xl p-3 text-center"
                             style="background:#f0fdf4;">
                            <p class="text-xl font-bold" style="color:#007B43;">{{ stat.value }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ stat.label }}</p>
                        </div>
                    </div>
            </div>


            <!-- ── Edit form ────────────────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-5">Profile Details</h2>

                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Name + Email -->
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
                    <Field label="About Me">
                        <textarea v-model="form.bio" rows="4" v-bind="inp"
                                  placeholder="A short intro about yourself, your studies, or your learning goals…" />
                        <p class="text-xs text-gray-400 mt-1 text-right">{{ form.bio?.length ?? 0 }} / 1000</p>
                        <FieldError :message="form.errors.bio" />
                    </Field>

                    <!-- Phone + Timezone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <Field label="Phone Number">
                            <input v-model="form.phone_number" type="tel" v-bind="inp"
                                   placeholder="+27 82 000 0000" />
                            <FieldError :message="form.errors.phone_number" />
                        </Field>
                     <!--   <Field label="Timezone">
                            <select v-model="form.timezone" v-bind="inp">
                                <option value="Africa/Johannesburg">Africa/Johannesburg (SAST)</option>
                                <option value="UTC">UTC</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="America/New_York">America/New_York</option>
                            </select>
                        </Field>
                        -->
                    </div>

                    <!-- Language -->
               <!--     <Field label="Preferred Language">
                        <div class="flex flex-wrap gap-2 mt-1">
                            <label v-for="lang in languages" :key="lang.value"
                                   class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium cursor-pointer transition-colors"
                                   :class="form.language_preference === lang.value
                                       ? 'border-transparent text-white'
                                       : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                                   :style="form.language_preference === lang.value ? 'background:#007B43' : ''">
                                <input type="radio" :value="lang.value" v-model="form.language_preference" class="hidden" />
                                {{ lang.label }}
                            </label>
                        </div>
                    </Field>
-->
                    <!-- Save -->
                    <div class="pt-1 flex items-center gap-3">
                        <button type="submit" :disabled="form.processing"
                                class="px-6 py-2.5 text-white font-semibold rounded-lg disabled:opacity-50 transition-opacity hover:opacity-90"
                                style="background:#007B43;">
                            {{ form.processing ? 'Saving…' : 'Save Changes' }}
                        </button>
                        <span v-if="form.recentlySuccessful" class="text-sm font-medium" style="color:#007B43;">Saved!</span>
                    </div>
                </form>
            </div>

        </div>
    </StudentLayout>
</template>

<script setup>
import { ref, computed, h, onMounted, onUnmounted, nextTick } from 'vue'
import { useForm, router, usePage }       from '@inertiajs/vue3'
import StudentLayout     from '@/Layouts/StudentLayout.vue'
import FieldError        from '@/Components/FieldError.vue'

    const Field = {
        props: ['label'],
        setup(props, { slots }) {
            return () => h('div', [
                h('label', { class: 'block text-xs font-medium text-gray-600 mb-1' }, props.label),
                slots.default?.(),
            ])
        }
    }

const props = defineProps({
    user:    Object,
    profile: Object,
})

// ── Shared input style ─────────────────────────────────────────────────
const inp = {
    class: 'w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2',
    style: '--tw-ring-color:#007B43',
}

const languages = [
    { value: 'en', label: 'English'   },
    { value: 'af', label: 'Afrikaans' },
    { value: 'zu', label: 'Zulu'      },
    { value: 'xh', label: 'Xhosa'     },
]

// ── Initials ───────────────────────────────────────────────────────────
const initials = computed(() =>
    props.user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
)

// ── Stats ──────────────────────────────────────────────────────────────
const stats = computed(() => [
    { value: props.profile.total_sessions_attended, label: 'Sessions'  },
    { value: props.profile.total_reviews,           label: 'Reviews'   },
    { value: props.profile.timezone?.split('/')[1]?.replace('_', ' ') ?? '—', label: 'Timezone' },
    { value: props.profile.language_preference?.toUpperCase() ?? '—',         label: 'Language' },
])

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
        route('student.profile.avatar'),   // ← change to 'student.profile.avatar' in the student page
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
// ── Profile form ───────────────────────────────────────────────────────
const form = useForm({
    name:                props.user.name,
    bio:                 props.profile.bio                 ?? '',
    phone_number:        props.profile.phone_number        ?? '',
    timezone:            props.profile.timezone            ?? 'Africa/Johannesburg',
    language_preference: props.profile.language_preference ?? 'en',
})

const submit = () => form.post(route('student.profile.update'))
</script>