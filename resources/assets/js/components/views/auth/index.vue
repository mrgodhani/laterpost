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
  }
}
</script>
