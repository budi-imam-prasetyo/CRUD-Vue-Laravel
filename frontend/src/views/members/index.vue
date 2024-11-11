<script setup>
import { Icon } from '@iconify/vue';
import { ref, onMounted, watch } from 'vue';
import api from '../../api';

const members = ref([]);
const currentPage = ref(1);
const totalPages = ref(0);
const search = ref('');
const genderFilter = ref('');
const classFilter = ref('');
const sortBy = ref('latest');
const loading = ref(true);
const sortColumn = ref('');
const sortDirection = ref('asc');

const fetchDataMembers = async () => {
  loading.value = true;

  const params = {
    ...(search.value && { search: search.value }),
    ...(genderFilter.value && { gender: genderFilter.value }),
    ...(classFilter.value && { class: classFilter.value }),
    ...(sortColumn.value && { sort_column: sortColumn.value }),
    ...(sortDirection.value && { sort_direction: sortDirection.value }),
    sort_by: sortBy.value,
    page: currentPage.value,
  };

  try {
    const response = await api.get('/api/members', { params });
    members.value = response.data.data;
    totalPages.value = response.data.last_page;
  } catch (error) {
    console.error('Error fetching data:', error);
  } finally {
    loading.value = false;
  }
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

const updateSort = (column) => {
  if (sortColumn.value === column) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortColumn.value = column;
    sortDirection.value = 'asc';
  }
  fetchDataMembers();
};

onMounted(() => {
  fetchDataMembers();
});

watch([search, genderFilter, classFilter, sortBy, currentPage], fetchDataMembers);

</script>

<template>
  <div class="relative z-20 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-white">
        Members Management
      </h2>
      <router-link :to="{ name: 'members.create' }" class="inline-flex items-center gap-2 px-6 py-3 
         rounded-xl backdrop-blur-md bg-white/10 border border-white/20 
         text-white font-medium
         transition-all duration-300 
         hover:bg-white/20
         hover:scale-105 hover:-translate-y-0.5
         focus:outline-none focus:ring-2 focus:ring-white/25">
        <span class="relative">Add New Member</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>

        <!-- Optional: Tambahkan efek glow saat hover -->
        <div class="absolute inset-0 transition-opacity opacity-0 rounded-xl bg-green-400/20 blur-xl hover:opacity-100">
        </div>
      </router-link>
    </div>

    <!-- Filter & Search Section -->
    <div class="relative p-4 mb-8 border rounded-xl bg-white/5 backdrop-blur-lg border-white/10"
      style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));">
      <!-- Decorative Element -->
      <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-teal-500/5 rounded-xl"></div>

      <div class="relative flex flex-wrap items-center gap-4">
        <!-- Search Input -->
        <div class="flex-1 min-w-[240px]">
          <div class="relative">
            <Icon icon="mdi:magnify" class="absolute text-gray-400 transform -translate-y-1/2 left-3 top-1/2"
              width="20" />
            <input v-model="search" type="text" placeholder="Search members..." class="w-full px-10 py-2.5 text-sm bg-white/10 border border-white/10 rounded-lg 
                               text-gray-200 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50
                               transition-all duration-200" />
          </div>
        </div>

        <!-- Gender Filter -->
        <div class="relative min-w-[160px]">
          <Icon icon="mdi:gender-male-female" class="absolute text-gray-400 transform -translate-y-1/2 left-3 top-1/2"
            width="20" />
          <select v-model="genderFilter" class="w-full appearance-none px-10 py-2.5 text-sm bg-white/10 border border-white/10 rounded-lg 
                           text-gray-200
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50
                           transition-all duration-200">
            <option value="">All Genders</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Polygender">Polygender</option>
          </select>
          <Icon icon="mdi:chevron-down"
            class="absolute text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" width="20" />
        </div>

        <!-- Class Filter -->
        <div class="relative min-w-[160px]">
          <Icon icon="mdi:school" class="absolute text-gray-400 transform -translate-y-1/2 left-3 top-1/2" width="20" />
          <select v-model="classFilter" class="w-full appearance-none px-10 py-2.5 text-sm bg-white/10 border border-white/10 rounded-lg 
                           text-gray-200
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50
                           transition-all duration-200">
            <option value="">All Classes</option>
            <option value="1">Class 1</option>
            <option value="2">Class 2</option>
          </select>
          <Icon icon="mdi:chevron-down"
            class="absolute text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" width="20" />
        </div>

        <!-- Sort Filter -->
        <div class="relative min-w-[160px]">
          <Icon icon="mdi:sort-variant" class="absolute text-gray-400 transform -translate-y-1/2 left-3 top-1/2"
            width="20" />
          <select v-model="sortBy" class="w-full appearance-none px-10 py-2.5 text-sm bg-white/10 border border-white/10 rounded-lg 
                           text-gray-200
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50
                           transition-all duration-200">
            <option value="latest">Latest</option>
            <option value="oldest">Oldest</option>
          </select>
          <Icon icon="mdi:chevron-down"
            class="absolute text-gray-400 transform -translate-y-1/2 pointer-events-none right-3 top-1/2" width="20" />
        </div>
      </div>
    </div>

    <!-- Loading Indicator -->


    <!-- Table Section -->
    <div class="relative overflow-hidden border rounded-xl bg-white/5 backdrop-blur-lg border-white/10"
      style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));">
      <!-- Decorative background -->
      <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-teal-500/5"></div>

      <div class="relative overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-white/10">
              <th @click="updateSort('id')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  ID
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'id' && sortDirection === 'asc' ? 'rotate-180' : ''" class="text-gray-400"
                    width="16" />
                </div>
              </th>
              <th @click="updateSort('class_id')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  Class ID
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'class_id' && sortDirection === 'asc' ? 'rotate-180' : ''"
                    class="text-gray-400" width="16" />
                </div>
              </th>
              <th @click="updateSort('first_name')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  Name
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'first_name' && sortDirection === 'asc' ? 'rotate-180' : ''"
                    class="text-gray-400" width="16" />
                </div>
              </th>
              <th @click="updateSort('email')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  Email
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'email' && sortDirection === 'asc' ? 'rotate-180' : ''" class="text-gray-400"
                    width="16" />
                </div>
              </th>
              <th @click="updateSort('gender')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  Gender
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'gender' && sortDirection === 'asc' ? 'rotate-180' : ''"
                    class="text-gray-400" width="16" />
                </div>
              </th>
              <th @click="updateSort('address')" class="p-5 text-sm font-medium text-gray-300 cursor-pointer">
                <div class="flex items-center justify-center gap-2">
                  Address
                  <Icon icon="mdi:arrow-up-down"
                    :class="sortColumn === 'address' && sortDirection === 'asc' ? 'rotate-180' : ''"
                    class="text-gray-400" width="16" />
                </div>
              </th>
              <th class="p-5 text-sm font-medium text-center text-gray-300">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Container utama dengan full height agar loader berada di tengah -->
            <!-- Tambahkan div wrapper dengan tinggi penuh -->
            <div v-if="loading" class="w-full h-[50vh]"> <!-- atau min-h-screen untuk minimum height -->
              <div class="fixed inset-0 flex items-center justify-center">
                <!-- atau bg-black/50 untuk overlay gelap -->
                <div class="flex items-center space-x-2 text-green-500">
                  <svg class="w-8 h-8 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"
                    preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" r="40" stroke="url(#greenGradient)" stroke-width="6" fill="none"
                      stroke-dasharray="150" stroke-dashoffset="10" stroke-linecap="round" />
                    <circle cx="50" cy="50" r="30" stroke="url(#greenGradient)" stroke-width="4" fill="none"
                      stroke-dasharray="120" stroke-dashoffset="30" stroke-linecap="round" />
                    <defs>
                      <linearGradient id="greenGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#4ADE80; stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#22C55E; stop-opacity:1" />
                      </linearGradient>
                    </defs>
                  </svg>
                  <span>Loading...</span>
                </div>
              </div>
            </div>

            <!-- Pesan "No Data Available" jika tidak ada data dan loading selesai -->
            <tr v-else-if="members.length === 0">
              <td colspan="7" class="p-8">
                <div class="flex flex-col items-center justify-center gap-2 text-gray-400">
                  <Icon icon="mdi:folder-open-outline" width="48" />
                  <span class="text-sm">No Data Available!</span>
                </div>
              </td>
            </tr>
            <tr v-else v-for="(member, index) in members" :key="index"
              class="transition-colors border-b border-white/5 hover:bg-white/5">
              <td class="p-5 text-sm text-center text-gray-300">{{ member.id }}</td>
              <td class="p-5 text-sm text-center text-gray-300">{{ member.class.id }}</td>
              <td class="p-5 text-sm text-gray-300">
                <div class="flex items-center gap-3">
                  <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/20">
                    <Icon icon="mdi:account" class="text-emerald-400" width="16" />
                  </div>
                  {{ member.first_name }} {{ member.last_name }}
                </div>
              </td>
              <td class="p-5 text-sm text-gray-300">{{ member.email }}</td>
              <td class="p-5 text-sm text-center">
                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full" :class="{
                  'bg-emerald-500/20 text-emerald-400': member.gender === 'Male',
                  'bg-pink-500/20 text-pink-400': member.gender === 'Female',
                  'bg-purple-500/20 text-purple-400': member.gender === 'Polygender'
                }">
                  <Icon :icon="member.gender === 'Male' ? 'mdi:gender-male' :
                    member.gender === 'Female' ? 'mdi:gender-female' :
                      'mdi:gender-non-binary'" class="mr-1" width="14" />
                  {{ member.gender }}
                </span>
              </td>
              <td class="p-5 text-sm text-gray-300">
                <div class="flex items-center gap-2">
                  <Icon icon="mdi:map-marker" class="text-gray-400" width="16" />
                  {{ member.address }}
                </div>
              </td>
              <td class="p-5">
                <div class="flex items-center justify-center gap-2">
                  <router-link :to="{ name: 'members.edit', params: { id: member.id } }" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-emerald-400 
                                           bg-emerald-500/10 rounded-lg transition-colors hover:bg-emerald-500/20">
                    <Icon icon="mdi:pencil" class="mr-1" width="14" />
                    Edit
                  </router-link>
                  <button @click="deleteMember(member.id)" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-400 
                                           bg-red-500/10 rounded-lg transition-colors hover:bg-red-500/20">
                    <Icon icon="mdi:trash-can" class="mr-1" width="14" />
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination Control -->
    <div class="flex items-center justify-center mt-4 space-x-4">
      <!-- Previous Button -->
      <button @click="currentPage--" :disabled="currentPage === 1" class="px-6 py-4 rounded-xl backdrop-blur-md bg-white/10 border border-white/20 
           text-white text-sm font-medium
           transition-all duration-300 
           hover:bg-white/20 hover:shadow-[0_8px_32px_0_rgba(31,38,135,0.47)]
           disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white/10">
        <span class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Previous
        </span>
      </button>

      <!-- Page Counter -->
      <div
        class="flex items-center px-4 py-2 space-x-2 border rounded-xl backdrop-blur-md bg-white/10 border-white/20 ">
        <input type="text" inputmode="numeric" v-model="currentPage" min="1" :max="totalPages"
          class="w-12 px-2 py-1 text-center text-white transition-all duration-300 border rounded-lg bg-white/5 border-white/20 focus:outline-none focus:ring-2 focus:ring-green-500/50" />
        <span class="text-sm font-medium text-white/80">of {{ totalPages }}</span>
      </div>

      <!-- Next Button -->
      <button @click="currentPage++" :disabled="currentPage === totalPages" class="px-6 py-4 rounded-xl backdrop-blur-md bg-white/10 border border-white/20 
           text-white text-sm font-medium
           transition-all duration-300 
           hover:bg-white/20 hover:shadow-[0_8px_32px_0_rgba(31,38,135,0.47)]
           disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white/10">
        <span class="flex items-center">
          Next
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </span>
      </button>
    </div>
  </div>
</template>

<style scoped>
select option {
  @apply bg-gray-800 text-gray-200;
}
</style>