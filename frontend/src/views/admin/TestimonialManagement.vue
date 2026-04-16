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
              <router-link to="/admin/testimonials" class="px-3 py-2 text-primary font-semibold">Reviews</router-link>
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
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Customer Reviews</h1>
        <p class="text-gray-600">Manage customer testimonials</p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="review in testimonials" :key="review.id" class="bg-white rounded-lg shadow p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h3 class="font-semibold">{{ review.name }}</h3>
              <p class="text-sm text-gray-500">{{ review.location }}</p>
            </div>
            <div class="flex text-yellow-400">
              <span v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
            </div>
          </div>
          <p class="text-gray-600 mb-4">"{{ review.content }}"</p>
          <div class="flex justify-between items-center pt-4 border-t">
            <div class="flex items-center gap-2">
              <span v-if="review.is_approved" class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full">Approved</span>
              <span v-else class="bg-yellow-100 text-yellow-800 px-2 py-1 text-xs rounded-full">Pending</span>
            </div>
            <div class="space-x-2">
              <template v-if="!review.is_approved">
                <button @click="approveReview(review.id)" class="text-green-600 hover:text-green-800 text-sm">Approve</button>
              </template>
              <button @click="deleteReview(review.id)" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
            </div>
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
const testimonials = ref([])

async function loadTestimonials() {
  const response = await adminAPI.testimonials.list()
  testimonials.value = response.data.data
}

async function approveReview(id) {
  await adminAPI.testimonials.approve(id)
  loadTestimonials()
}

async function deleteReview(id) {
  if (confirm('Delete this review?')) {
    await adminAPI.testimonials.delete(id)
    loadTestimonials()
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadTestimonials)
</script>
