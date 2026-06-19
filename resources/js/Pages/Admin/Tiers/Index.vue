<template>
    <AdminLayout title="Tutor Tiers">
        <div class="flex justify-end mb-4">
            <Link
                :href="route('admin.tiers.create')"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors"
            >
                + New Tier
            </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div
                v-for="tier in tiers"
                :key="tier.id"
                class="bg-white rounded-xl border-2 overflow-hidden"
                :style="{ borderColor: '#' + tier.theme_colour_primary }"
            >
                <!-- Tier header -->
                <div
                    class="px-5 py-4 flex items-center justify-between"
                    :style="{ backgroundColor: '#' + tier.theme_colour_primary + '18' }"
                >
                    <div>
                        <h3 class="font-bold text-gray-900">{{ tier.name }}</h3>
                        <p class="text-xs text-gray-500">{{ tier.sessions_threshold }}+ sessions</p>
                    </div>
                    <span
                        class="text-2xl font-black"
                        :style="{ color: '#' + tier.theme_colour_primary }"
                    >
                        {{ tier.commission_rate }}%
                    </span>
                </div>

                <!-- Stats -->
                <div class="px-5 py-4 border-b border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tutors assigned</span>
                        <span class="font-semibold">{{ tier.tutor_count }}</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-gray-500">Commission</span>
                        <span class="font-semibold">{{ tier.commission_rate }}%</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-gray-500">Status</span>
                        <StatusBadge :status="tier.is_active ? 'active' : 'declined'" />
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-5 py-3 flex gap-2">
                    <Link
                        :href="route('admin.tiers.edit', tier.id)"
                        class="flex-1 text-center text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg py-1.5 hover:bg-indigo-50"
                    >
                        Edit
                    </Link>
                    <button
                        @click="toggle(tier)"
                        class="flex-1 text-center text-xs font-medium border rounded-lg py-1.5 transition-colors"
                        :class="tier.is_active
                            ? 'text-orange-600 border-orange-200 hover:bg-orange-50'
                            : 'text-green-600 border-green-200 hover:bg-green-50'"
                    >
                        {{ tier.is_active ? 'Disable' : 'Enable' }}
                    </button>
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
    tiers: { type: Array, default: () => [] },
})

const toggle = (tier) => {
    router.post(route('admin.tiers.toggle', tier.id))
}
</script>