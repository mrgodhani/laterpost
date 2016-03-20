<template>
  <div>
    <v-modal :show.sync="showModal">
      <div slot="body">
        <v-timepicker name="datetime" :model.sync="datetimeselect" placeholder="Choose Date & Time"></v-timepicker>
        <br/>
        <p name="timezone"><strong>Timezone</strong> : {{ timezone }}</p>
      </div>
      <div slot="footer">
        <button class="btn btn-default"
        @click="showModal = false">
        Cancel
      </button>
      <button class="btn btn-primary"
      @click="schedulePost(datetime)">
      Schedule
    </button>
  </div>
</v-modal>
<div class="composer col-xs-12">
  <div id="profiles">
    <div class="profile avatar twitter" v-for="account in accounts" v-bind:class="{ 'selected' :  account.compose_profile }" @click="markSelected(account)">
      <img :src="account.avatar" width="44">
      <span></span>
    </div>
  </div>
  <a href='{{ link }}' class="connect-accounts">Connect Account</a>
  <div class="countdown" v-if="tweet">{{ getCount(tweet.length) }}</div>
  <br/>
  <textarea class="form-control" rows="5" v-model="tweet" placeholder="Write your post here"></textarea>
  <div class="row" v-if="image">
    <div class="col-xs-3">
      <a href="#" class="thumbnail" @click="removeImage">
        <img :src="image">
      </a>
    </div>
  </div>
  <div class="form-actions col-xs-12">
    <div class="pull-left">
      <span id="fileselector">
        <label class="btn btn-default" for="upload-file-selector" v-bind:disabled="getCount(tweet.length) < 0">
          <input id="upload-file-selector" type="file" accept="image/gif,image/jpeg,image/png" @change="onFileChange">
          <i class="fa fa-camera"></i>
        </label>
      </span>
    </div>
    <div class="pull-right">
      <button type="button" class="btn btn-default" v-bind:disabled="getCount(tweet.length) < 0 || tweet.length === 0" @click="postNow"><i class="fa fa-fw fa-paper-plane"></i> Post now</button>
      <button type="button" class="btn btn-primary" v-bind:disabled="getCount(tweet.length) < 0 || tweet.length === 0" @click="showModal = true"><i class="fa fa-fw fa-calendar"></i> Schedule post</button>
    </div>
  </div>
</div>
<div class="posts" v-if="accounts.length > 0">
  <br/>
  <h3><strong>Pending posts</strong></h3>
  <br/>
  <div class="tabs-wrapper">
    <ul class="tabs clearfix">
      <li class="tab" v-for="account in accounts" v-bind:class="{ 'selected' :  account.tab_profile }" @click="selectTab(account)">
        <span class="profile avatar twitter">
          <img :src="account.avatar">
          <span class="small"></span>
        </span>
        <span class="tab-meta">
          <span class="tab-username">{{ account.username }}</span>
          <span class="tab-updates">{{ account.posts.data.length }} posts</span>
        </li>
      </ul>
      <div class="composer tab-inner">
        <div class="empty-timeline">
          <p class="text-center">No pending posts available. </p>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import _ from 'lodash'

export default {
  vuex: {
    getters: {
      timezone: state => state.timezone,
      accounts: state => state.accounts,
      link: state => state.link
    }
  },
  data(){
    return {
      tweet: '',
      image: null,
      files: null,
      showModal: false,
      datetimeselect: null
    }
  },
  computed: {
    getTimezone(){
      return this.timezone
    },
    allAccounts(){
      return _.filter(this.accounts,'selected')
    },
    getAllAccountData(){
      return this.accounts
    },
    dateTime(){
      if(this.datetimeselect !== null) {
        var time = moment.tz(this.datetimeselect,this.getTimezone).format();
        return time;
      }
    }
  },
  methods: {
    getCount(textlength){
      return 140 - textlength
    },
    markSelected(data){
      data.selected = !data.selected;
      data.compose_profile = !data.compose_profile
    },
    getAllSelected(){
      return _.filter(this.allAccounts,['selected',true])
    },
    selectTab(data){
      _.forEach(this.getAllAccountData,function(value,key){
        value.tab_profile = undefined
      })
      data.tab_profile = true
    },
    schedulePost(){
      this.showModal = false;
    },
    removeImage(){
      this.image = null
      this.files = null
    },
    onFileChange(e){
      var files = e.target.files || e.dataTransfer.files;
      console.log(files.length);
      if (!files.length){
        return;
      }
      this.createImage(files[0])
      this.files = files[0]
      // var data = new FormData()
      // data.append('image',files[0]);
    },
    createImage(file){
      var image = new Image();
      var reader = new FileReader();
      var self = this;
      reader.addEventListener("load", function () {
        self.image = reader.result;
      }, false);

      reader.readAsDataURL(file);
    },
    postNow(){
      var data = new FormData()
      data.append('image',this.files)
      data.append('base64',this.image)
      data.append('accounts',JSON.stringify(this.allAccounts))
      data.append('content',this.tweet)
      this.$http.post('tweet',data).then(function(response){
        UIkit.notify('Successfully posted');
        this.files = null,
        this.image = null,
        this.tweet = null
      })
    }
  }
}
</script>
