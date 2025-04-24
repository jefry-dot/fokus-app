<template>
  <Head title="Fokus Sekarang" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="min-h-screen p-6 flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-indigo-900 to-black animate-gradient">
      <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md w-full max-w-md text-center text-gray-900 dark:text-white">
        <h1 class="text-3xl font-bold mb-4">🚀 Fokus Sekarang</h1>

        <p class="text-gray-600 dark:text-gray-300 mb-2">Waktu Fokus:</p>
        <h2 class="text-5xl font-mono font-bold mb-4">{{ time }}</h2>

        <!-- Pilihan kategori -->
        <div class="mb-4 text-left">
          <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-1">Kategori:</label>
          <select v-model="category"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <option disabled value="">Pilih kategori</option>
            <option>Belajar</option>
            <option>Kerja</option>
            <option>Olahraga</option>
            <option>Ibadah</option>
            <option>Lainnya</option>
          </select>
        </div>

        <!-- Input aktivitas -->
        <div class="mb-4 text-left">
          <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-1">Aktivitas:</label>
          <input v-model="activity" type="text"
                 placeholder="Contoh: Ngoding struktur data"
                 class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        </div>

        <div class="flex justify-center gap-4 mb-4">
          <button @click="start" v-if="!isRunning" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl shadow">
            Mulai
          </button>
          <button @click="pause" v-if="isRunning" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl shadow">
            Jeda
          </button>
          <button @click="reset" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl shadow">
            Reset
          </button>
          <button @click="stop" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl shadow">
            Selesai
          </button>
        </div>

        <p class="text-gray-500 dark:text-gray-400 text-sm">Sesi akan otomatis disimpan ke histori kamu</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Fokus Sekarang', href: '/focus' },
];

const duration = 25 * 60;
const timeLeft = ref(duration);
const isRunning = ref(false);
const category = ref('');
const activity = ref('');
let timer: number | null = null;

const time = computed(() => {
  const m = String(Math.floor(timeLeft.value / 60)).padStart(2, '0');
  const s = String(timeLeft.value % 60).padStart(2, '0');
  return `${m}:${s}`;
});

const start = () => {
  if (isRunning.value || !category.value || !activity.value) {
    alert('Harap pilih kategori dan isi aktivitas terlebih dahulu.');
    return;
  }

  isRunning.value = true;

  timer = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--;
    } else {
      finishSession(true);
    }
  }, 1000);
};

const pause = () => {
  clearInterval(timer!);
  isRunning.value = false;
};

const reset = () => {
  clearInterval(timer!);
  timeLeft.value = duration;
  isRunning.value = false;
};

const stop = () => {
  if (duration - timeLeft.value < 60) {
    if (!confirm('Sesi belum 1 menit. Yakin ingin menyimpan?')) return;
  }
  finishSession(false);
};

const finishSession = (autoFinished: boolean) => {
  clearInterval(timer!);
  isRunning.value = false;

  const startedAt = new Date(Date.now() - (duration - timeLeft.value) * 1000).toISOString();
  const endedAt = new Date().toISOString();
  const durationMinutes = Math.round((duration - timeLeft.value) / 60);

  if (durationMinutes <= 0) return;

  alert(autoFinished ? 'Sesi otomatis selesai 🎉' : 'Sesi disimpan!');

  router.post('/focus-sessions', {
    duration_minutes: durationMinutes,
    started_at: startedAt,
    ended_at: endedAt,
    category: category.value,
    activity: activity.value,
  });

  timeLeft.value = duration;
  activity.value = '';
  category.value = '';
};
</script>

<style scoped>
@keyframes gradient {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.animate-gradient {
  background-size: 200% 200%;
  animation: gradient 8s ease infinite;
}
</style>
