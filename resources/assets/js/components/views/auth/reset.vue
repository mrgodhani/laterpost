<template>
  <div>
    <div class="login-wrapper">
      <form v-on:submit.prevent="resetPass">
        <h2 class="text-center">Set a new password</h2>
        <br/>
        <div class="form-group">
          <input type="password" class="form-control" v-model="user.password" placeholder="Password">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" v-model="user.password_confirmation" placeholder="Password Confirmation">
        </div>
        <br/>
        <button type="submit" class="btn btn-block login-btn btn-primary">Change password</button>
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
  route: {
    activate(transition){
      if(transition.to.params.token === '')
      {
        transition.abort()
      }
      this.user.email = transition.to.query.email
      this.user.token = transition.to.params.token
      return transition.next()
    }
  },
  data()
  {
    return {
      user: {
        token: null,
        email: null,
        password : null,
        password_confirmation: null
      }
    }
  },
  ready()
  {
    document.body.className = document.body.className.replace("auth","");
    document.getElementsByTagName('body')[0].className+='auth'
  },
  methods: {
    resetPass(){
        this.$http.post('passwordreset',this.user).then(function(response){
              UIkit.notify(response.data.message)
        });
        this.$route.router.go('/auth/login');
    }
  }
}
</script>
