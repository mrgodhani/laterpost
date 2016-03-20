import Vue from 'vue'

export default {
  handle(response){
    var self = this;
    var retry = function(respdata) {
      localStorage.setItem('token',respdata.data.token)
      return self.retry(response.request).then(function(respond){
        return respond
      });
    }.bind(this);

    return Vue.http.get('refresh')
    .then(retry)
  },
  retry(request){
    var method = request.method.toLowerCase()
    return Vue.http[method](request.url,request.params)
  }

}
