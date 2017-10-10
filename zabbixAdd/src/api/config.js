/**
 * Created by wqq on 2017/3/21.
 */
import qs from 'qs'
export default {
  url:'/route',
  method:'post',
  baseURL:'http://192.168.9.13/yunwei/servers/hosts',
  transformRequest:[
    function(data){
      data=qs.stringfy({});
      return data;
    }
  ],
  transformResponse:[
    function(data){
      return data;
    }
  ],
  headers:{'X-Requested-With':'XMLHttpRequest'},
  params:{},
  data:{},
  timeout:60000,
  responseType:'json',
  withCredentials:true
}



