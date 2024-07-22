<!-- resources/js/Components/Admin/Groups.vue -->
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
            <li v-for="group in groups" :key="group.id" class="flex justify-between items-center p-2 border rounded">
                <span>{{ group.name || '-' }} - {{ group.description || '-' }}</span>
                <div>
                    <button @click="editGroup(group)" class="bg-yellow-500 text-white p-1 rounded ml-2">Редактировать</button>
                    <button @click="deleteGroup(group.id)" class="bg-red-500 text-white p-1 rounded ml-2">Удалить</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['groups']);
const emit = defineEmits(['data-changed']);

const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    description: ''
});

function submitForm() {
    if (isEditing.value) {
        form.put(route('groups.update', form.id), {
            onSuccess: () => {
                form.reset();
                isEditing.value = false;
                emit('data-changed');
            }
        });
    } else {
        form.post(route('groups.store'), {
            onSuccess: () => {
                form.reset();
                emit('data-changed');
            }
        });
    }
}

function editGroup(group) {
    form.id = group.id;
    form.name = group.name;
    form.description = group.description;
    isEditing.value = true;
}

function cancelEdit() {
    form.reset();
    isEditing.value = false;
}

function deleteGroup(id) {
    form.delete(route('groups.destroy', id), {
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
