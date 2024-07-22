<!-- resources/js/Components/Admin/Categories.vue -->
<template>
    <div>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div class="flex space-x-4">
                <input v-model="form.name" placeholder="Название" class="border rounded p-2 w-full" />
                <input v-model="form.description" placeholder="Описание" class="border rounded p-2 w-full"></input>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                    {{ isEditing ? 'Обновить' : 'Добавить' }}
                </button>
                <button v-if="isEditing" @click="cancelEdit" class="bg-gray-500 text-white p-2 rounded">Отменить</button>
            </div>
        </form>
        <ul class="mt-4 space-y-2">
            <li v-for="category in categories" :key="category.id" class="flex justify-between items-center p-2 border rounded">
                <span>{{ category.name || '-' }} - {{ category.description || '-' }}</span>
                <div>
                    <button @click="editCategory(category)" class="bg-yellow-500 text-white p-1 rounded ml-2">Редактировать</button>
                    <button @click="deleteCategory(category.id)" class="bg-red-500 text-white p-1 rounded ml-2">Удалить</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['categories']);
const emit = defineEmits(['data-changed']);

const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    description: ''
});

function submitForm() {
    if (isEditing.value) {
        form.put(route('categories.update', form.id), {
            onSuccess: () => {
                form.reset();
                isEditing.value = false;
                emit('data-changed');
            }
        });
    } else {
        form.post(route('categories.store'), {
            onSuccess: () => {
                form.reset();
                emit('data-changed');
            }
        });
    }
}

function editCategory(category) {
    form.id = category.id;
    form.name = category.name;
    form.description = category.description;
    isEditing.value = true;
}

function cancelEdit() {
    form.reset();
    isEditing.value = false;
}

function deleteCategory(id) {
    form.delete(route('categories.destroy', id), {
        onSuccess: () => {
            form.reset();
            emit('data-changed');
        }
    });
}
</script>

<style scoped>
.flex {
    display: flex;
    gap: 10px;
}
.space-x-4 {
    gap: 16px;
}
.space-y-4 > * + * {
    margin-top: 16px;
}
.space-y-2 > * + * {
    margin-top: 8px;
}
</style>
