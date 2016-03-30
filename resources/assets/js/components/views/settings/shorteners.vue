<template>
  <br/>
  <h3><strong>Link shortenering</strong></h3><br/>
  <p> Connect your own bit.ly account to make your long links shortened whenever you post. </p>
  <br/>
  <div class="account-list-item" v-if="bitly_accounts.length > 0">
    <div class="row">
      <div class="col-xs-6">
          <h4><strong>No shorterning</strong><br/><small>Links won't be shortened</small></h4>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-default btn-outline" @click="selectDomain(null)" v-if="shortener !== null">Select</button>
        <button type="button" class="btn btn-primary" v-if="shortener === null">Selected</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
          <h4><strong>bit.ly</strong><br/><small>Links would be shortened using above domain</small></h4>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-default btn-outline" @click="selectDomain('bit.ly')" v-if="shortener !== 'bit.ly'">Select</button>
        <button type="button" class="btn btn-primary" v-if="shortener === 'bit.ly'">Selected</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
          <h4><strong>bitly.com</strong><br/><small>Links would be shortened using above domain</small></h4>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-default btn-outline" @click="selectDomain('bitly.com')" v-if="shortener !== 'bitly.com'">Select</button>
        <button type="button" class="btn btn-primary" v-if="shortener === 'bitly.com'">Selected</button>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
          <h4><strong>j.mp</strong><br/><small>Links would be shortened using above domain</small></h4>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-default btn-outline" @click="selectDomain('j.mp')" v-if="shortener !== 'j.mp'">Select</button>
        <button type="button" class="btn btn-primary" v-if="shortener === 'j.mp'">Selected</button>
      </div>
    </div>
  </div>
  <br/>
  <a href='{{ link }}' class="btn btn-default" v-if="bitly_accounts.length === 0">Connect bit.ly account</a>
  <button type="button" class="btn btn-default" v-if="bitly_accounts.length > 0" @click="disconnect">Disconnect  bit.ly</button>
  <br/>
</template>
<script>
import { updateDomain,removeBitly } from '../../../vuex/actions'

export default {
  vuex: {
    getters: {
      bitly_accounts: state => state.bitly,
      link: state => state.bitlylink,
      shortener: state => state.shortener
    },
    actions: {
      updateDomain,
      removeBitly
    }
  },
  methods: {
    selectDomain(domain)
    {
      this.$http.patch('shortener',{ domain : domain })
      this.updateDomain(domain)
    },
    disconnect()
    {
      this.$http.delete('accounts/bitly')
      this.removeBitly()
    }
  }
}
</script>
