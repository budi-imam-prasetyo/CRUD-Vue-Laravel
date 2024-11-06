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

    console.log('Data yang dikirim:', {
      class_id: class_id.value,
      first_name: first_name.value,
      last_name: last_name.value,
      email: email.value,
      gender: gender.value,
      address: address.value
    });

    const response = await api.post('/api/members', formData);
    console.log('Response:', response.data);
    
    router.push({ path: "/members/" });
    
  } catch (error) {
    console.error('Error detail:', error.response.data.errors);
    errors.value = error.response.data.errors || {}; // Update untuk menyimpan error di state `errors`
  }
};
</script>

<template>
  <div class="container mx-auto my-5">
    <div class="flex justify-center">
        <div class="w-full max-w-lg p-6 my-5 bg-white rounded-lg shadow-lg">
          <h1 class="text-3xl font-bold text-center text-black">Create Member</h1>
        <form @submit.prevent="storePost()" class="w-full max-w-lg mt-2">
          <div class="mb-4">
            <label class="block font-bold text-gray-700">Class ID</label>
            <input type="text" class="w-full input input-bordered" v-model="class_id" placeholder="Class ID">
            <div v-if="errors.class_id" class="mt-1 text-sm text-red-500">
              {{ errors.class_id[0] }}
            </div>
          </div>

          <div class="flex gap-4">
            <div class="w-1/2 mb-4">
              <label class="block font-bold text-gray-700">First Name</label>
              <input type="text" class="w-full input input-bordered" v-model="first_name" placeholder="First Name">
              <div v-if="errors.first_name" class="mt-1 text-sm text-red-500">
                {{ errors.first_name[0] }}
              </div>
            </div>

            <div class="w-1/2 mb-4">
              <label class="block font-bold text-gray-700">Last Name</label>
              <input type="text" class="w-full input input-bordered" v-model="last_name" placeholder="Last Name">
              <div v-if="errors.last_name" class="mt-1 text-sm text-red-500">
                {{ errors.last_name[0] }}
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="block font-bold text-gray-700">Email</label>
            <input type="email" class="w-full input input-bordered" v-model="email" placeholder="Email">
            <div v-if="errors.email" class="mt-1 text-sm text-red-500">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="mb-4">
            <label class="block font-bold text-gray-700">Gender</label>
            <select class="w-full select select-bordered" v-model="gender">
              <option value="" disabled selected>Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            <div v-if="errors.gender" class="mt-1 text-sm text-red-500">
              {{ errors.gender[0] }}
            </div>
          </div>

          <div class="mb-6">
            <label class="block font-bold text-gray-700">Address</label>
            <textarea class="w-full textarea textarea-bordered" v-model="address" rows="3" placeholder="Address"></textarea>
            <div v-if="errors.address" class="mt-1 text-sm text-red-500">
              {{ errors.address[0] }}
            </div>
          </div>

          <div class="flex justify-between gap-2">
            <button type="" class="w-1/4 btn">Back</button>
            <button type="submit" class="w-3/4 btn btn-primary">Save Member</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
