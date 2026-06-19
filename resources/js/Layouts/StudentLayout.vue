<template>
    <AppLayout :title="title" :no-padding="noPadding" role="student">
        <template #nav>
            <NavItem :href="route('student.dashboard')"        icon="home">Dashboard</NavItem>

            <NavGroup label="Learning">
                <NavItem :href="route('student.discover')"     icon="magnifying-glass">Find a Tutor</NavItem>
                <NavItem :href="route('student.bookings.index')" icon="calendar">My Bookings</NavItem>
            </NavGroup>

            <NavGroup label="Finance">
                <NavItem :href="route('student.wallet.index')" icon="banknotes">Wallet</NavItem>
            </NavGroup>
            <NavGroup label="Account">
                <NavItem :href="route('student.profile.edit')" icon="user-circle">My Profile</NavItem>
            </NavGroup>
        </template>

        <slot />
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import NavItem   from '@/Components/NavItem.vue'
import NavGroup  from '@/Components/NavGroup.vue'

defineProps({
    title:    { type: String,  default: '' },
    noPadding:{ type: Boolean, default: false },
})
</script>
