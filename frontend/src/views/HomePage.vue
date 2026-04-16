<template>
  <div>
    <section class="relative h-screen overflow-hidden">
      <div v-if="loading" class="absolute inset-0 flex items-center justify-center bg-dark">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent"></div>
      </div>
      
      <template v-else-if="slides.length">
        <div v-for="(slide, index) in slides" :key="slide.id" 
             class="absolute inset-0 transition-opacity duration-1000"
             :class="index === currentSlide ? 'opacity-100' : 'opacity-0'">
          <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover zoom-effect">
          <div class="absolute inset-0 bg-dark/50"></div>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white fade-in">
              <h1 class="font-display text-5xl md:text-7xl font-bold mb-4">{{ slide.title }}</h1>
              <p class="text-xl md:text-2xl mb-8">{{ slide.subtitle }}</p>
              <a v-if="slide.button_text" :href="slide.button_url" 
                 class="inline-block bg-secondary text-dark px-8 py-3 font-semibold hover:bg-white transition-colors">
                {{ slide.button_text }}
              </a>
            </div>
          </div>
        </div>
      </template>
      
      <div v-else class="absolute inset-0 flex items-center justify-center bg-dark">
        <div class="text-center text-white">
          <h1 class="font-display text-5xl md:text-7xl font-bold mb-4">Barista Cafe</h1>
          <p class="text-xl md:text-2xl mb-8">Your favourite coffee daily lives</p>
          <a href="#menu" class="inline-block bg-secondary text-dark px-8 py-3 font-semibold hover:bg-white transition-colors">
            Check Menu
          </a>
        </div>
      </div>
      
      <div v-if="slides.length > 1" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
        <button v-for="(_, index) in slides" :key="index"
                @click="currentSlide = index"
                class="w-3 h-3 rounded-full transition-colors"
                :class="index === currentSlide ? 'bg-secondary' : 'bg-white/50 hover:bg-white'">
        </button>
      </div>
    </section>

    <section id="about" class="py-20 bg-cream">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <img v-if="about?.image" :src="about.image" alt="About Us" class="rounded-lg shadow-xl">
          </div>
          <div>
            <h2 class="font-display text-4xl font-bold text-dark mb-4">{{ about?.title || 'Our Story' }}</h2>
            <p class="text-lg text-gray-600 mb-6">{{ about?.subtitle }}</p>
            <p class="text-gray-600 mb-8">{{ about?.content || 'Loading...' }}</p>
            <div class="grid grid-cols-2 gap-6">
              <div class="text-center p-6 bg-white rounded-lg shadow">
                <span class="block text-4xl font-bold text-primary">{{ about?.founded_year || '2015' }}</span>
                <span class="text-gray-600">Founded</span>
              </div>
              <div class="text-center p-6 bg-white rounded-lg shadow">
                <span class="block text-4xl font-bold text-primary">{{ about?.experience_years || '10' }}+</span>
                <span class="text-gray-600">Years Experience</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-dark text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="font-display text-4xl font-bold">Meet People</h2>
          <p class="text-gray-400 mt-4">Our Creative Baristas</p>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
          <div v-for="member in team" :key="member.id" class="text-center">
            <img :src="member.image" :alt="member.name" class="w-48 h-48 mx-auto rounded-full object-cover mb-4">
            <h3 class="font-display text-xl font-semibold">{{ member.name }}</h3>
            <p class="text-secondary">{{ member.position }}</p>
            <p class="text-gray-400 text-sm mt-2">{{ member.bio }}</p>
          </div>
        </div>
      </div>
    </section>

    <section id="menu" class="py-20 bg-cream">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="font-display text-4xl font-bold text-dark">Delicious Menu</h2>
          <p class="text-gray-600 mt-4">Explore our finest selections</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-4 mb-12">
          <button v-for="cat in categories" :key="cat.id"
                  @click="activeCategory = cat.id"
                  class="px-6 py-2 rounded-full transition-colors"
                  :class="activeCategory === cat.id ? 'bg-primary text-white' : 'bg-white text-dark hover:bg-secondary'">
            {{ cat.name }}
          </button>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="item in filteredItems" :key="item.id" class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
            <div class="relative">
              <img :src="item.image || 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400'" 
                   :alt="item.name" class="w-full h-48 object-cover">
              <span v-if="item.is_featured" class="absolute top-4 right-4 bg-secondary text-dark px-3 py-1 text-sm font-semibold rounded">
                Recommend
              </span>
            </div>
            <div class="p-6">
              <h3 class="font-display text-xl font-semibold mb-2">{{ item.name }}</h3>
              <p class="text-gray-600 text-sm mb-4">{{ item.description }}</p>
              <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-primary">${{ item.price }}</span>
                <span v-if="item.original_price" class="text-gray-400 line-through">${{ item.original_price }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="font-display text-4xl font-bold text-dark">Reviews by Customers</h2>
          <p class="text-gray-600 mt-4">What they say about us</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="review in testimonials" :key="review.id" class="bg-cream p-8 rounded-lg">
            <div class="flex items-center mb-4">
              <img v-if="review.image" :src="review.image" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-semibold">{{ review.name }}</h4>
                <p class="text-sm text-gray-500">{{ review.location }}</p>
              </div>
            </div>
            <p class="text-gray-600 mb-4">"{{ review.content }}"</p>
            <div class="flex text-yellow-400">
              <span v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-primary text-white">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="font-display text-4xl font-bold mb-6">Make a Reservation</h2>
        <p class="text-lg mb-8 opacity-90">Book a table and enjoy our delicious coffee and food</p>
        <router-link to="/contact" class="inline-block bg-white text-primary px-8 py-3 font-semibold hover:bg-cream transition-colors">
          Reserve Now
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { publicAPI } from '../services/api'

const slides = ref([])
const currentSlide = ref(0)
const loading = ref(true)
const about = ref(null)
const team = ref([])
const menuItems = ref([])
const categories = ref([])
const testimonials = ref([])
const activeCategory = ref(null)

let slideInterval = null

const filteredItems = computed(() => {
  if (!activeCategory.value) return menuItems.value
  return menuItems.value.filter(item => item.category_id === activeCategory.value)
})

async function loadData() {
  try {
    const [slidesRes, aboutRes, teamRes, menuRes, testimonialsRes] = await Promise.all([
      publicAPI.getHeroSlides(),
      publicAPI.getAbout(),
      publicAPI.getTeam(),
      publicAPI.getMenu(),
      publicAPI.getTestimonials(),
    ])
    
    slides.value = slidesRes.data.data
    about.value = aboutRes.data.data
    team.value = teamRes.data.data
    menuItems.value = menuRes.data.data
    testimonials.value = testimonialsRes.data.data
    
    const uniqueCategories = [...new Set(menuItems.value.map(item => item.category_id))]
    categories.value = uniqueCategories.map(id => {
      const item = menuItems.value.find(i => i.category_id === id)
      return { id, name: item?.category?.name || 'Other' }
    })
    if (categories.value.length) activeCategory.value = categories.value[0].id
    
  } catch (error) {
    console.error('Error loading data:', error)
  } finally {
    loading.value = false
  }
}

function startSlider() {
  if (slides.value.length > 1) {
    slideInterval = setInterval(() => {
      currentSlide.value = (currentSlide.value + 1) % slides.value.length
    }, 5000)
  }
}

onMounted(() => {
  loadData()
  startSlider()
})

onUnmounted(() => {
  if (slideInterval) clearInterval(slideInterval)
})
</script>
