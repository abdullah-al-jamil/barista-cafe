<template>
  <div class="pt-20">
    <section class="relative h-96 bg-dark">
      <img src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=1920" 
           alt="About" class="w-full h-full object-cover opacity-50">
      <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="font-display text-5xl font-bold text-white">About Us</h1>
      </div>
    </section>

    <section class="py-20 bg-cream">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <img v-if="about?.image" :src="about.image" alt="About" class="rounded-lg shadow-xl">
          </div>
          <div>
            <h2 class="font-display text-4xl font-bold text-dark mb-4">{{ about?.title || 'Our Story' }}</h2>
            <p class="text-lg text-secondary mb-6">{{ about?.subtitle }}</p>
            <p class="text-gray-600 mb-8">{{ about?.content }}</p>
            <div class="grid grid-cols-2 gap-6">
              <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <span class="block text-5xl font-bold text-primary mb-2">{{ about?.founded_year }}</span>
                <span class="text-gray-600">Year Founded</span>
              </div>
              <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <span class="block text-5xl font-bold text-primary mb-2">{{ about?.experience_years }}+</span>
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
          <h2 class="font-display text-4xl font-bold">Meet Our Team</h2>
          <p class="text-gray-400 mt-4">Creative Baristas</p>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
          <div v-for="member in team" :key="member.id" class="text-center group">
            <div class="relative overflow-hidden rounded-full mb-4">
              <img :src="member.image" :alt="member.name" class="w-48 h-48 mx-auto object-cover transition-transform group-hover:scale-110">
            </div>
            <h3 class="font-display text-xl font-semibold">{{ member.name }}</h3>
            <p class="text-secondary">{{ member.position }}</p>
            <p class="text-gray-400 text-sm mt-2">{{ member.bio }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-cream">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="font-display text-4xl font-bold text-dark mb-6">Visit Us Today</h2>
        <p class="text-lg text-gray-600 mb-8">Experience the best coffee in town. We're open 7 days a week.</p>
        <router-link to="/contact" class="inline-block bg-primary text-white px-8 py-3 font-semibold hover:bg-dark transition-colors">
          Get in Touch
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { publicAPI } from '../services/api'

const about = ref(null)
const team = ref([])

async function loadData() {
  try {
    const [aboutRes, teamRes] = await Promise.all([
      publicAPI.getAbout(),
      publicAPI.getTeam(),
    ])
    about.value = aboutRes.data.data
    team.value = teamRes.data.data
  } catch (error) {
    console.error('Error loading data:', error)
  }
}

onMounted(loadData)
</script>
