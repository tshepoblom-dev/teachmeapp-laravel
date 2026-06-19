<template>
    <AdminLayout title="Platform Settings">
        <div class="space-y-6">
            <div
                v-for="(groupSettings, group) in settings"
                :key="group"
                class="bg-white rounded-xl border border-gray-200 overflow-hidden"
            >
                <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700 capitalize">{{ group }}</h2>
                </div>

                <div class="divide-y divide-gray-50">
                    <div
                        v-for="setting in groupSettings"
                        :key="setting.key"
                        class="flex items-center justify-between px-5 py-3.5"
                    >
                        <div class="flex-1 min-w-0 pr-6">
                            <p class="font-medium text-gray-800">{{ setting.label }}</p>
                            <p v-if="setting.description" class="text-xs text-gray-400 mt-0.5">
                                {{ setting.description }}
                            </p>
                            <p class="text-xs text-gray-300 mt-0.5">
                                {{ group }}.{{ setting.key }}
                                <span v-if="setting.is_encrypted" class="text-yellow-500 ml-1">🔒 encrypted</span>
                            </p>
                        </div>

                        <!-- Editable field -->
                        <div class="flex items-center gap-2 shrink-0">
                            <template v-if="editing === `${group}.${setting.key}`">
                                <input
                                    v-model="editValue"
                                    type="text"
                                    class="border border-indigo-300 rounded-lg px-3 py-1.5 w-48 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    @keydown.enter="save(group, setting.key)"
                                    @keydown.escape="cancel"
                                />
                                <button
                                    @click="save(group, setting.key)"
                                    class="text-xs text-green-600 font-medium hover:underline"
                                >Save</button>
                                <button
                                    @click="cancel"
                                    class="text-xs text-gray-400 hover:underline"
                                >Cancel</button>
                            </template>
                            <template v-else>
                                <span class="text-gray-600 font-mono">
                                    {{ setting.value }}
                                </span>
                                <button
                                    @click="startEdit(group, setting)"
                                    class="text-xs text-indigo-600 hover:underline"
                                >Edit</button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    settings: { type: Object, default: () => ({}) },
})

const editing   = ref(null)
const editValue = ref('')

const startEdit = (group, setting) => {
    editing.value   = `${group}.${setting.key}`
    editValue.value = setting.value
}

const save = (group, key) => {
    router.post(route('admin.settings.update'), {
        group,
        key,
        value: editValue.value,
    }, {
        preserveState: true,
        onSuccess: () => cancel(),
    })
}

const cancel = () => {
    editing.value   = null
    editValue.value = ''
}
</script>