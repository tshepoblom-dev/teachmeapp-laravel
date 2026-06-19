<template>
    <AdminLayout title="Payment Gateways">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
                v-for="method in methods"
                :key="method.id"
                class="bg-white rounded-xl border border-gray-200 overflow-hidden"
            >
                <!-- Header -->
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                            <span class="font-bold text-gray-600 uppercase">
                                {{ method.code?.slice(0, 2) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">{{ method.name }}</h3>
                            <p class="text-xs text-gray-400 capitalize">{{ method.payment_flow }} flow</p>
                        </div>
                    </div>
                    <StatusBadge :status="method.is_active ? 'active' : 'declined'" />
                </div>

                <!-- Config status -->
                <div class="px-5 py-3 border-b border-gray-50">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-2 h-2 rounded-full"
                            :class="method.is_configured ? 'bg-green-500' : 'bg-yellow-400'"
                        />
                        <span class="text-xs text-gray-500">
                            {{ method.is_configured ? 'Configured' : 'Not configured' }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-5 py-3 flex gap-2">
                    <Link
                        :href="route('admin.gateways.show', method.id)"
                        class="flex-1 text-center text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg py-1.5 hover:bg-indigo-50 transition-colors"
                    >
                        Configure
                    </Link>
                    <form @submit.prevent="toggle(method)">
                        <button
                            type="submit"
                            class="px-3 text-xs font-medium border rounded-lg py-1.5 transition-colors"
                            :class="method.is_active
                                ? 'text-orange-600 border-orange-200 hover:bg-orange-50'
                                : 'text-green-600 border-green-200 hover:bg-green-50'"
                        >
                            {{ method.is_active ? 'Disable' : 'Enable' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

defineProps({
    methods: { type: Array, default: () => [] },
})

const toggle = (method) => {
    router.post(route('admin.gateways.toggle', method.id))
}
</script>