<template>
    <AdminLayout :title="`${method.name} Configuration`">
        <div class="max-w-2xl space-y-5">

            <!-- Gateway status card -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-gray-900">{{ method.name }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5 capitalize">
                            {{ method.payment_flow }} flow · {{ method.code }}
                        </p>
                    </div>
                    <StatusBadge :status="method.is_active ? 'active' : 'declined'" />
                </div>
            </div>

            <!-- Config form -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Credentials</h3>

                <form @submit.prevent="save" class="space-y-4">
                    <!-- Environment toggle -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Environment</label>
                        <div class="flex rounded-lg border border-gray-200 overflow-hidden w-fit">
                            <button
                                type="button"
                                @click="environment = 'sandbox'"
                                class="px-4 py-2 font-medium transition-colors"
                                :class="environment === 'sandbox'
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-white text-gray-600 hover:bg-gray-50'"
                            >
                                Sandbox
                            </button>
                            <button
                                type="button"
                                @click="environment = 'production'"
                                class="px-4 py-2 font-medium transition-colors"
                                :class="environment === 'production'
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-white text-gray-600 hover:bg-gray-50'"
                            >
                                Production
                            </button>
                        </div>
                        <p class="text-xs text-orange-500 mt-1" v-if="environment === 'production'">
                            ⚠ You are editing production credentials.
                        </p>
                    </div>

                    <!-- Dynamic fields from schema -->
                    <template v-if="schema.length">
                        <div
                            v-for="field in schema"
                            :key="field.key"
                        >
                            <label class="block font-medium text-gray-700 mb-1">
                                {{ field.label }}
                                <span v-if="field.required" class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    v-model="configValues[field.key]"
                                    :type="field.type === 'password' ? (showFields[field.key] ? 'text' : 'password') : 'text'"
                                    :placeholder="isSet(field.key) ? '••••••• (leave blank to keep current)' : field.placeholder || ''"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                />
                                <button
                                    v-if="field.type === 'password'"
                                    type="button"
                                    @click="showFields[field.key] = !showFields[field.key]"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs"
                                >
                                    {{ showFields[field.key] ? 'Hide' : 'Show' }}
                                </button>
                            </div>
                            <p v-if="isSet(field.key)" class="text-xs text-green-600 mt-0.5">
                                ✓ Currently set
                            </p>
                            <p v-if="field.description" class="text-xs text-gray-400 mt-0.5">
                                {{ field.description }}
                            </p>
                        </div>
                    </template>

                    <div v-else class="text-gray-400 py-4 text-center">
                        No configuration fields defined for this gateway.
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button
                            type="submit"
                            :disabled="saving"
                            class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-60"
                        >
                            {{ saving ? 'Saving…' : 'Save Credentials' }}
                        </button>
                        <Link
                            :href="route('admin.gateways.index')"
                            class="text-gray-500 hover:text-gray-700 py-2"
                        >
                            ← Back
                        </Link>
                    </div>
                </form>
            </div>

            <!-- Current config status -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-3">Stored Keys</h3>
                <div class="space-y-2">
                    <div
                        v-for="c in configs"
                        :key="c.id"
                        class="flex items-center justify-between text-sm"
                    >
                        <span class="font-mono text-xs text-gray-600">{{ c.config_key }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400 capitalize">{{ c.environment }}</span>
                            <div
                                class="w-2 h-2 rounded-full"
                                :class="c.is_set ? 'bg-green-500' : 'bg-gray-300'"
                            />
                        </div>
                    </div>
                    <p v-if="!configs.length" class="text-xs text-gray-400">No keys stored yet.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    method:  { type: Object, required: true },
    configs: { type: Array,  default: () => [] },
    schema:  { type: Array,  default: () => [] },
})

const environment   = ref('sandbox')
const saving        = ref(false)
const configValues  = reactive({})
const showFields    = reactive({})

const isSet = (key) => {
    return props.configs.some(c =>
        c.config_key === key &&
        c.environment === environment.value &&
        c.is_set
    )
}

const save = () => {
    saving.value = true

    const configs = Object.entries(configValues)
        .filter(([, v]) => v && v.trim() !== '')
        .map(([key, value]) => ({ key, value }))

    router.post(
        route('admin.gateways.configure', props.method.id),
        { environment: environment.value, configs },
        {
            onFinish: () => {
                saving.value = false
                Object.keys(configValues).forEach(k => delete configValues[k])
            },
        }
    )
}
</script>