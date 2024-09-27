import './bootstrap';
/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);
import { createApp } from 'vue';
import ChatComponent from './components/ChatComponent.vue';


const app = createApp({});

app.component('chat-component', ChatComponent);
app.mount('#app');
