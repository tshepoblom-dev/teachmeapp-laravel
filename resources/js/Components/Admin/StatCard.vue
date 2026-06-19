<template>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ label }}</p>
                <p class="mt-1.5 text-2xl font-bold text-gray-900">{{ value }}</p>
                <p v-if="sub" class="mt-0.5 text-xs text-gray-400">{{ sub }}</p>
            </div>
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center"
                :class="iconBg"
            >
                <slot />
            </div>
        </div>
        <div v-if="trend !== undefined" class="mt-3 flex items-center gap-1">
            <span
                :class="trend >= 0 ? 'text-green-600' : 'text-red-500'"
                class="text-xs font-semibold"
            >
                {{ trend >= 0 ? '+' : '' }}{{ trend }}%
            </span>
            <span class="text-xs text-gray-400">vs last month</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    label:   { type: String,  required: true },
    value:   { type: [String, Number], required: true },
    sub:     { type: String,  default: null },
    iconBg:  { type: String,  default: 'bg-indigo-50' },
    trend:   { type: Number,  default: undefined },
})
</script>