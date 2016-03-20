import Auth from './components/views/auth/index.vue'
import Register from './components/views/auth/register.vue'
import Login from './components/views/auth/login.vue'
import Dashboard from './components/views/Dashboard.vue'
import Compose from './components/views/Compose.vue'
import Settings from './components/views/Settings.vue'

export function configRouter (router) {

  router.map({
    '/': {
      component: Dashboard,
      auth: true,
      subRoutes: {
        '/settings':{
          component: Settings
        },
        '/': {
          component: Compose
        }
      }
    },
    '/auth/': {
      component: Auth,
      guest: true,
      subRoutes: {
        '/login':{
          component: Login
        },
        '/register':{
          component: Register
        }
      }
    }
  })

  router.beforeEach(function(transition){
    var token = localStorage.getItem('token')
    if(transition.to.auth){
      if(!token || token === null){
        transition.redirect('/auth/login')
      }
    }
    if(transition.to.guest){
      if(token){
        transition.redirect('/')
      }
    }
    transition.next()
  })
}
