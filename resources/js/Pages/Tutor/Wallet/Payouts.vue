<template>
    <TutorLayout title="Payouts">
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Request payout -->
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500 mb-1">Available to Withdraw</p>
                    <p class="text-3xl font-bold text-gray-800 mb-4">R {{ balance.toFixed(2) }}</p>

                    <form @submit.prevent="submitPayout" class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Amount (ZAR)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">R</span>
                                <input v-model="payoutForm.amount" type="number" min="50" step="0.01"
                                    class="w-full border border-gray-200 rounded-lg pl-7 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                            <FieldError :message="payoutForm.errors.amount" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Payout Account</label>
                            <select v-model="payoutForm.payout_account_id"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select account…</option>
                                <option v-for="a in payout_accounts" :key="a.id" :value="a.id">
                                    {{ a.bank_name || a.account_type }} — {{ a.holder_name }}
                                </option>
                            </select>
                            <FieldError :message="payoutForm.errors.payout_account_id" />
                        </div>
                        <button type="submit" :disabled="payoutForm.processing || !payout_accounts.length"
                            class="w-full py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 disabled:opacity-50">
                            {{ payoutForm.processing ? 'Submitting…' : 'Request Payout' }}
                        </button>
                        <p v-if="!payout_accounts.length" class="text-xs text-amber-600 text-center">
                            Add a payout account below first.
                        </p>
                    </form>
                </div>

                <!-- Add account form -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <h2 class="font-semibold text-gray-700 mb-4">Add Payout Account</h2>
                    <form @submit.prevent="submitAccount" class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Account Type</label>
                            <select v-model="accountForm.account_type"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="bank">South African Bank Account</option>
                                <option value="payfast">PayFast</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Account Holder Name</label>
                            <input v-model="accountForm.account_holder_name" type="text"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <template v-if="accountForm.account_type === 'bank'">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Bank Name</label>
                                <select v-model="accountForm.bank_name"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option>ABSA</option><option>FNB</option><option>Nedbank</option>
                                    <option>Standard Bank</option><option>Capitec</option><option>Investec</option>
                                    <option>African Bank</option><option>Bidvest Bank</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Account Number</label>
                                    <input v-model="accountForm.account_number" type="text"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Branch Code</label>
                                    <input v-model="accountForm.branch_code" type="text"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>
                        </template>
                        <label class="flex items-center gap-2 text-gray-600">
                            <input v-model="accountForm.is_default" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600" />
                            Set as default payout account
                        </label>
                        <button type="submit" :disabled="accountForm.processing"
                            class="w-full py-2 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-900 disabled:opacity-50">
                            Save Account
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payout history -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden self-start">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700">Payout History</h2>
                </div>
                <div v-if="!payout_history.data.length" class="px-5 py-8 text-center text-gray-400">
                    No payouts yet.
                </div>
                <div v-else class="divide-y divide-gray-50">
                    <div v-for="p in payout_history.data" :key="p.id" class="px-5 py-3 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">R{{ p.amount.toFixed(2) }}</p>
                            <p class="text-xs text-gray-400">{{ p.account }} · {{ fmtDateOnly(p.created_at) }}</p>
                        </div>
                        <span :class="{
                            'bg-yellow-100 text-yellow-700': p.status === 'pending',
                            'bg-blue-100 text-blue-700':    p.status === 'processing',
                            'bg-green-100 text-green-700':  p.status === 'completed',
                            'bg-red-100 text-red-700':      p.status === 'failed',
                        }" class="px-2 py-0.5 rounded-full text-xs font-medium capitalize">{{ p.status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { useForm }      from '@inertiajs/vue3'
import TutorLayout      from '@/Layouts/TutorLayout.vue'
import FieldError       from '@/Components/FieldError.vue'
import { fmtDateOnly }  from '@/utils/time'

defineProps({ balance: Number, payout_accounts: Array, payout_history: Object })

const payoutForm = useForm({ amount: '', payout_account_id: '' })
const submitPayout = () => payoutForm.post(route('tutor.wallet.payout.request'), {
    onSuccess: () => payoutForm.reset(),
})

const accountForm = useForm({
    account_type: 'bank', account_holder_name: '', bank_name: 'ABSA',
    account_number: '', branch_code: '', is_default: false,
})
const submitAccount = () => accountForm.post(route('tutor.wallet.payout-account.store'), {
    onSuccess: () => accountForm.reset(),
})
</script>