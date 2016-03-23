<template>
  <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a v-link="'/'" class="navbar-brand"><i class="fa fa-fw fa-paper-plane-o"></i> Laterpost</a>
    </div>
    <div id="navbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a v-link="'/'">Dashboard</a></li>
        <li><a v-link="'/settings'">Settings</a></li>
        <li><a href="#" @click="logout">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
</template>
<script>
export default {
  methods: {
    logout(){
      localStorage.removeItem('token')
      this.$dispatch('clearUserDetails')
      return this.$route.router.go('/auth/login')
    }
  }
}
</script>
