<template>
    <div class="pt-3">
        <p class="section-title" :class="lightMode ? 'section-title--light' : ''">{{ label }}</p>
        <div class="space-y-0.5">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { inject } from 'vue'
defineProps({ label: { type: String, required: true } })
const lightMode = inject('sidebarLightMode', false)
</script>

<style>
.section-title--light {
    color: #9ca3af;
}
</style>
