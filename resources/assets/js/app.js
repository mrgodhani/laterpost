import Vue from 'vue'
import VueRouter from 'vue-router'
import { configRouter } from './router-config'
import VueResource from 'vue-resource'
import RegisterComponent from './components/register'
import App from './App.vue'
import Interceptor from './interceptor.js'

Vue.use(VueResource)
Vue.use(VueRouter)
Vue.config.debug = false;
Vue.http.options.root = '/api';
Vue.http.interceptors.push(Interceptor)

RegisterComponent.registerAllGlobalComponents()

const router = new VueRouter({
  history: true,
  saveScrollPosition: false
})


configRouter(router)

router.start(App,'#app')
