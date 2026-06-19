<template>
    <div class="min-h-screen" style="background:#f9fafb;">
        <!-- Nav bar -->
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
                <h1 class="text-3xl font-bold mt-2" style="color:#141F3E;">Privacy Policy</h1>
                <p class="text-gray-500 mt-2">Effective date: 1 June 2025 · Last updated: 20 May 2026</p>
                <div class="mt-4 p-4 rounded-xl text-sm"
                     style="background:rgba(0,123,67,.06);border:1px solid rgba(0,123,67,.2);color:#005c32;">
                    This policy is written in compliance with the <strong>Protection of Personal Information Act 4 of 2013
                    (POPIA)</strong> of the Republic of South Africa.
                </div>
            </div>

            <div class="prose-section space-y-10">

                <section v-for="section in sections" :key="section.title">
                    <h2 class="text-xl font-semibold mb-3" style="color:#141F3E;">{{ section.title }}</h2>
                    <div class="text-gray-600 text-sm leading-relaxed space-y-3"
                         v-html="section.html"></div>
                </section>

                <!-- Contact -->
                <section>
                    <h2 class="text-xl font-semibold mb-3" style="color:#141F3E;">10. Contact our Information Officer</h2>
                    <div class="rounded-xl border border-gray-200 p-5 text-sm text-gray-700 space-y-1">
                        <p><strong>TeachMe App (Pty) Ltd</strong></p>
                        <p>Information Officer: privacy@teachme.co.za</p>
                        <p>Postal address: PO Box 1234, Cape Town, 8001</p>
                        <p>Tel: +27 21 000 0000</p>
                        <p class="pt-2 text-xs text-gray-500">
                            To lodge a complaint with the regulator:
                            <a href="https://www.justice.gov.za/inforeg/" target="_blank"
                               class="underline" style="color:#007B43;">
                                Information Regulator of South Africa
                            </a>
                        </p>
                    </div>
                </section>
            </div>
        </main>
    </div>
</template>

<script setup>
const sections = [
    {
        title: '1. Who we are',
        html: `<p>TeachMe App (Pty) Ltd (<strong>"TeachMe App", "we", "us"</strong>) operates the TeachMe App online tutoring
               marketplace accessible at <strong>teachme.co.za</strong>. We are the responsible party (controller)
               for personal information processed through the platform.</p>`
    },
    {
        title: '2. Information we collect',
        html: `<ul class="list-disc pl-5 space-y-1">
                 <li><strong>Account data</strong> — full name, email address, chosen role (student / tutor).</li>
                 <li><strong>Profile data</strong> — bio, subjects, timezone, profile photograph (optional).</li>
                 <li><strong>Identity & qualification documents</strong> — uploaded during KYC verification (tutors only).</li>
                 <li><strong>Payment data</strong> — processed by our PCI-DSS compliant gateway partners; we store transaction references only.</li>
                 <li><strong>Session data</strong> — booking records, session attendance, chat messages, poll responses.</li>
                 <li><strong>Device & network data</strong> — IP address, browser user-agent, timestamps — for security and audit purposes.</li>
                 <li><strong>Consent records</strong> — timestamp, IP address, and user-agent recorded at the moment you accept these policies.</li>
               </ul>`
    },
    {
        title: '3. Purpose and lawful basis',
        html: `<p>We process your personal information for the following purposes, each grounded in a POPIA-recognised
               lawful basis:</p>
               <table class="w-full text-xs mt-3 border border-gray-200 rounded-lg overflow-hidden">
                 <thead style="background:#f3f4f6;">
                   <tr>
                     <th class="text-left p-3 font-semibold text-gray-700">Purpose</th>
                     <th class="text-left p-3 font-semibold text-gray-700">Lawful basis</th>
                   </tr>
                 </thead>
                 <tbody class="divide-y divide-gray-100">
                   <tr><td class="p-3">Account creation and management</td><td class="p-3">Consent / Contract performance</td></tr>
                   <tr><td class="p-3">Matching students with tutors</td><td class="p-3">Contract performance</td></tr>
                   <tr><td class="p-3">Processing payments</td><td class="p-3">Contract performance</td></tr>
                   <tr><td class="p-3">KYC identity verification</td><td class="p-3">Legal obligation</td></tr>
                   <tr><td class="p-3">Fraud prevention & security</td><td class="p-3">Legitimate interest</td></tr>
                   <tr><td class="p-3">Audit logging</td><td class="p-3">Legal obligation / Legitimate interest</td></tr>
                   <tr><td class="p-3">Service communications</td><td class="p-3">Consent / Contract performance</td></tr>
                 </tbody>
               </table>`
    },
    {
        title: '4. Sharing of personal information',
        html: `<p>We do not sell your personal information. We share it only with:</p>
               <ul class="list-disc pl-5 space-y-1">
                 <li><strong>Payment processors</strong> (PayFast, Ozow) — solely to complete transactions.</li>
                 <li><strong>Video infrastructure</strong> (Agora) — channel tokens required to join live sessions.</li>
                 <li><strong>Cloud hosting</strong> — servers located in South Africa or equivalent-jurisdiction regions.</li>
                 <li><strong>Regulators</strong> — when required by law or court order.</li>
               </ul>`
    },
    {
        title: '5. Retention',
        html: `<p>We retain your personal information for as long as your account is active, plus a further
               <strong>5 years</strong> as required by South African financial and tax law. KYC documents are
               retained for <strong>5 years</strong> from the date of verification. You may request deletion of
               non-legally-required data at any time (see section 7).</p>`
    },
    {
        title: '6. Security',
        html: `<p>We employ industry-standard controls including TLS encryption in transit, bcrypt password hashing,
               role-based access control, and comprehensive audit logging. We maintain an incident response procedure
               and will notify you and the Information Regulator within the prescribed timeframes in the event of a
               reportable data breach.</p>`
    },
    {
        title: '7. Your rights under POPIA',
        html: `<ul class="list-disc pl-5 space-y-1">
                 <li><strong>Access</strong> — request a copy of the personal information we hold about you.</li>
                 <li><strong>Correction</strong> — ask us to correct inaccurate or incomplete information.</li>
                 <li><strong>Deletion</strong> — request erasure of data we are not legally obliged to retain.</li>
                 <li><strong>Objection</strong> — object to processing based on legitimate interest.</li>
                 <li><strong>Withdrawal of consent</strong> — withdraw consent at any time; this will not affect
                     the lawfulness of prior processing.</li>
                 <li><strong>Complaint</strong> — lodge a complaint with the Information Regulator of South Africa.</li>
               </ul>
               <p>Submit requests to <a href="mailto:privacy@teachme.co.za" class="underline" style="color:#007B43;">
               privacy@teachme.co.za</a>. We will respond within <strong>30 days</strong>.</p>`
    },
    {
        title: '8. Cookies',
        html: `<p>We use strictly necessary session cookies to maintain your login state. No third-party advertising
               or tracking cookies are set. You may disable cookies in your browser settings, but the platform
               will not function correctly without session cookies.</p>`
    },
    {
        title: '9. Changes to this policy',
        html: `<p>We will notify you by email and in-app notification at least <strong>14 days</strong> before any
               material changes take effect. Continued use of the platform after the effective date constitutes
               acceptance of the revised policy.</p>`
    },
]
</script>