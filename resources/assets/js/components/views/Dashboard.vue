<template>
  <div>
    <navbar></navbar>
    <div class="container">
      <router-view class="view" transition="fade" transition-mode="out-in"></router-view>
    </div>
  </div>
</template>
<script>
export default {
  route:{
    canReuse(transition){
      return false
    }
  }
}
</script>
