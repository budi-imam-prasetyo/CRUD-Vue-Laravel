<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';
import api from "../../api";

const router = useRouter();
const route = useRoute();

const class_id = ref("");
const first_name = ref("");
const last_name = ref("");
const email = ref("");
const gender = ref("");
const address = ref("");
const errors = ref([]);

const getMember = async () => {
    try {
        const response = await api.get(`/api/members/${route.params.id}`);
        
        class_id.value = response.data.id;
        first_name.value = response.data.first_name;
        last_name.value = response.data.last_name;
        email.value = response.data.email;
        gender.value = response.data.gender;
        address.value = response.data.address;
        
    } catch (error) {
        console.error('Error:', error);
    }
};

const updatePost = async () => {
    try {
        let formData = new FormData();

        formData.append("_method", "PUT");
        formData.append("class_id", class_id.value);
        formData.append("first_name", first_name.value);
        formData.append("last_name", last_name.value);
        formData.append("email", email.value);
        formData.append("gender", gender.value);
        formData.append("address", address.value);

        await api.post(`/api/members/${route.params.id}`, formData);
        
        router.push({ path: "/members/" });
        
    } catch (error) {
        errors.value = error.response.data;
    }
};

onMounted(() => {
    getMember();
});
</script>

<template>
    <div class="relative z-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-4xl font-bold">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-white">
                            Edit Member
                        </span>
                    </h1>
                    <p class="mt-3 text-base text-gray-300">
                        Update member information by modifying the form below
                    </p>
                </div>

                <!-- Form Card -->
                <div class="p-8 bg-green-100 shadow-xl bg-opacity-10 backdrop-blur-lg rounded-xl">
                    <form @submit.prevent="updatePost()" class="space-y-6">
                        <!-- Class ID -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white">Class ID</label>
                            <input type="text" v-model="class_id" placeholder="Enter class ID"
                                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <div v-if="errors.class_id" class="mt-2 text-sm text-red-400">
                                {{ errors.class_id[0] }}
                            </div>
                        </div>

                        <!-- Name Fields -->
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

                        <!-- Email -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white">Email Address</label>
                            <input type="email" v-model="email" placeholder="Enter email address"
                                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <div v-if="errors.email" class="mt-2 text-sm text-red-400">
                                {{ errors.email[0] }}
                            </div>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white">Gender</label>
                            <select v-model="gender"
                                class="w-full px-4 py-3 text-white border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="" disabled selected>Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div v-if="errors.gender" class="mt-2 text-sm text-red-400">
                                {{ errors.gender[0] }}
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white">Address</label>
                            <textarea v-model="address" rows="4" placeholder="Enter complete address"
                                class="w-full px-4 py-3 text-white placeholder-green-400 border border-green-900 rounded-lg bg-green-950 focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            <div v-if="errors.address" class="mt-2 text-sm text-red-400">
                                {{ errors.address[0] }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="router.push('/members')"
                                class="w-1/3 px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-900 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-green-400">
                                Back to List
                            </button>
                            <button type="submit"
                                class="w-2/3 px-4 py-3 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                                Edit Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>