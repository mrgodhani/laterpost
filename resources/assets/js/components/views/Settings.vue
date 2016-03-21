<template>
  <div>
    <div class="settings">
      <h2><strong>Settings</strong></h2>
      <br/>
      <br/>
      <div class="composer col-xs-12">
        <h3><strong>Timezone</strong></h3>
        <br/>
        <div class="row">
          <div class="col-xs-4">
            <p> Your current timezone is <strong>{{ current_timezone }}</strong> </p>
            <br/>
            <v-select :value.sync="new_timezone" :options="timezonelist"></v-select>
          </div>
        </div>
        <br/>
        <button type="button" class="btn btn-default" @click="updateTimezone(current_timezone)">Update timezone</button>
        <br/>
        <br/>
        <h3><strong>Email</strong></h3>
        <br/>
        <div class="row">
          <div class="col-xs-4">
            <p> Your current email is <strong>{{ email }}</strong> </p>
            <br/>
            <input type="email" class="form-control" v-model="newemail" placeholder="New Email">
          </div>
        </div>
        <br/>
        <button type="button" class="btn btn-default" @click="updateEmail(newemail)">Update email</button>
        <br/>
        <br/>
        <h3><strong>Change password</strong></h3>
        <br/>
        <div class="row">
          <div class="col-xs-4">
            <form>
              <div class="form-group">
                <input type="password" v-model="currentpassword" placeholder="Current password" class="form-control">
              </div>
              <div class="form-group">
                <input type="password" v-model="newpassword" placeholder="New password" class="form-control">
              </div>
            </form>
          </div>
        </div>
        <br/>
        <button type="button" class="btn btn-default" @click="changePassword()">Change Password</button>
        <br/>
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
              <button type="button" class="btn btn-danger btn-outline" @click="disconnect(account)">Disconnect</button>
            </div>
          </div>
        </div>
        <p v-if="accounts.length === 0">No accounts connected</p>
        <br/>
        <br/>
        <h3><strong> Delete Account</strong></h3>
        <div class="col-xs-6 deleteaccount">
          <div class="row">
            <div class="checkbox">
              <label>
                <input type="checkbox" v-model="deleteaccount"> Yes I want to delete my account and all of my data.
              </label>
            </div><br/>
            <button type="button" class="btn btn-danger" v-bind:disabled="!deleteaccount" @click="deleteAccount">Delete Account</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  vuex:{
    getters: {
      email: state => state.email,
      accounts: state => state.accounts,
      current_timezone: state => state.timezone
    }
  },
  data(){
    return {
      timezonelist : null,
      new_timezone: null
    }
  },
  ready(){
    this.$dispatch("saveUserDetails")
    this.getTimezones()
  },
  methods: {
    getTimezones(){
      var self = this;
      // Get timezones
      this.$http.get('timezones')
      .then(function(response){
        self.timezonelist = response.data
      })
    },
    updateTimezone(timezone){
      var self = this;
      this.$http.patch('timezone',{timezone : timezone }).then(function(response){
        self.getUser();
      })
    },
    updateEmail(email)
    {
      var self = this;
      this.$http.patch('email',{email : email}).then(function(response){
        self.getUser();
      })
    },
    deleteAccount(){
      var self = this;
      this.$http.delete('users').then(function(response){
        self.$dispatch('clearUserDetails');
      })
    }
  }
}
</script>
