import './bootstrap';
/*
  Add custom scripts here
*/
import { createApp } from 'vue';
import ChatComponent from './components/ChatComponent.vue';
import RolesComponent from './components/roles.vue';
import CallsComponent from './components/Calls.vue';
import User_list from "./components/User_list.vue";
import ChatUsers from "./components/ChatUsers.vue";
import ExcelList from "./components/Excel-List.vue";
import VueTailwindDatepicker from 'vue-tailwind-datepicker';
import 'flowbite';
import 'vue-tailwind-datepicker';
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);



const app = createApp({});
app.component('VueTailwindDatepicker', VueTailwindDatepicker);
app.component('chat-component', ChatComponent);
app.component('roles-component', RolesComponent);
app.component('calls-component', CallsComponent);
app.component('users-list', User_list);
app.component('chat-users', ChatUsers);
app.component('excel-list', ExcelList);
app.mount('#app');
