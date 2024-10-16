<template>
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
    <div class="p-6 text-gray-400">
      <h5 class="text-lg font-bold">Roles List</h5>
      <p class="mb-4">
        A role provides access to predefined menus and features, allowing administrators to manage user access based on their roles.
      </p>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="role in roles" :key="role.id" class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
<!--          <p>Total {{ role.users.count() }} user{{ role.users.count() === 1 ? '' : 's' }}</p>-->
          <h3  class="text-lg font-semibold">{{ role.name }}</h3>
          <a href="{{ route('role-edit', role.id) }}" class="text-blue-500 hover:underline ">Edit role</a>
        </div>
      </div>
      <div class="bg-white-100 p-4 pt-8 rounded-lg shadow-md block hover:bg-gray-100">
        <a @click="showForm = true" class="text-white mt-6 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add New Role</a>
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

    </div>
  </div>
</template>

<script setup>
import RoleCreate from "./role-create.vue";
import {onMounted, ref} from 'vue';
import axios from 'axios';
import {isDisabled} from "bootstrap/js/src/util/index.js";
// defineProps({
//   roles: Array
// });
const showForm = ref(false);
const newRole = ref('');
const roles = ref();
const fetchRole = async () => {
  try {
    const response = await axios.get('/roles', );
    console.log('Roles:', response.data.result);
    roles.value = response.data.result;
  } catch (error) {
    console.error('Error creating role:', error);
  }
};
const submitRole = async () => {
  try {
    const response = await axios.post('/role/create', { name: newRole.value });
    console.log('Role created successfully:', response.data.result);
    roles.value.push(response.data.result);
    showForm.value = false;
    newRole.value = '';
  } catch (error) {
    console.error('Error creating role:', error);
  }
};
onMounted(()=>{
  fetchRole();
})
</script>
