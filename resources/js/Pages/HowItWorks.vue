<template>
    <GuestLayout>
        <Head title="How TeachMe App works" />

        <!-- Hero -->
        <section class="relative overflow-hidden py-24 px-6 text-center"
                 style="background:linear-gradient(135deg,#141F3E 0%,#1a2d5a 100%);">
            <div class="absolute inset-0 pointer-events-none">
                <div style="position:absolute;width:600px;height:600px;top:-200px;left:50%;transform:translateX(-50%);background:radial-gradient(circle,rgba(0,123,67,.15) 0%,transparent 70%);"></div>
            </div>
            <div class="relative max-w-3xl mx-auto">
                <span class="inline-block px-3 py-1.5 rounded-full text-xs font-semibold mb-6"
                      style="background:rgba(0,123,67,.25);color:#4ade80;border:1px solid rgba(0,123,67,.35);">
                    Simple. Secure. Effective.
                </span>
                <h1 class="text-5xl font-extrabold text-white mb-5 leading-tight">How TeachMe App works</h1>
                <p class="text-lg" style="color:rgba(255,255,255,.6);">
                    From sign-up to your first session in under 10 minutes.
                </p>
            </div>
        </section>

        <!-- Tab toggle -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto">
                <div class="flex rounded-2xl p-1.5 w-fit mx-auto mb-16 gap-1"
                     style="background:#f1f5f9;">
                    <button v-for="tab in tabs" :key="tab.id"
                            @click="activeTab = tab.id"
                            class="px-7 py-2.5 rounded-xl font-semibold transition-all"
                            :style="activeTab === tab.id
                                ? 'background:#141F3E;color:white;box-shadow:0 2px 8px rgba(20,31,62,.25);'
                                : 'color:#64748b;'">
                        {{ tab.label }}
                    </button>
                </div>

                <!-- Steps -->
                <div class="space-y-0">
                    <div v-for="(step, i) in activesteps" :key="i"
                         class="hiw-step flex gap-8 items-start pb-12 relative">
                        <!-- Connector line -->
                        <div v-if="i < activesteps.length - 1"
                             class="absolute left-7 top-16 w-0.5 h-full -bottom-0"
                             style="background:linear-gradient(to bottom,#007B43,transparent);"></div>

                        <!-- Step number -->
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-black shrink-0 shadow-sm z-10"
                             :style="activeTab === 'student'
                                ? 'background:#007B43;color:white;'
                                : 'background:#141F3E;color:white;'">
                            {{ i + 1 }}
                        </div>

                        <div class="flex-1 pt-2">
                            <h3 class="text-xl font-bold mb-2" style="color:#141F3E;">{{ step.title }}</h3>
                            <p class="text-gray-500 leading-relaxed mb-4">{{ step.desc }}</p>
                            <!-- Optional image -->
                            <div v-if="step.img" class="rounded-2xl overflow-hidden shadow-md mt-4"
                                 style="max-width:560px;height:220px;">
                                <img :src="step.img" :alt="step.title"
                                     class="w-full h-full object-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust badges -->
        <section class="py-14 px-6" style="background:#f8fafc;border-top:1px solid #e2e8f0;">
            <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="b in badges" :key="b.label"
                     class="flex flex-col items-center text-center gap-2">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-sm"
                         style="background:white;">{{ b.icon }}</div>
                    <p class="font-semibold" style="color:#141F3E;">{{ b.label }}</p>
                    <p class="text-xs text-gray-400 leading-snug">{{ b.desc }}</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-20 px-6 text-center" style="background:#141F3E;">
            <h2 class="text-3xl font-extrabold text-white mb-4">Ready to get started?</h2>
            <p class="mb-8" style="color:rgba(255,255,255,.6);">Join thousands of students and tutors already on TeachMe App.</p>
            <Link :href="route('register')"
                  class="inline-flex items-center gap-2 font-bold px-8 py-4 rounded-2xl transition-transform hover:scale-105"
                  style="background:#007B43;color:white;">
                Create your free account
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </Link>
        </section>
    </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const activeTab = ref('student')
const tabs = [
    { id: 'student', label: '🎓 For Students' },
    { id: 'tutor',   label: '📚 For Tutors' },
]

const studentSteps = [
    {
        title: 'Create a free account',
        desc: 'Sign up with your email and pick the Student role. No credit card required to browse tutors.',
        img: 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=700&q=80&auto=format&fit=crop',
    },
    {
        title: 'Discover verified tutors',
        desc: 'Browse by subject, tier, and availability. Every tutor is KYC-verified with qualifications on display.',
        img: null,
    },
    {
        title: 'Book a session',
        desc: 'Pick an open slot, top up your TeachMe App wallet, and your booking is confirmed instantly. Funds are held in escrow — only released once the session completes.',
        img: null,
    },
    {
        title: 'Join the live session',
        desc: 'At session time, join directly from your dashboard. No downloads — browser-based HD video powered by Agora.',
        img: 'https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?w=700&q=80&auto=format&fit=crop',
    },
    {
        title: 'Rate and grow',
        desc: 'After the session, leave a review and track your progress. Your payment releases to the tutor automatically.',
        img: null,
    },
]

const tutorSteps = [
    {
        title: 'Apply and complete KYC',
        desc: 'Register as a Tutor and submit your identity and qualification documents. Our admin team reviews within 48 hours.',
        img: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=700&q=80&auto=format&fit=crop',
    },
    {
        title: 'Set your availability',
        desc: 'Define your weekly schedule. Students can only book during your open slots — you\'re always in control.',
        img: null,
    },
    {
        title: 'Get booked',
        desc: 'You get a notification the moment a student confirms. Review the details and accept or decline.',
        img: null,
    },
    {
        title: 'Run a great session',
        desc: 'Join the video call, use polls, chat, and screen sharing to deliver an engaging session.',
        img: 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=700&q=80&auto=format&fit=crop',
    },
    {
        title: 'Get paid',
        desc: 'Earnings land in your TeachMe App wallet after session completion. Request a payout to your bank anytime.',
        img: null,
    },
]

const activesteps = computed(() =>
    activeTab.value === 'student' ? studentSteps : tutorSteps
)

const badges = [
    { icon: '🛡️', label: 'KYC Verified',     desc: 'Every tutor is identity-verified before going live' },
    { icon: '🔒', label: 'Escrow Payments',  desc: 'Funds held securely — released only on completion' },
    { icon: '⭐', label: 'Tier System',       desc: 'Standard, Pro, and Elite tiers reflect real track records' },
    { icon: '🎥', label: 'Browser Sessions', desc: 'HD video powered by Agora — no downloads needed' },
]
</script>

<style scoped>
.hiw-step { transition: opacity .2s; }
</style>
