<template>
    <GuestLayout>
        <Head title="Find your perfect tutor" />

        <!-- ── HERO ─────────────────────────────────────────────────────── -->
        <section class="hero-section">
            <!-- Background image overlay -->
            <div class="hero-bg-img"></div>

            <!-- Floating decorative shapes -->
            <div class="hero-shapes" aria-hidden="true">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>

            <div class="hero-content container mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-10 items-center w-full">

                    <!-- Copy -->
                    <div class="lg:col-span-7 text-white">
                        <h1 class="hero-heading fade-up">
                            Find Your Perfect<br>
                            <span class="text-yellow-300">Peer Tutor</span> Today
                        </h1>

                        <p class="hero-lead fade-up delay-1">
                            Connect with qualified student tutors at South African universities,
                            colleges, and TVET institutions. Get the academic support you need to excel.
                        </p>

                        <!-- CTAs -->
                        <div class="flex flex-wrap items-center gap-4 mb-8 fade-up delay-2">
                            <Link href="route('student.discover')" class="btn-cta-primary">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                                </svg>
                                Find a Tutor Now
                            </Link>
                            <Link href="route('register')" class="btn-cta-secondary">
                                Become a Tutor
                            </Link>
                        </div>

                        <!-- Quick Search -->
                         <!--
                        <div class="fade-up delay-3">
                            <form action="/search" method="get" class="hero-search">
                                <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                                </svg>
                                <input type="text" name="search" placeholder="Search by subject or course..." class="search-input"/>
                                <button type="submit" class="search-btn">Search</button>
                            </form>
                        </div> -->
                    </div>

                    <!-- Hero image -->
                    <div class="lg:col-span-5 hidden lg:flex justify-center fade-up delay-2">
                        <div class="hero-img-wrap">
                            <img :src="appImg" alt="TeachMe App" class="hero-img"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── HOW IT WORKS ───────────────────────────────────────────── -->
        <section class="section-pad">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="section-header">
                    <h2 class="section-title">How It Works</h2>
                    <p class="section-subtitle">Get started with TeachMe App in three simple steps</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div v-for="(step, i) in steps" :key="i" class="step-card">
                        <div class="step-number" :class="step.colorClass">{{ i + 1 }}</div>
                        <h4 class="step-title">{{ step.title }}</h4>
                        <p class="step-desc">{{ step.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── STUDENTS LEARNING ──────────────────────────────────────── -->
        <section class="section-pad" style="background:linear-gradient(135deg,#f7fafc 0%,#fff 100%);">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="img-deco-wrap">
                        <img :src="studentImg" alt="Students studying together" class="img-deco"/>
                    </div>
                    <div class="ps-0 md:ps-8">
                        <span class="badge badge-orange">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Student Success
                        </span>
                        <h3 class="split-title">Join Other Students Already Excelling</h3>
                        <p class="split-body">
                            Thousands of students across South Africa are already improving their grades
                            with peer tutors who understand their exact curriculum and challenges.
                        </p>
                        <ul class="mt-6 space-y-3">
                            <li v-for="b in studentBenefits" :key="b" class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="check-dot">✓</span>
                                {{ b }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── WHY TEACHME ────────────────────────────────────────────── -->
        <section class="section-pad">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center">

                    <!-- Features cards -->
                    <div class="grid grid-cols-1 gap-6">
                        <div v-for="(f, i) in features" :key="i" class="feature-card" :class="'feature-card--' + (i+1)">
                            <div class="feature-icon" :class="'feature-icon--' + (i+1)">
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" v-html="f.icon" />
                            </div>
                            <div>
                                <h3 class="feature-title">{{ f.title }}</h3>
                                <p class="feature-desc">{{ f.desc }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Text -->
                    <div class="lg:ps-8">
                        <h2 class="section-title text-left after-left">Why Students Choose TeachMe App</h2>
                        <p class="section-subtitle text-left mx-0 mt-5 mb-8">
                            We're dedicated to bridging the academic gap and ensuring every student
                            has access to quality peer support.
                        </p>

                        <div v-for="(b, i) in benefits" :key="i" class="benefit-item">
                            <div class="benefit-icon" :class="'benefit-icon--' + (i+1)">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="benefit-title">{{ b.title }}</h5>
                                <p class="benefit-desc">{{ b.desc }}</p>
                            </div>
                        </div>

                        <Link :href="route('register')"
                              class="inline-flex items-center gap-2 font-bold px-8 py-4 rounded-full text-white text-sm mt-6"
                              style="background:var(--green-primary);box-shadow:0 4px 15px rgba(5,130,72,.3);">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                            </svg>
                            Get Started Free
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── BECOME A TUTOR CTA ─────────────────────────────────────── -->
        <section class="tutor-cta-section">
            <!-- Decorative circles -->
            <div class="tutor-cta-circle-1" aria-hidden="true"></div>
            <div class="tutor-cta-circle-2" aria-hidden="true"></div>

            <div class="container mx-auto px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-5 hidden lg:block">
                        <img :src="tutorImg" alt="Happy tutor" class="tutor-cta-img"/>
                    </div>
                    <div class="lg:col-span-7 text-white lg:text-left text-center">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-5"
                              style="background:rgba(255,255,255,.15);color:#fff;">
                            <svg class="w-3.5 h-3.5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            Earn While You Learn
                        </span>

                        <h2 class="text-4xl lg:text-5xl font-extrabold mb-5 leading-tight" style="letter-spacing:-.02em;">
                            Earn Money Sharing<br>Your Knowledge
                        </h2>
                        <p class="text-lg mb-8" style="color:rgba(255,255,255,.85);">
                            Join hundreds of student tutors earning up to 70% commission while
                            helping fellow students succeed. Set your own rates and schedule.
                        </p>

                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-10">
                            <Link href="route('register')" class="btn-cta-primary">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                </svg>
                                Apply to Become a Tutor
                            </Link>
                            <button @click="showTutorModal = true" class="btn-cta-secondary">Learn More</button>
                        </div>

                        <!-- Mini stats -->
                        <div class="grid grid-cols-2 gap-6 pt-8 border-t border-white/20 max-w-xs lg:max-w-none">
                            <div class="text-left">
                                <p class="text-3xl font-extrabold mb-1">50% to 70%</p>
                                <p class="text-sm opacity-80">Commission Rate</p>
                            </div>
                            <div class="text-left">
                                <p class="text-3xl font-extrabold mb-1">Flexible</p>
                                <p class="text-sm opacity-80">Set Your Schedule</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── APP DOWNLOAD ───────────────────────────────────────────── -->
        <section class="app-section">
            <div class="app-blob-1" aria-hidden="true"></div>
            <div class="container mx-auto px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h2 class="section-title text-left after-left">Download Our Mobile App</h2>
                        <p class="text-gray-500 mb-8 mt-4">
                            Get the full TeachMe App experience on your phone. Book sessions, chat with
                            tutors, and manage your learning on the go.
                        </p>
                        <a href="https://play.google.com/store" target="_blank" rel="noopener"
                           class="inline-block app-badge">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                 alt="Get it on Google Play" style="height:60px;"/>
                        </a>
                        <p class="text-xs text-gray-400 mt-3">*iOS version coming soon</p>
                    </div>
                    <div class="text-center">
                        <img :src="appImg" alt="Mobile App Preview" style="max-height:400px;" class="inline-block"/>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── CONTACT ────────────────────────────────────────────────── -->
        <section class="section-pad" style="background:linear-gradient(to bottom,#fff 0%,#f7fafc 100%);">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="section-header">
                    <h2 class="section-title">Get in Touch</h2>
                    <p class="section-subtitle">Have questions? We're here to help you succeed!</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                    <a v-for="c in contacts" :key="c.label"
                       :href="c.href" v-bind="c.attrs" class="contact-card group">
                        <div class="contact-icon-wrap" :style="'background:' + c.gradient">
                            <svg class="w-7 h-7 text-white" :viewBox="c.viewBox" :fill="c.svgFill"
                                 fill="none" stroke-width="1.5" stroke="currentColor"
                                 v-html="c.icon" />
                        </div>
                        <h5 class="font-bold mb-1" style="color:#2d3748;">{{ c.title }}</h5>
                        <p class="text-sm text-gray-400 mb-3">{{ c.subtitle }}</p>
                        <span class="font-bold" style="color:var(--green-primary);">{{ c.label }}</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ── TUTOR INFO MODAL ───────────────────────────────────────── -->
        <Teleport to="body">
            <div v-if="showTutorModal" class="modal-overlay" @click.self="showTutorModal = false">
                <div class="modal-box">
                    <div class="modal-header">
                        <h5 class="font-bold text-lg" style="color:#2d3748;">Becoming a Tutor</h5>
                        <button @click="showTutorModal = false" class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h6 class="font-bold mb-3" style="color:#2d3748;">Requirements:</h6>
                        <ul class="list-disc ps-5 text-sm text-gray-600 space-y-1 mb-6">
                            <li>Currently enrolled at a South African university, college, or TVET institution</li>
                            <li>Achieve 70% or higher in your Grade Pass Average</li>
                            <li>75% or higher in the module or subject you tutor</li>
                            <li>Good communication skills</li>
                            <li>Reliable and committed to helping students succeed</li>
                        </ul>
                        <h6 class="font-bold mb-3" style="color:#2d3748;">Benefits:</h6>
                        <ul class="list-disc ps-5 text-sm text-gray-600 space-y-1 mb-6">
                            <li>Earn up to 70% commission on all sessions</li>
                            <li>Build your teaching portfolio</li>
                            <li>Help fellow students while earning money</li>
                            <li>Flexible — work around your own study schedule</li>
                        </ul>
                        <h6 class="font-bold mb-3" style="color:#2d3748;">How to Apply:</h6>
                        <ol class="list-decimal ps-5 text-sm text-gray-600 space-y-1">
                            <li>Click "Apply to Become a Tutor"</li>
                            <li>Complete the registration form</li>
                            <li>Upload your academic transcript</li>
                            <li>Wait for verification (usually 24–48 hours)</li>
                            <li>Start tutoring and earning!</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button @click="showTutorModal = false" class="modal-btn-cancel">Close</button>
                        <Link href="/become-instructor" class="modal-btn-apply">Apply Now</Link>
                    </div>
                </div>
            </div>
        </Teleport>
    </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const showTutorModal = ref(false)

const appImg     = '/img/app.png'
const studentImg = '/img/student.jpg'
const tutorImg   = '/img/student3.jpg'

const steps = [
    {
        title: 'Search & Browse',
        desc: 'Find tutors by Course, Institution, availability, and rating. Filter results to match your exact needs.',
        colorClass: 'step-num--1',
    },
    {
        title: 'Book a Session',
        desc: 'Choose a time that works for you and book directly through the platform. Get instant confirmation.',
        colorClass: 'step-num--2',
    },
    {
        title: 'Learn & Succeed',
        desc: 'Meet online, get the support you need, and monitor your academic progress every step of the way.',
        colorClass: 'step-num--3',
    },
]

const studentBenefits = [
    'Access tutors who aced the same courses you\'re taking',
    'Flexible online sessions — book anytime, anywhere',
    'Affordable peer-to-peer rates designed for students',
    'Secure payments with escrow protection',
]

const features = [
    {
        title: 'Book Instantly',
        desc: 'Find availability and confirm your session in seconds.',
        // Calendar icon
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>',
    },
    {
        title: 'Live Video Sessions',
        desc: 'Browser-based video — no downloads, no friction.',
        // Video camera icon
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z"/>',
    },
    {
        title: 'Verified Tutors',
        desc: 'Every tutor passes academic and identity verification.',
        // Shield check icon
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>',
    },
]


const benefits = [
    { title: 'Affordable Rates',             desc: 'Peer tutoring at prices students can actually afford' },
    { title: 'Same Curriculum Understanding', desc: 'Tutors who recently took the same courses you\'re struggling with' },
    { title: 'Mobile & Web Access',           desc: 'Book and manage sessions from anywhere, anytime' },
]

const contacts = [
    {
        href: 'mailto:Info@teachmeapp.co.za',
        attrs: {},
        gradient: 'linear-gradient(135deg,#FF6B35,#FFC914)',
        viewBox: '0 0 24 24',
        svgFill: 'none',
        title: 'Email Us',
        subtitle: 'Get a response within 24 hours',
        label: 'Info@teachmeapp.co.za',
        // Envelope icon
        icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>',
    },
    {
        href: 'https://wa.me/27713364034',
        attrs: { target: '_blank', rel: 'noopener' },
        gradient: 'linear-gradient(135deg,#4A90E2,#03a65a)',
        viewBox: '0 0 32 32',
        svgFill: 'none',
        title: 'WhatsApp Us',
        subtitle: 'Chat with us instantly',
        label: '+27 71 336 4034',
        // WhatsApp icon
        icon: '<path fill="white" d="M16 3C8.82 3 3 8.82 3 16c0 2.3.6 4.47 1.66 6.35L3 29l6.82-1.63A13 13 0 0016 29c7.18 0 13-5.82 13-13S23.18 3 16 3z"/><path fill="#25D366" d="M16 5C9.93 5 5 9.93 5 16c0 2.06.55 4 1.5 5.66L5 27l5.5-1.47A10.96 10.96 0 0016 27c6.07 0 11-4.93 11-11S22.07 5 16 5z"/><path fill="white" d="M22.11 19.46c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07a8.17 8.17 0 01-2.4-1.48 9 9 0 01-1.66-2.07c-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51H12.2c-.2 0-.52.07-.79.37-.27.3-1.03 1-1.03 2.46 0 1.45 1.05 2.86 1.2 3.06.15.2 2.07 3.16 5.01 4.43.7.3 1.25.48 1.67.62.7.22 1.34.19 1.84.11.56-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35z"/>',
    },
]
</script>

<style scoped>
/* ── CSS Variables ──────────────────────────────────────────── */
:root {
    --green-primary: #058248;
    --green-light: #03a65a;
    --orange: #FF6B35;
    --yellow: #FFC914;
    --blue: #4A90E2;
    --coral: #FF5A5F;
    --purple: #9B59B6;
}

/* ── Animations ─────────────────────────────────────────────── */
.fade-up  { animation: fadeUp .8s cubic-bezier(.22,1,.36,1) both; }
.delay-1  { animation-delay: .12s; }
.delay-2  { animation-delay: .24s; }
.delay-3  { animation-delay: .40s; }
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Hero ───────────────────────────────────────────────────── */
.hero-section {
    position: relative;
    min-height: 85vh;
    background: linear-gradient(135deg, #058248 0%, #03a65a 100%);
    display: flex;
    align-items: center;
    overflow: hidden;
}
.hero-bg-img {
    position: absolute;
    inset: 0;
    background: url('https://img.freepik.com/free-photo/happy-university-students-using-laptop-while-sitting-hallway_637285-9244.jpg') center/cover no-repeat;
    opacity: .15;
}
.hero-shapes { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
.shape { position: absolute; border-radius: 50%; opacity: .1; animation: floatShape 20s infinite; }
.shape-1 { width: 300px; height: 300px; background: #FF6B35; top: 10%; left: -5%; animation-delay: 0s; }
.shape-2 { width: 200px; height: 200px; background: #FFC914; bottom: 20%; right: 10%; animation-delay: 5s; }
.shape-3 { width: 150px; height: 150px; background: #4A90E2; top: 60%; left: 15%; animation-delay: 10s; }
@keyframes floatShape {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50%       { transform: translateY(-30px) rotate(180deg); }
}
.hero-content {
    position: relative;
    z-index: 2;
    padding-top: 5rem;
    padding-bottom: 5rem;
    width: 100%;
}
.hero-heading {
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.25rem;
    text-shadow: 0 2px 10px rgba(0,0,0,.2);
}
.hero-lead {
    font-size: 1.15rem;
    margin-bottom: 1.75rem;
    color: rgba(255,255,255,.92);
    max-width: 480px;
    line-height: 1.7;
}
.hero-img-wrap { position: relative; }
.hero-img-wrap::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #FF6B35, #FFC914);
    border-radius: 20px;
    transform: rotate(-6deg);
    z-index: -1;
    opacity: .2;
}
.hero-img { max-height: 480px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.2); }

/* ── Buttons ────────────────────────────────────────────────── */
.btn-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    background: #fff;
    color: #058248;
    padding: .85rem 2.2rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: .95rem;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,.2);
    transition: transform .22s, box-shadow .22s;
    cursor: pointer;
    text-decoration: none;
}
.btn-cta-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.28); color: #058248; }

.btn-cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    background: transparent;
    color: #fff;
    padding: .85rem 2.2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: .95rem;
    border: 2px solid #fff;
    transition: background .22s, color .22s;
    cursor: pointer;
    text-decoration: none;
}
.btn-cta-secondary:hover { background: #fff; color: #058248; }

/* ── Hero Search ────────────────────────────────────────────── */
.hero-search {
    display: flex;
    align-items: center;
    max-width: 480px;
    background: #fff;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
}
.search-icon { width: 18px; height: 18px; color: #9ca3af; flex-shrink: 0; margin-left: 1.2rem; }
.search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: .9rem 1rem;
    font-size: .9rem;
    color: #374151;
    background: transparent;
}
.search-btn {
    background: #058248;
    color: #fff;
    border: none;
    padding: .85rem 1.4rem;
    font-weight: 600;
    font-size: .85rem;
    cursor: pointer;
    transition: background .2s;
}
.search-btn:hover { background: #046b3c; }

/* ── Section commons ────────────────────────────────────────── */
.section-pad { padding: 5rem 0; }
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: .75rem;
    position: relative;
    display: inline-block;
}
.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #FF6B35, #FFC914);
    border-radius: 2px;
}
.after-left::after { left: 0; transform: none; }
.section-subtitle { font-size: 1.05rem; color: #718096; max-width: 560px; margin: 1.5rem auto 0; }

/* ── Step cards ─────────────────────────────────────────────── */
.step-card { position: relative; padding-left: 5rem; }
.step-number {
    position: absolute;
    left: 0;
    top: 0;
    width: 62px;
    height: 62px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,.18);
}
.step-num--1 { background: linear-gradient(135deg, #FF6B35, #FFC914); }
.step-num--2 { background: linear-gradient(135deg, #4A90E2, #03a65a); }
.step-num--3 { background: linear-gradient(135deg, #FF5A5F, #9B59B6); }
.step-title { font-size: 1.2rem; font-weight: 600; color: #2d3748; margin-bottom: .4rem; }
.step-desc  { color: #718096; line-height: 1.65; font-size: .95rem; }

/* ── Badge ──────────────────────────────────────────────────── */
.badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .35rem 1rem;
    border-radius: 50px;
    font-size: .75rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
}
.badge-orange { background: linear-gradient(135deg, #FF6B35, #FFC914); }

/* ── Image decoration ───────────────────────────────────────── */
.img-deco-wrap { position: relative; }
.img-deco-wrap::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #FF6B35, #FFC914);
    border-radius: 20px;
    transform: rotate(-6deg);
    z-index: -1;
    opacity: .18;
}
.img-deco { border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.13); width: 100%; object-fit: cover; }

/* ── Split section text ─────────────────────────────────────── */
.split-title { font-size: 1.9rem; font-weight: 700; color: #2d3748; margin-bottom: .75rem; }
.split-body  { font-size: 1.05rem; color: #718096; line-height: 1.7; }
.check-dot {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #058248;
    color: #fff;
    font-size: 11px;
    flex-shrink: 0;
}

/* ── Feature cards ──────────────────────────────────────────── */
.feature-card {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    background: #fff;
    border-radius: 16px;
    padding: 1.75rem;
    border: 2px solid transparent;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform .25s, box-shadow .25s, border-color .25s;
    position: relative;
    overflow: hidden;
}
.feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
}
.feature-card--1::before { background: linear-gradient(90deg, #FF6B35, #FFC914); }
.feature-card--2::before { background: linear-gradient(90deg, #4A90E2, #03a65a); }
.feature-card--3::before { background: linear-gradient(90deg, #FF5A5F, #9B59B6); }
.feature-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,.12); border-color: #058248; }

.feature-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.feature-icon--1 { background: linear-gradient(135deg, #FF6B35, #FFC914); }
.feature-icon--2 { background: linear-gradient(135deg, #4A90E2, #03a65a); }
.feature-icon--3 { background: linear-gradient(135deg, #FF5A5F, #9B59B6); }
.feature-title { font-size: 1.1rem; font-weight: 600; color: #2d3748; margin-bottom: .35rem; }
.feature-desc  { font-size: .9rem; color: #718096; }

/* ── Benefits list ──────────────────────────────────────────── */
.benefit-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: .85rem;
    border-radius: 10px;
    margin-bottom: .5rem;
    transition: background .2s, transform .2s;
}
.benefit-item:hover { background: #f7fafc; transform: translateX(8px); }
.benefit-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.benefit-icon--1 { background: linear-gradient(135deg, #FF6B35, #FFC914); }
.benefit-icon--2 { background: linear-gradient(135deg, #4A90E2, #03a65a); }
.benefit-icon--3 { background: linear-gradient(135deg, #FF5A5F, #9B59B6); }
.benefit-title { font-size: 1.05rem; font-weight: 600; color: #2d3748; margin-bottom: .15rem; }
.benefit-desc  { font-size: .875rem; color: #718096; margin: 0; }

/* ── Tutor CTA Section ──────────────────────────────────────── */
.tutor-cta-section {
    background: linear-gradient(135deg, #058248 0%, #03a65a 100%);
    color: #fff;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}
.tutor-cta-circle-1 {
    position: absolute;
    top: -50%; right: -10%;
    width: 500px; height: 500px;
    background: #FFC914;
    border-radius: 50%;
    opacity: .08;
}
.tutor-cta-circle-2 {
    position: absolute;
    bottom: -30%; left: -5%;
    width: 400px; height: 400px;
    background: #FF6B35;
    border-radius: 50%;
    opacity: .08;
}
.tutor-cta-img {
    width: 100%;
    border-radius: 50%;
    object-fit: cover;
    aspect-ratio: 1;
    max-height: 380px;
    box-shadow: 0 20px 60px rgba(0,0,0,.28);
    border: 8px solid rgba(255,255,255,.18);
}

/* ── App Section ────────────────────────────────────────────── */
.app-section {
    background: linear-gradient(135deg, #f7fafc 0%, #e6f7f1 100%);
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}
.app-blob-1 {
    position: absolute;
    top: 0; right: 0;
    width: 300px; height: 300px;
    background: #03a65a;
    border-radius: 50%;
    opacity: .05;
    transform: translate(30%, -30%);
}
.app-badge { transition: transform .2s; }
.app-badge:hover { transform: scale(1.05); }

/* ── Contact cards ──────────────────────────────────────────── */
.contact-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    border-left: 4px solid #058248;
    box-shadow: 0 4px 15px rgba(0,0,0,.07);
    transition: transform .25s, box-shadow .25s;
    text-decoration: none;
}
.contact-card:hover { transform: translateY(-5px); box-shadow: 0 10px 28px rgba(0,0,0,.12); }
.contact-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

/* ── Modal ──────────────────────────────────────────────────── */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1.5rem;
}
.modal-box {
    background: #fff;
    border-radius: 16px;
    max-width: 620px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 24px 64px rgba(0,0,0,.2);
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e9eef4;
}
.modal-close {
    font-size: 1.5rem;
    color: #718096;
    background: none;
    border: none;
    cursor: pointer;
    line-height: 1;
}
.modal-body { padding: 1.5rem; }
.modal-footer {
    display: flex;
    gap: .75rem;
    justify-content: flex-end;
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #e9eef4;
}
.modal-btn-cancel {
    padding: .6rem 1.25rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #718096;
    font-weight: 500;
    cursor: pointer;
}
.modal-btn-apply {
    padding: .6rem 1.5rem;
    border-radius: 8px;
    background: #058248;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}

/* ── Responsive ─────────────────────────────────────────────── */
@media (max-width: 768px) {
    .hero-heading { font-size: 2rem; }
    .hero-lead    { font-size: 1rem; }
    .section-title { font-size: 1.8rem; }
    .shape { display: none; }
}
</style>