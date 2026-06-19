<template>
    <div class="min-h-screen flex items-center justify-center p-4" >
        <div class="w-full max-w-sm">

            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24"
                     >
                   <img src="/assets/img/logo.svg" alt="TeachMe App" class="h-8 w-auto" />
                </div>
                <h1 class="text-2xl font-bold " style="color:#141F3E;">TeachMe App</h1>
                <p class="mt-1" style="color:#6b7280;">Almost there!</p>
            </div>

            <!-- Card -->
            <div class="card p-8 text-center">

                <!-- Envelope illustration -->
                <div class="flex items-center justify-center mb-5">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center"
                         style="background:rgba(0,123,67,.1);">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.3" style="color:#007B43;" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-bold mb-2" style="color:#141F3E;">Check your inbox</h2>

                <p class="text-gray-500 mb-1">We've sent a verification link to</p>
                <p class="font-semibold mb-6" style="color:#141F3E;">{{ email }}</p>

                <p class="text-xs text-gray-400 mb-6 leading-relaxed">
                    Click the link in that email to activate your account.
                    The link expires in&nbsp;<strong>60&nbsp;minutes</strong>.
                </p>

                <!-- Success flash -->
                <div v-if="$page.props.flash?.success"
                     class="mb-4 rounded-lg px-4 py-3 font-medium"
                     style="background:#f0faf5;color:#065f46;border:1px solid #a7f3d0;">
                    {{ $page.props.flash.success }}
                </div>

                <!-- Resend button -->
                <form @submit.prevent="resend">
                    <button
                        type="submit"
                        :disabled="resendForm.processing || justSent"
                        class="btn btn-primary w-full"
                    >
                        <svg v-if="resendForm.processing" class="w-4 h-4 animate-spin"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        {{ justSent ? 'Email sent ✓' : resendForm.processing ? 'Sending…' : 'Resend verification email' }}
                    </button>
                </form>

                <!-- Cooldown hint -->
                <p v-if="justSent" class="text-xs text-gray-400 mt-3">
                    Check your spam folder if you don't see it within a minute.
                </p>

                <!-- Sign out link -->
                <div class="mt-6 pt-5" style="border-top:1px solid #f3f4f6;">
                    <Link :href="route('logout')" method="post" as="button"
                          class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        Sign out and use a different account
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link, Head } from '@inertiajs/vue3'

const props = defineProps({ email: String })

const resendForm = useForm({})
const justSent   = ref(false)

const resend = () => {
    resendForm.post(route('verification.send'), {
        onSuccess: () => {
            justSent.value = true
            // Reset the "just sent" state after 30 s so they can retry
            setTimeout(() => { justSent.value = false }, 30_000)
        },
    })
}
</script>
