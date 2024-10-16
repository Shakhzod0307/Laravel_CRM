<template>
  <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    <form @submit.prevent="fetchUsers" class="max-w-full mb-7 mx-auto">
      <label for="default-search" class="mb-2 text-sm font-medium text-gray-700 sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input
          type="search"
          id="default-search"
          v-model="searchQuery"
          class="block w-full p-4 ps-10 text-black border border-gray-400 rounded-lg bg-gray-100 focus:ring-gray-500 focus:border-gray-500"
          placeholder="Search by name, email, or username..."
          required
        />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
          Search
        </button>
      </div>
    </form>

    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
      <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">ID</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Username</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Role</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
      </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
      <tr v-for="(user, index) in users" :key="user.id" class="hover:bg-gray-50">
        <td class="px-6 py-4">{{ index + 1 }}</td>
        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
          <div class="relative h-10 w-10">
            <img class="h-full w-full rounded-full object-cover object-center" src="/public/images/admin.jpg" alt="" />
            <span :class="user.status === 'active' ? 'absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white' : 'absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-400 ring ring-white'"></span>
          </div>
          <div class="text-sm">
            <div class="font-medium mt-3 text-gray-700">{{ user.first_name }} {{ user.last_name }}</div>
            <div class="text-gray-400">{{ user.email }}</div>
          </div>
        </th>
        <td class="px-6 py-4">
            <span :class="user.status === 'active' ? 'inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600' : 'inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600'">
              <span :class="user.status === 'active' ? 'h-1.5 w-1.5 rounded-full bg-green-600' : 'h-1.5 w-1.5 rounded-full bg-red-600'"></span>
              {{ user.status.charAt(0).toUpperCase() + user.status.slice(1) }}
            </span>
        </td>
        <td class="px-6 py-4">{{ user.username }}</td>
        <td class="px-6 py-4">
          <div class="flex gap-2">
              <span v-for="role in user.roles" :key="role.id" :class="roleClass(role.name)">
                {{ role.name }}
              </span>
          </div>
        </td>
        <td class="px-6 py-4">
          <div class="flex justify-end gap-4">
            <a :href="`/chat/${user.id}`" class="bg-gray-100 p-4 rounded-lg shadow-md block hover:bg-green-200">
              Send message
            </a>
          </div>
        </td>

      </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-center m-7">
      <button @click="changePage(page - 1)" :disabled="page <= 1" class="px-4 py-2 bg-gray-300 rounded-l-lg">Previous</button>
      <span class="mx-2 m-3" >{{ page }} / {{ totalPages }}</span>
      <button @click="changePage(page + 1)" :disabled="page >= totalPages" class="px-4 py-2 bg-gray-300  rounded-r-lg">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const users = ref([]);
const searchQuery = ref('');
const page = ref(1);
const totalPages = ref(0);

const fetchUsers = async () => {

  try {
    const response = await axios.get(`/api/users`, {
      params: {
        search: searchQuery.value,
        page: page.value,
      },
    });
    // console.log(response.data.data);
    users.value = response.data.data.data;
    totalPages.value = response.data.data.last_page;
  } catch (error) {
    console.error("Error fetching users:", error);
  }
};
watch(searchQuery, () => {
  page.value = 1;
  fetchUsers();
});
const changePage = (newPage) => {
  if (newPage >= 1 && newPage <= totalPages.value) {
    page.value = newPage;
    fetchUsers();
  }
};
fetchUsers();
const roleClass = (role) => {
  switch (role) {
    case 'Administrator':
      return 'bg-blue-100 text-blue-600 rounded-md px-2 py-1 text-xs';
    case 'Manager':
      return 'bg-cyan-100 text-cyan-600 rounded-md px-2 py-1 text-xs';
    case 'Editor':
      return 'bg-yellow-100 text-yellow-600 rounded-md px-2 py-1 text-xs';
    case 'User':
      return 'bg-green-100 text-green-600 rounded-md px-2 py-1 text-xs';
    default:
      return 'bg-gray-100 text-gray-600 rounded-md px-2 py-1 text-xs';
  }
};
</script>

<style scoped>

</style>
