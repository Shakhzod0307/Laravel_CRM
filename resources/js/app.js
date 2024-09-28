import './bootstrap';
/*
  Add custom scripts here
*/
import { createApp } from 'vue';
import ChatComponent from './components/ChatComponent.vue';
import RolesComponent from './components/roles.vue';
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);



const app = createApp({});

app.component('chat-component', ChatComponent);
app.component('roles-component', RolesComponent);
app.mount('#app');
