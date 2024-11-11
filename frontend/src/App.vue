<script setup>
import { ref } from 'vue';
const isOpen = ref(false);
</script>

<template>
  <div class="bg-gradient-to-b from-[#000000] relative to-[#082014] px-4 mx-auto sm:px-6 lg:px-8">
    <header class="absolute inset-x-0 top-0 z-10 ">
      <div class="">
        <div class="flex items-center justify-between h-16 px-10 lg:h-20 ">
          <div class="flex-shrink-0">
            <a href="#" title="" class="flex">
              <img class="w-auto h-8" src="https://cdn.rareblocks.xyz/collection/celebration/images/hero/5/logo.svg"
                alt="" />
            </a>
          </div>

          <div class="hidden lg:flex lg:items-center lg:justify-center lg:space-x-10">
            <router-link :to="{ name: 'home' }"
              class="text-base text-white transition-all duration-200 hover:text-opacity-80 hover:border-b-2 hover:border-green-300"
              active-class="border-b-4 border-green-400">Home</router-link>
            <router-link :to="{ name: 'members.index' }"
              class="text-base text-white transition-all duration-200 hover:text-opacity-80 hover:border-b-2 hover:border-green-300"
              active-class="border-b-4 border-green-400">Members</router-link>
          </div>
          <div v-if="isOpen"
            class="absolute flex flex-col items-center w-full mt-10 space-y-4 border shadow-lg lg:hidden bg-green-950 bg-opacity-40 backdrop-blur-md rounded-xl border-white/20">
            <router-link :to="{ name: 'home' }"
              class="text-base text-white transition-all duration-200 hover:text-opacity-80 hover:border-b-2 hover:border-green-300"
              active-class="border-b-4 border-green-400">
              Home
            </router-link>
            <router-link :to="{ name: 'members.index' }"
              class="text-base text-white transition-all duration-200 hover:text-opacity-80 hover:border-b-2 hover:border-green-300"
              active-class="border-b-4 border-green-400">
              Members
            </router-link>
          </div>

          <button @click="isOpen = !isOpen"
            class="inline-flex p-2 ml-1 text-white rounded-md lg:hidden focus:bg-gray-800 hover:bg-gray-800">
            <svg v-if="!isOpen" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <svg v-else class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </header>

    <section class="relative lg:min-h-[1000px] pt-24 pb-10 sm:pt-32 sm:pb-16 lg:pb-24">
      <router-view></router-view>
    </section>
  </div>
</template>