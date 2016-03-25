<template>
  <div>
    <router-view class="view" transition="fade" transition-mode="out-in"></router-view>
  </div>
</template>
<script>
export default {
  route: {
    canReuse(transition){
      return false
    }
  },
  ready()
  {
    document.body.className = document.body.className.replace("auth","");
    document.getElementsByTagName('body')[0].className+='auth'
  }
}
</script>
