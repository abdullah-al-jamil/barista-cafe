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
              <router-link to="/admin/reservations" class="px-3 py-2 text-primary font-semibold">Reservations</router-link>
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
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Reservations</h1>
        <p class="text-gray-600">Manage customer reservations</p>
      </div>

      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guests</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="res in reservations" :key="res.id">
              <td class="px-6 py-4">
                <div class="font-medium">{{ res.name }}</div>
                <div class="text-sm text-gray-500">{{ res.email }}</div>
                <div class="text-sm text-gray-500">{{ res.phone }}</div>
              </td>
              <td class="px-6 py-4">
                <div>{{ formatDate(res.date) }}</div>
                <div class="text-sm text-gray-500">{{ res.time }}</div>
              </td>
              <td class="px-6 py-4">{{ res.guests }}</td>
              <td class="px-6 py-4">
                <select v-model="res.status" @change="updateStatus(res)"
                        class="text-sm border rounded px-2 py-1">
                  <option value="pending">Pending</option>
                  <option value="confirmed">Confirmed</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ res.message }}</td>
              <td class="px-6 py-4 text-right">
                <button @click="deleteReservation(res.id)" class="text-red-600 hover:text-red-800">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
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
const reservations = ref([])

async function loadReservations() {
  const response = await adminAPI.reservations.list()
  reservations.value = response.data.data
}

async function updateStatus(reservation) {
  await adminAPI.reservations.update(reservation.id, { status: reservation.status })
}

async function deleteReservation(id) {
  if (confirm('Delete this reservation?')) {
    await adminAPI.reservations.delete(id)
    loadReservations()
  }
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' })
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadReservations)
</script>
