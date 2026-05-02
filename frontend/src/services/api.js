import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ? `${import.meta.env.VITE_API_URL}/api` : '/api',
  headers: {
    'Content-Type': 'application/json'
  }
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('admin_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

export const authAPI = {
  login: (data) => api.post('/auth/login', data),
  logout: () => api.post('/auth/logout'),
  me: () => api.get('/auth/me'),
}

export const publicAPI = {
  getHeroSlides: () => api.get('/public/hero-slides'),
  getAbout: () => api.get('/public/about'),
  getTeam: () => api.get('/public/team'),
  getMenu: () => api.get('/public/menu'),
  getFeaturedMenu: () => api.get('/public/menu/featured'),
  getMenuCategories: () => api.get('/public/menu/categories'),
  getTestimonials: () => api.get('/public/testimonials'),
  submitReservation: (data) => api.post('/public/reservations', data),
  submitTestimonial: (data) => api.post('/public/testimonials', data),
}

export const adminAPI = {
  getStats: () => api.get('/admin/dashboard/stats'),
  
  heroSlides: {
    list: () => api.get('/admin/hero-slides'),
    create: (data) => api.post('/admin/hero-slides', data),
    update: (id, data) => api.put(`/admin/hero-slides/${id}`, data),
    delete: (id) => api.delete(`/admin/hero-slides/${id}`),
  },
  
  team: {
    list: () => api.get('/admin/team'),
    create: (data) => api.post('/admin/team', data),
    update: (id, data) => api.put(`/admin/team/${id}`, data),
    delete: (id) => api.delete(`/admin/team/${id}`),
  },
  
  menuCategories: {
    list: () => api.get('/admin/menu-categories'),
    create: (data) => api.post('/admin/menu-categories', data),
    update: (id, data) => api.put(`/admin/menu-categories/${id}`, data),
    delete: (id) => api.delete(`/admin/menu-categories/${id}`),
  },
  
  menuItems: {
    list: () => api.get('/admin/menu-items'),
    create: (data) => api.post('/admin/menu-items', data),
    update: (id, data) => api.put(`/admin/menu-items/${id}`, data),
    delete: (id) => api.delete(`/admin/menu-items/${id}`),
  },
  
  testimonials: {
    list: () => api.get('/admin/testimonials'),
    approve: (id) => api.put(`/admin/testimonials/${id}/approve`),
    reject: (id) => api.put(`/admin/testimonials/${id}/reject`),
    delete: (id) => api.delete(`/admin/testimonials/${id}`),
  },
  
  reservations: {
    list: () => api.get('/admin/reservations'),
    update: (id, data) => api.put(`/admin/reservations/${id}`, data),
    delete: (id) => api.delete(`/admin/reservations/${id}`),
  },
  
  about: {
    get: () => api.get('/admin/about'),
    update: (data) => api.put('/admin/about', data),
  },
}

export default api
