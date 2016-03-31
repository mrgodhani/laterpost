import Auth from './components/views/auth/index.vue'
import Register from './components/views/auth/register.vue'
import Login from './components/views/auth/login.vue'
import Dashboard from './components/views/Dashboard.vue'
import Compose from './components/views/Compose.vue'
import Settings from './components/views/settings/index.vue'
import General  from './components/views/settings/general.vue'
import Accounts from './components/views/settings/accounts.vue'
import Shorteners from './components/views/settings/shorteners.vue'
import Forget from './components/views/auth/forget.vue'
import ResetPass from './components/views/auth/reset.vue'

export function configRouter (router) {

  router.map({
    '/': {
      component: Dashboard,
      auth: true,
      subRoutes: {
        '/settings': {
          component: Settings,
          subRoutes: {
            '/accounts': {
              component: Accounts
            },
            '/shorteners': {
              component: Shorteners
            },
            '/': {
              component: General
            }
          }
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
        '/password/reset/:token': {
          component: ResetPass,
        },
        '/login':{
          component: Login
        },
        '/register':{
          component: Register
        },
        '/forget': {
          component: Forget
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
