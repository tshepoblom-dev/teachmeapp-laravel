<template>
    <TutorLayout title="KYC Verification">
        <div class="max-w-xl space-y-5">
            <!-- Status banner -->
            <div :class="bannerClass" class="rounded-2xl p-5 border">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">{{ bannerIcon }}</span>
                    <div>
                        <p class="font-semibold text-gray-800 capitalize">{{ statusLabel }}</p>
                        <p class="text-gray-600 mt-0.5">{{ statusDescription }}</p>
                        <p v-if="application?.rejection_reason" class="mt-2 text-red-700 bg-red-50 rounded-lg px-3 py-2">
                            <strong>Rejection reason:</strong> {{ application.rejection_reason }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Start application -->
            <div v-if="kyc_status === 'not_submitted'" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-2">Start Verification</h2>
                <p class="text-gray-500 mb-4">
                    Identity verification is required before you can accept bookings. You'll need to upload:
                </p>
                <ul class="text-gray-600 space-y-1 mb-5 list-disc list-inside">
                    <li>A valid national ID or passport</li>
                    <li>A live selfie holding your ID</li>
                    <li>Proof of qualifications (optional but recommended)</li>
                </ul>
                <button @click="startApplication" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                    Start KYC Application
                </button>
            </div>

            <!-- Upload documents -->
            <div v-if="canUpload" class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Upload Documents</h2>
                <form @submit.prevent="uploadDoc" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Type</label>
                        <select v-model="uploadForm.document_type"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option v-for="t in document_types" :key="t" :value="t">
                                {{ t.replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase()) }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">File (PDF, JPG, PNG — max 10MB)</label>
                        <input @change="uploadForm.file = $event.target.files[0]" type="file"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>
                    <FieldError :message="uploadForm.errors.file" />
                    <button type="submit" :disabled="uploadForm.processing || !uploadForm.file"
                        class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 disabled:opacity-50">
                        {{ uploadForm.processing ? 'Uploading…' : 'Upload Document' }}
                    </button>
                </form>

                <!-- Uploaded documents -->
                <div v-if="application?.documents?.length" class="mt-5 space-y-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Uploaded</h3>
                    <div v-for="d in application.documents" :key="d.id"
                        class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-700 capitalize">{{ d.document_type.replace(/_/g,' ') }}</p>
                            <p class="text-xs text-gray-400">{{ d.mime_type }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span :class="{
                                'text-green-600': d.status === 'verified',
                                'text-amber-600': d.status === 'uploaded',
                                'text-red-600':   d.status === 'rejected',
                            }" class="text-xs font-medium capitalize">{{ d.status }}</span>
                            <button v-if="d.status === 'uploaded'" @click="deleteDoc(d.id)"
                                class="text-red-400 hover:text-red-600 text-xs">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TutorLayout>
</template>

<script setup>
import { computed }       from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import TutorLayout        from '@/Layouts/TutorLayout.vue'
import FieldError         from '@/Components/FieldError.vue'

const props = defineProps({ kyc_status: String, application: Object, document_types: Array })

const canUpload = computed(() => ['pending','resubmitted'].includes(props.application?.status))

const statusLabel = computed(() => ({
    not_submitted: 'Not Submitted',
    pending:       'Pending Review',
    approved:      'Verified ✓',
    rejected:      'Rejected — Resubmission Required',
}[props.kyc_status] ?? props.kyc_status))

const statusDescription = computed(() => ({
    not_submitted: 'Start your KYC application to unlock bookings.',
    pending:       'Your documents are under review. This usually takes 1–2 business days.',
    approved:      'Your identity has been verified. You can accept bookings.',
    rejected:      'Your application was rejected. Please review the reason and resubmit.',
}[props.kyc_status] ?? ''))

const bannerClass = computed(() => ({
    not_submitted: 'bg-gray-50 border-gray-200',
    pending:       'bg-blue-50 border-blue-200',
    approved:      'bg-green-50 border-green-200',
    rejected:      'bg-red-50 border-red-200',
}[props.kyc_status] ?? 'bg-gray-50 border-gray-200'))

const bannerIcon = computed(() => ({
    not_submitted: '📋', pending: '⏳', approved: '✅', rejected: '❌',
}[props.kyc_status] ?? '📋'))

const uploadForm = useForm({ document_type: 'national_id', file: null })
const uploadDoc  = () => uploadForm.post(route('tutor.kyc.upload'), {
    onSuccess: () => uploadForm.reset('file'),
    forceFormData: true,
})

const startApplication = () => router.post(route('tutor.kyc.apply'))
const deleteDoc = (id) => router.delete(route('tutor.kyc.document.destroy', id))
</script>