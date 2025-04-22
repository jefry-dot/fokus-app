<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { MenuIcon, XIcon, LogOutIcon, SunIcon } from 'lucide-vue-next';

const isMobileMenuOpen = ref(false);
const logoutForm = useForm({});
const handleLogout = () => logoutForm.post('/logout');

const navItems = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Focus', href: '/focus' },
  { title: 'Projects', href: '/projects' },
];

const currentPath = computed(() => window.location.pathname);
</script>

<template>
  <header class="sticky top-0 z-50 border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 dark:border-neutral-800 dark:bg-neutral-900/80">
    <div class="mx-auto h-16 px-4 sm:px-6 lg:px-8 max-w-7xl">
      <div class="flex h-full items-center justify-between">
        <!-- Logo -->
        <Link href="/dashboard" class="flex items-center gap-2">
          <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">MyApp</span>
        </Link>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex h-full">
          <div class="flex items-center space-x-2">
            <Link
              v-for="item in navItems"
              :key="item.title"
              :href="item.href"
              class="relative flex items-center px-4 py-2 text-sm font-medium transition-all rounded-lg"
              :class="[
                currentPath === item.href 
                  ? 'text-indigo-600 bg-indigo-50 dark:text-indigo-300 dark:bg-neutral-800'
                  : 'text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800',
              ]"
            >
              {{ item.title }}
              <span 
                v-if="currentPath === item.href"
                class="absolute -bottom-[17px] h-[2px] w-4/5 bg-indigo-600 dark:bg-indigo-400"
              />
            </Link>
          </div>
        </nav>

        <!-- Right Side -->
        <div class="flex items-center gap-4">
          <!-- Theme toggle (optional) -->
          <button class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800">
            <SunIcon class="h-5 w-5 text-neutral-600 dark:text-neutral-300" />
          </button>

          <!-- Logout button -->
          <button
            @click="handleLogout"
            class="group flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition-all bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white dark:text-red-400 dark:hover:bg-red-500/20"
            :disabled="logoutForm.processing"
          >
            <LogOutIcon class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" />
            <span class="hidden sm:block">Sign Out</span>
          </button>

          <!-- Mobile Menu Button -->
          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="p-2 lg:hidden rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800"
          >
            <MenuIcon v-if="!isMobileMenuOpen" class="h-6 w-6" />
            <XIcon v-else class="h-6 w-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <div v-show="isMobileMenuOpen" class="lg:hidden border-b dark:border-neutral-800">
      <div class="px-4 py-3 space-y-1">
        <Link
          v-for="item in navItems"
          :key="item.title"
          :href="item.href"
          class="block px-3 py-2 rounded-lg font-medium"
          :class="currentPath === item.href 
            ? 'bg-indigo-50 text-indigo-600 dark:bg-neutral-800 dark:text-indigo-400' 
            : 'text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800'"
        >
          {{ item.title }}
        </Link>
      </div>
    </div>
  </header>
</template>
