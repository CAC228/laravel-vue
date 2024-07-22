<template>
    <div class="flex h-screen bg-gray-100">
        <Sidebar />
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>
            <main class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
</script>