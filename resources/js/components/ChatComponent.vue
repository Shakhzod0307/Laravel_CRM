<template>
  <a :href="'/chats/index'" class="h-2 text-blue-500 hover:text-blue-700">Back</a>
  <div class="flex flex-col h-[600px]">
    <div class="flex items-center">
      <img src="/public/images/avatar/64-1.jpg" alt class="mt-4 w-px-40 h-auto rounded-circle">
      <h1 class="text-lg mt-3 font-semibold ml-2 mr-2">{{ user.username }}</h1>
      <span :class="isUserOnline ? 'bg-green-500' : 'bg-gray-400'" class="inline-block h-2 w-2 rounded-full"></span>
    </div>

    <!-- Messages -->
    <div ref="messageContainer" class="overflow-y-auto p-4 mt-3 flex-grow border-t border-gray-200">
      <div class="space-y-4">
        <div
          v-for="message in messages"
          :key="message.id"
          :class="{ 'text-right': message.sender_id === currentUser.id }"
          class="mb-4"
        >
          <div
            :class="message.sender_id === currentUser.id ? 'bg-indigo-200 text-black' : 'bg-gray-200 text-black'"
            class="inline-block px-5 py-2 rounded-lg"
          >
            <p v-if="message.text !== null">{{ message.text }}</p>
            <img v-if="message.type.startsWith('image/')" :src="message.url" class="max-w-xs" alt="Image Message">
            <a v-if="message.type.startsWith('application/')" :href="message.url" class="text-black" target="_blank">{{ message.filename }}</a>

            <audio v-if="message.type.startsWith('audio/')" controls>
              <source :src="message.url" :type="message.type">
              Your browser does not support the audio tag.
            </audio>
            <video v-if="message.type.startsWith('video/')" controls class="w-64 h-64  object-cover">
              <source :src="message.url" :type="message.type">
              Your browser does not support the video tag.
            </video>
            <span class="text-[10px]">{{ formatTime(message.created_at) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Message Input -->
    <div class="border-t pt-4">
      <form @submit.prevent="sendMessage">
        <div class="flex items-center">
          <input
            v-model="newMessage"
            @keydown="sendTypingEvent"
            type="text"
            name="text"
            class="flex-1 border p-3 rounded-lg"
            placeholder="Type your message here..."
          />
          <input type="file" ref="fileInput" @change="handleFileUpload" class="ml-2" />
          <button type="submit" class="ml-2 bg-indigo-500 text-white p-3 rounded-lg shadow hover:bg-indigo-600 transition duration-300 flex items-center justify-center">
            <i class="fas fa-paper-plane"></i>
            <span class="ml-2">Send</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  <small v-if="isUserTyping" class="text-gray-600 mt-5">
    {{ user.username }} is typing...
  </small>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue';
import axios from 'axios';

const props = defineProps({
  user: {
    type: Object,
    required: true
  },
  currentUser: {
    type: Object,
    required: true
  }
});

const messages = ref([]);
const newMessage = ref('');
const messageContainer = ref(null);
const isUserTyping = ref(false);
const isUserTypingTimer = ref(null);
const isUserOnline = ref(false);
const selectedFile = ref(null);
const fileInput = ref(null); // Reference for the file input

watch(
  messages,
  () => {
    nextTick(() => {
      messageContainer.value.scrollTo({
        top: messageContainer.value.scrollHeight,
        behavior: "smooth",
      });
    });
  },
  { deep: true }
);

const fetchMessages = async () => {
  try {
    const response = await axios.get(`/messages/${props.user.id}`);
    messages.value = response.data.data;
  } catch (error) {
    console.error("Failed to fetch messages:", error);
  }
};

const sendMessage = async () => {
  const formData = new FormData();

  if (newMessage.value.trim() !== '') {
    formData.append('message', newMessage.value);
    formData.append('type', 'text');
  }

  if (selectedFile.value) {
    formData.append('file', selectedFile.value);
    formData.append('type', selectedFile.value.type);
  }

  try {
    const response = await axios.post(`/messages/${props.user.id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    messages.value.push(response.data);
    newMessage.value = '';
    selectedFile.value = null;
    fileInput.value.value = '';
  } catch (error) {
    console.error("Failed to send message:", error);
  }
};

const handleFileUpload = (event) => {
  selectedFile.value = event.target.files[0];
};

const sendTypingEvent = () => {
  Echo.private(`chat.${props.user.id}`).whisper("typing", {
    userID: props.currentUser.id,
  });
};

const formatTime = (datetime) => {
  const options = { hour: '2-digit', minute: '2-digit' };
  return new Date(datetime).toLocaleTimeString([], options);
};

onMounted(() => {
  fetchMessages();

  Echo.join(`presence.chat`)
    .here(users => {
      isUserOnline.value = users.some(user => user.id === props.user.id);
    })
    .joining(user => {
      if (user.id === props.user.id) isUserOnline.value = true;
    })
    .leaving(user => {
      if (user.id === props.user.id) isUserOnline.value = false;
    });

  Echo.private(`chat.${props.currentUser.id}`)
    .listen("MessageSent", (response) => {
      messages.value.push(response.message);
    })
    .listenForWhisper("typing", (response) => {
      isUserTyping.value = response.userID === props.user.id;

      if (isUserTypingTimer.value) {
        clearTimeout(isUserTypingTimer.value);
      }

      isUserTypingTimer.value = setTimeout(() => {
        isUserTyping.value = false;
      }, 1000);
    });
});
</script>
