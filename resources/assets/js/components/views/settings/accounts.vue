<template>
  <br/>
  <h3><strong> Connected accounts</strong></h3>
  <br/>
  <div class="account-list-item" v-for="account in accounts" v-if="accounts.length > 0">
    <div class="row">
      <div class="col-xs-6">
        <p class="pull-left"><img :src="account.avatar" class="img-responsive" width="60"></p>
        <p>Twitter<br/>{{ account.username }}</p>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-danger btn-outline" @click="disconnect(account.id)">Disconnect</button>
      </div>
    </div>
  </div>
  <p v-if="accounts.length === 0">No accounts connected</p>
  <br/>
  <br/>
</template>
<script>
import { deleteTwitterAccount } from '../../../vuex/actions'
export default {
  vuex:{
    getters: {
      accounts: state => state.accounts
    },
    actions: {
      deleteTwitterAccount
    }
  },
  methods: {
    disconnect(id){
      var self = this
      this.$http.delete('accounts/' + id).then(function(response){
        self.deleteTwitterAccount(id)
      })
    }
  }
}
</script>
