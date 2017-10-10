/**
 * Created by Administrator on 2017/8/2.
 */
const domain='/api';
export default {
  /*
  * url 请求路径
  * type 请求方式
  * param 请求参数
  * fun 请求成功的回调函数
  * asy 同步还是异步，默认为异步
  * */
  ajaxSend(url,type,param,fun,asy){
    $.ajax({   //普通请求
      url:domain+url,
      type:type,
      data:param,
      dataType:'text',
      async:asy||true,
      success:function (res) {
        if(res.indexOf('<h3>错误位置</h3>')>-1){
          console.log('PHP_ERROE_MSG: 系统发生错误');
        }else{
          res=eval('('+res+')');
          fun(res);
        }
      },
      error:function () {
        console.log('请求失败');
      }
    })
  },
  ajaxFile(url,type,param,fun){   //有文件上传时的请求
    $.ajax({
      url:domain+url,
      type:type,
      data:param,
      dataType:'text',
      async:true,
      processData:false,   //  告诉jquery不要处理发送的数据
      contentType:false,    // 告诉jquery不要设置content-Type请求头
      success:function (res) {
        res=eval('('+res+')');
        fun(res);
      },
      error:function () {
        console.log('请求失败');
      }
    })
  },
  /*
  * ele   body元素
  * url  请求地址
  * type 请求方式
  * */
  downloadFile(ele,url,type){   //下载文件
    var $eleForm;
    if($('#download').length>0){
      $eleForm=$('#download');
    }else {
      $eleForm = $("<form method="+type+" id='download'></form>");
      $(ele).append($eleForm);
    }
    $eleForm.attr("action",domain+url);
    $eleForm.submit();   //提交表单，实现下载
  }
}
export const fileTypeCheck=(fileName,arr)=>{
  const fileArr=arr;
  const fileCheck=fileName.slice(fileName.indexOf('.')).toLowerCase();
  return fileArr.some((value)=>{
    if(value==fileCheck){
      return true;
    }else{
      return false;
    }
  });
};
