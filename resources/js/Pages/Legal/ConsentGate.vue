<template>
    <div class="min-h-screen flex items-center justify-center p-4" style="background:#f9fafb;">
        <div class="w-full max-w-lg">
            <div class="text-center mb-8">
                <img src="/assets/img/logo.svg" alt="TeachMe App" class="w-20 h-20 mx-auto mb-3" />
                <h1 class="text-2xl font-bold" style="color:#141F3E;">One more step</h1>
                <p class="text-gray-500 mt-1">We've updated our policies — please review and accept to continue</p>
            </div>

            <div class="card p-8">
                <div class="rounded-xl p-4 mb-6"
                     style="background:rgba(0,123,67,.06); border:1px solid rgba(0,123,67,.2);">
                    <p class="text-sm font-semibold" style="color:#005c32;">🔒 POPIA compliance required</p>
                    <p class="text-xs text-gray-600 mt-1">
                        South African law requires us to record your explicit consent before we
                        continue processing your personal information.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <label class="flex gap-3 cursor-pointer rounded-xl border-2 p-4 transition-all"
                           :style="form.terms_accepted ? 'border-color:#007B43;background:rgba(0,123,67,.04)' : 'border-color:#e5e7eb'">
                        <input type="checkbox" v-model="form.terms_accepted"
                               class="mt-0.5 w-4 h-4 rounded accent-green-700 shrink-0" />
                        <span class="text-sm text-gray-700">
                            I agree to the
                            <a href="/legal/terms" target="_blank" class="font-semibold underline" style="color:#007B43;">
                                Terms of Service
                            </a>
                        </span>
                    </label>
                    <p v-if="form.errors.terms_accepted" class="text-xs text-red-600 pl-1">
                        {{ form.errors.terms_accepted }}
                    </p>

                    <label class="flex gap-3 cursor-pointer rounded-xl border-2 p-4 transition-all"
                           :style="form.privacy_accepted ? 'border-color:#007B43;background:rgba(0,123,67,.04)' : 'border-color:#e5e7eb'">
                        <input type="checkbox" v-model="form.privacy_accepted"
                               class="mt-0.5 w-4 h-4 rounded accent-green-700 shrink-0" />
                        <span class="text-sm text-gray-700">
                            I consent to the
                            <a href="/legal/privacy" target="_blank" class="font-semibold underline" style="color:#007B43;">
                                Privacy Policy
                            </a>
                            and processing of my personal data under POPIA
                        </span>
                    </label>
                    <p v-if="form.errors.privacy_accepted" class="text-xs text-red-600 pl-1">
                        {{ form.errors.privacy_accepted }}
                    </p>

                    <button type="submit"
                            :disabled="form.processing || !form.terms_accepted || !form.privacy_accepted"
                            class="btn btn-primary w-full btn-lg">
                        <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        {{ form.processing ? 'Saving…' : 'Accept &amp; continue' }}
                    </button>
                </form>

                <form method="POST" :action="route('logout')" class="mt-4 text-center">
                    <input type="hidden" name="_token" :value="csrf" />
                    <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 underline">
                        Sign out instead
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'

const csrf = usePage().props.csrf_token ?? document.querySelector('meta[name=csrf-token]')?.content

const form = useForm({
    terms_accepted:   false,
    privacy_accepted: false,
})

function submit() {
    form.post(route('consent.store'))
}
</script>