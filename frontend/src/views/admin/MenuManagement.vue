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
              <router-link to="/admin/menu" class="px-3 py-2 text-primary font-semibold">Menu</router-link>
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
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Menu Management</h1>
          <p class="text-gray-600">Manage categories and items</p>
        </div>
        <button @click="openCategoryModal()" class="bg-secondary text-dark px-4 py-2 rounded-lg hover:bg-primary hover:text-white">
          Add Category
        </button>
      </div>

      <div class="space-y-8">
        <div v-for="category in categories" :key="category.id" class="bg-white rounded-lg shadow">
          <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">{{ category.name }}</h2>
            <div class="space-x-2">
              <button @click="openItemModal(null, category.id)" class="text-sm bg-primary text-white px-3 py-1 rounded">Add Item</button>
              <button @click="openCategoryModal(category)" class="text-sm text-gray-600 hover:text-primary">Edit</button>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Featured</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="item in category.items" :key="item.id">
                  <td class="px-4 py-3">
                    <img :src="item.image || 'https://via.placeholder.com/50'" class="w-12 h-12 object-cover rounded">
                  </td>
                  <td class="px-4 py-3">{{ item.name }}</td>
                  <td class="px-4 py-3">${{ item.price }}</td>
                  <td class="px-4 py-3">
                    <span v-if="item.is_featured" class="text-yellow-500">★</span>
                  </td>
                  <td class="px-4 py-3">
                    <span :class="item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" 
                          class="px-2 py-1 text-xs rounded-full">
                      {{ item.is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-right space-x-2">
                    <button @click="openItemModal(item)" class="text-primary hover:text-dark text-sm">Edit</button>
                    <button @click="deleteItem(item.id)" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <div v-if="showCategoryModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">{{ editingCategory ? 'Edit' : 'Add' }} Category</h2>
        <form @submit.prevent="saveCategory" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input v-model="categoryForm.name" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input v-model="categoryForm.slug" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea v-model="categoryForm.description" class="w-full border rounded px-3 py-2"></textarea>
          </div>
          <div class="flex items-center">
            <input v-model="categoryForm.is_active" type="checkbox" id="cat_active" class="mr-2">
            <label for="cat_active">Active</label>
          </div>
          <div class="flex justify-end gap-2 mt-6">
            <button type="button" @click="showCategoryModal = false" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded">Save</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showItemModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">{{ editingItem ? 'Edit' : 'Add' }} Menu Item</h2>
        <form @submit.prevent="saveItem" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input v-model="itemForm.name" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input v-model="itemForm.slug" type="text" required class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea v-model="itemForm.description" class="w-full border rounded px-3 py-2"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
              <input v-model="itemForm.price" type="number" step="0.01" min="0" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Original Price ($)</label>
              <input v-model="itemForm.original_price" type="number" step="0.01" min="0" class="w-full border rounded px-3 py-2">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
            <input v-model="itemForm.image" type="url" class="w-full border rounded px-3 py-2">
          </div>
          <div class="flex items-center gap-4">
            <div class="flex items-center">
              <input v-model="itemForm.is_featured" type="checkbox" id="featured" class="mr-2">
              <label for="featured">Featured</label>
            </div>
            <div class="flex items-center">
              <input v-model="itemForm.is_active" type="checkbox" id="item_active" class="mr-2">
              <label for="item_active">Active</label>
            </div>
          </div>
          <div class="flex justify-end gap-2 mt-6">
            <button type="button" @click="showItemModal = false" class="px-4 py-2 border rounded">Cancel</button>
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
const categories = ref([])
const showCategoryModal = ref(false)
const showItemModal = ref(false)
const editingCategory = ref(null)
const editingItem = ref(null)
const selectedCategoryId = ref(null)

const categoryForm = ref({ name: '', slug: '', description: '', is_active: true })
const itemForm = ref({ category_id: null, name: '', slug: '', description: '', price: 0, original_price: null, image: '', is_featured: false, is_active: true })

async function loadCategories() {
  const response = await adminAPI.menuCategories.list()
  categories.value = response.data.data
}

function openCategoryModal(category = null) {
  if (category) {
    editingCategory.value = category
    categoryForm.value = { ...category }
  } else {
    editingCategory.value = null
    categoryForm.value = { name: '', slug: '', description: '', is_active: true }
  }
  showCategoryModal.value = true
}

async function saveCategory() {
  try {
    if (editingCategory.value) {
      await adminAPI.menuCategories.update(editingCategory.value.id, categoryForm.value)
    } else {
      await adminAPI.menuCategories.create(categoryForm.value)
    }
    showCategoryModal.value = false
    loadCategories()
  } catch (error) {
    alert('Error saving category')
  }
}

function openItemModal(item, categoryId = null) {
  if (item) {
    editingItem.value = item
    itemForm.value = { ...item, category_id: item.category_id }
  } else {
    editingItem.value = null
    itemForm.value = { category_id: categoryId, name: '', slug: '', description: '', price: 0, original_price: null, image: '', is_featured: false, is_active: true }
  }
  showItemModal.value = true
}

async function saveItem() {
  try {
    if (editingItem.value) {
      await adminAPI.menuItems.update(editingItem.value.id, itemForm.value)
    } else {
      await adminAPI.menuItems.create(itemForm.value)
    }
    showItemModal.value = false
    loadCategories()
  } catch (error) {
    alert('Error saving item')
  }
}

async function deleteItem(id) {
  if (confirm('Delete this item?')) {
    await adminAPI.menuItems.delete(id)
    loadCategories()
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'AdminLogin' })
}

onMounted(loadCategories)
</script>
