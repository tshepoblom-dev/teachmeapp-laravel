<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg">

            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24">
                    <img src="/assets/img/logo.svg" alt="TeachMe App" />
                </div>
                <h1 class="text-2xl font-bold" style="color:#141F3E;">TeachMe App</h1>
                <p class="mt-1" style="color:#6b7280;">Create your account</p>
            </div>

            <!-- Card -->
            <div class="card p-8">

                <!-- Step indicator -->
                <div class="flex items-center gap-2 mb-8">
                    <template v-for="(label, idx) in ['Choose role', 'Your details', 'Privacy & Terms']" :key="idx">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                                 :style="step >= idx + 1
                                     ? 'background:#007B43;color:#fff'
                                     : 'background:#e5e7eb;color:#6b7280'">
                                {{ idx + 1 }}
                            </div>
                            <span class="text-xs font-medium hidden sm:inline"
                                  :class="step >= idx + 1 ? 'text-gray-800' : 'text-gray-400'">
                                {{ label }}
                            </span>
                        </div>
                        <div v-if="idx < 2" class="flex-1 h-px"
                             :style="step >= idx + 2 ? 'background:#007B43' : 'background:#e5e7eb'">
                        </div>
                    </template>
                </div>

                <!-- ── Step 1: Role ──────────────────────────────────────── -->
                <div v-if="step === 1">
                    <h2 class="text-lg font-semibold mb-1" style="color:#141F3E;">I want to…</h2>
                    <p class="text-gray-500 mb-6">Choose how you'll use TeachMe App</p>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <button v-for="r in [{value:'student',icon:'student',title:'Learn',sub:'Book sessions with verified tutors'},{value:'tutor',icon:'tutor',title:'Teach',sub:'Share expertise, earn income'}]"
                                :key="r.value"
                                type="button"
                                @click="form.role = r.value"
                                class="relative p-6 rounded-xl border-2 text-left transition-all"
                                :style="form.role === r.value
                                    ? 'border-color:#007B43; background:rgba(0,123,67,.05);'
                                    : 'border-color:#e5e7eb; background:#fafafa;'">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4"
                                 :style="form.role === r.value ? 'background:rgba(0,123,67,.15)' : 'background:#f3f4f6'">
                                <!-- student icon -->
                                <svg v-if="r.value === 'student'" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" :stroke="form.role === 'student' ? '#007B43' : '#9ca3af'">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                <!-- tutor icon -->
                                <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" :stroke="form.role === 'tutor' ? '#007B43' : '#9ca3af'">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <p class="font-semibold mb-1" style="color:#141F3E;">{{ r.title }}</p>
                            <p class="text-xs text-gray-500">{{ r.sub }}</p>
                            <div v-if="form.role === r.value"
                                 class="absolute top-3 right-3 w-5 h-5 rounded-full flex items-center justify-center"
                                 style="background:#007B43;">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <p v-if="form.errors.role" class="mb-4 text-xs text-red-600">{{ form.errors.role }}</p>

                    <button type="button" @click="nextStep" :disabled="!form.role"
                            class="btn btn-primary w-full btn-lg">
                        Continue
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>

                <!-- ── Step 2: Details ───────────────────────────────────── -->
                <div v-if="step === 2">
                    <div class="flex items-center gap-3 mb-6">
                        <button type="button" @click="step = 1"
                                class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-lg font-semibold" style="color:#141F3E;">Your details</h2>
                            <p class="text-xs text-gray-500">
                                Registering as a
                                <span class="font-semibold" style="color:#007B43;">
                                    {{ form.role === 'tutor' ? 'Tutor' : 'Student' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium mb-1.5" style="color:#141F3E;">Full name</label>
                            <input v-model="form.name" type="text" autocomplete="name" required
                                   class="field" :class="{ error: form.errors.name }" placeholder="Jane Smith" />
                            <p v-if="form.errors.name" class="mt-1.5 text-xs text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label class="block font-medium mb-1.5" style="color:#141F3E;">Email address</label>
                            <input v-model="form.email" type="email" autocomplete="email" required
                                   class="field" :class="{ error: form.errors.email }" placeholder="you@example.com" />
                            <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-600">{{ form.errors.email }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1.5" style="color:#141F3E;">Password</label>
                                <input v-model="form.password" type="password" autocomplete="new-password" required
                                       class="field" :class="{ error: form.errors.password }" placeholder="Min 8 chars" />
                                <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-600">{{ form.errors.password }}</p>
                            </div>
                            <div>
                                <label class="block font-medium mb-1.5" style="color:#141F3E;">Confirm password</label>
                                <input v-model="form.password_confirmation" type="password"
                                       autocomplete="new-password" required class="field" placeholder="Repeat password" />
                            </div>
                        </div>

                        <!-- Password strength -->
                        <div v-if="form.password" class="space-y-1.5">
                            <div class="flex gap-1">
                                <div v-for="i in 4" :key="i" class="flex-1 h-1 rounded-full transition-all"
                                     :style="i <= strength.score ? `background:${strength.color}` : 'background:#e5e7eb'">
                                </div>
                            </div>
                            <p class="text-xs" :style="`color:${strength.color}`">{{ strength.label }}</p>
                        </div>

                        <div v-if="form.role === 'tutor'" class="rounded-xl p-4 text-sm"
                             style="background:rgba(0,123,67,.07); border:1px solid rgba(0,123,67,.2);">
                            <p class="font-semibold mb-1" style="color:#005c32;">📋 Tutors need KYC verification</p>
                            <p class="text-gray-600 text-xs">
                                After registering you'll be guided through identity and qualification verification
                                before you can accept bookings.
                            </p>
                        </div>

                        <button type="button" @click="goToConsent"
                                :disabled="!canProceedToConsent"
                                class="btn btn-primary w-full btn-lg">
                            Continue
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- ── Step 3: Privacy & Terms (POPIA consent) ───────────── -->
                <div v-if="step === 3">
                    <div class="flex items-center gap-3 mb-6">
                        <button type="button" @click="step = 2"
                                class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-400 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-lg font-semibold" style="color:#141F3E;">Privacy &amp; Terms</h2>
                            <p class="text-xs text-gray-500">Required before creating your account</p>
                        </div>
                    </div>

                    <!-- POPIA notice banner -->
                    <div class="rounded-xl p-4 mb-6"
                         style="background:rgba(0,123,67,.06); border:1px solid rgba(0,123,67,.2);">
                        <div class="flex gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#007B43">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold" style="color:#005c32;">Your data, your rights</p>
                                <p class="text-xs text-gray-600 mt-0.5">
                                    In compliance with the Protection of Personal Information Act (POPIA),
                                    we need your explicit consent before processing your personal data.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary of what we collect -->
                    <div class="rounded-xl border border-gray-200 p-4 mb-6 space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">What we collect &amp; why</p>
                        <div v-for="item in dataItems" :key="item.label" class="flex gap-3">
                            <div class="shrink-0 w-7 h-7 rounded-lg flex items-center justify-center"
                                 style="background:#f3f4f6;">
                                <span class="text-sm">{{ item.icon }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">{{ item.label }}</p>
                                <p class="text-xs text-gray-500">{{ item.purpose }}</p>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="space-y-4">
                        <!-- Terms checkbox -->
                        <label class="flex gap-3 cursor-pointer rounded-xl border-2 p-4 transition-all"
                               :style="form.terms_accepted
                                   ? 'border-color:#007B43;background:rgba(0,123,67,.04)'
                                   : form.errors.terms_accepted
                                       ? 'border-color:#dc2626;background:#fef2f2'
                                       : 'border-color:#e5e7eb'">
                            <input type="checkbox" v-model="form.terms_accepted"
                                   class="mt-0.5 w-4 h-4 rounded accent-green-700 shrink-0" />
                            <span class="text-sm text-gray-700">
                                I have read and agree to the
                                <a href="/legal/terms" target="_blank"
                                   class="font-semibold underline" style="color:#007B43;">Terms of Service</a>
                            </span>
                        </label>
                        <p v-if="form.errors.terms_accepted" class="text-xs text-red-600 -mt-2 pl-1">
                            {{ form.errors.terms_accepted }}
                        </p>

                        <!-- Privacy checkbox -->
                        <label class="flex gap-3 cursor-pointer rounded-xl border-2 p-4 transition-all"
                               :style="form.privacy_accepted
                                   ? 'border-color:#007B43;background:rgba(0,123,67,.04)'
                                   : form.errors.privacy_accepted
                                       ? 'border-color:#dc2626;background:#fef2f2'
                                       : 'border-color:#e5e7eb'">
                            <input type="checkbox" v-model="form.privacy_accepted"
                                   class="mt-0.5 w-4 h-4 rounded accent-green-700 shrink-0" />
                            <span class="text-sm text-gray-700">
                                I have read and consent to the
                                <a href="/legal/privacy" target="_blank"
                                   class="font-semibold underline" style="color:#007B43;">Privacy Policy</a>
                                and the processing of my personal information under POPIA
                            </span>
                        </label>
                        <p v-if="form.errors.privacy_accepted" class="text-xs text-red-600 -mt-2 pl-1">
                            {{ form.errors.privacy_accepted }}
                        </p>

                        <p class="text-xs text-gray-400 text-center">
                            You may withdraw consent at any time by contacting
                            <a href="mailto:privacy@teachme.co.za" class="underline">privacy@teachme.co.za</a>
                        </p>

                        <button type="submit"
                                :disabled="form.processing || !form.terms_accepted || !form.privacy_accepted"
                                class="btn btn-primary w-full btn-lg">
                            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            {{ form.processing ? 'Creating account…' : 'Create account' }}
                        </button>
                    </form>
                </div>

                <!-- Sign-in link -->
                <p class="text-center text-gray-500 mt-6">
                    Already have an account?
                    <a href="/login" class="font-semibold" style="color:#007B43;">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const step = ref(1)

const form = useForm({
    name:                  '',
    email:                 '',
    password:              '',
    password_confirmation: '',
    role:                  '',
    terms_accepted:        false,
    privacy_accepted:      false,
})

const dataItems = [
    { icon: '👤', label: 'Account information',  purpose: 'Name, email, role — to create and manage your account' },
    { icon: '📚', label: 'Session & booking data', purpose: 'Bookings and sessions you participate in' },
    { icon: '💳', label: 'Payment information',  purpose: 'Processed securely via our payment partners' },
    { icon: '📍', label: 'IP address & device',  purpose: 'Security, fraud prevention, and audit logging' },
]

function nextStep() {
    if (!form.role) return
    step.value = 2
}

const canProceedToConsent = computed(() =>
    form.name.length >= 2 &&
    form.email.includes('@') &&
    form.password.length >= 8 &&
    form.password === form.password_confirmation
)

function goToConsent() {
    if (!canProceedToConsent.value) return
    step.value = 3
}

function submit() {
    form.post(route('register.post'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}

const strength = computed(() => {
    const p = form.password
    let score = 0
    if (p.length >= 8)           score++
    if (/[A-Z]/.test(p))        score++
    if (/[0-9]/.test(p))        score++
    if (/[^A-Za-z0-9]/.test(p)) score++

    const map = {
        0: { label: 'Too weak',  color: '#dc2626' },
        1: { label: 'Weak',      color: '#f97316' },
        2: { label: 'Fair',      color: '#eab308' },
        3: { label: 'Good',      color: '#22c55e' },
        4: { label: 'Strong',    color: '#007B43' },
    }
    return { score, ...map[score] }
})
</script>