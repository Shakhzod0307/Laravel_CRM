<template>
  <div class="bg-white-100 p-4 pt-8 rounded-lg shadow-md block hover:bg-gray-100">
    <a href="#" @click="showForm = true" class="text-white mt-6 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add New Role</a>
    <h6 class="mt-6">Add new role, if it doesn't exist.</h6>

    <div v-if="showForm" class="mt-4">
      <form @submit.prevent="submitRole">
        <div class="mb-4">
          <label for="roleName" class="block text-sm font-medium text-gray-700">Role Name</label>
          <input type="text" id="roleName" v-model="newRole" class="border p-2 w-full rounded-md" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Role</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
const showForm = ref(false);
const newRole = ref('');

const submitRole = async () => {
  try {
    const response = await axios.post('/role/create', { name: newRole.value });
    console.log('Role created successfully:', response.data);
    showForm.value = false;
    newRole.value = '';
  } catch (error) {
    console.error('Error creating role:', error);
  }
};
</script>
