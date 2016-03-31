<template>
  <div>
    <div class="login-wrapper">
      <form v-on:submit.prevent="resetPass">
        <h2 class="text-center">Password Reset</h2>
        <br/>
        <div class="form-group">
          <input type="email" class="form-control" v-model="user.email" placeholder="Email">
        </div>
        <br/>
        <button type="submit" class="btn btn-block login-btn btn-primary">Send Reset Email</button>
        <br/>
        <p class="text-center">Already have a account ? <a v-link="'/auth/login'">Sign In</a></p>
      </form>
      <br/>
      <p><i class="fa fa-copyright"></i> Meet Godhani 2016</p>
    </div>
  </div>
</template>
<script>
export default {
  data(){
    return {
      user: {
        email : null
      }
    }
  },
  methods: {
    resetPass(){
      if(this.user.email === null)
      {
        UIkit.notify('Email is required.')
      } else {
        this.$http.post('reset',this.user).then(function(response){
            UIkit.notify(response.data.message)
        })
      }
    }
  }
}
</script>
