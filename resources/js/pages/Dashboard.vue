<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
];

// Simulasi data fokus
const focusToday = ref('1h 30m');
const focusYesterday = ref('2h 10m');
const focusThisMonth = ref('26h 45m');
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Fullscreen gradient background -->
    <div class="min-h-screen p-6 bg-gradient-to-br from-gray-900 via-indigo-900 to-black animate-gradient">
      <div class="space-y-6">
        <!-- Quick stats row -->
        <div class="grid gap-6 md:grid-cols-3">
          <!-- Fokus Hari Ini -->
          <div
            class="relative p-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl shadow-2xl overflow-hidden group hover:scale-105 transform transition-transform duration-300"
          >
            <div class="absolute inset-0 opacity-20 mix-blend-overlay animate-slide-fade">
              <PlaceholderPattern />
            </div>
            <div class="relative z-10 text-white">
              <h3 class="text-sm font-medium uppercase">Fokus Hari Ini</h3>
              <p class="mt-2 text-3xl font-bold">{{ focusToday }}</p>
            </div>
          </div>

          <!-- Fokus Kemarin -->
          <div
            class="relative p-6 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-2xl shadow-2xl overflow-hidden group hover:scale-105 transform transition-transform duration-300"
          >
            <div class="absolute inset-0 opacity-20 mix-blend-overlay animate-slide-fade">
              <PlaceholderPattern />
            </div>
            <div class="relative z-10 text-white">
              <h3 class="text-sm font-medium uppercase">Fokus Kemarin</h3>
              <p class="mt-2 text-3xl font-bold">{{ focusYesterday }}</p>
            </div>
          </div>

          <!-- Fokus Bulan Ini -->
          <div
            class="relative p-6 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-2xl overflow-hidden group hover:scale-105 transform transition-transform duration-300"
          >
            <div class="absolute inset-0 opacity-20 mix-blend-overlay animate-slide-fade">
              <PlaceholderPattern />
            </div>
            <div class="relative z-10 text-white">
              <h3 class="text-sm font-medium uppercase">Fokus Bulan Ini</h3>
              <p class="mt-2 text-3xl font-bold">{{ focusThisMonth }}</p>
            </div>
          </div>
        </div>

        <!-- Focus Timeline / Chart -->
        <div class="relative bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8 overflow-hidden animate-slide-fade">
          <div class="absolute inset-0 opacity-10 [mask-image:linear-gradient(transparent,#000,transparent)]">
            <PlaceholderPattern />
          </div>
          <div class="relative z-10">
            <h2 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-purple-400 mb-4">
              Focus Timeline
            </h2>
            <!-- Placeholder untuk Chart -->
            <PlaceholderPattern class="h-64 w-full rounded-lg" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
@keyframes slide-fade {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

.animate-slide-fade {
  animation: slide-fade 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

.animate-gradient {
  background-size: 200% 200%;
  animation: gradient 8s ease infinite;
}
</style>
