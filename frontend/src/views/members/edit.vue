<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router';
import api from "../../api";

//init router
const router = useRouter();
const route = useRoute();

//define state
const class_id = ref("");
const first_name = ref("");
const last_name = ref("");
const email = ref("");
const gender = ref("");
const address = ref("");
const errors = ref([]);

//method untuk mengambil detail member
const getMember = async () => {
    try {
        const response = await api.get(`/api/members/${route.params.id}`);
        
        //assign data ke state
        class_id.value = response.data.class_id;
        first_name.value = response.data.first_name;
        last_name.value = response.data.last_name;
        email.value = response.data.email;
        gender.value = response.data.gender;
        address.value = response.data.address;
        
    } catch (error) {
        console.error('Error:', error);
    }
};

//method untuk update
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
        
        //redirect
        router.push({ path: "/members/" });
        
    } catch (error) {
        errors.value = error.response.data;
    }
};

//panggil method getMember ketika component dimount
onMounted(() => {
    getMember();
});
</script>

<template>
    <div class="container mx-auto my-5">
        <div class="flex justify-center">
            <div class="w-full max-w-lg p-6 my-5 bg-white rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold text-center text-black">Create Member</h1>
                <form @submit.prevent="updatePost()" class="w-full max-w-lg mt-2">
                    <div class="mb-4">
                        <label class="block font-bold text-gray-700">Class ID</label>
                        <input type="text" class="w-full input input-bordered" v-model="class_id"
                            placeholder="Class ID">
                        <div v-if="errors.class_id" class="mt-1 text-sm text-red-500">
                            {{ errors.class_id[0] }}
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2 mb-4">
                            <label class="block font-bold text-gray-700">First Name</label>
                            <input type="text" class="w-full input input-bordered" v-model="first_name"
                                placeholder="First Name">
                            <div v-if="errors.first_name" class="mt-1 text-sm text-red-500">
                                {{ errors.first_name[0] }}
                            </div>
                        </div>

                        <div class="w-1/2 mb-4">
                            <label class="block font-bold text-gray-700">Last Name</label>
                            <input type="text" class="w-full input input-bordered" v-model="last_name"
                                placeholder="Last Name">
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
                            <option value="" disabled>Select Gender</option>
                            <option value="Male" :selected="gender === 'Male'">Male</option>
                            <option value="Female" :selected="gender === 'Female'">Female</option>
                        </select>
                        <div v-if="errors.gender" class="mt-1 text-sm text-red-500">
                            {{ errors.gender[0] }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-gray-700">Address</label>
                        <textarea class="w-full textarea textarea-bordered" v-model="address" rows="3"
                            placeholder="Address"></textarea>
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