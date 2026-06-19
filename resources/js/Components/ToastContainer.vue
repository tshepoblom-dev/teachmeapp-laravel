<template>
    <div class="toast-wrap">
        <div
            v-for="t in toasts"
            :key="t.id"
            class="toast"
            :class="[`toast-${t.type}`, { leaving: t.leaving }]"
        >
            <!-- Icon -->
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path v-if="t.type === 'success'" stroke-linecap="round" stroke-linejoin="round"
                      d="M4.5 12.75l6 6 9-13.5" />
                <path v-else-if="t.type === 'error'" stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                <path v-else-if="t.type === 'warning'" stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                <path v-else stroke-linecap="round" stroke-linejoin="round"
                      d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <span class="flex-1">{{ t.message }}</span>
            <button class="toast-close" @click="remove(t.id)">✕</button>
        </div>
    </div>
</template>

<script setup>
import { useToast } from '@/composables/useToast'
const { toasts, remove } = useToast()
</script>