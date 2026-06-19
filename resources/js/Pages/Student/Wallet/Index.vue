<template>
    <StudentLayout title="Wallet">
        <div class="max-w-3xl space-y-6">
            <!-- Balance row -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500 mb-1">Available Balance</p>
                    <p class="text-3xl font-bold text-gray-800">R {{ balance.toFixed(2) }}</p>
                </div>
                <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5">
                    <p class="text-xs text-amber-700 mb-1">Held in Escrow</p>
                    <p class="text-3xl font-bold text-amber-800">R {{ escrow_balance.toFixed(2) }}</p>
                </div>
            </div>

            <!-- Top up form -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Top Up Wallet</h2>
                <form @submit.prevent="submit" class="flex flex-wrap gap-3 items-end">
                    <!-- Quick amounts -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Quick amounts</p>
                        <div class="flex gap-2">
                            <button v-for="amt in [100, 250, 500, 1000]" :key="amt" type="button"
                                @click="form.amount = amt"
                                :class="form.amount === amt ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-700 border-gray-200 hover:border-teal-300'"
                                class="px-3 py-1.5 rounded-lg border transition-colors">
                                R{{ amt }}
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 min-w-32">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Custom Amount (ZAR)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">R</span>
                            <input v-model="form.amount" type="number" min="10" step="0.01"
                                class="w-full border border-gray-200 rounded-lg pl-7 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500" />
                        </div>
                        <FieldError :message="form.errors.amount" />
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Payment Method</label>
                        <select v-model="form.payment_method_id"
                            class="border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option v-for="m in payment_methods" :key="m.id" :value="m.id">{{ m.name }}</option>
                        </select>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="px-5 py-2.5 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 disabled:opacity-50 flex items-center gap-2">
                        <!-- Spinner shown while Inertia::location() is navigating -->
                        <svg v-if="form.processing" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        {{ form.processing ? 'Redirecting…' : 'Top Up' }}
                    </button>
                </form>
            </div>

            <!-- Transactions -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700">Transactions</h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Description</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Amount</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-if="!transactions.data.length">
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No transactions yet.</td>
                        </tr>
                        <tr v-for="t in transactions.data" :key="t.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ fmtDateOnly(t.created_at) }}
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ t.description || t.type.replace(/_/g,' ') }}
                            </td>
                            <td class="px-4 py-3 text-right font-medium"
                                :class="t.direction === 'credit' ? 'text-green-600' : 'text-red-500'">
                                {{ t.direction === 'credit' ? '+' : '-' }}R{{ t.amount.toFixed(2) }}
                            </td>
                            <td class="px-4 py-3 text-right text-gray-400 text-xs">
                                R{{ t.balance_after.toFixed(2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="transactions.last_page > 1" class="px-4 py-3 border-t border-gray-100 flex gap-2">
                    <Link v-for="link in transactions.links" :key="link.label" :href="link.url ?? '#'"
                        class="px-2.5 py-1 rounded text-xs border"
                        :class="link.active ? 'bg-teal-600 text-white border-teal-600' : 'border-gray-200 text-gray-600'"
                        v-html="link.label" />
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { Link, useForm }  from '@inertiajs/vue3'
import StudentLayout       from '@/Layouts/StudentLayout.vue'
import FieldError          from '@/Components/FieldError.vue'
import { fmtDateOnly }     from '@/utils/time'

const props = defineProps({
    balance: Number, escrow_balance: Number, transactions: Object, payment_methods: Array,
})

const form = useForm({ amount: 250, payment_method_id: props.payment_methods[0]?.id ?? null })

/**
 * Inertia::location() (returned by the backend when PayFast redirect is needed)
 * causes a real browser GET to the intermediate gatewayRedirect route, which
 * serves a plain HTML auto-submit form — fully outside Inertia's srcdoc modal.
 * No extra logic is needed here; form.post() + Inertia::location() handles it.
 */
const submit = () => form.post(route('student.wallet.deposit'))
</script>
