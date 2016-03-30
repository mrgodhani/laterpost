<template>
  <div>
    <div class="login-wrapper">
      <form v-on:submit.prevent="register" autocomplete="off">
        <h3 class="text-center">Register</h3>
        <br/>
        <div class="form-group">
          <input type="text" class="form-control" v-model="user.name" placeholder="Name">
        </div>
        <div class="form-group">
          <input type="email" class="form-control" v-model="user.email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" v-model="user.password" placeholder="Password">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" v-model="user.password_confirmation" placeholder="Confirm password">
        </div>
        <br/>
        <button type="submit" class="btn btn-block login-btn btn-primary">Register</button>
      </form>
      <br/>
      <p class="text-muted">Already have a account ? <a v-link="'/auth/login'">Sign in</a></p>
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
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      errors: null
    }
  },
  methods: {
    register(){
      var self = this;
      this.$http.post('register',this.user)
      .then(function(response){
        localStorage.setItem('token',response.data.token);
        self.$route.router.go('/')
      },function(response){
        self.errors = response.data.errors
      })
    }
  }
}
</script>
