<template>
  <div>
    <div class="container">
      <div class="login-wrapper">
        <div class="jumbotron login-panel">
          <div class="row">
            <div class="col-xs-5 center-block no-float">
              <h3><strong>Register</strong></h3>
              <br/>
              <div class="alert alert-danger" v-if="errors">
                <ul class="list-unstyled">
                  <li v-for="error in errors">{{ error }}</li>
                </ul>
              </div>
              <form v-on:submit.prevent="register">
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
                <button type="submit" class="btn btn-block btn-outline btn-primary">Login</button>
              </form>
              <br/>
              <p class="text-muted">Already have a account ? <a v-link="'/auth/login'">Sign in</a></p>
            </div>
          </div>
        </div>
      </div>
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
