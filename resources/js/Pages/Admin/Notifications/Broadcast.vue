<template>
    <AdminLayout title="Broadcast Notification">
        <div class="max-w-3xl mx-auto space-y-5">

            <!-- Flash -->
            <div
                v-if="$page.props.flash?.success"
                class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium"
            >
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $page.props.flash.success }}
            </div>

            <!-- ── Step 1: Recipients ───────────────────────── -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800">1. Recipients</h2>

                <!-- Target selector -->
                <div class="grid grid-cols-3 gap-3">
                    <button
                        v-for="opt in targetOptions"
                        :key="opt.value"
                        type="button"
                        @click="form.target = opt.value; form.roles = []; form.user_ids = []; selectedUsers = []"
                        class="flex flex-col items-center gap-1 rounded-xl border-2 p-4 transition-colors text-sm font-medium"
                        :class="form.target === opt.value
                            ? 'border-indigo-500 bg-indigo-50 text-indigo-700'
                            : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                    >
                        <span class="text-lg">{{ opt.icon }}</span>
                        <span>{{ opt.label }}</span>
                        <span class="text-xs font-normal" :class="form.target === opt.value ? 'text-indigo-500' : 'text-gray-400'">
                            {{ opt.sub }}
                        </span>
                    </button>
                </div>

                <!-- Role checkboxes -->
                <div v-if="form.target === 'role'" class="space-y-2">
                    <p class="text-sm font-medium text-gray-600">Select roles:</p>
                    <div class="flex flex-wrap gap-3">
                        <label
                            v-for="role in roleOptions"
                            :key="role.value"
                            class="flex items-center gap-2 cursor-pointer rounded-lg border px-4 py-2 text-sm transition-colors"
                            :class="form.roles.includes(role.value)
                                ? 'border-indigo-400 bg-indigo-50 text-indigo-700'
                                : 'border-gray-200 text-gray-600'"
                        >
                            <input
                                type="checkbox"
                                :value="role.value"
                                v-model="form.roles"
                                class="rounded"
                                style="accent-color:#6366f1;"
                            />
                            {{ role.label }}
                            <span class="ml-1 text-xs px-1.5 py-0.5 rounded-full font-semibold"
                                  :class="form.roles.includes(role.value) ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500'">
                                {{ recipientCounts[role.value] }}
                            </span>
                        </label>
                    </div>
                    <p v-if="form.errors.roles" class="text-xs text-red-500">{{ form.errors.roles }}</p>
                </div>

                <!-- User search picker -->
                <div v-if="form.target === 'specific'" class="space-y-3">
                    <p class="text-sm font-medium text-gray-600">Search and add users:</p>

                    <!-- Search input -->
                    <div class="relative">
                        <input
                            v-model="userSearch"
                            @input="onUserSearch"
                            type="text"
                            placeholder="Search by name or email…"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 pl-9 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z" />
                        </svg>

                        <!-- Dropdown results -->
                        <div
                            v-if="searchResults.length"
                            class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden"
                        >
                            <button
                                v-for="u in searchResults"
                                :key="u.id"
                                type="button"
                                @click="addUser(u)"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 text-left"
                                :class="isSelected(u.id) ? 'opacity-40 cursor-default' : ''"
                            >
                                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0">
                                    {{ u.name.charAt(0) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 truncate">{{ u.name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ u.email }}</p>
                                </div>
                                <span v-if="isSelected(u.id)" class="ml-auto text-xs text-indigo-400">Added</span>
                            </button>
                        </div>
                    </div>

                    <!-- Selected users chips -->
                    <div v-if="selectedUsers.length" class="flex flex-wrap gap-2">
                        <div
                            v-for="u in selectedUsers"
                            :key="u.id"
                            class="flex items-center gap-1.5 bg-indigo-50 text-indigo-700 rounded-full pl-3 pr-1 py-1 text-sm"
                        >
                            <span class="font-medium">{{ u.name }}</span>
                            <button type="button" @click="removeUser(u.id)"
                                    class="w-5 h-5 rounded-full hover:bg-indigo-200 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p v-if="form.errors.user_ids" class="text-xs text-red-500">{{ form.errors.user_ids }}</p>
                </div>

                <!-- Recipient count summary -->
                <div class="flex items-center gap-2 text-sm text-gray-500 pt-1 border-t border-gray-100">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Sending to <strong class="text-gray-700 mx-1">{{ recipientSummary }}</strong>
                </div>
            </div>

            <!-- ── Step 2: Channels ─────────────────────────── -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800">2. Delivery Channels</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label
                        v-for="ch in channelOptions"
                        :key="ch.value"
                        class="flex items-start gap-3 rounded-xl border-2 p-4 cursor-pointer transition-colors"
                        :class="form.channels.includes(ch.value)
                            ? 'border-indigo-500 bg-indigo-50'
                            : 'border-gray-200 hover:border-gray-300'"
                    >
                        <input
                            type="checkbox"
                            :value="ch.value"
                            v-model="form.channels"
                            class="mt-0.5 rounded shrink-0"
                            style="accent-color:#6366f1;"
                        />
                        <div>
                            <p class="text-sm font-semibold" :class="form.channels.includes(ch.value) ? 'text-indigo-700' : 'text-gray-700'">
                                {{ ch.label }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ ch.description }}</p>
                        </div>
                    </label>
                </div>
                <p v-if="form.errors.channels" class="text-xs text-red-500">{{ form.errors.channels }}</p>
            </div>

            <!-- ── Step 3: Message ─────────────────────────── -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800">3. Message</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        maxlength="100"
                        placeholder="e.g. Platform Maintenance Notice"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        :class="{ 'border-red-400': form.errors.title }"
                    />
                    <div class="flex justify-between mt-1">
                        <p v-if="form.errors.title" class="text-xs text-red-500">{{ form.errors.title }}</p>
                        <p class="text-xs text-gray-400 ml-auto">{{ form.title.length }}/100</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Message body</label>
                    <textarea
                        v-model="form.body"
                        rows="5"
                        maxlength="1000"
                        placeholder="Write your message here…"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
                        :class="{ 'border-red-400': form.errors.body }"
                    />
                    <div class="flex justify-between mt-1">
                        <p v-if="form.errors.body" class="text-xs text-red-500">{{ form.errors.body }}</p>
                        <p class="text-xs text-gray-400 ml-auto">{{ form.body.length }}/1000</p>
                    </div>
                </div>
            </div>

            <!-- ── Preview + Send ──────────────────────────── -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800">Preview</h2>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-5 space-y-2">
                    <p class="font-semibold text-gray-800">{{ form.title || '(no title yet)' }}</p>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ form.body || '(no message yet)' }}</p>
                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200">
                        <span
                            v-for="ch in form.channels"
                            :key="ch"
                            class="text-xs px-2 py-0.5 rounded-full font-medium"
                            :class="{
                                'bg-blue-100 text-blue-700':   ch === 'database',
                                'bg-orange-100 text-orange-700': ch === 'mail',
                                'bg-purple-100 text-purple-700': ch === 'fcm',
                            }"
                        >
                            {{ { database: '🔔 In-App', mail: '✉️ Email', fcm: '📱 Push' }[ch] }}
                        </span>
                        <span class="text-xs text-gray-400">→ {{ recipientSummary }}</span>
                    </div>
                </div>

                <button
                    type="button"
                    :disabled="form.processing || !canSend"
                    @click="send"
                    class="w-full py-3 rounded-xl font-semibold text-white transition-colors"
                    :class="canSend && !form.processing
                        ? 'bg-indigo-600 hover:bg-indigo-700'
                        : 'bg-gray-300 cursor-not-allowed'"
                >
                    {{ form.processing ? 'Queuing…' : 'Send Notification' }}
                </button>
                <p v-if="!canSend" class="text-xs text-center text-gray-400">
                    Fill in all fields, select at least one channel and one recipient to send.
                </p>
            </div>

        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
    recipientCounts: { type: Object, required: true },
})

// ── Form ──────────────────────────────────────────────────────────────────────
const form = useForm({
    target:   'all',
    roles:    [],
    user_ids: [],
    channels: ['database'],
    title:    '',
    body:     '',
})

// ── Target options ────────────────────────────────────────────────────────────
const targetOptions = [
    { value: 'all',      icon: '🌍', label: 'All Users',       sub: `${props.recipientCounts.all} users` },
    { value: 'role',     icon: '🎭', label: 'By Role',          sub: 'Select roles below' },
    { value: 'specific', icon: '👤', label: 'Specific Users',   sub: 'Search & pick' },
]

const roleOptions = [
    { value: 'student', label: 'Students' },
    { value: 'tutor',   label: 'Tutors' },
    { value: 'admin',   label: 'Admins' },
]

// ── Channel options ───────────────────────────────────────────────────────────
const channelOptions = [
    { value: 'database', label: 'In-App',   description: 'Bell icon notification inside the app' },
    { value: 'mail',     label: 'Email',    description: 'Sent to the user\'s registered email' },
    { value: 'fcm',      label: 'Push',     description: 'Mobile push via Firebase Cloud Messaging' },
]

// ── User search ───────────────────────────────────────────────────────────────
const userSearch    = ref('')
const searchResults = ref([])
const selectedUsers = ref([])
let searchTimer     = null

const onUserSearch = () => {
    clearTimeout(searchTimer)
    if (! userSearch.value.trim()) { searchResults.value = []; return }
    searchTimer = setTimeout(async () => {
        const url = route('admin.notifications.broadcast.search-users') + '?q=' + encodeURIComponent(userSearch.value)
        const res = await fetch(url, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
        searchResults.value = await res.json()
    }, 250)
}

const isSelected = (id) => selectedUsers.value.some(u => u.id === id)

const addUser = (u) => {
    if (isSelected(u.id)) return
    selectedUsers.value.push(u)
    form.user_ids = selectedUsers.value.map(u => u.id)
    searchResults.value = []
    userSearch.value = ''
}

const removeUser = (id) => {
    selectedUsers.value = selectedUsers.value.filter(u => u.id !== id)
    form.user_ids = selectedUsers.value.map(u => u.id)
}

// ── Computed helpers ──────────────────────────────────────────────────────────
const recipientSummary = computed(() => {
    if (form.target === 'all') return `all ${props.recipientCounts.all} users`
    if (form.target === 'role') {
        if (! form.roles.length) return 'no roles selected'
        return form.roles.map(r => {
            const count = props.recipientCounts[r] ?? 0
            return `${count} ${r}s`
        }).join(', ')
    }
    const n = selectedUsers.value.length
    return n ? `${n} specific ${n === 1 ? 'user' : 'users'}` : 'no users selected'
})

const canSend = computed(() => {
    if (! form.title.trim() || ! form.body.trim()) return false
    if (! form.channels.length) return false
    if (form.target === 'role' && ! form.roles.length) return false
    if (form.target === 'specific' && ! selectedUsers.value.length) return false
    return true
})

// ── Send ──────────────────────────────────────────────────────────────────────
const send = () => {
    const label = recipientSummary.value
    if (! confirm(`Send "${form.title}" to ${label} via ${form.channels.join(', ')}?`)) return
    form.post(route('admin.notifications.broadcast.send'), {
        onSuccess: () => {
            form.reset()
            selectedUsers.value = []
            userSearch.value    = ''
        },
    })
}
</script>
