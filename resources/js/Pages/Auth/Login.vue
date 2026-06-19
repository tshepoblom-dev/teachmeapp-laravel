<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24"
                     >                   
                    <img src="/assets/img/logo.svg" alt="TeachMe App" />
                </div>
                <h1 class="text-2xl font-bold" style="color:#141F3E;">TeachMe App</h1>
                <p class="mt-1" style="color:#6b7280;">Sign in to your account</p>
            </div>

            <!-- Card -->
            <div class="card p-8">
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

                    <div>
                        <label class="block font-medium mb-1.5" style="color:#141F3E;">Password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="field"
                            placeholder="••••••••"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                id="remember"
                                class="rounded border-gray-300"
                                style="accent-color:#007B43;"
                            />
                            <label for="remember" class="text-gray-600">Remember me</label>
                        </div>
                        <a href="/forgot-password" class="text-sm font-semibold" style="color:#007B43;">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" :disabled="form.processing" class="btn btn-primary w-full btn-lg">
                        {{ form.processing ? 'Signing in…' : 'Sign in' }}
                    </button>
                </form>

                <p class="text-center text-gray-500 mt-6">
                    Don't have an account?
                    <a href="/register" class="font-semibold" style="color:#007B43;">Create one</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({ email: '', password: '', remember: false })

const submit = () => {
    form.post(route('login.post'), { onFinish: () => form.reset('password') })
}
</script>