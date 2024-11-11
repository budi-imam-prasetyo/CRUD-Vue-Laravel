<script setup>
import { ref } from "vue";
import { useRouter } from 'vue-router';
import api from "../../api";

const router = useRouter();

const class_id = ref("");
const first_name = ref("");
const last_name = ref("");
const email = ref("");
const gender = ref("");
const address = ref("");
const errors = ref({});

const storePost = async () => {
  try {
    let formData = new FormData();
    formData.append("class_id", class_id.value);
    formData.append("first_name", first_name.value);
    formData.append("last_name", last_name.value);
    formData.append("email", email.value);
    formData.append("gender", gender.value);
    formData.append("address", address.value);

    const response = await api.post('/api/members', formData);
    console.log('Response:', response.data);

    router.push({ path: "/members/" });

  } catch (error) {
    console.error('Error detail:', error.response.data.errors);
    errors.value = error.response.data.errors || {};
  }
};
</script>

<template>
  <div class="relative z-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex justify-center">
      <div class="w-full max-w-2xl">
        <div class="mb-8 text-center">
          <h1 class="text-4xl font-bold">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-white">
              Create New Member
            </span>
          </h1>
          <p class="mt-3 text-base text-gray-300">
            Add a new member to your organization by filling out the form below
          </p>
        </div>
        
        <div class="p-8 bg-green-100 shadow-xl bg-opacity-10 backdrop-blur-lg rounded-xl">
          <form @submit.prevent="storePost()" class="space-y-6">
            <div>
              <label class="block mb-2 text-sm font-medium text-white">Class ID</label>
              <input type="text" v-model="class_id" placeholder="Enter class ID"
                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
              <div v-if="errors.class_id" class="mt-2 text-sm text-red-400">
                {{ errors.class_id[0] }}
              </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <div>
                <label class="block mb-2 text-sm font-medium text-white">First Name</label>
                <input type="text" v-model="first_name" placeholder="Enter first name"
                  class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <div v-if="errors.first_name" class="mt-2 text-sm text-red-400">
                  {{ errors.first_name[0] }}
                </div>
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-white">Last Name</label>
                <input type="text" v-model="last_name" placeholder="Enter last name"
                  class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <div v-if="errors.last_name" class="mt-2 text-sm text-red-400">
                  {{ errors.last_name[0] }}
                </div>
              </div>
            </div>
            
            <div>
              <label class="block mb-2 text-sm font-medium text-white">Email Address</label>
              <input type="email" v-model="email" placeholder="Enter email address"
                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
              <div v-if="errors.email" class="mt-2 text-sm text-red-400">
                {{ errors.email[0] }}
              </div>
            </div>
            
            <div>
              <label class="block mb-2 text-sm font-medium text-white">Gender</label>
              <select v-model="gender"
                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <div v-if="errors.gender" class="mt-2 text-sm text-red-400">
                {{ errors.gender[0] }}
              </div>
            </div>
            
            <div>
              <label class="block mb-2 text-sm font-medium text-white">Address</label>
              <textarea v-model="address" rows="4" placeholder="Enter complete address"
                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
              <div v-if="errors.address" class="mt-2 text-sm text-red-400">
                {{ errors.address[0] }}
              </div>
            </div>
            
            <div class="flex gap-4 pt-4">
              <button type="button" @click="router.push('/members')"
                class="w-1/3 px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-900 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-green-400">
                Back to List
              </button>
              <button type="submit"
                class="w-2/3 px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                Create Member
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>