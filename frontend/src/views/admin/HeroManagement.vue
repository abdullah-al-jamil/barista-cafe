<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/admin/dashboard" class="font-display text-xl font-bold text-primary">Admin Panel</router-link>
            <div class="hidden md:flex ml-10 space-x-4">
              <router-link to="/admin/dashboard" class="px-3 py-2 text-gray-700 hover:text-primary">Dashboard</router-link>
              <router-link to="/admin/hero" class="px-3 py-2 text-primary font-semibold">Hero Slides</router-link>
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
      <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Hero Slides</h1>
        <button @click="openModal()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-dark">
          Add New Slide
        </button>
      </div>

      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="slide in slides" :key="slide.id">
              <td class="px-6 py-4">
                <img :src="slide.image" class="w-20 h-12 object-cover rounded">
              </td>
              <td class="px-6 py-4">{{ slide.title }}</td>
              <td class="px-6 py-4">
                <span :class="slide.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                      class="px-2 py-1 text-xs rounded-full">
                  {{ slide.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4">{{ slide.order }}</td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="openModal(slide)" class="text-primary hover:text-dark">Edit</button>
                <button @click="deleteSlide(slide.id)" class="text-red-600 hover:text-red-800">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <div v-if="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">{{ editingSlide ? 'Edit' : 'Add' }} Hero Slide</h2>
        <form @submit.prevent="saveSlide" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input v-model="form.title" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
            <input v-model="form.subtitle" type="text" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
            <input v-model="form.image" type="url" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
            <input v-model="form.button_text" type="text" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
            <input v-model="form.button_url" type="text" class="w-full border rounded px-3 py-2">
          </div>
          <div class="flex items-center gap-4">
            <div class="flex items-center">
              <input v-model="form.is_active" type="checkbox" id="is_active" class="mr-2">
              <label for="is_active">Active</label>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
              <input v-model="form.order" type="number" min="0" class="w-24 border rounded px-3 py-2">
            </div>
          </div>
          <div class="flex justify-end gap-2 mt-6">
            <button type="button" @click="showModal = false" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { adminAPI } from '../../services/api'

const router = useRouter()
const authStore = useAuthStore()
const slides = ref([])
const showModal = ref(false)
const editingSlide = ref(null)
const form = ref({ title: '', subtitle: '', image: '', button_text: '', button_url: '', is_active: true, order: 0 })

async function loadSlides() {
  const response = await adminAPI.heroSlides.list()
  slides.value = response.data.data
}

function openModal(slide = null) {
  if (slide) {
    editingSlide.value = slide
    form.value = { ...slide }
  } else {
    editingSlide.value = null
    form.value = { title: '', subtitle: '', image: '', button_text: '', button_url: '', is_active: true, order: 0 }
  }
  showModal.value = true
}

async function saveSlide() {
  try {
    if (editingSlide.value) {
      await adminAPI.heroSlides.update(editingSlide.value.id, form.value)
    } else {
      await adminAPI.heroSlides.create(form.value)
    }
    showModal.value = false
    loadSlides()
  } catch (error) {
    alert('Error saving slide')
  }
}

async function deleteSlide(id) {
  if (confirm('Delete this slide?')) {
    await adminAPI.heroSlides.delete(id)
    loadSlides()
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadSlides)
</script>
