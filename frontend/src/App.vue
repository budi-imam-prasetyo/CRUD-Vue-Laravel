<template>
  <div>
    <nav class="bg-gray-800 shadow-lg">
      <div class="container mx-auto px-4 flex items-center justify-between h-16">
        <!-- Home Link -->
        <router-link :to="{ name: 'home' }" class="text-white font-semibold text-lg">
          HOME
        </router-link>

        <!-- Mobile Menu Button -->
        <button
          class="text-gray-400 hover:text-white focus:outline-none focus:text-white lg:hidden"
          @click="isOpen = !isOpen"
        >
          <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

        <!-- Navbar Links -->
        <div :class="{'block': isOpen, 'hidden': !isOpen}" class="lg:flex lg:items-center lg:w-auto w-full">
          <ul class="lg:flex lg:space-x-6 lg:mt-0 mt-4">
            <li>
              <router-link :to="{ name: 'members.index' }" class="text-gray-300 hover:text-white text-md">
                MEMBERS
              </router-link>
            </li>
          </ul>

          <!-- Button -->
          <a
            href="https://santrikoding.com"
            target="_blank"
            class="ml-6 btn btn-success btn-sm"
          >
            SANTRIKODING.COM
          </a>
        </div>
      </div>
    </nav>

    <!-- Render router view -->
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: false
    };
  }
};
</script>

<style scoped>
/* Optional: Customize more styles here */
</style>
