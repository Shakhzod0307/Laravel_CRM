<template>
  <div class="container">
    <div class="card mt-5">
      <h3 class="card-header p-3">
        <i class="fa fa-star"></i> Import Export Excel to Database
      </h3>

      <div class="card-body">
        <!-- Success Alert -->
        <div v-if="successMessage" class="alert alert-success" role="alert">
          {{ successMessage }}
        </div>

        <!-- Error Alert -->
        <div v-if="errors" class="alert alert-danger">
          <strong>Whoops!</strong> There were some problems with your input.
          <ul>
            <li>{{ errors }}</li>
          </ul>
        </div>

        <!-- File Upload Form -->
        <form @submit.prevent="importUsers" enctype="multipart/form-data">
          <input type="file" ref="fileInput" class="form-control" />
          <br />
          <button class="btn btn-success">
            <i class="fa fa-file"></i> Import User Data
          </button>
        </form>

        <!-- Add/Drop Column Buttons -->
        <button @click="ShowNewColumn = !ShowNewColumn" class="btn btn-primary mt-2">
          <i class="fa fa-plus"></i> Add Column
        </button>
        <button @click="ShowDropColumn = !ShowDropColumn" class="btn btn-danger mt-2">
          <i class="fa fa-trash"></i> Drop Column
        </button>

        <!-- Add Column Form -->
        <div v-if="ShowNewColumn" class="mb-3 mt-2">
          <form class="d-flex" @submit.prevent="SubmitColumn">
            <input
              v-model="newColumnName"
              type="text"
              class="form-control w-20"
              placeholder="Enter column name"
            />
            <button class="btn btn-primary">Send</button>
          </form>
        </div>

        <!-- Drop Column Form -->
        <div v-if="ShowDropColumn" class="mb-3 mt-2">
          <form class="d-flex" @submit.prevent="SubmitDropColumn">
            <div v-for="(col, index) in droppingColumns" :key="index">
              <input
                type="checkbox"
                :id="col"
                :value="col"
                v-model="checkedNames"
                class="ml-2 mt-2.5"
              />
              <label :for="col">{{ col }}</label>
            </div>
            <button class="ml-2 btn btn-primary">Drop</button>
          </form>
        </div>

        <!-- Dynamic Table -->
        <table class="table table-bordered mt-3">
          <thead>
          <tr>
            <th :colspan="dynamicColumns.length">
              List Of Something
              <button @click="showDialog = true" class="btn btn-danger float-end">
                <i class="fa fa-trash"></i> Drop
              </button>
              <button @click="exportUsers" class="btn btn-warning float-end">
                <i class="fa fa-download"></i> Export
              </button>
            </th>
          </tr>
          <tr>
            <th v-for="(col, index) in dynamicColumns" :key="index">
              {{ col }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="user in users" :key="user.id">
            <td v-for="(col, index) in dynamicColumns" :key="index">
              {{ user[col] || '-' }}
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <Teleport to="body">
      <div v-if="showDialog" class="modal-backdrop">
        <div class="text-center">
          <p>Are you sure you want to drop all data? This action cannot be undone.</p>
          <button @click="confirmDrop" class="btn btn-danger">Yes, Drop All</button>
          <button @click="showDialog = false" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
    </Teleport>
  </div>
</template>



<script setup>
import {ref, onMounted, watch} from 'vue';
import axios from 'axios';

const users = ref([]);
const fileInput = ref(null);
const successMessage = ref('');
const errors = ref('');
const showDialog = ref(false);
const newColumnName = ref('');
const ShowNewColumn = ref(false);
const ShowDropColumn = ref(false);
const dynamicColumns = ref([]);
const droppingColumns = ref([]);
const checkedNames = ref([]);

onMounted(async () => {
  await fetchUsers();
  await GetColumns();
});


const fetchUsers = async () => {
  try {
    const response = await axios.get('/excel-list');
    users.value = response.data.data;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};
const importUsers = async () => {
  const formData = new FormData();
  const file = fileInput.value.files[0];
  if (!file) {
    errors.value = 'Please select a file.';
    setTimeout(() => (errors.value = ''), 3000);
    return;
  }
  formData.append('file', file);
  try {
    const response = await axios.post('/excel-import', formData);
    successMessage.value = response.data.message;
    errors.value = '';
    await fetchUsers();
    setTimeout(() => (successMessage.value = null), 3000);
  } catch (error) {
    errors.value = error.response?.data?.errors || 'Import failed.';
  }
};
const exportUsers = async () => {
  try {
    const response = await axios.get('/excel-export', { responseType: 'blob' });
    const url = URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'users.xlsx');
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    console.error('Error exporting users:', error);
  }
};
const confirmDrop = async () => {
  try {
    const response = await axios.post('/excel-drop');
    successMessage.value = response.data.message;
    errors.value = '';
    await fetchUsers();
    showDialog.value = false;
    setTimeout(() => (successMessage.value = null), 3000);
  } catch (error) {
    errors.value = error.response?.data?.errors || 'Drop failed.';
  }
};
const GetColumns = async () => {
  try {
    const response = await axios.get('/get-columns');
    const columns = response.data.data.filter(
      (col) => col !== 'created_at' && col !== 'updated_at'
    );
    dynamicColumns.value = columns;
    droppingColumns.value = columns.filter((col) => col !== 'id');
  } catch (error) {
    console.error('Error fetching columns:', error);
  }
};
const SubmitColumn = async () => {
  if (newColumnName.value.trim() === '') {
    errors.value = 'Column name cannot be empty.';
    setTimeout(() => (errors.value = ''), 3000);
    return;
  }
  try {
    const response = await axios.post('/add-new-column', {
      column_name: newColumnName.value,
    });
    dynamicColumns.value.push(newColumnName.value);
    droppingColumns.value = droppingColumns.value.filter(
      (col) => !checkedNames.value.includes(col)
    );
    successMessage.value = response.data.message;
    newColumnName.value = '';
    setTimeout(() => (successMessage.value = null), 3000);
  } catch (error) {
    errors.value = error.response?.data?.error || 'Adding column failed.';
    setTimeout(() => (errors.value = null), 3000);
  }
};
const SubmitDropColumn = async () => {
  if (checkedNames.value.length === 0) {
    errors.value = 'Select at least one column to drop.';
    setTimeout(() => (errors.value = ''), 3000);
    return;
  }
  try {
    await axios.post('/drop-columns', {
      columns: checkedNames.value
    });
    dynamicColumns.value = dynamicColumns.value.filter(
      (col) => !checkedNames.value.includes(col)
    );
    droppingColumns.value = droppingColumns.value.filter(
      (col) => !checkedNames.value.includes(col)
    );
    successMessage.value = 'Columns dropped successfully.';
    checkedNames.value = [];
    ShowDropColumn.value = !ShowDropColumn;
    setTimeout(() => (successMessage.value = null), 3000);
  } catch (error) {
    errors.value = 'Drop failed.';
  }
};
</script>

<style>
.container {
  //max-width: 800px;
  //margin: auto;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.text-center {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.modal button {
  margin: 10px;
}
</style>

