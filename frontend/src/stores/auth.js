import { defineStore } from 'pinia'
import { ref } from 'vue'
import { authAPI } from '../services/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('admin_token'))
  const loading = ref(false)
  
  async function login(credentials) {
    loading.value = true
    try {
      const response = await authAPI.login(credentials)
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('admin_token', response.data.token)
      return true
    } catch (error) {
      throw error
    } finally {
      loading.value = false
    }
  }
  
  async function logout() {
    try {
      await authAPI.logout()
    } catch (e) {
      // ignore
    }
    token.value = null
    user.value = null
    localStorage.removeItem('admin_token')
  }
  
  async function checkAuth() {
    if (!token.value) return false
    try {
      const response = await authAPI.me()
      user.value = response.data.user
      return true
    } catch {
      logout()
      return false
    }
  }
  
  return { user, token, loading, login, logout, checkAuth }
})
