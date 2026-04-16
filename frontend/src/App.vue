<template>
  <div id="app">
    <nav v-if="!isAdminRoute" class="fixed w-full z-50 bg-dark/90 backdrop-blur-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
          <router-link to="/" class="flex items-center space-x-2">
            <span class="text-2xl font-display font-bold text-secondary">Barista</span>
            <span class="text-2xl font-display text-white">Cafe</span>
          </router-link>
          
          <div class="hidden md:flex items-center space-x-8">
            <router-link to="/" class="text-white hover:text-secondary transition-colors">Home</router-link>
            <router-link to="/about" class="text-white hover:text-secondary transition-colors">About</router-link>
            <router-link to="/menu" class="text-white hover:text-secondary transition-colors">Menu</router-link>
            <router-link to="/contact" class="text-white hover:text-secondary transition-colors">Contact</router-link>
            <!-- <router-link to="/admin" class="text-secondary hover:text-white transition-colors text-sm">Admin</router-link> -->
          </div>
          
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
      
      <div v-if="mobileMenuOpen" class="md:hidden bg-dark border-t border-white/10">
        <div class="px-4 py-4 space-y-3">
          <router-link to="/" @click="mobileMenuOpen = false" class="block text-white hover:text-secondary">Home</router-link>
          <router-link to="/about" @click="mobileMenuOpen = false" class="block text-white hover:text-secondary">About</router-link>
          <router-link to="/menu" @click="mobileMenuOpen = false" class="block text-white hover:text-secondary">Menu</router-link>
          <router-link to="/contact" @click="mobileMenuOpen = false" class="block text-white hover:text-secondary">Contact</router-link>
        </div>
      </div>
    </nav>
    
    <router-view />
    
    <footer v-if="!isAdminRoute" class="bg-dark text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <h3 class="font-display text-2xl mb-4">Barista Cafe</h3>
            <p class="text-gray-400">Your favourite coffee daily lives. Visit us for the best coffee experience.</p>
          </div>
          <div>
            <h4 class="font-semibold mb-4">Opening Hours</h4>
            <p class="text-gray-400">Monday - Friday: 7AM - 10PM</p>
            <p class="text-gray-400">Saturday - Sunday: 8AM - 11PM</p>
          </div>
          <div>
            <h4 class="font-semibold mb-4">Contact</h4>
            <p class="text-gray-400">123 Coffee Street, KL</p>
            <p class="text-gray-400">+60 12 345 6789</p>
            <p class="text-gray-400">hello@baristacafe.com</p>
          </div>
        </div>
        <div class="border-t border-white/10 mt-8 pt-8 text-center text-gray-400">
          <p>&copy; 2024 Barista Cafe. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const mobileMenuOpen = ref(false)

const isAdminRoute = computed(() => route.path.startsWith('/admin'))
</script>
