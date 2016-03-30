import Vue from 'vue'
import Vuex from 'vuex'
import _ from 'lodash'
import moment from 'moment-timezone'

Vue.use(Vuex)

const state = {
  email: null,
  shortener: null,
  bitly: [],
  accounts: [],
  timezone: null,
  link: null,
  bitlylink: null
}

const mutations = {
  SAVE_USER (state,data) {
    state.email = data.email
    state.timezone = data.timezone
    var twitter_accounts =  _.filter(data.accounts.data,{ 'provider' : 'twitter' });
    state.bitly = _.filter(data.accounts.data,{ 'provider' : 'bitly' });
    if(data.default_shortener !== null){
          state.shortener = data.default_shortener
    }
    state.accounts = twitter_accounts.map(function(obj,key){
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
      obj.posts.data.map(function(item){
        var utc = moment.utc(item.scheduled_at).format()
        item.scheduled_at = moment.tz(new Date(utc).toISOString(),state.timezone).format('DD MMM YYYY hh:mm a')
        return item
      });
      return obj;
    });
    state.link = '/auth/twitter?user=' + data.id
    state.bitlylink = '/auth/bitly?user=' + data.id
  },
  ADD_POST(state,data){
    data.forEach(function(item){
      var utc = moment.utc(item.scheduled_at).format()
      item.scheduled_at = moment.tz(new Date(utc).toISOString(),state.timezone).format('DD MMM YYYY hh:mm a')
      var index = _.findIndex(state.accounts,{ 'profile_id' : item.profile_id})
      state.accounts[index].posts.data.push(item)
    })
  },
  UPDATE_POST(state,currentaccount,postid,data){
    currentaccount.forEach(function(item){
      var account_index = _.findIndex(state.accounts,{ 'id' : item.id })
      var post_index = _.findIndex(state.accounts[account_index].posts.data,{ 'id' : postid })
      var utc = moment.utc(data['scheduled_at']).format()
      data.scheduled_at = moment.tz(new Date(utc).toISOString(),state.timezone).format('DD MMM YYYY hh:mm a')
      state.accounts[account_index].posts.data[post_index].content = data['content']
      state.accounts[account_index].posts.data[post_index].scheduled_at = data['scheduled_at']
      state.accounts[account_index].posts.data[post_index].media_path = data['media_path']
      state.accounts[account_index].posts.data[post_index].mimetype = data['mimetype']
    })
  },
  DELETE_POST(state,data,id){
    data.forEach(function(item){
      var index = _.findIndex(state.accounts,{ 'profile_id' : item.profile_id})
      var post_index = _.findIndex(state.accounts[index].posts.data,{ 'id' : id })
      state.accounts[index].posts.data.splice(post_index,1)
    })
  },
  DELETE_TWITTER_ACCOUNT (state,id){
    var index = _.findIndex(state.accounts,{ 'id' : id})
    state.accounts.splice(index,1)
  },
  UPDATE_EMAIL(state,email){
    state.email = email
  },
  UPDATE_TIMEZONE(state,timezone){
    state.timezone = timezone
  },
  UPDATE_DOMAIN(state,domainname){
    state.shortener = domainname
  },
  DELETE_BITLY(state,domain){
    state.bitly = []
  },
  CLEAR_USER(state){
    state.email = {},
    state.accounts = []
    state.bitly = []
    state.link = null
    state.shortener = null
    state.timezone = null
  }
}

export default new Vuex.Store({
  state,
  mutations
})
