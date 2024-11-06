<script setup>
  import { ref, onMounted } from 'vue';
  import api from '../../api';

  const members = ref([]);

  const fetchDataMembers = async () => {
    await api.get('/api/members').then((response) => {
      members.value = response.data.data;
    });
  };

  const deleteMember = async (id) => {
    if (confirm('Are you sure you want to delete this member?')) {
      try {
        await api.delete(`/api/members/${id}`);
        fetchDataMembers();
      } catch (error) {
        console.error('Error:', error);
      }
    }
  };

  onMounted(() => {
    fetchDataMembers();
  });
</script>

<template>
  <div class="container mx-auto mt-5 mb-5">
    <div class="flex justify-end mb-4">
      <router-link
        :to="{ name: 'members.create' }"
        class="btn btn-success btn-sm rounded shadow-md"
      >
        ADD NEW MEMBER
      </router-link>
    </div>

    <div class="rounded-lg shadow-md overflow-hidden">
      <table class="table w-full">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th>ID</th>
            <th>Class ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Address</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="members.length === 0">
            <td colspan="7" class="text-center">
              <div class="alert alert-warning">Data Belum Tersedia!</div>
            </td>
          </tr>
          <tr v-else v-for="(member, index) in members" :key="index">
            <td class="text-black text-center">{{ member.id }}</td>
            <td class="text-black text-center">{{ member.class.id }}</td>
            <td class="text-black text-center">{{ member.first_name }} {{ member.last_name }}</td>
            <td class="text-black text-center">{{ member.email }}</td>
            <td class="text-black text-center">{{ member.gender }}</td>
            <td class="text-black text-center">{{ member.address }}</td>
            <td class="text-center">
              <router-link
                :to="{ name: 'members.edit', params: { id: member.id } }"
                class="btn btn-sm btn-primary mr-2 rounded"
              >
                EDIT
              </router-link>
              <button
                @click="deleteMember(member.id)"
                class="btn btn-sm btn-error text-white rounded"
              >
                DELETE
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
