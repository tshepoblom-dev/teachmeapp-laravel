<template>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Table header with search + actions -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <input
                    v-if="searchable"
                    v-model="searchQuery"
                    type="search"
                    :placeholder="searchPlaceholder"
                    class="border border-gray-200 rounded-lg px-3 py-1.5 w-56 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    @input="$emit('search', searchQuery)"
                />
                <slot name="filters" />
            </div>
            <div class="flex items-center gap-2">
                <slot name="actions" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th
                            v-for="col in columns"
                            :key="col.key"
                            class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3"
                            :class="col.class"
                        >
                            {{ col.label }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr
                        v-for="(row, i) in rows"
                        :key="i"
                        class="hover:bg-gray-50 transition-colors"
                    >
                        <slot :row="row" />
                    </tr>
                    <tr v-if="rows.length === 0">
                        <td
                            :colspan="columns.length"
                            class="px-5 py-10 text-center text-gray-400 text-sm"
                        >
                            {{ emptyMessage }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            v-if="pagination && pagination.last_page > 1"
            class="flex items-center justify-between px-5 py-3 border-t border-gray-100"
        >
            <p class="text-xs text-gray-500">
                Showing {{ pagination.from }}–{{ pagination.to }} of {{ pagination.total }}
            </p>
            <div class="flex gap-1">
                <Link
                    v-for="link in pagination.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    :class="[
                        'px-3 py-1 text-xs rounded-lg border transition-colors',
                        link.active
                            ? 'bg-indigo-600 text-white border-indigo-600'
                            : 'border-gray-200 text-gray-600 hover:bg-gray-50',
                        !link.url ? 'opacity-40 pointer-events-none' : '',
                    ]"
                    preserve-scroll
                    v-html="link.label"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    columns:         { type: Array,  required: true },
    rows:            { type: Array,  default: () => [] },
    pagination:      { type: Object, default: null },
    searchable:      { type: Boolean, default: true },
    searchPlaceholder: { type: String, default: 'Search...' },
    emptyMessage:    { type: String, default: 'No records found.' },
})

defineEmits(['search'])

const searchQuery = ref('')
</script>