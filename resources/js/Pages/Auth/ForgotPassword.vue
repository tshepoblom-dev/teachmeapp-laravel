<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24">
                    <img src="/assets/img/logo.svg" alt="TeachMe App" />
                </div>
                <h1 class="text-2xl font-bold" style="color:#141F3E;">Forgot Password</h1>
                <p class="mt-1" style="color:#6b7280;">Enter your email and we'll send a reset link</p>
            </div>

            <!-- Success state -->
            <div v-if="status" class="card p-8 text-center space-y-4">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full mx-auto"
                     style="background:#e6f4ee;">
                    <svg class="w-7 h-7" style="color:#007B43;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="font-medium" style="color:#141F3E;">Check your inbox</p>
                <p class="text-sm" style="color:#6b7280;">{{ status }}</p>
                <a href="/login" class="block text-sm font-semibold mt-2" style="color:#007B43;">
                    ← Back to sign in
                </a>
            </div>

            <!-- Form -->
            <div v-else class="card p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block font-medium mb-1.5" style="color:#141F3E;">Email address</label>
                        <input
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            required
                            class="field"
                            :class="{ error: form.errors.email }"
                            placeholder="you@example.com"
                        />
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <button type="submit" :disabled="form.processing" class="btn btn-primary w-full btn-lg">
                        {{ form.processing ? 'Sending…' : 'Send reset link' }}
                    </button>
                </form>

                <p class="text-center text-gray-500 mt-6 text-sm">
                    <a href="/login" class="font-semibold" style="color:#007B43;">← Back to sign in</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    status: { type: String, default: null },
})

const form = useForm({ email: '' })

const submit = () => {
    form.post(route('password.email'))
}
</script>
