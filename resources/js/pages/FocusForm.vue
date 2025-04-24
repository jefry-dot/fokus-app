<template>
  <Head title="Mulai Fokus" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="min-h-screen flex items-center justify-center p-4 bg-gray-100">
      <form @submit.prevent="handleStart" class="bg-white p-6 rounded-xl shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center">🎯 Mulai Sesi Fokus</h1>

        <!-- Durasi Fokus -->
        <label class="block mb-2 font-semibold">Durasi Fokus</label>
        <select v-model="duration" class="w-full mb-4 border rounded p-2">
          <option value="900">15 menit</option>
          <option value="1500">25 menit</option>
          <option value="3000">50 menit</option>
          <option value="custom">Custom</option>
        </select>

        <input
          v-if="duration === 'custom'"
          type="number"
          v-model.number="customDuration"
          placeholder="Masukkan durasi dalam menit"
          class="w-full mb-4 border rounded p-2"
          min="1"
        />

        <!-- Kategori -->
        <label class="block mb-2 font-semibold">Kategori Aktivitas</label>
        <select v-model="category" class="w-full mb-4 border rounded p-2">
          <option value="">-- Pilih Kategori --</option>
          <option value="Belajar">Belajar</option>
          <option value="Kerja">Kerja</option>
          <option value="Lainnya">Lainnya</option>
        </select>

        <button
          type="submit"
          class="bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-xl shadow"
        >
          Mulai Fokus 🚀
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Mulai Fokus', href: '/focus-form' },
];

const duration = ref('1500');
const customDuration = ref(30);
const category = ref('');

const handleStart = () => {
  const realDuration =
    duration.value === 'custom' ? customDuration.value * 60 : Number(duration.value);

  if (!realDuration || realDuration < 60) {
    alert('Durasi minimal 1 menit!');
    return;
  }
  if (!category.value) {
    alert('Kategori harus dipilih!');
    return;
  }

  // Simpan ke localStorage
  localStorage.setItem(
    'focusSession',
    JSON.stringify({
      duration: realDuration,
      category: category.value,
      startTime: Date.now(),
    })
  );

  // Redirect ke halaman fokus
  router.visit('/focus');
};
</script>
