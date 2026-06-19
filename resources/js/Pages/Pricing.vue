<template>
    <GuestLayout>
        <Head title="Tutor tiers — TeachMe App" />

        <!-- Hero -->
        <section class="relative py-24 px-6 text-center overflow-hidden"
                 style="background:linear-gradient(135deg,#141F3E 0%,#1a2d5a 100%);">
            <div class="absolute inset-0 pointer-events-none">
                <div style="position:absolute;width:600px;height:600px;top:-200px;left:50%;transform:translateX(-50%);background:radial-gradient(circle,rgba(0,123,67,.15) 0%,transparent 70%);"></div>
            </div>
            <div class="relative max-w-3xl mx-auto">
                <span class="inline-block px-3 py-1.5 rounded-full text-xs font-semibold mb-6"
                      style="background:rgba(0,123,67,.25);color:#4ade80;border:1px solid rgba(0,123,67,.35);">
                    Transparent pricing
                </span>
               <h1 class="text-5xl font-extrabold text-white mb-5 leading-tight">Simple pricing, zero surprises</h1>
                <p class="text-lg" style="color:rgba(255,255,255,.6);">
                    Students pay a flat <strong class="text-white">R100/hour</strong> for any session.
                    Tutors earn more as they grow through Standard, Pro, and Elite tiers.
                </p>
            </div>
        </section>

        <!-- Tier cards -->
        <section class="py-20 px-6">
            <div class="max-w-5xl mx-auto">

                <!-- Student flat-rate banner -->
                <div class="flex items-center justify-between flex-wrap gap-4 rounded-2xl px-8 py-5 mb-10"
                    style="background:#f0faf5;border:1.5px solid #a7f3d0;">
                    <div>
                        <p class="font-semibold text-gray-500 uppercase tracking-widest mb-0.5">Students always pay</p>
                        <p class="text-4xl font-extrabold" style="color:#007B43;">R100 <span class="text-xl font-semibold text-gray-400">/ hour</span></p>
                    </div>
                    <div class="text-gray-500 max-w-xs leading-relaxed">
                        One flat rate for any tutor, any subject, any tier.
                        The tier affects tutor experience and earnings — never your cost.
                    </div>
                </div>

                <!-- Tutor tier heading -->
                <p class="text-center font-semibold uppercase tracking-widest mb-8" style="color:#141F3E;">
                    Tutor commission by tier
                </p>

                <div class="grid md:grid-cols-3 gap-7">
                    <div v-for="tier in tiers" :key="tier.name"
                        class="tier-card rounded-3xl p-8 flex flex-col relative overflow-hidden"
                        :class="tier.highlight ? 'tier-highlight' : ''">

                        <!-- Highlight glow -->
                        <div v-if="tier.highlight"
                            class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-20"
                            style="background:radial-gradient(circle,#4ade80,transparent);"></div>

                        <!-- Badge -->
                        <span v-if="tier.badge"
                            class="self-start text-xs font-bold px-3 py-1 rounded-full mb-5"
                            :style="tier.highlight
                                ? 'background:rgba(74,222,128,.2);color:#4ade80;'
                                : 'background:#f0faf5;color:#007B43;'">
                            {{ tier.badge }}
                        </span>
                        <div v-else class="mb-8"></div>

                        <h3 class="text-xl font-extrabold mb-1"
                            :style="tier.highlight ? 'color:white;' : 'color:#141F3E;'">
                            {{ tier.name }}
                        </h3>
                        <p class="mb-6"
                        :style="tier.highlight ? 'color:rgba(255,255,255,.6);' : 'color:#6b7280;'">
                            {{ tier.tagline }}
                        </p>

                        <!-- Commission block -->
                        <div class="rounded-2xl px-5 py-4 mb-6"
                            :style="tier.highlight
                                ? 'background:rgba(255,255,255,.08);'
                                : 'background:#f8fafc;border:1px solid #e2e8f0;'">
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs font-medium mb-0.5"
                                    :style="tier.highlight ? 'color:rgba(255,255,255,.45);' : 'color:#9ca3af;'">
                                        Tutor earns
                                    </p>
                                    <p class="text-3xl font-extrabold"
                                    :style="tier.highlight ? 'color:#4ade80;' : 'color:#007B43;'">
                                        {{ tier.tutorEarns }}
                                        <span class="text-base font-semibold"
                                            :style="tier.highlight ? 'color:rgba(74,222,128,.6);' : 'color:#86efac;'">
                                            / hr
                                        </span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-medium mb-0.5"
                                    :style="tier.highlight ? 'color:rgba(255,255,255,.45);' : 'color:#9ca3af;'">
                                        Commission
                                    </p>
                                    <p class="text-2xl font-extrabold"
                                    :style="tier.highlight ? 'color:white;' : 'color:#141F3E;'">
                                        {{ tier.commission }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-xs mt-2"
                            :style="tier.highlight ? 'color:rgba(255,255,255,.3);' : 'color:#d1d5db;'">
                                of the R100/hr student rate
                            </p>
                        </div>

                        <ul class="space-y-3 flex-1 mb-8">
                            <li v-for="f in tier.features" :key="f"
                                class="flex items-start gap-2.5 text-sm">
                                <span class="w-4 h-4 rounded-full flex items-center justify-center text-xs mt-0.5 shrink-0"
                                    :style="tier.highlight
                                        ? 'background:rgba(74,222,128,.2);color:#4ade80;'
                                        : 'background:#f0faf5;color:#007B43;'">✓</span>
                                <span :style="tier.highlight ? 'color:rgba(255,255,255,.75);' : 'color:#374151;'">
                                    {{ f }}
                                </span>
                            </li>
                        </ul>

                        <Link :href="route('register')"
                            class="block text-center font-bold py-3.5 rounded-2xl transition-all text-sm"
                            :style="tier.highlight
                                ? 'background:white;color:#141F3E;'
                                : 'background:#141F3E;color:white;'"
                            onmouseover="this.style.opacity='.9'"
                            onmouseout="this.style.opacity='1'">
                            Get started
                        </Link>
                    </div>
                </div>
            </div>
        </section>
        <!-- Comparison image -->
        <section class="py-10 px-6">
            <div class="max-w-5xl mx-auto rounded-3xl overflow-hidden relative shadow-lg" style="height:280px;">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1200&q=80&auto=format&fit=crop"
                     alt="Students studying" class="w-full h-full object-cover"/>
                <div class="absolute inset-0 flex items-center justify-center"
                     style="background:rgba(20,31,62,.65);">
                    <div class="text-center text-white px-6">
                        <p class="text-2xl font-extrabold mb-2">All tiers include escrow-secured payments</p>
                        <p style="color:rgba(255,255,255,.65);">Your money is only released to the tutor when you're satisfied.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="py-20 px-6" style="background:#f8fafc;">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl font-extrabold text-center mb-12" style="color:#141F3E;">Common questions</h2>
                <div class="space-y-3">
                    <div v-for="faq in faqs" :key="faq.q"
                         class="bg-white rounded-2xl overflow-hidden"
                         style="border:1px solid #e2e8f0;">
                        <button @click="faq.open = !faq.open"
                                class="w-full flex items-center justify-between px-6 py-4 text-left font-semibold hover:bg-gray-50 transition-colors"
                                style="color:#141F3E;">
                            {{ faq.q }}
                            <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform"
                                 :class="faq.open ? 'rotate-45' : ''"
                                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </button>
                        <Transition
                            enter-active-class="transition-all ease-out duration-200"
                            enter-from-class="opacity-0 max-h-0"
                            enter-to-class="opacity-100 max-h-40"
                            leave-active-class="transition-all ease-in duration-150"
                            leave-from-class="opacity-100 max-h-40"
                            leave-to-class="opacity-0 max-h-0">
                            <div v-if="faq.open" class="px-6 pb-5 text-gray-500 leading-relaxed">
                                {{ faq.a }}
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const tiers = [
    {
        name: 'Standard',
        tagline: 'Qualified tutors for everyday learning',
        commission: '50%',
        tutorEarns: 'R50',
        badge: null,
        highlight: false,
        features: [
            'KYC-verified identity & qualifications',
            'Flexible scheduling',
            'Live browser-based video sessions',
            'In-session chat',
            'Escrow-secured payments',
        ],
    },
    {
        name: 'Pro',
        tagline: 'Experienced tutors with a proven track record',
        commission: '60%',
        tutorEarns: 'R60',
        badge: '⭐ Most popular',
        highlight: true,
        features: [
            'Everything in Standard',
            '50+ completed sessions',
            'Higher qualification threshold',
            'Interactive polls & quizzes',
            'Priority availability slots',
        ],
    },
    {
        name: 'Elite',
        tagline: 'Top-rated specialists for advanced needs',
        commission: '70%',
        tutorEarns: 'R70',
        badge: '🏆 Best results',
        highlight: false,
        features: [
            'Everything in Pro',
            '200+ sessions & 4.8★+ rating',
            'Specialist subject expertise',
            'Extended session support',
            'Student progress tracking',
        ],
    },
]

const faqs = reactive([
    {
        q: 'How much does a session cost?',
        a: 'Every session is R100 per hour, regardless of which tier tutor you book. There are no hidden fees or surge pricing.',
        open: false,
    },
    {
        q: 'How are tutors verified?',
        a: 'Every tutor submits identity documents and proof of qualifications. Our admin team reviews each application manually and only approves tutors who meet our standards.',
        open: false,
    },
    {
        q: 'How does the tutor commission work?',
        a: 'Tutors earn a percentage of the R100/hr session fee based on their tier — 50% (R50) for Standard, 60% (R60) for Pro, and 70% (R70) for Elite. Tiers are earned automatically through completed sessions and ratings.',
        open: false,
    },
    {
        q: 'How does escrow payment work?',
        a: 'You top up your TeachMe App wallet before booking. The R100/hr fee is held in escrow and only released to the tutor once the session is marked complete.',
        open: false,
    },
    {
        q: 'What happens if I need to cancel?',
        a: 'You can cancel before the session starts. Refund policies vary by notice period and are displayed clearly at booking time.',
        open: false,
    },
    {
        q: 'Can I switch tutors?',
        a: 'Absolutely. You can book different tutors for different subjects or simply try another if one is not the right fit.',
        open: false,
    },
])
</script>

<style scoped>
.tier-card {
    background: white;
    border: 1.5px solid #e2e8f0;
    transition: transform .2s, box-shadow .2s;
}
.tier-card:hover { transform:translateY(-6px); box-shadow:0 24px 48px rgba(20,31,62,.1); }
.tier-highlight  { background:#141F3E !important; border-color:#141F3E !important; }
</style>
