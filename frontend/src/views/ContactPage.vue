<template>
  <div class="pt-20">
    <section class="relative h-96 bg-dark">
      <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=1920" 
           alt="Contact" class="w-full h-full object-cover opacity-50">
      <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="font-display text-5xl font-bold text-white">Contact Us</h1>
      </div>
    </section>

    <section class="py-20 bg-cream">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12">
          <div>
            <h2 class="font-display text-3xl font-bold text-dark mb-6">Get in Touch</h2>
            <p class="text-gray-600 mb-8">Have a question or want to make a reservation? Fill out the form and we'll get back to you shortly.</p>
            
            <div class="space-y-6">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-dark">Location</h3>
                  <p class="text-gray-600">123 Coffee Street, Kuala Lumpur, Malaysia</p>
                </div>
              </div>
              
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-dark">Phone</h3>
                  <p class="text-gray-600">+60 12 345 6789</p>
                </div>
              </div>
              
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-dark">Opening Hours</h3>
                  <p class="text-gray-600">Mon - Fri: 7AM - 10PM</p>
                  <p class="text-gray-600">Sat - Sun: 8AM - 11PM</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="font-display text-2xl font-bold text-dark mb-6">Make a Reservation</h2>
            
            <div v-if="success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
              {{ success }}
            </div>
            
            <form @submit.prevent="submitReservation" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input v-model="form.name" type="text" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
              
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                  <input v-model="form.email" type="email" required
                         class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                  <input v-model="form.phone" type="tel"
                         class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
              </div>
              
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                  <input v-model="form.date" type="date" required
                         class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Time *</label>
                  <input v-model="form.time" type="time" required
                         class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Guests *</label>
                  <select v-model="form.guests" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option v-for="n in 10" :key="n" :value="n">{{ n }} {{ n === 1 ? 'Guest' : 'Guests' }}</option>
                  </select>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                <textarea v-model="form.message" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
              </div>
              
              <button type="submit" :disabled="loading"
                      class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-dark transition-colors disabled:opacity-50">
                {{ loading ? 'Submitting...' : 'Book Reservation' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { publicAPI } from '../services/api'

const form = ref({
  name: '',
  email: '',
  phone: '',
  date: '',
  time: '',
  guests: 2,
  message: '',
})

const loading = ref(false)
const success = ref('')

async function submitReservation() {
  loading.value = true
  success.value = ''
  try {
    await publicAPI.submitReservation(form.value)
    success.value = 'Reservation submitted successfully! We will contact you to confirm.'
    form.value = { name: '', email: '', phone: '', date: '', time: '', guests: 2, message: '' }
  } catch (error) {
    alert('Failed to submit reservation. Please try again.')
  } finally {
    loading.value = false
  }
}
</script>
