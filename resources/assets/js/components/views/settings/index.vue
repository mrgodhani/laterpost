<template>
  <div>
    <div class="settings">
      <h2><strong>Settings</strong></h2>
      <br/>
      <br/>
      <div class="posts">
        <div class="tabs-wrapper">
          <ul class="tabs clearfix">
            <li class="tab" v-link-active>
              <h5 class="text-center"><a v-link="{ path: '/settings', activeClass: 'selected' , exact: true }">General</a></h5>
            </li>
            <li class="tab" v-link-active>
              <h5 class="text-center"><a v-link="{ path: '/settings/accounts', activeClass: 'selected' , exact: true }">Social Accounts</a></h5>
            </li>
            <li class="tab" v-link-active>
              <h5 class="text-center"><a v-link="{ path: '/settings/shorteners', activeClass: 'selected' , exact: true }">Link Shortening</a></h5>
            </li>
          </ul>
        </div>
        <div class="composer tab-inner">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  ready(){
    this.$dispatch("saveUserDetails")
  }
}
</script>
