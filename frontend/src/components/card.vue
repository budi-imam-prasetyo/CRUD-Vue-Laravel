<script setup>
import { Icon } from '@iconify/vue';

defineProps({
    member: {
        type: Object,
        required: true,
        default: () => ({
            id: '',
            class_id: '',
            first_name: '',
            last_name: '',
            email: '',
            gender: '',
            address: ''
        })
    }
});
</script>

<template>
    <div class="w-full p-6 lg:w-1/3">
        <div class="relative h-full overflow-hidden transition-all duration-500 bg-white border border-gray-200 rounded-2xl backdrop-blur-xl bg-opacity-10 hover:transform hover:scale-105 hover:shadow-2xl"
            style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);">

            <!-- Decorative Elements -->
            <div
                class="absolute top-0 left-0 w-20 h-20 -translate-x-1/2 -translate-y-1/2 rounded-full bg-emerald-500 opacity-10">
            </div>
            <div
                class="absolute bottom-0 right-0 w-32 h-32 translate-x-1/2 translate-y-1/2 bg-teal-500 rounded-full opacity-10">
            </div>

            <!-- Content Container -->
            <div class="relative px-8 pt-8 pb-24">
                <!-- Profile Section -->
                <div class="text-center">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 mb-4 overflow-hidden rounded-full bg-emerald-500 bg-opacity-20">
                        <Icon icon="mdi:account" class="w-12 h-12 text-emerald-300" />
                    </div>
                    <h2 class="mb-1 text-sm font-medium tracking-wider uppercase text-emerald-400">
                        Member ID: {{ member.id }}
                    </h2>
                    <h1 class="mb-4 text-2xl font-semibold text-white">
                        {{ member.first_name }} {{ member.last_name }}
                    </h1>
                </div>

                <!-- Details Section -->
                <div class="space-y-4">
                    <div
                        class="flex items-center p-3 space-x-3 transition-colors rounded-lg bg-white/5 hover:bg-white/10">
                        <Icon icon="mdi:email" class="text-emerald-400" width="24" />
                        <p class="text-gray-200">{{ member.email }}</p>
                    </div>

                    <div
                        class="flex items-center p-3 space-x-3 transition-colors rounded-lg bg-white/5 hover:bg-white/10">
                        <Icon icon="mdi:account" class="text-emerald-400" width="24" />
                        <span class="px-4 py-1.5 text-sm font-medium text-emerald-400 rounded-full bg-emerald-500/20">
                            {{ member.gender }}
                        </span>
                    </div>

                    <div
                        class="flex items-start p-3 space-x-3 transition-colors rounded-lg bg-white/5 hover:bg-white/10">
                        <Icon icon="mdi:map-marker" class="mt-1 text-emerald-400" width="24" />
                        <p class="text-sm text-gray-300">{{ member.address }}</p>
                    </div>
                </div>  
            </div>

            <!-- Footer -->
            <div class="absolute bottom-0 left-0 w-full">
                <div class="px-8 py-4 border-t border-white/10">
                    <button
                        class="flex items-center justify-center w-full px-6 py-3 space-x-2 text-sm font-medium transition-colors rounded-lg bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300">
                        <span>View Details</span>
                        <Icon icon="mdi:arrow-right" width="20" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>