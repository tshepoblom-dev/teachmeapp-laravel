<template>
    <AdminLayout :title="user.name">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left column: Profile info + actions -->
            <div class="space-y-4">

                <!-- Profile card -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600">
                            {{ user.name?.charAt(0) }}
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900">{{ user.name }}</h2>
                            <p class="text-gray-500">{{ user.email }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="capitalize text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                    {{ user.role }}
                                </span>
                                <StatusBadge :status="user.account_status" />
                            </div>
                        </div>
                    </div>

                    <dl class="space-y-2 border-t border-gray-100 pt-4">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Joined</dt>
                            <dd>{{ formatDate(user.created_at) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Last login</dt>
                            <dd>{{ user.last_login_at || '—' }}</dd>
                        </div>
                        <div class="flex justify-between" v-if="user.profile">
                            <dt class="text-gray-500">KYC Status</dt>
                            <dd><StatusBadge :status="user.profile.kyc_status || 'not_submitted'" /></dd>
                        </div>
                        <div class="flex justify-between" v-if="user.profile?.tutor_tier">
                            <dt class="text-gray-500">Tier</dt>
                            <dd class="font-medium">{{ user.profile.tutor_tier.name }}</dd>
                        </div>
                        <div class="flex justify-between" v-if="user.wallet">
                            <dt class="text-gray-500">Wallet Balance</dt>
                            <dd class="font-semibold text-green-700">R {{ Number(user.wallet.balance).toFixed(2) }}</dd>
                        </div>
                        <div class="flex justify-between" v-if="user.wallet">
                            <dt class="text-gray-500">Escrow Balance</dt>
                            <dd class="font-medium text-orange-600">R {{ Number(user.wallet.escrow_balance).toFixed(2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Booking stats -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Booking Stats</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">As Student</dt>
                            <dd class="font-medium">{{ bookingStats.as_student }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">As Tutor</dt>
                            <dd class="font-medium">{{ bookingStats.as_tutor }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Completed</dt>
                            <dd class="font-medium text-green-700">{{ bookingStats.completed }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Tutor profile details -->
                <div
                    v-if="user.role === 'tutor' && user.profile"
                    class="bg-white rounded-xl border border-gray-200 p-5"
                >
                    <h3 class="font-semibold text-gray-700 mb-3">Tutor Profile</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Hourly Rate</dt>
                            <dd class="font-medium">R {{ user.profile.hourly_rate || '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Sessions Hosted</dt>
                            <dd class="font-medium">{{ user.profile.total_sessions_hosted }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Avg Rating</dt>
                            <dd class="font-medium">
                                {{ user.profile.average_rating
                                    ? `${user.profile.average_rating} ★`
                                    : '—' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Available</dt>
                            <dd>
                                <span :class="user.profile.is_available ? 'text-green-600' : 'text-gray-400'">
                                    {{ user.profile.is_available ? 'Yes' : 'No' }}
                                </span>
                            </dd>
                        </div>
                        <div v-if="user.profile.subjects" class="pt-2 border-t border-gray-100">
                            <dt class="text-gray-500 mb-1.5">Subjects</dt>
                            <dd class="flex flex-wrap gap-1">
                                <span
                                    v-for="s in user.profile.subjects"
                                    :key="s"
                                    class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full"
                                >
                                    {{ s }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-4">
                    <h3 class="font-semibold text-gray-700">Security</h3>

                    <!-- Set new password -->
                    <div class="space-y-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Set New Password</p>
                        <input
                            v-model="passwordForm.password"
                            type="password"
                            placeholder="New password"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            :class="{ 'border-red-400': passwordForm.errors.password }"
                        />
                        <input
                            v-model="passwordForm.password_confirmation"
                            type="password"
                            placeholder="Confirm password"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                        <p v-if="passwordForm.errors.password" class="text-xs text-red-500">{{ passwordForm.errors.password }}</p>
                        <p class="text-xs text-gray-400">Min 8 chars, upper &amp; lowercase, at least one number.</p>
                        <button
                            :disabled="passwordForm.processing"
                            @click="updatePassword"
                            class="w-full py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50"
                        >
                            {{ passwordForm.processing ? 'Updating…' : 'Update Password' }}
                        </button>
                    </div>

                    <!-- Send reset link -->
                    <div class="pt-3 border-t border-gray-100 space-y-2">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Password Reset Email</p>
                        <p class="text-xs text-gray-400">Send the user a reset link to <strong>{{ user.email }}</strong>.</p>
                        <button
                            :disabled="resetLinkForm.processing"
                            @click="sendResetLink"
                            class="w-full py-2 border border-indigo-300 text-indigo-600 text-sm font-semibold rounded-lg hover:bg-indigo-50 transition-colors disabled:opacity-50"
                        >
                            {{ resetLinkForm.processing ? 'Sending…' : 'Send Reset Link' }}
                        </button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-3">
                    <h3 class="font-semibold text-gray-700">Account Actions</h3>

                    <!-- Activate -->
                    <form
                        v-if="user.account_status !== 'active'"
                        @submit.prevent="activate"
                    >
                        <button
                            type="submit"
                            class="w-full py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                        >
                            ✓ Activate Account
                        </button>
                    </form>

                    <!-- Suspend -->
                    <form
                        v-if="user.account_status !== 'suspended'"
                        @submit.prevent="suspend"
                        class="space-y-2 pt-2 border-t border-gray-100"
                    >
                        <textarea
                            v-model="suspendForm.reason"
                            placeholder="Suspension reason *"
                            rows="2"
                            required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        />
                        <input
                            v-model="suspendForm.suspended_until"
                            type="datetime-local"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none"
                            placeholder="Lift suspension at (optional)"
                        />
                        <button
                            type="submit"
                            class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-colors"
                        >
                            Suspend Account
                        </button>
                    </form>

                    <!-- Ban -->
                    <form
                        v-if="user.account_status !== 'banned'"
                        @submit.prevent="ban"
                        class="space-y-2 pt-2 border-t border-gray-100"
                    >
                        <textarea
                            v-model="banForm.reason"
                            placeholder="Ban reason *"
                            rows="2"
                            required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                        />
                        <button
                            type="submit"
                            class="w-full py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors"
                        >
                            Ban Account
                        </button>
                    </form>
                </div>

                <!-- Danger zone -->
                <div class="bg-white rounded-xl border border-red-200 p-5 space-y-2">
                    <h3 class="font-semibold text-red-700">Danger Zone</h3>
                    <p class="text-xs text-gray-500">
                        Permanently delete this account. This cannot be undone. Accounts with existing
                        bookings, reviews, reports, chat messages, or invoices can't be deleted — ban
                        them instead.
                    </p>
                    <button
                        @click="deleteAccount"
                        class="w-full py-2 border border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors"
                    >
                        Delete Account
                    </button>
                </div>
            </div>

            <!-- Right column: KYC applications -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-semibold text-gray-700">KYC Applications</h3>

                <div
                    v-if="user.kyc_applications?.length"
                    class="space-y-3"
                >
                    <div
                        v-for="app in user.kyc_applications"
                        :key="app.id"
                        class="bg-white rounded-xl border border-gray-200 p-4"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="font-medium text-gray-800 capitalize">
                                    {{ app.application_type?.replace('_', ' ') }}
                                </p>
                                <p class="text-xs text-gray-400">Submitted {{ formatDate(app.submitted_at) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <StatusBadge :status="app.status" />
                                <Link
                                    :href="route('admin.kyc.show', app.id)"
                                    class="text-xs text-indigo-600 hover:underline"
                                >
                                    Review →
                                </Link>
                            </div>
                        </div>

                        <!-- Document list -->
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="doc in app.documents"
                                :key="doc.id"
                                class="text-xs px-2 py-1 rounded-full capitalize"
                                :class="{
                                    'bg-green-50 text-green-700': doc.status === 'verified',
                                    'bg-yellow-50 text-yellow-700': doc.status === 'uploaded',
                                    'bg-red-50 text-red-600': doc.status === 'rejected',
                                }"
                            >
                                {{ doc.document_type.replace(/_/g, ' ') }}
                            </span>
                        </div>

                        <p
                            v-if="app.rejection_reason"
                            class="mt-2 text-xs text-red-500"
                        >
                            Rejected: {{ app.rejection_reason }}
                        </p>
                    </div>
                </div>

                <div
                    v-else
                    class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400"
                >
                    No KYC applications submitted yet.
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'
import { fmtDateOnly } from '@/utils/time'

const props = defineProps({
    user:         { type: Object, required: true },
    bookingStats: { type: Object, default: () => ({}) },
})

const suspendForm = reactive({ reason: '', suspended_until: '' })
const banForm     = reactive({ reason: '' })

const passwordForm = useForm({
    password:              '',
    password_confirmation: '',
})

const resetLinkForm = useForm({})

const activate = () => {
    router.post(route('admin.users.activate', props.user.id))
}

const suspend = () => {
    router.post(route('admin.users.suspend', props.user.id), suspendForm)
}

const ban = () => {
    if (! confirm(`Are you sure you want to ban ${props.user.name}? This action is serious.`)) return
    router.post(route('admin.users.ban', props.user.id), banForm)
}

const updatePassword = () => {
    if (! confirm(`Set a new password for ${props.user.name}? Their active sessions will be revoked.`)) return
    passwordForm.post(route('admin.users.update-password', props.user.id), {
        onSuccess: () => passwordForm.reset(),
    })
}

const sendResetLink = () => {
    if (! confirm(`Send a password reset email to ${props.user.email}?`)) return
    resetLinkForm.post(route('admin.users.send-reset-link', props.user.id))
}

const deleteAccount = () => {
    if (! confirm(`Permanently delete ${props.user.name}'s account? This cannot be undone.`)) return
    router.delete(route('admin.users.destroy', props.user.id))
}

const formatDate = (d) => d ? fmtDateOnly(d) : '—'
</script>