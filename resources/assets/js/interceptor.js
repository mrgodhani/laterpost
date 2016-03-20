import Unauthorized from './unauthorized'
import Vue from 'vue'

export default function()
{
  return {
    request(request){
      var token , headers

      token = localStorage.getItem('token')
      headers = request.headers || (request.headers = {})

      if(token !== null && token !== 'undefined'){
        headers.Authorization = 'Bearer ' + token
      }

      return request
    },
    response(response){
      if(response.data.message === 'Token has expired' && response.status === 401){
        console.log("Token Expired")
        return Unauthorized.handle(response)
      }

      if(response.data.message === 'The token has been blacklisted' && response.status === 500){
        console.log("Unauthorized")
        localStorage.removeItem('token')
        console.log(Vue)
        return this.$route.router.go('/auth/login')
      }

      if(response.data.message !== 'Token has expired' && response.status === 401) {
        console.log("Unauthorized")
        localStorage.removeItem('token')
        return this.$route.router.go('/auth/login')
      }

      return response;
    }
  }

}
