<template>
  <div>
    <composepanel></composepanel>
    <pending></pending>
  </div>
</template>
<script>
export default {
  ready(){
    this.$dispatch("saveUserDetails");
  }
}
</script>
