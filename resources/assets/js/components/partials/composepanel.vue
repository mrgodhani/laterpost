<template>
  <v-modal :show.sync="showModal">
    <div slot="body">
      <v-timepicker name="datetime" :model.sync="datetimeselect" placeholder="Choose Date & Time"></v-timepicker>
      <br/>
      <p name="timezone"><strong>Timezone</strong> : {{ timezone }}</p>
    </div>
    <div slot="footer">
      <button class="btn btn-default" @click="showModal = false"> Cancel </button>
      <button class="btn btn-primary" @click="schedulePost()"> Schedule</button>
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
    <div class="countdown" v-if="tweet">{{ tweetcount }}</div>
    <br/>
    <textarea class="form-control" rows="5" v-model="tweet" placeholder="Write your post here" @keyup.enter="shortenLink" @keyup.space="shortenLink"></textarea>
    <div class="row" v-if="image">
      <div class="col-xs-3">
        <a href="#" class="thumbnail">
          <img :src="image">
        </a>
        <a href="#" class="remove-btn" @click="removeImage">×</a>
      </div>
    </div>
    <div class="form-actions col-xs-12">
      <div class="pull-left">
        <span id="fileselector">
          <label class="btn btn-default" for="upload-file-selector" v-bind:disabled="tweetcount < 0">
            <input v-el:uploadfile id="upload-file-selector" type="file" name="uploadfile" accept="image/gif,image/jpeg,image/png" @change="onFileChange">
            <i class="fa fa-camera"></i>
          </label>
        </span>
      </div>
      <div class="pull-right">
        <button type="button" class="btn btn-default" v-bind:disabled="tweetcount < 0 || tweet.length === 0" @click="postNow"><i class="fa fa-fw fa-paper-plane"></i> Post now</button>
        <button type="button" class="btn btn-primary" v-bind:disabled="tweetcount < 0 || tweet.length === 0" @click="showModal = true"><i class="fa fa-fw fa-calendar"></i> Schedule post</button>
      </div>
    </div>
  </div>
</template>
<script>
import _ from 'lodash'
import { addPost } from '../../vuex/actions'
import uri from 'url'

export default {
  vuex: {
    getters: {
      timezone: state => state.timezone,
      accounts: state => state.accounts,
      shortener: state => state.shortener,
      link: state => state.link
    },
    actions: {
      addPost
    }
  },
  data()
  {
    return {
      tweet: '',
      image: null,
      files: null,
      showModal: false,
      tweetcount: null,
      datetimeselect: null,
      shortenlinks: []
    }
  },
  computed: {
    getTimezone(){
      return this.timezone
    },
    getShortenerSetting(){
      return this.shortener
    },
    allAccounts(){
      return _.filter(this.accounts,'selected')
    }
  },
  watch: {
    'tweet' : 'getCount'
  },
  methods: {
    getCount(){
      var m
      var content
      var re = /((http|https|ftp|ftps)\:\/\/)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?\b/ig;
      var urls = this.tweet.match(re);
      if(urls !== null && urls.length > 0){
        content = this.tweet.replace(re,"")
      } else {
        content = this.tweet
      }
      if(urls !== null && urls.length > 0){
        this.tweetcount = (140 - (23 * urls.length)) - content.length
      } else {
        this.tweetcount = (140  - content.length)
      }
    },
    markSelected(data){
      data.selected = !data.selected;
      data.compose_profile = !data.compose_profile
    },
    getAllSelected(){
      return _.filter(this.allAccounts,['selected',true])
    },
    removeImage(){
      this.image = null
      this.files = null
    },
    onFileChange(e){
      e.preventDefault();
      var files = this.$els.uploadfile.files;
      //var files = e.target.files || e.dataTransfer.files;
      if (!files.length){
        return;
      }
      if(files[0].size < 5242880){
        this.createImage(files[0])
        this.files = files[0]
      } else {
        UIkit.notify('Image size too large')
      }
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
    schedulePost(){
      var self = this
      if(this.tweet !== null || this.allAccounts.length > 0) {
        var data = new FormData()
        data.append('image',this.files)
        data.append('accounts',JSON.stringify(this.allAccounts))
        data.append('content',this.tweet)
        data.append('scheduled_at',this.datetimeselect)
        data.append('timezone',this.getTimezone)
        this.$http.post('posts',data).then(function(response){
          UIkit.notify('Successfully scheduled post');
          this.files = null
          this.image = null
          this.tweet = ''
          this.showModal = false
          this.datetimeselect = null
          self.addPost(response.data.data)
        })
      } else {
        UIkit.notify('Oops something went wrong');
        this.showModal = false
      }
    },
    postNow(){
      if(this.allAccounts.length > 0) {
        var data = new FormData()
        data.append('image',this.files)
        data.append('accounts',JSON.stringify(this.allAccounts))
        data.append('content',this.tweet)
        this.$http.post('tweet',data).then(function(response){
          UIkit.notify('Successfully posted')
          this.files = null,
          this.image = null,
          this.tweet = ''
        })
      } else {
        UIkit.notify('Oops something went wrong');
      }
    },
    shortenLink(){
      var m
      var self = this
      var links = []
      var re = /((http|https|ftp|ftps)\:\/\/)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?\b/ig;

      while((m = re.exec(this.tweet)) !== null){
        if(m.index === re.lastIndex){
          re.lastIndex++
        }
        if(m[0] !== '' && this.getShortenerSetting !== null){
          links.push(m[0]);
        }
      }
      if(this.getShortenerSetting !== null){
        var link = links[links.length - 1]
        if(!link.match(/^http/)){
          link = 'http://' + links[links.length - 1]
        }
        var check = this.shortenlinks.indexOf(link)
        if(check < 0 ){
          this.$http.post('shorten',{ link : link}).then(function(response){
              self.tweet = self.tweet.replace(links[links.length - 1],response.data.data.url)
              self.shortenlinks.push(response.data.data.url)
          })
        }
      }
    }
  }
}
</script>
