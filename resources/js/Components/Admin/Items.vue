<template>
    <div>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div class="flex space-x-4">
                <input v-model="form.name" placeholder="Название" class="border rounded p-2 w-full" />
                <input v-model="form.description" placeholder="Описание" class="border rounded p-2 w-full"></input>
                <input v-model="form.price" placeholder="Цена" class="border rounded p-2 w-full" type="number" />
                <select v-model="form.category_id" class="border rounded p-2 w-full">
                    <option disabled value="">Выберите категорию</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                    {{ isEditing ? 'Обновить' : 'Добавить' }}
                </button>
                <button v-if="isEditing" @click="cancelEdit" class="bg-gray-500 text-white p-2 rounded">Отменить</button>
            </div>
        </form>
        <ul class="mt-4 space-y-2">
            <li v-for="item in items" :key="item.id" class="flex justify-between items-center p-2 border rounded">
                <span>{{ item.name || '-' }} - {{ item.description || '-' }} - {{ item.price || '-' }} - {{ item.category?.name || '-' }}</span>
                <div>
                    <button @click="editItem(item)" class="bg-yellow-500 text-white p-1 rounded ml-2">Редактировать</button>
                    <button @click="deleteItem(item.id)" class="bg-red-500 text-white p-1 rounded ml-2">Удалить</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['items', 'categories']);
const emit = defineEmits(['data-changed']);

const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    description: '',
    price: 0,
    category_id: null,
    hidden_for_groups: []
});

function submitForm() {
    if (isEditing.value) {
        form.put(route('items.update', form.id), {
            onSuccess: () => {
                form.reset();
                isEditing.value = false;
                emit('data-changed');
            }
        });
    } else {
        form.post(route('items.store'), {
            onSuccess: () => {
                form.reset();
                emit('data-changed');
            }
        });
    }
}

function editItem(item) {
    form.id = item.id;
    form.name = item.name;
    form.description = item.description;
    form.price = item.price;
    form.category_id = item.category_id;
    form.hidden_for_groups = item.hidden_for_groups || [];
    isEditing.value = true;
}

function cancelEdit() {
    form.reset();
    isEditing.value = false;
}

function deleteItem(id) {
    form.delete(route('items.destroy', id), {
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
