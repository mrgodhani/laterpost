import Vue from 'vue'
import Vuex from 'vuex'
import _ from 'lodash'
import moment from 'moment-timezone'

Vue.use(Vuex)

const state = {
  email: null,
  accounts: [],
  timezone: null,
  link: null
}

const mutations = {
  SAVE_USER (state,data) {
    state.email = data.email
    state.timezone = data.timezone
    state.accounts = data.accounts.data.map(function(obj,key){
      if(key === 0){
        obj.selected = true
        obj.compose_profile = true
        obj.tab_profile = true
      }
      else {
        obj.selected = false
        obj.compose_profile = false
        obj.tab_profile = false
      }
      return obj
    })
    state.link = '/auth/twitter?user=' + data.id
  },
  ADD_POST(state,data){
    data.forEach(function(item){
      var index = _.findIndex(state.accounts,{ 'profile_id' : item.profile_id})
      state.accounts[index].posts.data.push(item)
    })
  },
  DELETE_POST(state,data,id){
    data.forEach(function(item){
      var index = _.findIndex(state.accounts,{ 'profile_id' : item.profile_id})
      var post_index = _.findIndex(state.accounts[index].posts.data,{ 'id' : id })
      state.accounts[index].posts.data.splice(post_index,1)
    })
  },
  CLEAR_USER(state){
    state.user = {},
    state.accounts = []
    state.link = null
    state.timezone = null
  }
}

export default new Vuex.Store({
  state,
  mutations
})
