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
              <router-link to="/admin/team" class="px-3 py-2 text-primary font-semibold">Team</router-link>
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
        <h1 class="text-3xl font-bold text-gray-900">Team Members</h1>
        <button @click="openModal()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-dark">
          Add Team Member
        </button>
      </div>

      <div class="grid md:grid-cols-4 gap-6">
        <div v-for="member in team" :key="member.id" class="bg-white rounded-lg shadow overflow-hidden">
          <img :src="member.image" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg">{{ member.name }}</h3>
            <p class="text-secondary text-sm">{{ member.position }}</p>
            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ member.bio }}</p>
            <div class="mt-4 flex justify-between items-center">
              <span :class="member.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                    class="px-2 py-1 text-xs rounded-full">
                {{ member.is_active ? 'Active' : 'Inactive' }}
              </span>
              <div class="space-x-2">
                <button @click="openModal(member)" class="text-primary text-sm">Edit</button>
                <button @click="deleteMember(member.id)" class="text-red-600 text-sm">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div v-if="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">{{ editingMember ? 'Edit' : 'Add' }} Team Member</h2>
        <form @submit.prevent="saveMember" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input v-model="form.name" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
            <input v-model="form.position" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
            <textarea v-model="form.bio" class="w-full border rounded px-3 py-2"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
            <input v-model="form.image" type="url" required class="w-full border rounded px-3 py-2">
          </div>
          <div class="flex items-center gap-4">
            <div class="flex items-center">
              <input v-model="form.is_active" type="checkbox" id="active" class="mr-2">
              <label for="active">Active</label>
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
const team = ref([])
const showModal = ref(false)
const editingMember = ref(null)
const form = ref({ name: '', position: '', bio: '', image: '', is_active: true, order: 0 })

async function loadTeam() {
  const response = await adminAPI.team.list()
  team.value = response.data.data
}

function openModal(member = null) {
  if (member) {
    editingMember.value = member
    form.value = { ...member }
  } else {
    editingMember.value = null
    form.value = { name: '', position: '', bio: '', image: '', is_active: true, order: 0 }
  }
  showModal.value = true
}

async function saveMember() {
  try {
    if (editingMember.value) {
      await adminAPI.team.update(editingMember.value.id, form.value)
    } else {
      await adminAPI.team.create(form.value)
    }
    showModal.value = false
    loadTeam()
  } catch (error) {
    alert('Error saving team member')
  }
}

async function deleteMember(id) {
  if (confirm('Delete this team member?')) {
    await adminAPI.team.delete(id)
    loadTeam()
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadTeam)
</script>
