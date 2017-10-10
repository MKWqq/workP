/**
 * Created by wqq on 2017/6/22.
 */
import qs from 'qs'
export default {
  url:'',
  // 假如`url`不是绝对路径，那么向服务器发送请求的URL将是`baseURL + url`
  baseURL:'http:...',
  methods:'POST',
  transformRequest:[function(data){
    //...
    return data;
  }],
  transformResponse:[function(data){
    //...
    return data;
  }],
  headers:{'Content-Type':'application/x-www-form-urlencoded'},
  //get
  params:{},
  paramsSerializer:function(params){
    //序列化params参数
    return Qs.stringify(params)
  },
  data:{
    //put,post,patch
  },
  timeout:1000,
  //跨域
  withCredentials:false,
  responseType:'json',
  onUploadProgress:function(progressEvent){
    //允许在上传过程中的做一些操作
  },
  onDownloadProgress:function(progressEvent){
    //允许在下载过程中的做一些操作
  },
  maxContentLength:2000,//定义了接收到的response响应数据的最大长度
  validateStatus:function(status){
    //如果返回true，则promise为resolved，反之为rejected
    return status>=200 && status<300;
  },
  maxRedirect:5
}



