<template>
    <AdminLayout title="Subjects">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold" style="color:#141F3E;">Subjects & Modules</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage the catalogue tutors and students select from</p>
                </div>
                <button @click="openCreate" class="btn btn-primary">+ Add subject</button>
            </div>

            <!-- Institution filter -->
            <div class="flex gap-3 items-center">
                <select v-model="filterInstitution" @change="applyFilter"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2"
                        style="--tw-ring-color:#007B43;">
                    <option value="">All institutions</option>
                    <option v-for="i in institutions" :key="i.id" :value="i.id">
                        {{ i.abbreviation ? `${i.abbreviation} – ` : '' }}{{ i.name }}
                    </option>
                </select>
                <span class="text-sm text-gray-400">{{ subjects.length }} result{{ subjects.length !== 1 ? 's' : '' }}</span>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Subject</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Code</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Faculty</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Institution</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="s in subjects" :key="s.id" class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ s.name }}</td>
                            <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ s.code || '—' }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ s.faculty || '—' }}</td>
                            <td class="px-5 py-3 text-xs">
                                <span v-if="s.institution_id" class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full">
                                    {{ s.institution_name.split(' – ')[0] }}
                                </span>
                                <span v-else class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full">Universal</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="s.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                                    {{ s.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <button @click="openEdit(s)" class="text-xs text-blue-600 hover:underline">Edit</button>
                                <button @click="confirmDelete(s)" class="text-xs text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="!subjects.length">
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400">No subjects found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div v-if="modal.open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                    <h2 class="text-lg font-bold mb-5" style="color:#141F3E;">
                        {{ modal.mode === 'create' ? 'Add subject' : 'Edit subject' }}
                    </h2>
                    <form @submit.prevent="saveModal" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Subject name *</label>
                            <input v-model="form.name" type="text" required class="field" placeholder="e.g. Applied Mathematics" />
                            <p v-if="form.errors.name" class="text-xs text-red-600 mt-1">{{ form.errors.name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Module code</label>
                                <input v-model="form.code" type="text" maxlength="20" class="field" placeholder="MAT201" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Faculty / category</label>
                                <input v-model="form.faculty" type="text" class="field" placeholder="e.g. Engineering" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Institution</label>
                            <select v-model="form.institution_id" class="field">
                                <option :value="null">Universal (all institutions)</option>
                                <option v-for="i in institutions" :key="i.id" :value="i.id">
                                    {{ i.abbreviation ? `${i.abbreviation} – ` : '' }}{{ i.name }}
                                </option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">
                                "Universal" subjects appear for all institutions in the search filters.
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Sort order</label>
                                <input v-model.number="form.sort_order" type="number" min="0" class="field" />
                            </div>
                            <div class="flex items-center gap-2 mt-5">
                                <input id="sub_active" v-model="form.is_active" type="checkbox"
                                       class="w-4 h-4 accent-green-700" />
                                <label for="sub_active" class="text-sm font-medium">Active</label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
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
                    <p class="text-sm text-gray-500 mb-6">Any tutor/student links to this subject will be removed.</p>
                    <div class="flex gap-3 justify-center">
                        <button @click="deleteTarget = null"
                                class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button @click="doDelete"
                                class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
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
    subjects:     Array,
    institutions: Array,
    filters:      Object,
})

const filterInstitution = ref(props.filters?.institution_id ?? '')
const modal       = reactive({ open: false, mode: 'create' })
const deleteTarget = ref(null)

const form = useForm({
    id: null, name: '', code: '', faculty: '',
    institution_id: null, is_active: true, sort_order: 0,
})

function applyFilter() {
    router.get(route('admin.subjects.index'),
        filterInstitution.value ? { institution_id: filterInstitution.value } : {},
        { preserveState: true }
    )
}

function openCreate() {
    form.reset()
    form.is_active  = true
    form.sort_order = 0
    form.institution_id = null
    modal.mode = 'create'
    modal.open = true
}

function openEdit(s) {
    form.id             = s.id
    form.name           = s.name
    form.code           = s.code ?? ''
    form.faculty        = s.faculty ?? ''
    form.institution_id = s.institution_id
    form.is_active      = s.is_active
    form.sort_order     = s.sort_order
    modal.mode = 'edit'
    modal.open = true
}

function saveModal() {
    if (modal.mode === 'create') {
        form.post(route('admin.subjects.store'), { onSuccess: () => { modal.open = false } })
    } else {
        form.put(route('admin.subjects.update', form.id), { onSuccess: () => { modal.open = false } })
    }
}

function confirmDelete(s) { deleteTarget.value = s }
function doDelete() {
    router.delete(route('admin.subjects.destroy', deleteTarget.value.id), {
        onSuccess: () => { deleteTarget.value = null }
    })
}
</script>