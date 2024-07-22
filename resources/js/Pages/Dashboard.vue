<!-- resources/js/Pages/Dashboard.vue -->
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="flex">
            <Sidebar :tab="tab" @update:tab="navigateTo" />

            <div class="flex-1 py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <template v-if="no_access">
                                <div class="text-center text-red-500">
                                    <h1 class="text-4xl font-bold mb-4">Нет доступа</h1>
                                    <p class="text-xl">У вас нет доступа к этой странице.</p>
                                </div>
                            </template>
                            <template v-else>
                                <div v-if="loading" class="text-center">
                                    <p>Загрузка данных...</p>
                                </div>
                                <div v-else>
                                    <div v-if="tab === 'categories'">
                                        <Categories :categories="cachedCategories" @data-changed="fetchData(tab)" />
                                    </div>
                                    <div v-if="tab === 'groups'">
                                        <Groups :groups="cachedGroups" @data-changed="fetchData(tab)" />
                                    </div>
                                    <div v-if="tab === 'items'">
                                        <Items :items="cachedItems" :categories="cachedCategories" @data-changed="fetchData(tab)" />
                                    </div>
                                    <div v-if="tab === 'users'">
                                        <Users :users="cachedUsers" :groups="cachedGroups" @data-changed="fetchData(tab)" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';
import Categories from '@/Components/Admin/Categories.vue';
import Groups from '@/Components/Admin/Groups.vue';
import Items from '@/Components/Admin/Items.vue';
import Users from '@/Components/Admin/Users.vue';

const props = defineProps(['categories', 'groups', 'items', 'users', 'no_access']);

const tab = ref('categories');
const no_access = ref(props.no_access);
const loading = ref(false);

const categories = ref(props.categories);
const groups = ref(props.groups);
const items = ref(props.items);
const users = ref(props.users);

const cachedCategories = ref(props.categories);
const cachedGroups = ref(props.groups);
const cachedItems = ref(props.items);
const cachedUsers = ref(props.users);

async function navigateTo(newTab) {
    if (tab.value !== newTab) {
        tab.value = newTab;
    }
    await fetchData(newTab);
}

async function fetchData(tab) {
    loading.value = true;
    try {
        if (tab === 'categories') {
            const response = await axios.get(route('categories.index'));
            cachedCategories.value = response.data;
        } else if (tab === 'groups') {
            const response = await axios.get(route('groups.index'));
            cachedGroups.value = response.data;
        } else if (tab === 'items') {
            const response = await axios.get(route('items.index'));
            cachedItems.value = response.data;
        } else if (tab === 'users') {
            const response = await axios.get(route('users.index'));
            cachedUsers.value = response.data;
        }
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

onMounted(async () => {
    await fetchData(tab.value);
});
</script>

<style scoped>
.flex {
    display: flex;
}
.flex-1 {
    flex: 1;
}
</style>
