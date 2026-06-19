<template>
    <AdminLayout :title="tier ? `Edit ${tier.name}` : 'New Tier'">
        <div class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-5">

                <!-- Basic info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                    <h2 class="font-semibold text-gray-700">Basic Information</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Tier Name *</label>
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="e.g. Gold"
                                required
                                class="field"
                            />
                            <FieldError :message="form.errors.name" />
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Display Order *</label>
                            <input
                                v-model.number="form.display_order"
                                type="number"
                                min="0"
                                required
                                class="field"
                            />
                            <FieldError :message="form.errors.display_order" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">
                                Sessions Threshold *
                                <span class="text-gray-400 font-normal">(min sessions to qualify)</span>
                            </label>
                            <input
                                v-model.number="form.sessions_threshold"
                                type="number"
                                min="0"
                                required
                                class="field"
                            />
                            <FieldError :message="form.errors.sessions_threshold" />
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">
                                Commission Rate % *
                            </label>
                            <input
                                v-model.number="form.commission_rate"
                                type="number"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                                class="field"
                            />
                            <FieldError :message="form.errors.commission_rate" />
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">
                            Bonus Rate Above Threshold %
                            <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <input
                            v-model.number="form.bonus_rate_above_threshold"
                            type="number"
                            min="0"
                            max="100"
                            step="0.01"
                            class="field"
                        />
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Badge Icon URL</label>
                        <input
                            v-model="form.badge_icon_url"
                            type="url"
                            placeholder="https://..."
                            class="field"
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            id="is_active"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label for="is_active" class="text-gray-700">Active (visible to users)</label>
                    </div>
                </div>

                <!-- Theme -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                    <h2 class="font-semibold text-gray-700">Theme Colours</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Primary Colour *</label>
                            <div class="flex gap-2">
                                <input
                                    type="color"
                                    class="h-9 w-12 rounded border border-gray-200 cursor-pointer p-0.5"
                                    :value="'#' + form.theme_colour_primary"
                                    @input="form.theme_colour_primary = $event.target.value.replace('#', '')"
                                />
                                <input
                                    v-model="form.theme_colour_primary"
                                    type="text"
                                    placeholder="CD7F32"
                                    maxlength="6"
                                    class="field flex-1"
                                />
                            </div>
                            <FieldError :message="form.errors.theme_colour_primary" />
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Secondary Colour *</label>
                            <div class="flex gap-2">
                                <input
                                    type="color"
                                    class="h-9 w-12 rounded border border-gray-200 cursor-pointer p-0.5"
                                    :value="'#' + form.theme_colour_secondary"
                                    @input="form.theme_colour_secondary = $event.target.value.replace('#', '')"
                                />
                                <input
                                    v-model="form.theme_colour_secondary"
                                    type="text"
                                    placeholder="A0522D"
                                    maxlength="6"
                                    class="field flex-1"
                                />
                            </div>
                            <FieldError :message="form.errors.theme_colour_secondary" />
                        </div>
                    </div>

                    <!-- Preview -->
                    <div
                        class="rounded-xl border-2 p-4 flex items-center justify-between"
                        :style="{
                            borderColor: '#' + form.theme_colour_primary,
                            backgroundColor: '#' + form.theme_colour_primary + '18',
                        }"
                    >
                        <div>
                            <p class="font-bold text-gray-900">{{ form.name || 'Tier Name' }}</p>
                            <p class="text-xs text-gray-500">{{ form.sessions_threshold || 0 }}+ sessions</p>
                        </div>
                        <span
                            class="text-2xl font-black"
                            :style="{ color: '#' + form.theme_colour_primary }"
                        >
                            {{ form.commission_rate || 0 }}%
                        </span>
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-gray-700">Features</h2>
                        <button
                            type="button"
                            @click="addFeature"
                            class="text-xs text-indigo-600 hover:underline"
                        >
                            + Add feature
                        </button>
                    </div>

                    <div
                        v-for="(feature, i) in form.features"
                        :key="i"
                        class="flex gap-2"
                    >
                        <input
                            v-model="form.features[i]"
                            type="text"
                            placeholder="e.g. priority_support"
                            class="field flex-1"
                        />
                        <button
                            type="button"
                            @click="removeFeature(i)"
                            class="text-red-400 hover:text-red-600 px-2"
                        >
                            ✕
                        </button>
                    </div>

                    <p v-if="!form.features.length" class="text-gray-400">
                        No features added.
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-60"
                    >
                        {{ form.processing ? 'Saving…' : (tier ? 'Save Changes' : 'Create Tier') }}
                    </button>
                    <Link
                        :href="route('admin.tiers.index')"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FieldError from '@/Components/FieldError.vue'

const props = defineProps({
    tier: { type: Object, default: null },
})

const form = useForm({
    name:                       props.tier?.name                       ?? '',
    sessions_threshold:         props.tier?.sessions_threshold         ?? 0,
    commission_rate:            props.tier?.commission_rate            ?? 20,
    bonus_rate_above_threshold: props.tier?.bonus_rate_above_threshold ?? null,
    theme_colour_primary:       props.tier?.theme_colour_primary       ?? 'CD7F32',
    theme_colour_secondary:     props.tier?.theme_colour_secondary     ?? 'A0522D',
    badge_icon_url:             props.tier?.badge_icon_url             ?? '',
    features:                   props.tier?.features                   ?? [],
    is_active:                  props.tier?.is_active                  ?? true,
    display_order:              props.tier?.display_order              ?? 0,
})

const submit = () => {
    if (props.tier) {
        form.put(route('admin.tiers.update', props.tier.id))
    } else {
        form.post(route('admin.tiers.store'))
    }
}

const addFeature    = () => form.features.push('')
const removeFeature = (i) => form.features.splice(i, 1)
</script>

<style scoped>

@reference "tailwindcss";

.field {
    @apply w-full border border-gray-200 rounded-lg px-3 py-2
           focus:outline-none focus:ring-2 focus:ring-indigo-500;
}
</style>