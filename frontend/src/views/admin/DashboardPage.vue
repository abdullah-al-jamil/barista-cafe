<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/admin/dashboard" class="font-display text-xl font-bold text-primary">Admin Panel</router-link>
            <div class="hidden md:flex ml-10 space-x-4">
              <router-link to="/admin/dashboard" class="px-3 py-2 text-gray-700 hover:text-primary">Dashboard</router-link>
              <router-link to="/admin/hero" class="px-3 py-2 text-gray-700 hover:text-primary">Hero Slides</router-link>
              <router-link to="/admin/menu" class="px-3 py-2 text-gray-700 hover:text-primary">Menu</router-link>
              <router-link to="/admin/team" class="px-3 py-2 text-gray-700 hover:text-primary">Team</router-link>
              <router-link to="/admin/testimonials" class="px-3 py-2 text-gray-700 hover:text-primary">Reviews</router-link>
              <router-link to="/admin/reservations" class="px-3 py-2 text-gray-700 hover:text-primary">Reservations</router-link>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <router-link to="/" class="text-gray-600 hover:text-primary">View Site</router-link>
            <button @click="handleLogout" class="text-red-600 hover:text-red-800">Logout</button>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ authStore.user?.name }}</p>
      </div>

      <div v-if="loading" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent mx-auto"></div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Menu Items</p>
              <p class="text-3xl font-bold text-dark">{{ stats.menu_items }}</p>
            </div>
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
              <span class="text-primary text-2xl">☕</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Categories</p>
              <p class="text-3xl font-bold text-dark">{{ stats.categories }}</p>
            </div>
            <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center">
              <span class="text-secondary text-2xl">📋</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Pending Reservations</p>
              <p class="text-3xl font-bold text-dark">{{ stats.pending_reservations }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
              <span class="text-yellow-600 text-2xl">📅</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Pending Reviews</p>
              <p class="text-3xl font-bold text-dark">{{ stats.pending_testimonials }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
              <span class="text-green-600 text-2xl">⭐</span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8 grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
          <div class="space-y-2">
            <router-link to="/admin/menu" class="block p-3 bg-gray-50 rounded hover:bg-gray-100">
              Manage Menu Items →
            </router-link>
            <router-link to="/admin/team" class="block p-3 bg-gray-50 rounded hover:bg-gray-100">
              Manage Team Members →
            </router-link>
            <router-link to="/admin/hero" class="block p-3 bg-gray-50 rounded hover:bg-gray-100">
              Edit Hero Slides →
            </router-link>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4">Pending Actions</h2>
          <div class="space-y-2">
            <router-link v-if="stats.pending_reservations > 0" to="/admin/reservations" 
                         class="block p-3 bg-yellow-50 rounded text-yellow-700">
              {{ stats.pending_reservations }} reservations need review →
            </router-link>
            <router-link v-if="stats.pending_testimonials > 0" to="/admin/testimonials" 
                         class="block p-3 bg-green-50 rounded text-green-700">
              {{ stats.pending_testimonials }} reviews need approval →
            </router-link>
            <p v-if="stats.pending_reservations === 0 && stats.pending_testimonials === 0" class="text-gray-500">
              All caught up! No pending actions.
            </p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { adminAPI } from '../../services/api'

const router = useRouter()
const authStore = useAuthStore()
const stats = ref({ menu_items: 0, categories: 0, pending_reservations: 0, pending_testimonials: 0 })
const loading = ref(true)

async function loadStats() {
  try {
    const response = await adminAPI.getStats()
    stats.value = response.data.data
  } catch (error) {
    console.error('Error loading stats:', error)
  } finally {
    loading.value = false
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadStats)
</script>
