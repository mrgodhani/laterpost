<template>
  <div>
    <router-view class="view" transition="fade" transition-mode="out-in"></router-view>
  </div>
</template>
<script>
import store from './vuex/store'
import { saveUserDetail,clearUser } from './vuex/actions'

export default {
  store: store,
  vuex: {
    actions: {
      saveUserDetail,
      clearUser
    }
  },
  events: {
    saveUserDetails(){
      this.saveUser()
    },
    clearUserDetails(){
      this.clearUserData()
    }
  },
  methods: {
    saveUser(){
      var self = this
      this.$http.get('users/current')
      .then(function(response){
          self.saveUserDetail(response.data.data)
      });
    },
    clearUserData(){
      localStorage.removeItem('token')
      this.clearUser()
    }
  }
}
</script>
