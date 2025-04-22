<template>
  <div class="h-screen bg-gray-900 text-white flex flex-col justify-center items-center p-6">
    <h1 class="text-5xl font-bold mb-4 text-center animate-fade-in">
      Selamat Datang di Aplikasi Fokus!
    </h1>

    <!-- Deskripsi dengan animasi fade-in -->
    <p class="text-lg text-gray-300 mb-8 text-center max-w-2xl animate-fade-in">
      Tingkatkan produktivitas Anda dengan aplikasi fokus yang kami buat khusus untuk Anda.
    </p>

    <!-- Container tombol -->
    <div class="flex flex-col items-center space-y-6">
      <!-- Tombol Login/Register -->
      <div v-if="!$page.props.auth.user" class="flex gap-4">
        <Link 
          href="/login" 
          class="px-8 py-4 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300 
                shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 flex items-center gap-2 text-lg"
        >
          <span>🚀</span> Login
        </Link>
        <Link 
          href="/register" 
          class="px-8 py-4 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all duration-300 
                shadow-lg shadow-green-500/20 hover:shadow-green-500/40 flex items-center gap-2 text-lg"
        >
          <span>✨</span> Daftar
        </Link>
      </div>

      <!-- Tombol Dashboard -->
      <div v-else>
        <Link 
          href="/dashboard" 
          class="px-8 py-4 bg-indigo-500 text-white rounded-xl hover:bg-indigo-600 transition-all duration-300 
                shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 flex items-center gap-2 text-lg"
        >
          <span>📊</span> Ke Dashboard
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
  auth: {
    user: object | null;
  };
}>();
</script>

<!-- Jika belum punya, tambahkan definisi animasi di file global CSS atau Tailwind config -->
<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.8s ease-out forwards;
}
</style>
