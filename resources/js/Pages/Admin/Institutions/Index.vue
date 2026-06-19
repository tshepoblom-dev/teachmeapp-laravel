<template>
    <AdminLayout title="Institutions">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold" style="color:#141F3E;">Institutions</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage universities, colleges and TVET institutions</p>
                </div>
                <button @click="openCreate" class="btn btn-primary">+ Add institution</button>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Name</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Type</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">City</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Subjects</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="inst in institutions" :key="inst.id" class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <p class="font-semibold text-gray-800">{{ inst.name }}</p>
                                <p v-if="inst.abbreviation" class="text-xs text-gray-400">{{ inst.abbreviation }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="typeClass(inst.type)">
                                    {{ inst.type_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ inst.city || '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ inst.subjects_count }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="inst.is_active
                                          ? 'bg-green-100 text-green-700'
                                          : 'bg-gray-100 text-gray-500'">
                                    {{ inst.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <button @click="openEdit(inst)"
                                        class="text-xs text-blue-600 hover:underline">Edit</button>
                                <button @click="confirmDelete(inst)"
                                        class="text-xs text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="!institutions.length">
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                                No institutions yet. Add one to get started.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create / Edit Modal -->
            <div v-if="modal.open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                    <h2 class="text-lg font-bold mb-5" style="color:#141F3E;">
                        {{ modal.mode === 'create' ? 'Add institution' : 'Edit institution' }}
                    </h2>

                    <form @submit.prevent="saveModal" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1">Name *</label>
                                <input v-model="form.name" type="text" required class="field" />
                                <p v-if="form.errors.name" class="text-xs text-red-600 mt-1">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Abbreviation</label>
                                <input v-model="form.abbreviation" type="text" maxlength="20" class="field"
                                       placeholder="e.g. UCT" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Type *</label>
                                <select v-model="form.type" required class="field">
                                    <option v-for="(label, val) in typeOptions" :key="val" :value="val">
                                        {{ label }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">City</label>
                                <input v-model="form.city" type="text" class="field" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Province</label>
                                <select v-model="form.province" class="field">
                                    <option value="">— select —</option>
                                    <option v-for="p in provinces" :key="p" :value="p">{{ p }}</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1">Website</label>
                                <input v-model="form.website" type="url" class="field"
                                       placeholder="https://institution.ac.za" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Sort order</label>
                                <input v-model.number="form.sort_order" type="number" min="0" class="field" />
                            </div>
                            <div class="flex items-center gap-2 mt-5">
                                <input id="is_active" v-model="form.is_active" type="checkbox"
                                       class="w-4 h-4 accent-green-700" />
                                <label for="is_active" class="text-sm font-medium">Active</label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-2 pt-4 border-t border-gray-100">
                            <button type="button" @click="modal.open = false"
                                    class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" :disabled="form.processing" class="btn btn-primary">
                                {{ modal.mode === 'create' ? 'Create' : 'Save changes' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete confirm -->
            <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
                    <p class="font-semibold text-gray-800 mb-2">Delete "{{ deleteTarget.name }}"?</p>
                    <p class="text-sm text-gray-500 mb-6">
                        This will also remove all subject associations. This cannot be undone.
                    </p>
                    <div class="flex gap-3 justify-center">
                        <button @click="deleteTarget = null"
                                class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="doDelete"
                                class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
    institutions: Array,
    typeOptions:  Object,
})

const provinces = [
    'Eastern Cape','Free State','Gauteng','KwaZulu-Natal',
    'Limpopo','Mpumalanga','Northern Cape','North West','Western Cape',
]

const modal       = reactive({ open: false, mode: 'create' })
const deleteTarget = ref(null)

const form = useForm({
    id: null, name: '', abbreviation: '', type: 'university',
    city: '', province: '', website: '', is_active: true, sort_order: 0,
})

function openCreate() {
    form.reset()
    form.type      = 'university'
    form.is_active = true
    form.sort_order = 0
    modal.mode = 'create'
    modal.open = true
}

function openEdit(inst) {
    form.id           = inst.id
    form.name         = inst.name
    form.abbreviation = inst.abbreviation ?? ''
    form.type         = inst.type
    form.city         = inst.city ?? ''
    form.province     = inst.province ?? ''
    form.website      = inst.website ?? ''
    form.is_active    = inst.is_active
    form.sort_order   = inst.sort_order
    modal.mode = 'edit'
    modal.open = true
}

function saveModal() {
    if (modal.mode === 'create') {
        form.post(route('admin.institutions.store'), {
            onSuccess: () => { modal.open = false }
        })
    } else {
        form.put(route('admin.institutions.update', form.id), {
            onSuccess: () => { modal.open = false }
        })
    }
}

function confirmDelete(inst) { deleteTarget.value = inst }

function doDelete() {
    router.delete(route('admin.institutions.destroy', deleteTarget.value.id), {
        onSuccess: () => { deleteTarget.value = null }
    })
}

const typeColors = {
    university:               'bg-blue-100 text-blue-700',
    university_of_technology: 'bg-purple-100 text-purple-700',
    private_college:          'bg-orange-100 text-orange-700',
    tvet_college:             'bg-teal-100 text-teal-700',
    high_school:              'bg-yellow-100 text-yellow-700',
    other:                    'bg-gray-100 text-gray-600',
}
const typeClass = (t) => typeColors[t] ?? typeColors.other
</script>