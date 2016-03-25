<template>
  <v-modal :show.sync="showModal" :large=true>
    <div slot="body">
      <div class="row">
        <div class="col-xs-12 updatecomposer">
          <div class="countdown" v-if="tweet.length > 0">{{ tweetcount }}</div>
          <textarea class="form-control" rows="5" v-model="tweet" placeholder="Write your post here"></textarea>
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
                <label class="btn btn-default" for="updatefiles">
                  <input v-el:updatefiles id="updatefiles" type="file" name="updatefiles" accept="image/gif,image/jpeg,image/png" @change="onFileUpdateChange">
                  <i class="fa fa-camera"></i>
                </label>
              </span>
              <p>Change schedule time</p>
            </div>
            <div class="pull-right">
              <v-timepicker name="datetime" :model.sync="datetimeselect" placeholder="Choose Date & Time"></v-timepicker>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div slot="footer">
      <button class="btn btn-default" @click="showModal = false"> Cancel </button>
      <button class="btn btn-primary" @click="updatePostData(id)" v-bind:disabled="tweet.length < 0 || tweet.length === 0"> Update</button>
    </div>
  </v-modal>
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
          <div class="empty-timeline" v-if="selectedTabPost.length === 0">
            <p class="text-center">No pending posts available. </p>
          </div>
          <ul class="timeline list-unstyled" v-if="selectedTabPost.length > 0">
            <li class="post" v-for="postdata in selectedTabPost">
              <span class="post-time">
                {{ postdata.scheduled_at }}
              </span>
              <div class="update-body">
                {{ postdata.content }}
              </div>
              <div class="options">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit" @click="showUpdateModal(postdata)"><i class="fa fa-pencil"></i></button>
                  <!-- <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Post now"><i class="fa fa-paper-plane"></i></button> -->
                  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" @click="deletePost(postdata.id)"><i class="fa fa-times"></i></button>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </template>
  <script>
  import _ from 'lodash'
  import { deletePostItem,updatePost } from '../../vuex/actions'
  import moment from 'moment-timezone'

  export default {
    vuex: {
      getters: {
        timezone: state => state.timezone,
        accounts: state => state.accounts,
        link: state => state.link
      },
      actions: {
        deletePostItem,
        updatePost
      }
    },
    data() {
      return {
        showModal : false,
        tweet : '',
        tweetcount: '',
        datetimeselect: '',
        files: null,
        image: null,
        id: null
      }
    },
    watch: {
      'tweet' : 'getCount'
    },
    computed: {
      getTimezone(){
        return this.timezone
      },
      selectedTab(){
        return _.filter(this.accounts,'tab_profile')
      },
      selectedTabPost(){
        var self = this;
        var currentAccount = _.filter(this.accounts,'tab_profile')
        return currentAccount[0].posts.data
      },
      getAllAccountData(){
        return this.accounts
      }
    },
    methods: {
      getCount(){
        var m
        var content
        var re = /(http|https|ftp|ftps)\:\/\/|[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?\b/ig;
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
      selectTab(data){
        _.forEach(this.getAllAccountData,function(value,key){
          value.tab_profile = undefined
        })
        data.tab_profile = true
      },
      deletePost(id){
        var self = this
        this.$http.delete('posts',{ id : id}).then(function(response){
          UIkit.notify('Post deleted Successfully');
          self.deletePostItem(self.selectedTab,id)
        })
      },
      removeImage(){
        this.image = null
        this.files = null
      },
      onFileUpdateChange(e){
        e.preventDefault();
        var files = this.$els.updatefiles.files;
        if (!files.length){
          return;
        }
        if(files[0].size < 5242880){
          this.createImage(files[0])
          this.files = files[0]
        } else {
          UIkit.notify('Image size too large')
        }
        var data = new FormData()
        data.append('image',files[0]);
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
      updatePostData(id)
      {
        var self = this
        var data = new FormData()
        if(!_.isString(this.files) || this.files === null){
          data.append('image',this.files)
        }
        data.append('content',this.tweet)
        data.append('scheduled_at',this.datetimeselect)
        data.append('timezone',this.getTimezone)
        this.$http.post('posts/'+id,data).then(function(response){
          UIkit.notify('Successfully updated post');
          self.showModal = false
          self.updatePost(self.selectedTab,id,response.data)
        })
      },
      showUpdateModal(data)
      {
        var self = this
        this.image = null
        this.showModal = true
        this.id = data.id
        this.tweet = data.content
        this.datetimeselect = moment(data.scheduled_at).format('YYYY/MM/DD hh:mm')
        this.$http.get('posts/' + data.id + '/image')
        .then(function(response){
          self.image = response.data['base64']
          self.files = response.data['filename']
        },function(responsE){
          self.image = null
          self.files = null
        })
      }
    }
  }
  </script>
