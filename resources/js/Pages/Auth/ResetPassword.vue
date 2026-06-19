<template>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24">
                    <img src="/assets/img/logo.svg" alt="TeachMe App" />
                </div>
                <h1 class="text-2xl font-bold" style="color:#141F3E;">Reset Password</h1>
                <p class="mt-1" style="color:#6b7280;">Choose a strong new password</p>
            </div>

            <!-- Card -->
            <div class="card p-8">
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email (read-only, confirms whose account is being reset) -->
                    <div>
                        <label class="block font-medium mb-1.5" style="color:#141F3E;">Email address</label>
                        <input
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            readonly
                            class="field"
                            :class="{ error: form.errors.email }"
                            style="background:#f9fafb; cursor:default;"
                        />
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <!-- New password -->
                    <div>
                        <label class="block font-medium mb-1.5" style="color:#141F3E;">New password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="field"
                            :class="{ error: form.errors.password }"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-600">{{ form.errors.password }}</p>
                        <p class="mt-1.5 text-xs" style="color:#9ca3af;">
                            Min 8 characters, upper & lowercase, at least one number.
                        </p>
                    </div>

                    <!-- Confirm password -->
                    <div>
                        <label class="block font-medium mb-1.5" style="color:#141F3E;">Confirm password</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="field"
                            :class="{ error: form.errors.password_confirmation }"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password_confirmation" class="mt-1.5 text-xs text-red-600">
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <button type="submit" :disabled="form.processing" class="btn btn-primary w-full btn-lg">
                        {{ form.processing ? 'Resetting…' : 'Reset password' }}
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
    token: { type: String, required: true },
    email: { type: String, default: '' },
})

const form = useForm({
    token:                 props.token,
    email:                 props.email,
    password:              '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>
