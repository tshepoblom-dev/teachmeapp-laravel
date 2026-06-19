<template>
    <AppLayout :title="title" :no-padding="noPadding" role="tutor">
        <template #nav>
            <NavItem :href="route('tutor.dashboard')"           icon="home">Dashboard</NavItem>

            <NavGroup label="Work">
                <NavItem :href="route('tutor.bookings.requests')" icon="inbox">
                    Requests
                    <template #badge v-if="pendingRequests > 0">
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                            {{ pendingRequests }}
                        </span>
                    </template>
                </NavItem>
                <NavItem :href="route('tutor.bookings.index')"   icon="calendar">Bookings</NavItem>
                <NavItem :href="route('tutor.availability.index')" icon="clock">Availability</NavItem>
            </NavGroup>

            <NavGroup label="Finance">
                <NavItem :href="route('tutor.wallet.index')"    icon="banknotes">Wallet</NavItem>
                <NavItem :href="route('tutor.wallet.payouts')"  icon="arrow-up-tray">Payouts</NavItem>
            </NavGroup>

            <NavGroup label="Account">
                <NavItem :href="route('tutor.profile.edit')"    icon="user-circle">Profile</NavItem>
                <NavItem :href="route('tutor.kyc.index')"       icon="shield-check">KYC / Verification</NavItem>
            </NavGroup>
        </template>

        <slot />
    </AppLayout>
</template>

<script setup>
import { computed }       from 'vue'
import { usePage }        from '@inertiajs/vue3'
import AppLayout          from '@/Layouts/AppLayout.vue'
import NavItem            from '@/Components/NavItem.vue'
import NavGroup           from '@/Components/NavGroup.vue'

defineProps({
    title:    { type: String,  default: '' },
    noPadding:{ type: Boolean, default: false },
})

const page            = usePage()
const pendingRequests = computed(() => page.props.pendingRequests ?? 0)
</script>