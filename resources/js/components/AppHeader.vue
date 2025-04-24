<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { MenuIcon, XIcon, LogOutIcon, SunIcon, MoonIcon, UserIcon, SettingsIcon } from 'lucide-vue-next';
import { useDark, useToggle } from '@vueuse/core';

const isMobileMenuOpen = ref(false);
const isDropdownOpen = ref(false);

const logoutForm = useForm({});
const handleLogout = () => logoutForm.post('/logout');

// Navigasi utama
const navItems = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Focus', href: '/focus' },
  { title: 'History', href: '/history' },
];

// Theme toggle
const isDark = useDark();
const toggleDark = useToggle(isDark);

const currentPath = computed(() => window.location.pathname);
</script>

<template>
  <header class="sticky top-0 z-50 border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 dark:border-neutral-800 dark:bg-neutral-900/80">
    <div class="mx-auto h-16 px-4 sm:px-6 lg:px-8 max-w-7xl">
      <div class="flex h-full items-center justify-between">
        <!-- Logo -->
        <Link href="/dashboard" class="flex items-center gap-2">
          <span class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">MyApp</span>
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
                  ? 'text-cyan-600 bg-cyan-50 dark:text-cyan-300 dark:bg-neutral-800'
                  : 'text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800',
              ]"
            >
              {{ item.title }}
              <span 
                v-if="currentPath === item.href"
                class="absolute -bottom-[17px] h-[2px] w-4/5 bg-cyan-600 dark:bg-cyan-400"
              />
            </Link>
          </div>
        </nav>

        <!-- Right Side -->
        <div class="flex items-center gap-4">
          <!-- Theme toggle -->
          <button @click="toggleDark()" class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800">
            <SunIcon v-if="!isDark" class="h-5 w-5 text-neutral-600 dark:text-neutral-300" />
            <MoonIcon v-else class="h-5 w-5 text-neutral-600 dark:text-neutral-300" />
          </button>

          <!-- Akun Dropdown (desktop only) -->
          <div class="relative hidden lg:block">
            <button
              @click="isDropdownOpen = !isDropdownOpen"
              class="flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition-all bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700"
            >
              <UserIcon class="h-4 w-4" />
              Akun
            </button>
            <div
              v-show="isDropdownOpen"
              class="absolute right-0 mt-2 w-40 rounded-lg border bg-white shadow dark:bg-neutral-800 dark:border-neutral-700 transition ease-in-out duration-200"
            >
              <Link href="/profile" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                <UserIcon class="h-4 w-4 inline-block mr-2" /> Profil
              </Link>
              <Link href="/settings" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                <SettingsIcon class="h-4 w-4 inline-block mr-2" /> Pengaturan
              </Link>
              <button
                @click="handleLogout"
                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900"
                :disabled="logoutForm.processing"
              >
                <LogOutIcon class="h-4 w-4 inline-block mr-2" /> Keluar
              </button>
            </div>
          </div>

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
    <transition name="fade-slide">
      <div v-show="isMobileMenuOpen" class="lg:hidden border-b dark:border-neutral-800">
        <div class="px-4 py-3 space-y-1">
          <Link
            v-for="item in navItems"
            :key="item.title"
            :href="item.href"
            class="block px-3 py-2 rounded-lg font-medium"
            :class="currentPath === item.href 
              ? 'bg-cyan-50 text-cyan-600 dark:bg-neutral-800 dark:text-cyan-400' 
              : 'text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800'"
          >
            {{ item.title }}
          </Link>
        </div>
      </div>
    </transition>
  </header>
</template>

<style scoped>
/* Animasi buka mobile nav */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
