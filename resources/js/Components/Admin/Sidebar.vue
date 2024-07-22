<template>
    <div class="bg-gray-800 text-white h-screen">
        <div class="p-4">
            <nav>
                <ul>
                    <li @click="changeTab('categories')" :class="{'bg-gray-700': tab === 'categories'}" class="cursor-pointer p-2 mb-2 rounded">Категории</li>
                    <li @click="changeTab('groups')" :class="{'bg-gray-700': tab === 'groups'}" class="cursor-pointer p-2 mb-2 rounded">Группы</li>
                    <li @click="changeTab('items')" :class="{'bg-gray-700': tab === 'items'}" class="cursor-pointer p-2 mb-2 rounded">Товары</li>
                    <li @click="changeTab('users')" :class="{'bg-gray-700': tab === 'users'}" class="cursor-pointer p-2 mb-2 rounded">Пользователи</li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps(['tab']);
const emit = defineEmits(['update:tab']);

function changeTab(newTab) {
    emit('update:tab', newTab);
}
</script>

<style scoped>
.bg-gray-700 {
    background-color: #374151;
}
</style>
