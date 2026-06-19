<template>
    <div class="min-h-screen bg-white flex flex-col">

        <!-- Nav -->
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md"
                style="border-bottom:1px solid rgba(0,0,0,.06);">
            <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
                <Link :href="route('home')" class="flex items-center gap-2 group">
<img src="/assets/img/logo.svg" alt="TeachMe App" class="h-8 w-auto" />
                    <span class="text-lg font-bold" style="color:#141F3E;">TeachMe App</span>
                </Link>

                <nav class="hidden md:flex items-center gap-8 font-medium text-gray-500">
                    <Link :href="route('how-it-works')" class="hover:text-gray-900 transition-colors">How it works</Link>
                    <Link :href="route('pricing')" class="hover:text-gray-900 transition-colors">Pricing</Link>
                </nav>

                <div class="flex items-center gap-3">
                    <Link :href="route('login')"
                          class="font-medium text-gray-600 hover:text-gray-900 transition-colors px-3 py-1.5">
                        Sign in
                    </Link>
                    <Link :href="route('register')"
                          class="font-semibold text-white px-4 py-2 rounded-xl transition-colors"
                          style="background:#007B43;" onmouseover="this.style.opacity='.9'"
                          onmouseout="this.style.opacity='1'">
                        Get started
                    </Link>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer style="background:#141F3E;">
            <div class="max-w-6xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2">
                    <img src="/assets/img/logo.svg" alt="TeachMe App" class="h-8 w-auto" />
                    <span class="text-white font-bold">TeachMe App</span>
                    <span class="ml-3 text-xs" style="color:rgba(255,255,255,.35);">© 2025 All rights reserved.</span>
                </div>
                <div class="flex gap-8 text-sm" style="color:rgba(255,255,255,.5);">
                    <Link :href="route('how-it-works')" class="hover:text-white transition-colors">How it works</Link>
                    <Link :href="route('pricing')"      class="hover:text-white transition-colors">Pricing</Link>
                    <Link :href="route('login')"        class="hover:text-white transition-colors">Sign in</Link>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

