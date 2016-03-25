<template>
  <div>
      <div class="login-wrapper">
        <form v-on:submit.prevent="login">
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
          <p class="text-center">Forgot password ?</p>
        </form>
        <br/>
        <p><a href="https://github.com/mrgodhani/laterpost">View it on Github</a></p>
        <br/>
        <p><i class="fa fa-copyright"></i> Meet Godhani 2016</p>
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
