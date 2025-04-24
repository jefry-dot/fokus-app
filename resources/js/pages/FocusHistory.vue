<template>
  <Head title="Riwayat Fokus" />
  <AppLayout>
    <div class="p-6 max-w-4xl mx-auto">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold flex items-center gap-2 text-gray-900 dark:text-white">
          📊 Riwayat Fokus
          <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            (Total: {{ sessions.length }} sesi)
          </span>
        </h1>
      </div>

      <div class="overflow-x-auto bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg shadow-sm">
        <table class="w-full text-sm text-gray-800 dark:text-gray-200">
          <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <th 
                v-for="header in headers" 
                :key="header.key" 
                class="text-left px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200"
                @click="sortBy(header.key)"
              >
                <div class="flex items-center gap-2">
                  {{ header.label }}
                  <span v-if="sortColumn === header.key">
                    {{ sortDirection === 'asc' ? '↑' : '↓' }}
                  </span>
                </div>
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="s in sortedSessions" :key="s.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
              <td class="border-t border-gray-200 dark:border-gray-700 px-4 py-2">
                <div>{{ formatDate(s.created_at) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ relativeDate(s.created_at) }}</div>
              </td>
              <td class="border-t border-gray-200 dark:border-gray-700 px-4 py-2">
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-200">
                  {{ Math.floor(s.duration / 60) }} menit
                </span>
              </td>
              <td class="border-t border-gray-200 dark:border-gray-700 px-4 py-2">
                <span class="flex items-center gap-2">
                  {{ categoryIcons[s.category] || '📌' }} {{ s.category || 'Umum' }}
                </span>
              </td>
            </tr>

            <tr v-if="!sessions.length">
              <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 px-4 py-4">Belum ada riwayat fokus</td>
            </tr>
          </tbody>
        </table>

        <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300">
          Total durasi: {{ totalDuration }} menit
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, computed } from 'vue'

const { sessions } = usePage().props

const headers = [
  { label: 'Tanggal', key: 'created_at' },
  { label: 'Durasi', key: 'duration' },
  { label: 'Kategori', key: 'category' },
]

const sortColumn = ref('created_at')
const sortDirection = ref('desc')

function sortBy(key) {
  if (sortColumn.value === key) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortColumn.value = key
    sortDirection.value = 'desc'
  }
}

const sortedSessions = computed(() => {
  return [...sessions].sort((a, b) => {
    let modifier = sortDirection.value === 'asc' ? 1 : -1
    if (sortColumn.value === 'created_at') {
      return (new Date(a[sortColumn.value]) - new Date(b[sortColumn.value])) * modifier
    }
    return (a[sortColumn.value] > b[sortColumn.value] ? 1 : -1) * modifier
  })
})

const totalDuration = computed(() => {
  return Math.floor(sessions.reduce((acc, s) => acc + s.duration, 0) / 60)
})

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

function relativeDate(dateStr) {
  const date = new Date(dateStr)
  const now = new Date()
  const diffDays = Math.floor((now - date) / (1000 * 60 * 60 * 24))
  if (diffDays === 0) return 'Hari ini'
  if (diffDays === 1) return 'Kemarin'
  return `${diffDays} hari lalu`
}

const categoryIcons = {
  'Belajar': '📚',
  'Kerja': '💼',
  'Olahraga': '🏋️',
  'Baca': '📖',
  'Hobi': '🎨',
}
</script>
