<template>
    <AdminLayout :title="`KYC #${application.id}`">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left: Application info + actions -->
            <div class="space-y-4">
                <!-- Info card -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="font-semibold text-gray-700 mb-3">Application Info</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Applicant</dt>
                            <dd class="font-medium">{{ application.user?.name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="text-gray-600 text-xs">{{ application.user?.email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Type</dt>
                            <dd class="capitalize">{{ application.application_type?.replace('_', ' ') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Status</dt>
                            <dd><StatusBadge :status="application.status" /></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Submitted</dt>
                            <dd>{{ application.submitted_at }}</dd>
                        </div>
                        <div class="flex justify-between" v-if="application.resubmission_count > 0">
                            <dt class="text-gray-500">Resubmissions</dt>
                            <dd class="text-orange-600">{{ application.resubmission_count }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Rejection reason (if rejected) -->
                <div
                    v-if="application.rejection_reason"
                    class="bg-red-50 border border-red-200 rounded-xl p-4"
                >
                    <p class="text-xs font-semibold text-red-700 mb-1">Previous Rejection Reason</p>
                    <p class="text-red-600">{{ application.rejection_reason }}</p>
                </div>

                <!-- Actions -->
                <div
                    v-if="['pending', 'under_review', 'resubmitted'].includes(application.status)"
                    class="bg-white rounded-xl border border-gray-200 p-5 space-y-3"
                >
                    <h2 class="font-semibold text-gray-700">Actions</h2>

                    <!-- Approve -->
                    <form @submit.prevent="approve">
                        <textarea
                            v-model="approveForm.notes"
                            placeholder="Internal notes (optional)"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            rows="2"
                        />
                        <button
                            type="submit"
                            class="w-full py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                        >
                            ✓ Approve Application
                        </button>
                    </form>

                    <!-- Reject -->
                    <form @submit.prevent="reject" class="pt-2 border-t border-gray-100">
                        <textarea
                            v-model="rejectForm.reason"
                            placeholder="Rejection reason (shown to applicant) *"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                            rows="3"
                            required
                        />
                        <textarea
                            v-model="rejectForm.notes"
                            placeholder="Internal notes (optional)"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            rows="2"
                        />
                        <button
                            type="submit"
                            class="w-full py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors"
                        >
                            ✕ Reject Application
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Documents -->
            <div class="lg:col-span-2 space-y-4">
                <h2 class="font-semibold text-gray-700">Documents ({{ application.documents?.length }})</h2>

                <div
                    v-for="doc in application.documents"
                    :key="doc.id"
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden"
                >
                    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800 capitalize">
                                {{ doc.document_type.replace(/_/g, ' ') }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ doc.mime_type }} · {{ doc.file_size_kb }} KB · {{ doc.uploaded_at }}
                            </p>
                        </div>
                        <StatusBadge :status="doc.status" />
                    </div>

                    <!-- Document viewer -->
                    <div class="p-4 bg-gray-50 min-h-[300px] flex items-center justify-center">
                        <template v-if="doc.signed_url">
                            <img
                                v-if="doc.mime_type?.startsWith('image/')"
                                :src="doc.signed_url"
                                class="max-h-96 max-w-full rounded-lg shadow"
                                :alt="doc.document_type"
                            />
                            <iframe
                                v-else-if="doc.mime_type === 'application/pdf'"
                                :src="doc.signed_url"
                                class="w-full h-96 rounded"
                            />
                            <a
                                v-else
                                :href="doc.signed_url"
                                target="_blank"
                                class="text-indigo-600 hover:underline text-sm"
                            >
                                Open document
                            </a>
                        </template>
                        <p v-else class="text-gray-400">Document not available.</p>
                    </div>
                </div>

                <div v-if="!application.documents?.length" class="text-gray-400 text-center py-10">
                    No documents uploaded yet.
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    application: { type: Object, required: true },
})

const approveForm = reactive({ notes: '' })
const rejectForm  = reactive({ reason: '', notes: '' })

const approve = () => {
    router.post(route('admin.kyc.approve', props.application.id), approveForm)
}

const reject = () => {
    if (!rejectForm.reason) return
    router.post(route('admin.kyc.reject', props.application.id), rejectForm)
}
</script>