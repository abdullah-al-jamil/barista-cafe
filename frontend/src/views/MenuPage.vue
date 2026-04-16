<template>
  <div class="pt-20">
    <section class="relative h-96 bg-dark">
      <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1920" 
           alt="Menu" class="w-full h-full object-cover opacity-50">
      <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="font-display text-5xl font-bold text-white">Our Menu</h1>
      </div>
    </section>

    <section class="py-20 bg-cream">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4 mb-12">
          <button v-for="cat in categories" :key="cat.id"
                  @click="activeCategory = cat.id"
                  class="px-6 py-3 rounded-lg font-semibold transition-all"
                  :class="activeCategory === cat.id ? 'bg-primary text-white shadow-lg' : 'bg-white text-dark hover:bg-secondary'">
            {{ cat.name }}
          </button>
        </div>

        <div class="space-y-12">
          <div v-for="category in categories" :key="category.id" 
               :id="'category-' + category.id"
               class="scroll-mt-24">
            <div v-if="!activeCategory || activeCategory === category.id">
              <h2 class="font-display text-3xl font-bold text-dark mb-8 border-b-2 border-primary pb-4">
                {{ category.name }}
              </h2>
              <div class="grid md:grid-cols-2 gap-6">
                <div v-for="item in getItemsByCategory(category.id)" :key="item.id" 
                     class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition-shadow flex gap-6">
                  <img :src="item.image || 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200'" 
                       :alt="item.name" 
                       class="w-24 h-24 rounded-lg object-cover flex-shrink-0">
                  <div class="flex-grow">
                    <div class="flex justify-between items-start mb-2">
                      <h3 class="font-display text-xl font-semibold">{{ item.name }}</h3>
                      <span class="text-2xl font-bold text-primary">${{ item.price }}</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">{{ item.description }}</p>
                    <span v-if="item.is_featured" class="inline-block bg-secondary text-dark px-2 py-1 text-xs font-semibold rounded">
                      Recommended
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { publicAPI } from '../services/api'

const menuItems = ref([])
const categories = ref([])
const activeCategory = ref(null)

const itemsByCategory = computed(() => {
  const grouped = {}
  menuItems.value.forEach(item => {
    const catId = item.category_id
    if (!grouped[catId]) grouped[catId] = []
    grouped[catId].push(item)
  })
  return grouped
})

function getItemsByCategory(categoryId) {
  return itemsByCategory.value[categoryId] || []
}

async function loadData() {
  try {
    const [menuRes, catsRes] = await Promise.all([
      publicAPI.getMenu(),
      publicAPI.getMenuCategories(),
    ])
    menuItems.value = menuRes.data.data
    categories.value = catsRes.data.data
  } catch (error) {
    console.error('Error loading menu:', error)
  }
}

onMounted(loadData)
</script>
