<template>
  <div>
    <div class="login-wrapper">
      <form v-on:submit.prevent="login" autocomplete="off">
        <h2 class="text-center"><i class="fa fa-fw fa-paper-plane-o"></i> Laterpost<br/><small>Platform for scheduling twitter updates.</small></h2>
        <br/>
        <div class="form-group">
          <input type="email" class="form-control" v-model="user.email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" v-model="user.password" placeholder="Password">
        </div>
        <br/>
        <button type="submit" class="btn btn-block login-btn btn-primary">Login</button>
        <br/>
        <p class="text-center">Don't have an account ? <a v-link="'/auth/register'">Register</a></p>
        <p class="text-center"><a v-link="'/auth/forget'">Forgot password ?</a></p>
      </form>
      <br/>
      <br/>
      <p>Proudly hosted on <a href="https://m.do.co/c/58c511514217" target="_blank"> Digital Ocean</a></p>
    </div>
  </div>
</template>
<script>
export default {
  data(){
    return {
      user: {
        email : null,
        password: null
      },
      errors: null
    }
  },
  methods: {
    login(){
      var self = this;
      this.$http.post('login',this.user)
      .then(function(response){
        localStorage.setItem('token',response.data.token)
        return self.$route.router.go('/')
      },function(response){
        if(response.status === 401){
          UIkit.notify('Email or password is invalid')
        } else {
          if(self.user.email === null && self.user.password === null) {
            UIkit.notify('Email and password both are required.')
          } else {
            if(response.data.errors['password']){
              UIkit.notify(response.data.errors['password'][0])
            }
            if(response.data.errors['email']){
              UIkit.notify(response.data.errors['email'][0])
            }
          }
        }
      })
    }
  }
}
</script>
