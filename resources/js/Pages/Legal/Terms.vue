<template>
    <div class="min-h-screen" style="background:#f9fafb;">
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <img src="/assets/img/logo.svg" alt="TeachMe App" class="w-8 h-8" />
                <span class="font-bold text-lg" style="color:#141F3E;">TeachMe App</span>
            </a>
            <a href="/login" class="text-sm font-semibold" style="color:#007B43;">Sign in</a>
        </header>

        <main class="max-w-3xl mx-auto px-6 py-12">
            <div class="mb-10">
                <span class="text-xs font-semibold uppercase tracking-widest" style="color:#007B43;">Legal</span>
                <h1 class="text-3xl font-bold mt-2" style="color:#141F3E;">Terms of Service</h1>
                <p class="text-gray-500 mt-2">Effective date: 1 June 2025 · Last updated: 20 May 2026</p>
            </div>

            <div class="space-y-10 text-sm text-gray-600 leading-relaxed">

                <section v-for="section in sections" :key="section.title">
                    <h2 class="text-xl font-semibold mb-3" style="color:#141F3E;">{{ section.title }}</h2>
                    <div v-html="section.html" class="space-y-3"></div>
                </section>

                <section>
                    <h2 class="text-xl font-semibold mb-3" style="color:#141F3E;">11. Contact</h2>
                    <div class="rounded-xl border border-gray-200 p-5 space-y-1">
                        <p><strong>TeachMe App (Pty) Ltd</strong></p>
                        <p>Legal enquiries: legal@teachme.co.za</p>
                        <p>Registered office: Cape Town, South Africa</p>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>

<script setup>
const sections = [
    {
        title: '1. Acceptance of terms',
        html: `<p>By creating an account or using the TeachMe App platform, you agree to be bound by these Terms of
               Service and our Privacy Policy. If you do not agree, do not use the platform.</p>`
    },
    {
        title: '2. Description of service',
        html: `<p>TeachMe App is an online marketplace that connects students with independent tutors. We provide the
               technology platform; tutors are independent contractors, not employees of TeachMe App. TeachMe App does not
               guarantee the quality, safety, or legality of tutor services.</p>`
    },
    {
        title: '3. Eligibility',
        html: `<ul class="list-disc pl-5 space-y-1">
                 <li>You must be at least 13 years old to create an account.</li>
                 <li>Users under 18 must have a parent or guardian register a Guardian account and link it to the student account.</li>
                 <li>By accepting these terms you confirm you have the legal capacity to enter a binding contract.</li>
               </ul>`
    },
    {
        title: '4. Account responsibilities',
        html: `<ul class="list-disc pl-5 space-y-1">
                 <li>You are responsible for keeping your password confidential.</li>
                 <li>You must not share your account or allow others to access your sessions.</li>
                 <li>You must provide accurate registration information and keep it current.</li>
                 <li>You are responsible for all activity that occurs under your account.</li>
               </ul>`
    },
    {
        title: '5. Bookings, payments, and escrow',
        html: `<p>When a student books a session, the session fee is held in escrow. Funds are released to the tutor
               within <strong>48 hours</strong> of a successfully completed session. Disputed sessions are subject
               to our dispute resolution process. Refunds are governed by our Refund Policy, available on request.</p>`
    },
    {
        title: '6. Prohibited conduct',
        html: `<p>You must not:</p>
               <ul class="list-disc pl-5 space-y-1">
                 <li>Use the platform for any unlawful purpose.</li>
                 <li>Harass, threaten, or abuse other users.</li>
                 <li>Attempt to circumvent platform fees by arranging off-platform payments.</li>
                 <li>Upload content that infringes third-party intellectual property rights.</li>
                 <li>Reverse-engineer or scrape the platform.</li>
               </ul>`
    },
    {
        title: '7. Intellectual property',
        html: `<p>All platform software, design, and branding are owned by or licensed to TeachMe App. You retain
               ownership of content you upload (profile information, session materials) and grant TeachMe App a
               limited licence to display and transmit that content for the purpose of providing the service.</p>`
    },
    {
        title: '8. Limitation of liability',
        html: `<p>To the maximum extent permitted by South African law, TeachMe App's liability for any claim arising
               out of or relating to these terms is limited to the fees paid by you in the <strong>3 months</strong>
               preceding the claim. TeachMe App is not liable for indirect, incidental, or consequential damages.</p>`
    },
    {
        title: '9. Governing law',
        html: `<p>These terms are governed by the laws of the Republic of South Africa. Any dispute shall be
               submitted to the jurisdiction of the Western Cape High Court, Cape Town, subject to the right of
               either party to seek urgent relief in any competent court.</p>`
    },
    {
        title: '10. Changes to these terms',
        html: `<p>We may update these terms at any time. Material changes will be communicated by email and
               in-app notification at least <strong>14 days</strong> before they take effect. Continued use of
               the platform after the effective date constitutes acceptance of the revised terms.</p>`
    },
]
</script>