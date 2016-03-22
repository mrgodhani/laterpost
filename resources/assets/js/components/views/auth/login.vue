<template>
  <div>
      <div class="login-wrapper">
        <div class="jumbotron login-panel">
          <div class="row">
            <div class="col-xs-8">
              <h1><i class="fa fa-fw fa-paper-plane-o"></i> Laterpost</h1>
              <br/>
              <p class="text-muted small-text">Platform for scheduling twitter status updates</p>
              <br/>
              <p class="text-muted small-text"><i class="fa fa-github"></i><a href='https://github.com/mrgodhani/laterpost' target="_blank">View it on github</a></p>
            </div>
            <div class="col-xs-4">
              <p><strong>Login with your account</strong></p>
              <br/>
              <div class="alert alert-danger" v-if="errors">
                <span v-if="typeof errors === 'string'">{{ errors }}</span>
                <ul class="list-unstyled" v-if="typeof errors !== 'string'">
                  <li v-for="error in errors">{{ error }}</li>
                </ul>
              </div>
              <form v-on:submit.prevent="login">
                <div class="form-group">
                  <input type="email" class="form-control" v-model="user.email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" v-model="user.password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-block btn-outline btn-primary">Login</button>
              </form>
              <br/>
              <p class="text-muted">Don't have an account ? <a v-link="'/auth/register'">Register</a></p>
              <!-- <p class="text-muted">Forgot password ?</p> -->
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
         self.errors = "Email or password is invalid"
       } else {
         self.errors = response.data.errors
       }
     })
   }
 }
}
</script>
