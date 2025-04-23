<script setup>
import { Head, Link } from '@inertiajs/vue3';
// Layouts
import Header from '@/Layouts/Header.vue';
import Footer from '@/Layouts/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <Header />
        <!-- Hero Section Slideshow -->
        <div class="flex flex-col items-center justify-center w-full h-[560px] bg-cover bg-center bg-no-repeat bg-[url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fGdyYXJkZW5pbmd8ZW58MHx8fHwxNjg3NTY1NzA0&ixlib=rb-4.0.3&q=80&w=1080')]">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                Welcome to Smart Sprouts
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                Your one-stop solution for all your gardening needs.
            </p>
            <Link
                :href="route('user.register')"
                class="mt-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            >
                Get Started
            </Link>
        </div>
        <!-- Main Contents -->
        <main class="flex flex-col items-center justify-center w-full max-w-7xl mx-auto px-4 py-8">
            <!-- Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 1</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 1 goes here.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 2</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 2 goes here.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 3</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 3 goes here.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 4</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 4 goes here.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 5</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 5 goes here.
                    </p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Feature 6</h2>
                    <p class="mt-2 text-gray-600">
                        Description of feature 6 goes here.
                    </p>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <Footer />
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
