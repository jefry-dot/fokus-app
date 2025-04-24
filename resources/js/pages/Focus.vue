<template>
  <Head title="Fokus Sekarang" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="min-h-screen p-6 flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-indigo-900 to-black animate-gradient">
      <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-4">🚀 Fokus Sekarang</h1>

        <p class="text-gray-600 mb-2">Waktu Fokus:</p>
        <h2 class="text-5xl font-mono font-bold mb-4">{{ time }}</h2>

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

        <p class="text-gray-500 text-sm">Sesi fokus akan disimpan otomatis saat selesai</p>
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
let timer: number | null = null;

const formatTime = (seconds: number) => {
  const m = String(Math.floor(seconds / 60)).padStart(2, '0');
  const s = String(seconds % 60).padStart(2, '0');
  return `${m}:${s}`;
};

const time = computed(() => formatTime(timeLeft.value));

const start = () => {
  if (isRunning.value) return;
  isRunning.value = true;
  timer = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--;
    } else {
      finishSession(true); // selesai otomatis
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
    if (!confirm('Sesi fokus belum 1 menit. Yakin ingin menghentikan?')) return;
  }
  finishSession(false);
};

const finishSession = (autoFinished: boolean) => {
  clearInterval(timer!);
  isRunning.value = false;

  const focusedDuration = duration - timeLeft.value;
  if (focusedDuration <= 0) return;

  alert(autoFinished ? 'Sesi selesai 🎉' : 'Sesi dihentikan dan disimpan');

  // Simpan sesi ke DB
  router.post('/focus/save', {
    duration: focusedDuration, // detik
    ended_by: autoFinished ? 'auto' : 'manual',
  });

  timeLeft.value = duration;
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
