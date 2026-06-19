<template>
    <StudentLayout title="Book a Session">
        <div class="max-w-3xl space-y-5">

            <!-- ── Tutor header ─────────────────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0"
                     :style="{ background: AMBER }">
                    {{ tutor.name.charAt(0) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800">{{ tutor.name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ (tutor.subjects || []).join(', ') }}</p>
                    <span v-if="tutor.tier"
                          class="inline-block mt-1 text-xs font-semibold px-2 py-0.5 rounded-full"
                          :style="{ background: tutor.tier_colour + '22', color: tutor.tier_colour }">
                        {{ tutor.tier }}
                    </span>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-lg font-bold" :style="{ color: AMBER }">R{{ tutor.hourly_rate }}</p>
                    <p class="text-xs text-gray-400">per hour</p>
                </div>
            </div>

            <!-- ── Subject / Notes / Payment ───────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider uppercase mb-1.5">
                        Subject
                    </label>
                    <select v-model="form.subject"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                        <option value="">Select a subject…</option>
                        <option v-for="s in tutor.subjects" :key="s" :value="s">{{ s }}</option>
                        <option value="Other">Other</option>
                    </select>
                    <FieldError :message="form.errors.subject" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider uppercase mb-1.5">
                        Notes for Tutor <span class="normal-case font-normal">(optional)</span>
                    </label>
                    <textarea v-model="form.description" rows="3"
                        placeholder="What do you need help with?"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm resize-none" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider uppercase mb-1.5">
                        Payment Method
                    </label>
                    <select v-model="form.payment_method_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                        <option v-for="m in payment_methods" :key="m.id" :value="m.id">{{ m.name }}</option>
                    </select>
                    <FieldError :message="form.errors.payment_method_id" />
                </div>
            </div>

            <!-- ── Calendar ─────────────────────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="text-xs font-semibold text-gray-500 tracking-wider uppercase mb-4">
                    Select Date &amp; Time
                </h3>

                <!-- Duration picker -->
                <div class="mb-5">
                    <div class="text-xs font-semibold tracking-wider uppercase mb-2"
                         :style="{ color: MUTED }">Session Duration</div>
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="decreaseDuration"
                            :disabled="form.duration_minutes <= DURATION_MIN"
                            class="w-9 h-9 rounded-lg border flex items-center justify-center text-lg font-semibold transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                            :style="{ border: `1px solid ${BORDER}`, color: AMBER, background: CREAM }"
                        >−</button>
                        <div class="flex-1 rounded-xl border text-center py-2.5 px-3"
                             :style="{ border: `1.5px solid ${AMBER_BORDER}`, background: AMBER_LIGHT }">
                            <span class="font-semibold text-sm" :style="{ color: AMBER }">{{ durationLabel }}</span>
                            <span class="text-xs ml-2" :style="{ color: MUTED }">— R{{ sessionCost.toFixed(0) }}</span>
                        </div>
                        <button
                            type="button"
                            @click="increaseDuration"
                            :disabled="form.duration_minutes >= DURATION_MAX"
                            class="w-9 h-9 rounded-lg border flex items-center justify-center text-lg font-semibold transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                            :style="{ border: `1px solid ${BORDER}`, color: AMBER, background: CREAM }"
                        >+</button>
                    </div>
                    <!-- Hard conflict: overlaps a real booking — selection was cleared -->
                    <p v-if="bookingConflict" class="text-xs mt-2" :style="{ color: '#B45309' }">
                        ⚠ {{ bookingConflict }}
                    </p>
                    <!-- Soft notice: extends past the tutor's window — tutor decides -->
                    <p v-if="windowOverflow" class="text-xs mt-2 leading-snug"
                       :style="{ color: '#1D4ED8' }">
                        ℹ {{ windowOverflow }}
                    </p>
                    <FieldError :message="form.errors.duration_minutes" />
                </div>

                <!-- Calendar + Slots side-by-side -->
                <div :style="{
                    display: 'grid',
                    gridTemplateColumns: selectedDate ? 'minmax(0,1fr) minmax(0,1fr)' : 'minmax(0,1fr)',
                    gap: '12px',
                    alignItems: 'start',
                }">

                    <!-- ── Month grid ── -->
                    <div :style="calCard">
                        <!-- Month nav -->
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" @click="prevMonth"
                                class="w-8 h-8 flex items-center justify-center rounded-md border transition-colors hover:bg-gray-50"
                                :style="{ border: `1px solid ${BORDER}`, color: MUTED }">‹</button>
                            <span class="text-sm font-semibold" :style="{ color: INK, fontFamily: SERIF }">
                                {{ monthLabel }}
                            </span>
                            <button type="button" @click="nextMonth"
                                class="w-8 h-8 flex items-center justify-center rounded-md border transition-colors hover:bg-gray-50"
                                :style="{ border: `1px solid ${BORDER}`, color: MUTED }">›</button>
                        </div>

                        <!-- Weekday headers -->
                        <div class="grid grid-cols-7 gap-0.5 mb-1">
                            <div v-for="wd in WEEKDAYS" :key="wd"
                                class="text-center text-gray-400"
                                style="font-size:10px; font-weight:700; letter-spacing:0.04em; padding:2px 0;">
                                {{ wd }}
                            </div>
                        </div>

                        <!-- Day cells -->
                        <div class="grid grid-cols-7 gap-0.5">
                            <div v-for="(d, i) in calendarGrid" :key="i">
                                <template v-if="d">
                                    <button
                                        type="button"
                                        @click="handleDayClick(d)"
                                        :style="dayCellStyle(d)"
                                        style="width:100%; aspect-ratio:1; border:none; border-radius:7px; font-size:12px; transition: background 0.1s, color 0.1s;"
                                    >{{ d.getDate() }}</button>
                                </template>
                                <div v-else />
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="flex gap-4 mt-3 pt-3" :style="{ borderTop: `1px solid ${BORDER}` }">
                            <div v-for="item in legend" :key="item.label" class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-sm"
                                     :style="{ background: item.bg, border: `1px solid ${item.border}` }" />
                                <span class="text-xs" :style="{ color: MUTED }">{{ item.label }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- ── Time slots ── -->
                    <div v-if="selectedDate" :style="calCard">
                        <p class="text-sm font-semibold mb-0.5" :style="{ color: INK, fontFamily: SERIF }">
                            {{ dateLabel }}
                        </p>
                        <p class="text-xs mb-4" :style="{ color: MUTED }">
                            <template v-if="slots.length">
                                {{ slots.length }} slot{{ slots.length !== 1 ? 's' : '' }} available · {{ form.duration_minutes }} min each
                            </template>
                            <template v-else>No slots available</template>
                        </p>

                        <template v-if="slots.length === 0">
                            <div class="text-center py-6 text-sm leading-relaxed" :style="{ color: MUTED }">
                                No slots available on this day.
                            </div>
                        </template>
                        <template v-else>
                            <!-- Morning -->
                            <div v-if="amSlots.length" class="mb-4">
                                <div class="mb-1.5"
                                     style="font-size:10px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase;"
                                     :style="{ color: MUTED }">Morning</div>
                                <div class="grid grid-cols-3 gap-1.5">
                                    <button
                                        v-for="t in amSlots" :key="t"
                                        type="button"
                                        @click="setSelectedTime(t)"
                                        class="rounded-lg text-xs font-medium transition-all py-2"
                                        :style="timeBtnStyle(t)">
                                        {{ fmt12(t) }}
                                    </button>
                                </div>
                            </div>

                            <!-- Afternoon -->
                            <div v-if="pmSlots.length">
                                <div class="mb-1.5"
                                     style="font-size:10px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase;"
                                     :style="{ color: MUTED }">Afternoon</div>
                                <div class="grid grid-cols-3 gap-1.5">
                                    <button
                                        v-for="t in pmSlots" :key="t"
                                        type="button"
                                        @click="setSelectedTime(t)"
                                        class="rounded-lg text-xs font-medium transition-all py-2"
                                        :style="timeBtnStyle(t)">
                                        {{ fmt12(t) }}
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Mini summary once a time is chosen -->
                        <div v-if="selectedTime"
                             class="mt-4 pt-4" :style="{ borderTop: `1px solid ${BORDER}` }">
                            <div class="rounded-xl p-3 mb-3 text-sm space-y-1.5"
                                 :style="{ background: CREAM }">
                                <div class="flex justify-between">
                                    <span :style="{ color: MUTED }">Time</span>
                                    <span class="font-medium" :style="{ color: INK }">{{ fmt12(selectedTime) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span :style="{ color: MUTED }">Duration</span>
                                    <span class="font-medium" :style="{ color: INK }">{{ form.duration_minutes }} min</span>
                                </div>
                                <div class="flex justify-between pt-2 font-semibold text-sm"
                                     :style="{ borderTop: `1px dashed ${BORDER}` }">
                                    <span :style="{ color: MUTED }">Total</span>
                                    <span :style="{ color: AMBER }">R{{ sessionCost.toFixed(2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p v-if="!selectedDate" class="text-center text-xs mt-4" :style="{ color: MUTED }">
                    Tap an available date to see open time slots
                </p>

                <FieldError :message="form.errors.scheduled_at" />
            </div>

            <!-- ── Wallet summary + submit ───────────────────────────────── -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 space-y-4">
                <div class="bg-gray-50 rounded-xl p-3 text-sm">
                    <div class="flex justify-between text-gray-600 mb-1">
                        <span>R{{ tutor.hourly_rate }}/hr × {{ form.duration_minutes }}min</span>
                        <span>R{{ sessionCost.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-800 pt-1 border-t border-gray-200">
                        <span>Total</span>
                        <span>R{{ sessionCost.toFixed(2) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">
                        Wallet balance: R{{ wallet_balance.toFixed(2) }}
                        <span v-if="walletInsufficient" class="text-red-500 ml-1">— insufficient</span>
                    </p>
                </div>

                <div v-if="!form.scheduled_at" class="text-xs text-center py-1" :style="{ color: MUTED }">
                    Choose a date and time above to continue
                </div>

                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing || !form.scheduled_at || walletInsufficient"
                    class="w-full py-3 text-white font-semibold rounded-xl transition-colors disabled:opacity-40"
                    :style="{
                        background: form.scheduled_at && !walletInsufficient ? AMBER : '#9CA3AF',
                        cursor: form.processing || !form.scheduled_at || walletInsufficient ? 'not-allowed' : 'pointer',
                    }"
                >{{ form.processing ? 'Sending Request…' : 'Send Booking Request' }}</button>
            </div>

        </div>
    </StudentLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm }              from '@inertiajs/vue3'
import StudentLayout            from '@/Layouts/StudentLayout.vue'
import FieldError               from '@/Components/FieldError.vue'

// ─── Props ────────────────────────────────────────────────────────────────────

const props = defineProps({
    tutor:            Object,   // { id, name, subjects, hourly_rate, tier, tier_colour }
    availability:     Array,    // [{ day: 0-6, start: "HH:MM", end: "HH:MM" }]
    existing_bookings:Array,    // [{ date:[y,m,d], startH, startM, duration }]  — JS month (0-based)
    buffer_minutes:   Number,   // from PlatformSetting sessions.session_buffer_minutes
    wallet_balance:   Number,
    payment_methods:  Array,
    duration_options: Array,    // [30, 60, 90, 120]
})

// ─── Palette (mirrors BookingCalendar.jsx exactly) ────────────────────────────

const SERIF       = "Georgia, 'Times New Roman', serif"
const SANS        = "'Segoe UI', system-ui, -apple-system, sans-serif"
const AMBER       = '#C96A1A'
const AMBER_LIGHT = '#FDF3E8'
const AMBER_BORDER= '#E8924A'
const GREEN       = '#1A7A4A'
const GREEN_LIGHT = '#E6F5ED'
const GREEN_BORDER= '#3DAA72'
const BORDER      = '#E2DDD6'
const MUTED       = '#8C8680'
const INK         = '#1C1917'
const CREAM       = '#FAF8F4'

const calCard = {
    background: '#ffffff',
    borderRadius: 14,
    border: `1px solid ${BORDER}`,
    padding: '1rem',
}

// ─── Calendar constants ───────────────────────────────────────────────────────

const WEEKDAYS = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

// ─── Duration stepper ────────────────────────────────────────────────────────

const DURATION_MIN  = 30
const DURATION_MAX  = 300   // 5 hours; clamp to what availability allows anyway
const DURATION_STEP = 30

const durationLabel = computed(() => {
    const m = form.duration_minutes
    if (m < 60)  return `${m} min`
    if (m === 60) return '1 hour'
    const hrs  = Math.floor(m / 60)
    const mins = m % 60
    return mins ? `${hrs}h ${mins}m` : `${hrs} hours`
})

// Soft notice — session extends past the tutor's scheduled window.
// The tutor can still accept or decline, so we never block submission.
const windowOverflow = computed(() => {
    if (!selectedTime.value || !selectedDate.value) return null
    const t  = toMins(selectedTime.value)
    const d  = form.duration_minutes
    const bd = jsToBackend(selectedDate.value.getDay())
    const fits = (props.availability ?? [])
        .filter(a => a.day === bd)
        .some(w => toMins(w.start) <= t && t + d <= toMins(w.end))
    return fits
        ? null
        : `This session extends beyond the tutor's scheduled window — the tutor will need to approve the extra time.`
})

// Hard conflict — overlaps an existing confirmed/pending booking.
// Clears the selection because the slot is genuinely unavailable.
const bookingConflict = computed(() => {
    if (!selectedTime.value || !selectedDate.value) return null
    const t   = toMins(selectedTime.value)
    const d   = form.duration_minutes
    const buf = props.buffer_minutes ?? 15
    const clash = (props.existing_bookings ?? []).some(b => {
        if (!sameDate(b.date, selectedDate.value)) return false
        const bs = b.startH * 60 + b.startM
        const be = bs + b.duration
        return t < be + buf && t + d > bs - buf
    })
    return clash ? `${durationLabel.value} would overlap with another booking.` : null
})

// Union — used by any template bindings that need a single conflict signal.
const durationConflict = computed(() => bookingConflict.value || windowOverflow.value)

const decreaseDuration = () => {
    if (form.duration_minutes <= DURATION_MIN) return
    handleDurationChange(form.duration_minutes - DURATION_STEP)
}
const increaseDuration = () => {
    if (form.duration_minutes >= DURATION_MAX) return
    handleDurationChange(form.duration_minutes + DURATION_STEP)
}

const legend = [
    { bg: AMBER_LIGHT, border: AMBER_BORDER, label: 'Available' },
    { bg: AMBER,       border: AMBER,        label: 'Selected'  },
]

// ─── Helpers ──────────────────────────────────────────────────────────────────

// JS getDay() (0=Sun) → backend day_of_week (0=Mon)
const jsToBackend = jsDay => (jsDay + 6) % 7

const toMins = str => {
    const [h, m] = str.split(':').map(Number)
    return h * 60 + m
}
const fromMins = mins =>
    `${String(Math.floor(mins / 60)).padStart(2, '0')}:${String(mins % 60).padStart(2, '0')}`

const fmt12 = str => {
    const [h, m] = str.split(':').map(Number)
    return `${h % 12 || 12}:${String(m).padStart(2, '0')} ${h >= 12 ? 'PM' : 'AM'}`
}

const sameDate = ([y, mo, d], date) =>
    y === date.getFullYear() && mo === date.getMonth() && d === date.getDate()

// ─── Slot generation (mirrors assertTutorAvailableAt exactly) ─────────────────
function generateSlots(date, durationMins) {
    const bd      = jsToBackend(date.getDay())
    const windows = (props.availability ?? []).filter(a => a.day === bd)
    const buffer  = props.buffer_minutes ?? 15
    const slots   = []

    // For today: a slot is only valid if it starts strictly after now.
    // We use a 5-min lead so a slot that starts in the next few seconds isn't shown.
    const isDateToday = isToday(date)
    const nowMins = isDateToday
        ? today.value.getHours() * 60 + today.value.getMinutes() + 5
        : -1

    for (const w of windows) {
        const wStart = toMins(w.start)
        const wEnd   = toMins(w.end)

        // A slot is valid as long as it *starts* inside the window.
        // If the chosen duration runs past the window end the tutor can
        // still accept or decline — that is enforced at the booking level,
        // not here.
        for (let t = wStart; t < wEnd; t += 30) {
            // Skip slots that have already passed (or start too soon) today
            if (isDateToday && t < nowMins) continue

            const conflict = (props.existing_bookings ?? []).some(b => {
                if (!sameDate(b.date, date)) return false
                const bs = b.startH * 60 + b.startM
                const be = bs + b.duration
                return t < be + buffer && t + durationMins > bs - buffer
            })
            if (!conflict) slots.push(fromMins(t))
        }
    }
    return slots
}

// ─── Calendar state ───────────────────────────────────────────────────────────
// Replace the const with a computed so it always reflects the real current time
const today = computed(() => new Date())
const calYear      = ref(today.value.getFullYear())
const calMonth     = ref(today.value.getMonth())
const selectedDate = ref(null)
const selectedTime = ref(null)

const calendarGrid = computed(() => {
    const first  = new Date(calYear.value, calMonth.value, 1)
    const last   = new Date(calYear.value, calMonth.value + 1, 0)
    const offset = (first.getDay() + 6) % 7
    return [
        ...Array(offset).fill(null),
        ...Array.from({ length: last.getDate() }, (_, i) =>
            new Date(calYear.value, calMonth.value, i + 1)
        ),
    ]
})

const monthLabel = computed(() =>
    new Date(calYear.value, calMonth.value, 1)
        .toLocaleDateString('en', { month: 'long', year: 'numeric' })
)
const hasAvail = d => {
    if (!d) return false
    const hasWindow = (props.availability ?? []).some(
        a => a.day === jsToBackend(d.getDay())
    )
    if (!hasWindow) return false
    // For today, check that at least one slot is still in the future
    if (isToday(d)) return generateSlots(d, form.duration_minutes).length > 0
    return true
}
const isPast = d => {
    if (!d) return true
    const dt = new Date(d); dt.setHours(0, 0, 0, 0)
    const td = new Date(today.value); td.setHours(0, 0, 0, 0)
    return dt < td
}
const isToday    = d => d && sameDate([d.getFullYear(), d.getMonth(), d.getDate()], today.value)
const isSelected = d => d && selectedDate.value &&
    sameDate([d.getFullYear(), d.getMonth(), d.getDate()], selectedDate.value)

// ─── Derived slot lists ───────────────────────────────────────────────────────

const slots = computed(() =>
    selectedDate.value ? generateSlots(selectedDate.value, form.duration_minutes) : []
)
const amSlots = computed(() => slots.value.filter(s => parseInt(s, 10) < 12))
const pmSlots = computed(() => slots.value.filter(s => parseInt(s, 10) >= 12))

const dateLabel = computed(() =>
    selectedDate.value?.toLocaleDateString('en', {
        weekday: 'long', day: 'numeric', month: 'long',
    }) ?? ''
)

// ─── Handlers ─────────────────────────────────────────────────────────────────

const prevMonth = () => {
    if (calMonth.value === 0) { calYear.value--; calMonth.value = 11 }
    else calMonth.value--
    selectedDate.value = null
    selectedTime.value = null
    form.scheduled_at  = ''
}
const nextMonth = () => {
    if (calMonth.value === 11) { calYear.value++; calMonth.value = 0 }
    else calMonth.value++
    selectedDate.value = null
    selectedTime.value = null
    form.scheduled_at  = ''
}

const handleDayClick = d => {
    if (!d || isPast(d) || !hasAvail(d)) return
    selectedDate.value = d
    selectedTime.value = null
    form.scheduled_at  = ''
}

const handleDurationChange = mins => {
    form.duration_minutes = mins
    // Only clear the selection for a hard booking clash (the slot is truly
    // unavailable). A window-overflow is a soft notice — the tutor decides —
    // so we leave the selection intact and let the warning banner explain.
    if (selectedTime.value && bookingConflict.value) {
        selectedTime.value = null
        form.scheduled_at  = ''
    }
}

const setSelectedTime = t => {
    selectedTime.value = t
    const d = selectedDate.value
    const [h, m] = t.split(':').map(Number)

    // Build a local Date object for the selected date/time, then convert to UTC ISO
    const local = new Date(d.getFullYear(), d.getMonth(), d.getDate(), h, m, 0)
    form.scheduled_at = local.toISOString()   // e.g. "2026-05-15T06:30:00.000Z"
}

// ─── Style helpers ────────────────────────────────────────────────────────────

const dayCellStyle = d => {
    const avail     = hasAvail(d)
    const past      = isPast(d)
    const sel       = isSelected(d)
    const tod       = isToday(d)
    const clickable = avail && !past

    let bg      = 'transparent'
    let color   = avail && !past ? '#5C4A38' : '#C8C4C0'
    let outline = 'none'
    let cursor  = clickable ? 'pointer' : 'default'
    let fontWeight = tod ? 700 : 400

    if (sel)              { bg = AMBER;       color = '#fff' }
    else if (avail && !past) { bg = AMBER_LIGHT }
    if (tod && !sel)      { outline = `2px solid ${AMBER_BORDER}`; }

    return { background: bg, color, outline, outlineOffset: '-1px', cursor, fontWeight, fontFamily: SANS }
}


const timeBtnStyle = t => {
    const active = selectedTime.value === t
    return {
        border: active ? `1.5px solid ${GREEN_BORDER}` : `1px solid ${BORDER}`,
        background: active ? GREEN_LIGHT : CREAM,
        color: active ? GREEN : '#6B6560',
        fontWeight: active ? 600 : 400,
        fontFamily: SANS,
        cursor: 'pointer',
    }
}

// ─── Inertia form ─────────────────────────────────────────────────────────────

const form = useForm({
    tutor_id:           props.tutor.id,
    subject:            '',
    description:        '',
    scheduled_at:       '',
    duration_minutes:   30,
    payment_method_id:  props.payment_methods?.[0]?.id ?? null,
})

const sessionCost = computed(() =>
    +(props.tutor.hourly_rate * (form.duration_minutes / 60)).toFixed(2)
)

const walletInsufficient = computed(() => props.wallet_balance < sessionCost.value)

const submit = () => form.post(route('student.bookings.store'))
</script>
