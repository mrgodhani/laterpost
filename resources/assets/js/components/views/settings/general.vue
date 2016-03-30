<template>
  <h3><strong>Timezone</strong></h3>
  <br/>
  <div class="row">
    <div class="col-xs-4">
      <p> Your current timezone is<br/><strong>{{ current_timezone }}</strong> </p>
      <br/>
      <v-select :value.sync="new_timezone" :options="timezonelist"></v-select>
    </div>
  </div>
  <br/>
  <button type="button" class="btn btn-default" @click="updateUserTimezone(new_timezone)">Update timezone</button>
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
  <button type="button" class="btn btn-default" @click="updateUserEmail(newemail)">Update email</button>
  <br/>
  <br/>
  <h3><strong>Change password</strong></h3>
  <br/>
  <div class="row">
    <div class="col-xs-4">
      <form>
        <div class="form-group">
          <input type="password" v-model="newpassword" placeholder="New password" class="form-control">
        </div>
        <div class="form-group">
          <input type="password" v-model="password_confirmation" placeholder="Confirm password" class="form-control">
        </div>
      </form>
    </div>
  </div>
  <br/>
  <button type="button" class="btn btn-default" @click="changePassword">Change Password</button>
  <br/>
  <br/>
  <h3><strong> Delete Account</strong></h3>
  <br/>
  <div class="row">
    <div class="col-xs-6 deleteaccount">
      <div class="checkbox">
        <label>
          <input type="checkbox" v-model="deleteaccount"> Yes I want to delete my account and all of my data.
        </label>
      </div><br/>
      <button type="button" class="btn btn-danger" v-bind:disabled="!deleteaccount" @click="deleteAccount">Delete Account</button>
    </div>
  </div>
</template>
<script>
import { updateTimezone,updateEmail } from '../../../vuex/actions'
export default {
  vuex:{
    getters: {
      email: state => state.email,
      accounts: state => state.accounts,
      current_timezone: state => state.timezone
    },
    actions: {
      updateTimezone,
      updateEmail
    }
  },
  data(){
    return {
      timezonelist : null,
      new_timezone: null,
      deleteaccount: null,
      newemail: null,
      password_confirmation: null,
      newpassword: null
    }
  },
  ready()
  {
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
    updateUserTimezone(timezone){
      var self = this;
      if(timezone !== null) {
        this.$http.patch('timezone',{timezone : timezone }).then(function(response){
          self.updateTimezone(timezone)
        })
      } else {
        UIkit.notify('Please select timezone');
      }
    },
    updateUserEmail(email)
    {
      var self = this;
      if(email !== null) {
        this.$http.patch('email',{email : email}).then(function(response){
          self.updateEmail(email);
        })
      } else {
        UIkit.notify('Email is required');
      }
    },
    deleteAccount(){
      var self = this;
      this.$http.delete('users').then(function(response){
        self.$dispatch('clearUserDetails')
        self.$route.router.go('/auth/login')
      })
    },
    changePassword(){
      var self = this;
      this.$http.patch('password',{ password: this.newpassword,password_confirmation: this.password_confirmation}).then(function(response){
        UIkit.notify('Password updated Successfully');
      },function(response){
        UIkit.notify(response.data.errors.password[0]);
      })
    }
  }
}
</script>
