<template>
    <TutorLayout title="Wallet">
        <!-- Balance cards -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-xs text-gray-500 mb-1">Available Balance</p>
                <p class="text-3xl font-bold text-gray-800">R {{ balance.toFixed(2) }}</p>
                <Link :href="route('tutor.wallet.payouts')" class="text-xs text-indigo-600 hover:underline mt-2 inline-block">
                    Request payout →
                </Link>
            </div>
            <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5">
                <p class="text-xs text-amber-700 mb-1">In Escrow (Pending sessions)</p>
                <p class="text-3xl font-bold text-amber-800">R {{ escrow_balance.toFixed(2) }}</p>
                <p class="text-xs text-amber-600 mt-2">Released when sessions complete</p>
            </div>
        </div>

        <!-- Transaction history -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-700">Transaction History</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Type</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Amount</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr v-if="!transactions.data.length">
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">No transactions yet.</td>
                    </tr>
                    <tr v-for="t in transactions.data" :key="t.id" class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            {{ fmtDateOnly(t.created_at) }}
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ t.description || '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                {{ t.type.replace(/_/g,' ') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium"
                            :class="t.direction === 'credit' ? 'text-green-600' : 'text-red-500'">
                            {{ t.direction === 'credit' ? '+' : '-' }}R{{ t.amount.toFixed(2) }}
                        </td>
                        <td class="px-4 py-3 text-right text-gray-500 text-xs">R{{ t.balance_after.toFixed(2) }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="transactions.last_page > 1" class="px-4 py-3 border-t border-gray-100 flex gap-2">
                <Link v-for="link in transactions.links" :key="link.label" :href="link.url ?? '#'"
                    class="px-2.5 py-1 rounded text-xs border"
                    :class="link.active ? 'bg-indigo-600 text-white border-indigo-600' : 'border-gray-200 text-gray-600'"
                    v-html="link.label" />
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { Link }          from '@inertiajs/vue3'
import TutorLayout       from '@/Layouts/TutorLayout.vue'
import { fmtDateOnly }   from '@/utils/time'

defineProps({ balance: Number, escrow_balance: Number, transactions: Object })
</script>