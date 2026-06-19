<template>
    <!--
        Student live-session page.
        Layout: full-viewport video with overlaid controls (Teams / Zoom style).
    -->
    <StudentLayout title="Live Session" :no-padding="true">

        <!-- ── Full-screen session container ──────────────────────────────── -->
        <div class="relative w-full bg-black overflow-hidden"
             style="height: calc(100vh - 64px); min-height: 480px;">

            <!-- ── Remote video (fills container) ─────────────────────────── -->
            <div id="agora-remote" class="absolute inset-0 w-full h-full" />

            <!-- ── Local video PiP ────────────────────────────────────────── -->
            <div id="agora-local"
                 class="absolute bottom-24 right-4 w-44 h-32 bg-gray-800 rounded-xl
                        overflow-hidden z-20 shadow-2xl border border-white/10
                        transition-opacity hover:opacity-90" />

            <!-- ── Idle / connecting states ───────────────────────────────── -->
            <div v-if="liveStatus !== 'ended' && (!agoraJoined || !remoteJoined)"
                 class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3">
                <div v-if="agoraError" class="text-red-400 text-sm px-6 text-center max-w-sm">
                    ⚠ {{ agoraError }}
                </div>
                <template v-else>
                    <svg class="animate-spin w-8 h-8 text-white/40" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <p class="text-white/60 text-sm">
                        <template v-if="!agoraJoined">Connecting…</template>
                        <template v-else-if="liveStatus === 'active'">Connected. Waiting for your tutor to start…</template>
                        <template v-else>Waiting for your tutor to join…</template>
                    </p>
                </template>
            </div>

            <!-- ── Session ended overlay ──────────────────────────────────── -->
            <div v-if="liveStatus === 'ended' && !ratingSubmitted"
                 class="absolute inset-0 z-30 flex flex-col items-center justify-center
                        bg-gray-900/95 backdrop-blur-sm gap-3">
                <span class="text-5xl">🎓</span>
                <p class="text-white font-bold text-xl">Session Complete</p>
                <p class="text-gray-300 text-sm text-center px-8">
                    How was your session with {{ session.booking.tutor_name }}?
                </p>
                <button @click="showRatingModal = true"
                        class="mt-2 px-7 py-2.5 bg-green-600 text-white font-semibold
                               rounded-xl hover:bg-green-700 transition-colors shadow-lg">
                    Rate This Session
                </button>
                <button @click="goToBooking"
                        class="text-gray-400 hover:text-white text-sm transition-colors">
                    Skip for now
                </button>
            </div>
            <div v-else-if="liveStatus === 'ended' && ratingSubmitted"
                 class="absolute inset-0 z-30 flex flex-col items-center justify-center
                        bg-gray-900/95 backdrop-blur-sm gap-3">
                <span class="text-5xl">✅</span>
                <p class="text-white font-semibold text-lg">Thank you for your rating!</p>
                <button @click="goToBooking"
                        class="mt-3 px-6 py-2 bg-white text-gray-800 rounded-xl font-medium hover:bg-gray-100">
                    Back to Bookings
                </button>
            </div>

            <!-- ═══════════════════════════════════════════════════════════════
                 TOP BAR OVERLAY — session info + status
            ════════════════════════════════════════════════════════════════ -->
            <div class="absolute top-0 inset-x-0 z-20 flex items-center justify-between
                        px-5 py-3 bg-gradient-to-b from-black/70 to-transparent">
                <div>
                    <p class="font-semibold text-white text-sm">{{ session.booking.subject }}</p>
                    <p class="text-xs text-white/60">
                        with {{ session.booking.tutor_name }} · {{ session.booking.duration }}min
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span v-if="liveStatus === 'in_progress'"
                          class="flex items-center gap-1.5 text-green-400 text-xs font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse" />
                        In Progress
                    </span>
                    <span v-else-if="liveStatus === 'active'"
                          class="flex items-center gap-1.5 text-blue-400 text-xs font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse" />
                        Connected
                    </span>
                    <span v-else-if="liveStatus === 'ended'"
                          class="px-2 py-0.5 rounded-full bg-white/10 text-white/60 text-xs">
                        Ended
                    </span>
                    <span v-else class="px-2 py-0.5 rounded-full bg-yellow-500/20 text-yellow-300 text-xs">
                        Waiting…
                    </span>
                    <span v-if="elapsed && liveStatus === 'in_progress'"
                          class="font-mono text-sm text-white tabular-nums">
                        {{ elapsed }}
                    </span>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════════
                 BOTTOM BAR OVERLAY — controls + chat toggle
            ════════════════════════════════════════════════════════════════ -->
            <div v-if="liveStatus !== 'ended'"
                 class="absolute bottom-0 inset-x-0 z-20 flex items-center justify-between
                        px-5 py-4 bg-gradient-to-t from-black/80 to-transparent">

                <!-- Left: mic + camera -->
                <div class="flex items-center gap-2">
                    <button @click="toggleMute"
                            :class="muted ? 'bg-red-600 hover:bg-red-700' : 'bg-white/15 hover:bg-white/25'"
                            class="flex flex-col items-center gap-0.5 px-4 py-2 rounded-xl text-white
                                   text-xs font-medium transition-colors w-16">
                        <span class="text-lg">{{ muted ? '🔇' : '🎤' }}</span>
                        {{ muted ? 'Unmute' : 'Mute' }}
                    </button>
                    <button @click="toggleCamera"
                            :class="cameraOff ? 'bg-red-600 hover:bg-red-700' : 'bg-white/15 hover:bg-white/25'"
                            class="flex flex-col items-center gap-0.5 px-4 py-2 rounded-xl text-white
                                   text-xs font-medium transition-colors w-16">
                        <span class="text-lg">{{ cameraOff ? '📵' : '📹' }}</span>
                        {{ cameraOff ? 'Cam On' : 'Cam Off' }}
                    </button>
                </div>

                <!-- Centre: leave -->
                <div class="flex items-center gap-2">
                    <button v-if="liveStatus === 'active' || liveStatus === 'in_progress'"
                            @click="showLeaveConfirm = true"
                            class="flex flex-col items-center gap-0.5 px-4 py-2 bg-red-600 hover:bg-red-700
                                   rounded-xl text-white text-xs font-medium transition-colors w-16">
                        <span class="text-lg">📵</span>
                        Leave
                    </button>
                </div>

                <!-- Right: chat toggle + report -->
                <div class="flex items-center gap-2">
                    <!-- Report button -->
                    <button v-if="liveStatus === 'active' || liveStatus === 'in_progress'"
                            @click="showReportModal = true"
                            class="flex flex-col items-center gap-0.5 px-4 py-2 bg-white/15 hover:bg-red-600/80
                                   rounded-xl text-white text-xs font-medium transition-colors w-16">
                        <span class="text-lg">🚩</span>
                        Report
                    </button>
                    <!-- Chat toggle -->
                    <button @click="chatOpen = !chatOpen"
                            :class="chatOpen ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-white/15 hover:bg-white/25'"
                            class="flex flex-col items-center gap-0.5 px-4 py-2 rounded-xl text-white
                                   text-xs font-medium transition-colors w-16 relative">
                        <span class="text-lg">💬</span>
                        Chat
                        <span v-if="unreadCount > 0 && !chatOpen"
                              class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full
                                     text-[10px] font-bold flex items-center justify-center">
                            {{ unreadCount > 9 ? '9+' : unreadCount }}
                        </span>
                    </button>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════════
                 CHAT SIDE PANEL — overlaid on right side
            ════════════════════════════════════════════════════════════════ -->
            <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-x-4"
                enter-to-class="opacity-100 translate-x-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-x-0"
                leave-to-class="opacity-0 translate-x-4"
            >
                <div v-if="chatOpen"
                     class="absolute top-0 right-0 bottom-0 z-20 w-72 sm:w-80
                            flex flex-col bg-gray-900/90 backdrop-blur-md
                            border-l border-white/10">

                    <!-- Chat header -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-white/10">
                        <p class="text-sm font-semibold text-white">Session Chat</p>
                        <button @click="chatOpen = false" class="text-white/50 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Messages -->
                    <div ref="chatContainer"
                         class="flex-1 overflow-y-auto px-3 py-3 space-y-2 scroll-smooth">
                        <div v-if="chatMessages.length === 0"
                             class="text-center text-white/30 text-xs mt-8">
                            No messages yet
                        </div>
                        <div v-for="msg in chatMessages" :key="msg.id"
                             :class="msg.is_system_message
                                 ? 'text-center'
                                 : msg.sender_id === currentUserId ? 'flex justify-end' : 'flex justify-start'">
                            <!-- System message -->
                            <div v-if="msg.is_system_message"
                                 class="text-[11px] text-white/40 italic px-2">
                                {{ msg.message }}
                            </div>
                            <!-- User bubble -->
                            <div v-else
                                 :class="msg.sender_id === currentUserId
                                     ? 'bg-indigo-600 text-white rounded-2xl rounded-tr-sm'
                                     : 'bg-white/15 text-white rounded-2xl rounded-tl-sm'"
                                 class="max-w-[85%] px-3 py-2 text-sm">
                                <p class="text-[10px] font-semibold opacity-60 mb-0.5">
                                    {{ msg.sender_id === currentUserId ? 'You' : session.booking.tutor_name }}
                                </p>
                                {{ msg.message }}
                            </div>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="px-3 py-3 border-t border-white/10 flex gap-2">
                        <input v-model="chatInput"
                               @keyup.enter="sendChatMessage"
                               placeholder="Type a message…"
                               maxlength="500"
                               class="flex-1 bg-white/10 text-white placeholder-white/30 text-sm
                                      rounded-xl px-3 py-2 outline-none border border-white/10
                                      focus:border-indigo-400 transition-colors" />
                        <button @click="sendChatMessage"
                                :disabled="!chatInput.trim()"
                                class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-40
                                       text-white rounded-xl text-sm transition-colors">
                            ↑
                        </button>
                    </div>
                </div>
            </Transition>
        </div>

        <!-- ═══════════════════════════════════════════════════════════════════
             MODALS (teleported to body)
        ════════════════════════════════════════════════════════════════════ -->

        <!-- Leave confirm -->
        <Teleport to="body">
            <div v-if="showLeaveConfirm"
                 class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Leave Session?</h3>
                    <p class="text-sm text-gray-500 mb-5">
                        Leaving will end the session for both you and your tutor. The escrow will be released.
                    </p>
                    <div class="flex gap-3">
                        <button @click="showLeaveConfirm = false"
                                class="flex-1 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                            Stay
                        </button>
                        <button @click="leaveSession" :disabled="leaving"
                                class="flex-1 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg
                                       hover:bg-red-700 disabled:opacity-50 transition-colors">
                            {{ leaving ? 'Leaving…' : 'Leave' }}
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- ── Report modal ───────────────────────────────────────────────── -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="showReportModal"
                     class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl">

                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Report an Issue</h3>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    Report {{ session.booking.tutor_name }} to our moderation team.
                                </p>
                            </div>
                            <button @click="showReportModal = false"
                                    class="text-gray-400 hover:text-gray-600 transition-colors ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Reason -->
                        <label class="block mb-1 text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Reason *
                        </label>
                        <select v-model="reportForm.reason"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm mb-4
                                       focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                            <option value="" disabled>Select a reason…</option>
                            <option>Inappropriate behaviour</option>
                            <option>Harassment or bullying</option>
                            <option>Offensive language</option>
                            <option>No-show / late without notice</option>
                            <option>Requesting off-platform payment</option>
                            <option>Content violates platform rules</option>
                            <option>Technical issue caused by tutor</option>
                            <option>Other</option>
                        </select>

                        <!-- Description -->
                        <label class="block mb-1 text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            Additional details (optional)
                        </label>
                        <textarea v-model="reportForm.description"
                                  placeholder="Describe what happened…"
                                  rows="3"
                                  maxlength="2000"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm mb-4
                                         focus:outline-none focus:ring-2 focus:ring-red-400 resize-none" />

                        <!-- Action choice -->
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            After submitting this report…
                        </p>
                        <div class="flex flex-col gap-2 mb-5">
                            <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition-colors"
                                   :class="reportForm.action_taken === 'continue_session'
                                       ? 'border-green-400 bg-green-50'
                                       : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio" v-model="reportForm.action_taken"
                                       value="continue_session" class="mt-0.5 accent-green-600" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Continue the session</p>
                                    <p class="text-xs text-gray-400">Report is logged; session stays active.</p>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition-colors"
                                   :class="reportForm.action_taken === 'end_session'
                                       ? 'border-red-400 bg-red-50'
                                       : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio" v-model="reportForm.action_taken"
                                       value="end_session" class="mt-0.5 accent-red-600" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">End the session now</p>
                                    <p class="text-xs text-gray-400">Session ends immediately and escrow is released.</p>
                                </div>
                            </label>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button @click="showReportModal = false"
                                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm
                                           hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button @click="submitReport"
                                    :disabled="!reportForm.reason || !reportForm.action_taken || submittingReport"
                                    class="flex-1 py-2.5 bg-red-600 text-white text-sm font-semibold
                                           rounded-xl hover:bg-red-700 disabled:opacity-40
                                           disabled:cursor-not-allowed transition-colors">
                                {{ submittingReport ? 'Submitting…' : 'Submit Report' }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Rating modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="showRatingModal"
                     class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                    <div class="bg-white rounded-3xl p-7 max-w-md w-full shadow-2xl">
                        <div class="text-center mb-6">
                            <p class="text-2xl mb-2">⭐</p>
                            <h3 class="text-xl font-bold text-gray-800">Rate your session</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                How was your experience with {{ session.booking.tutor_name }}?
                            </p>
                        </div>
                        <div class="flex justify-center gap-2 mb-5">
                            <button v-for="star in 5" :key="star"
                                    @click="rating = star"
                                    @mouseenter="hoverRating = star"
                                    @mouseleave="hoverRating = 0"
                                    class="text-4xl transition-transform hover:scale-110 focus:outline-none"
                                    :class="star <= (hoverRating || rating) ? 'text-yellow-400' : 'text-gray-200'">
                                ★
                            </button>
                        </div>
                        <p class="text-center text-sm font-medium mb-5"
                           :class="rating ? 'text-gray-700' : 'text-gray-400'">
                            {{ ratingLabel }}
                        </p>
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                                What stood out? (optional)
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <button v-for="tag in AVAILABLE_TAGS" :key="tag"
                                        @click="toggleTag(tag)"
                                        class="px-3 py-1 rounded-full text-xs font-medium border transition-colors"
                                        :class="selectedTags.includes(tag)
                                            ? 'bg-green-600 text-white border-green-600'
                                            : 'bg-white text-gray-600 border-gray-200 hover:border-green-400'">
                                    {{ tag }}
                                </button>
                            </div>
                        </div>
                        <textarea v-model="reviewComment"
                                  placeholder="Leave a comment… (optional)"
                                  rows="3"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm mb-5
                                         focus:outline-none focus:ring-2 focus:ring-green-400 resize-none" />
                        <div class="flex gap-3">
                            <button @click="skipRating"
                                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm
                                           hover:bg-gray-50 transition-colors">
                                Skip
                            </button>
                            <button @click="submitRating"
                                    :disabled="!rating || submittingRating"
                                    class="flex-1 py-2.5 bg-green-600 text-white text-sm font-semibold
                                           rounded-xl hover:bg-green-700 disabled:opacity-40
                                           disabled:cursor-not-allowed transition-colors">
                                {{ submittingRating ? 'Submitting…' : 'Submit Rating' }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </StudentLayout>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'
import AgoraRTC     from 'agora-rtc-sdk-ng'
import { useEcho }  from '@/composables/useEcho'
import { useToast } from '@/composables/useToast'

// ─── Props ────────────────────────────────────────────────────────────────────
const props = defineProps({
    session:        Object,
    agora_app_id:   String,
    current_user_id: Number,
})

// ─── Services ─────────────────────────────────────────────────────────────────
const toast = useToast()
const { listenToSession, leaveSession: leaveEchoChannel } = useEcho()

// ─── Session state ────────────────────────────────────────────────────────────
const liveStatus   = ref(props.session.status)
const elapsed      = ref('')
const agoraJoined  = ref(false)
const remoteJoined = ref(false)
const agoraError   = ref('')
const muted        = ref(false)
const cameraOff    = ref(false)
const currentUserId = props.current_user_id ?? props.session?.booking?.student_id

// ─── Modals ───────────────────────────────────────────────────────────────────
const showLeaveConfirm = ref(false)
const leaving          = ref(false)
const showRatingModal  = ref(false)
const showReportModal  = ref(false)

// ─── Chat ─────────────────────────────────────────────────────────────────────
const chatOpen      = ref(false)
const chatInput     = ref('')
const chatMessages  = ref([])
const chatContainer = ref(null)
const unreadCount   = ref(0)

async function sendChatMessage() {
    const msg = chatInput.value.trim()
    if (!msg) return
    chatInput.value = ''

    // Optimistically add message
    chatMessages.value.push({
        id: Date.now(),
        sender_id: currentUserId,
        message: msg,
        is_system_message: false,
    })
    await scrollChat()

    router.post(route('sessions.chat.send', props.session.id), { message: msg }, {
        preserveState: true,
        onError: () => toast.error('Message failed to send.'),
    })
}

async function scrollChat() {
    await nextTick()
    if (chatContainer.value) {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight
    }
}

// ─── Report ───────────────────────────────────────────────────────────────────
const reportForm = ref({ reason: '', description: '', action_taken: 'continue_session' })
const submittingReport = ref(false)

function submitReport() {
    if (!reportForm.value.reason || !reportForm.value.action_taken) return
    submittingReport.value = true

    router.post(
        route('sessions.report', props.session.id),
        reportForm.value,
        {
            onSuccess: () => {
                showReportModal.value = false
                toast.success('Report submitted. Our team will review it shortly.')
                if (reportForm.value.action_taken === 'end_session') {
                    liveStatus.value = 'ended'
                    stopTimer()
                    leaveAgoraChannel()
                }
                reportForm.value = { reason: '', description: '', action_taken: 'continue_session' }
            },
            onError: (errs) => {
                const first = Object.values(errs)[0]
                toast.error(first ?? 'Could not submit report.')
            },
            onFinish: () => { submittingReport.value = false },
        }
    )
}

// ─── Rating ───────────────────────────────────────────────────────────────────
const rating           = ref(0)
const hoverRating      = ref(0)
const reviewComment    = ref('')
const selectedTags     = ref([])
const submittingRating = ref(false)
const ratingSubmitted  = ref(false)

const AVAILABLE_TAGS = [
    'Clear explanations', 'Patient', 'Knowledgeable', 'Engaging',
    'Well-prepared', 'Punctual', 'Encouraging', 'Interactive',
]
const RATING_LABELS = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent']
const ratingLabel   = computed(() =>
    hoverRating.value
        ? RATING_LABELS[hoverRating.value]
        : (rating.value ? RATING_LABELS[rating.value] : 'Tap a star to rate')
)

function toggleTag(tag) {
    const idx = selectedTags.value.indexOf(tag)
    if (idx === -1) { if (selectedTags.value.length < 5) selectedTags.value.push(tag) }
    else { selectedTags.value.splice(idx, 1) }
}

// ─── Agora ────────────────────────────────────────────────────────────────────
let client      = null
let micTrack    = null
let cameraTrack = null
let timerHandle = null
let echoCleanup = null

const lowAudioWarning = ref(false) 

// Agora exception code map — only codes we care about surfacing or suppressing
const AGORA_EXCEPTIONS = {
    2002: { level: 'warn',  action: 'low_audio'   },  // AUDIO_OUTPUT_LEVEL_TOO_LOW
    4002: { level: 'info',  action: 'low_recover'  },  // AUDIO_OUTPUT_LEVEL_TOO_LOW_RECOVER
    // Add further codes here as needed; anything unmapped is logged at 'warn'
}

function handleAgoraException({ code, msg, uid }) {
    const entry = AGORA_EXCEPTIONS[code]

    if (!entry) {
        // Unknown exception — log it but don't surface to the user
        console.warn(`[Agora] exception code ${code} (uid ${uid}): ${msg}`)
        return
    }

    switch (entry.action) {
        case 'low_audio':
            // Remote user's audio output is too low — show a brief UI advisory
            lowAudioWarning.value = true
            // Auto-dismiss after 10 s; the 4002 recovery event will also clear it
            setTimeout(() => { lowAudioWarning.value = false }, 10_000)
            break

        case 'low_recover':
            // Audio level recovered
            lowAudioWarning.value = false
            break
    }
}

function startTimer(fromIso = null) {
    if (timerHandle) return
    const start = fromIso ? new Date(fromIso) : new Date()
    timerHandle = setInterval(() => {
        const secs = Math.floor((Date.now() - start) / 1000)
        elapsed.value = `${String(Math.floor(secs / 60)).padStart(2, '0')}:${String(secs % 60).padStart(2, '0')}`
    }, 1000)
}

function stopTimer() { clearInterval(timerHandle); timerHandle = null }

function subscribeToSession() {
    const stopStatus = listenToSession(props.session.id, 'session.status', (payload) => {
        const prev = liveStatus.value
        liveStatus.value = payload.new_status
        if (payload.new_status === 'in_progress' && prev !== 'in_progress') {
            toast.success('Your tutor has started the session!')
            startTimer(payload.started_at)
        }
        if (payload.new_status === 'ended') {
            stopTimer()
            leaveAgoraChannel()
            setTimeout(() => { showRatingModal.value = true }, 800)
        }
    })

    // Listen for incoming chat messages
    const stopChat = listenToSession(props.session.id, 'session.chat', (payload) => {
        chatMessages.value.push(payload.message)
        if (!chatOpen.value) unreadCount.value++
        else scrollChat()
    })
   // OnBeforeUnmount(stopChat)

    echoCleanup = () => {
        stopStatus()
        stopChat()
        leaveEchoChannel(props.session.id)
    }
}

function goToBooking() {
    const id = props.session?.booking?.id
    if (id) router.visit(route('student.bookings.show', id))
}

async function refreshToken() {
    try {
        const res  = await fetch(route('sessions.token.refresh', props.session.id), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' },
        })
        const json = await res.json()
        if (json.success && client) await client.renewToken(json.data.token)
    } catch (err) { console.error('[agora] token refresh failed', err) }
}

async function checkDevices() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices()
        return {
            hasAudio: devices.some(d => d.kind === 'audioinput'),
            hasVideo: devices.some(d => d.kind === 'videoinput'),
        }
    } catch { return { hasAudio: false, hasVideo: false } }
}
async function initAgora() {
    const appId = props.agora_app_id
    const { channel_name: channelName, agora_token: token, agora_uid: uid } = props.session
    if (!appId || !channelName || !token) { agoraError.value = 'Session credentials not available.'; return }

    let hasAudio = false, hasVideo = false
    try {
        const devices = await navigator.mediaDevices.enumerateDevices()
        hasAudio = devices.some(d => d.kind === 'audioinput')
        hasVideo = devices.some(d => d.kind === 'videoinput')
    } catch { /* ignore */ }

    client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' })
    client.on('user-published', async (remoteUser, mediaType) => {
        await client.subscribe(remoteUser, mediaType)
        if (mediaType === 'video') { remoteUser.videoTrack.play('agora-remote'); remoteJoined.value = true }
        if (mediaType === 'audio') remoteUser.audioTrack.play()
    })
    client.on('user-unpublished', (_, mediaType) => { if (mediaType === 'video') remoteJoined.value = false })
    client.on('user-left', () => { remoteJoined.value = false })
    client.on('token-privilege-will-expire', refreshToken)
    client.on('token-privilege-did-expire', refreshToken)
    client.on('connection-state-change', (state) => { if (state === 'DISCONNECTED') agoraJoined.value = false })
    client.on('exception', handleAgoraException)

    try {
        await client.join(appId, channelName, token || null, Number(uid))
        agoraJoined.value = true
        const tracks = []
        if (hasAudio) { try { micTrack = await AgoraRTC.createMicrophoneAudioTrack(); tracks.push(micTrack) } catch { agoraError.value = 'Microphone unavailable — listen only.' } }
        if (hasVideo) { try { cameraTrack = await AgoraRTC.createCameraVideoTrack(); tracks.push(cameraTrack); cameraTrack.play('agora-local') } catch { if (!agoraError.value) agoraError.value = 'Camera unavailable — audio only.' } }
        if (tracks.length) await client.publish(tracks)
    } catch (err) { agoraError.value = `Could not connect: ${err.message ?? err}`; console.error('[agora]', err) }
}

async function leaveAgoraChannel() {
    micTrack?.close(); cameraTrack?.close()
    if (client) { try { await client.leave() } catch { /* ignore */ }; client = null }
}

onMounted(async () => {
    subscribeToSession()
    if (props.session.status === 'in_progress') startTimer(props.session.started_at)
    if (['waiting', 'active', 'in_progress'].includes(props.session.status)) await initAgora()
})

onUnmounted(async () => { stopTimer(); echoCleanup?.(); await leaveAgoraChannel() })

async function toggleMute() { muted.value = !muted.value; if (micTrack) await micTrack.setEnabled(!muted.value) }
async function toggleCamera() { cameraOff.value = !cameraOff.value; if (cameraTrack) await cameraTrack.setEnabled(!cameraOff.value) }

function leaveSession() {
    leaving.value = true
    router.post(route('student.session.end', props.session.id), {}, {
        onSuccess: () => { showLeaveConfirm.value = false; liveStatus.value = 'ended'; stopTimer(); leaveAgoraChannel(); setTimeout(() => { showRatingModal.value = true }, 800) },
        onError:  () => toast.error('Could not end session. Please try again.'),
        onFinish: () => { leaving.value = false },
    })
}

function submitRating() {
    if (!rating.value) return
    submittingRating.value = true
    router.post(
        route('student.bookings.review.store', props.session.booking.id),
        { rating: rating.value, comment: reviewComment.value, tags: selectedTags.value },
        {
            onSuccess: () => { showRatingModal.value = false; ratingSubmitted.value = true; toast.success('Thank you! Your rating has been submitted.'); setTimeout(goToBooking, 2500) },
            onError:   () => toast.error('Could not submit your rating. Please try from your bookings page.'),
            onFinish:  () => { submittingRating.value = false },
        }
    )
}

function skipRating() { showRatingModal.value = false; goToBooking() }
</script>
