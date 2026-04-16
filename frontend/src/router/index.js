import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomePage.vue')
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/AboutPage.vue')
  },
  {
    path: '/menu',
    name: 'Menu',
    component: () => import('../views/MenuPage.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../views/ContactPage.vue')
  },
  {
    path: '/admin',
    name: 'AdminLogin',
    component: () => import('../views/admin/LoginPage.vue')
  },
  {
    path: '/admin/dashboard',
    name: 'AdminDashboard',
    component: () => import('../views/admin/DashboardPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/menu',
    name: 'AdminMenu',
    component: () => import('../views/admin/MenuManagement.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/team',
    name: 'AdminTeam',
    component: () => import('../views/admin/TeamManagement.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/hero',
    name: 'AdminHero',
    component: () => import('../views/admin/HeroManagement.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/testimonials',
    name: 'AdminTestimonials',
    component: () => import('../views/admin/TestimonialManagement.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/reservations',
    name: 'AdminReservations',
    component: () => import('../views/admin/ReservationManagement.vue'),
    meta: { requiresAuth: true }
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('admin_token')
  
  if (to.meta.requiresAuth && !token) {
    next({ name: 'AdminLogin' })
  } else if (to.name === 'AdminLogin' && token) {
    next({ name: 'AdminDashboard' })
  } else {
    next()
  }
})

export default router
