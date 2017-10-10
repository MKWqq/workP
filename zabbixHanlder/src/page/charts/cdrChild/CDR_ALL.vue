<template>
  <div class="contentBContent">
    <div class="CDRContentHeader">
      <form id="fileForm" name="fileForm" :action="actionHref" method="post" enctype="multipart/form-data" target='fileIFrame'>
        <div class="CDRContentRow">
          <span>YEAR</span>
          <input type="text" v-model="AllForm.Year" name="year" />
        </div>
        <div class="CDRContentFile">
          <p v-text="FileName"></p>
          <input class='fileInput' @change='getFileMsg' type="file" name="photo" />
          <div class="fileCss">选择文件</div>
        </div>
        <div class="CDRContentButton">
          <input type="submit" :loading="isLoading" @click="searchClick" value='查询' />
        </div>
      </form>
      <iframe id="fileIFrame" name="fileIFrame" style='display:none'></iframe>
    </div>
    <div class="CDRContentContent" v-show="isHaveData">
      <div class="DataHeader">
        <h1>查询结果</h1>
        <a @click="exportClick" :href="exportDataHref" class="ScanExportButton">导出数据</a>
      </div>
      <div class="DataContent">
        <ul>
          <li>CID</li>
          <li>PID</li>
          <li>MID</li>
          <li>YEAR</li>
          <li>MONTH</li>
          <li>TYPE</li>
          <li>visit_time</li>
        </ul>
        <div class='tableContainer'>
          <table cellpadding="0" cellspacing="0">
            <tr v-for="content in data.value">
              <td v-text="content.cid"></td>
              <td v-text="content.mid"></td>
              <td v-text="content.year"></td>
              <td v-text="content.month"></td>
              <td v-text="content.pid"></td>
              <td v-text="content.type"></td>
              <td v-text="content.visit_time"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="promptMsg" v-show="isNoData">查询失败！</div>
  </div>
</template>
<script>
import $ from 'jquery'
import {LoginHTTP} from '../../../api/http'
export default{
  data(){
    return{
      sessionid:'',
      data:{},
      isLoading:false,
      isNoData:false,
      isHaveData:false,
      exportDataHref:'javascript:void(0);',
      actionHref:'',
      FileName:'',
      fileList:[{name:'',url:''}],
      AllForm:{
        Year:'',
        File:''
      }
    }
  },
  methods:{
    getFileMsg(event){
      let e=$(event.target||event.srcElement);
      let path=e.val();
      this.FileName=this.extractFilename(path);
    },
    exportClick(){
      this.exportDataHref='http://171.221.202.190:11111/yunwei/index.php/cdr/export?sessionid='+this.sessionid;
    },
    submitUpload(){
      this.$refs.upload.submit();
    },
    GetSearchData(e){
      this.isLoading=false;
      this.data=JSON.parse(e.data);
      if(this.data.result){
        this.isNoData=false;
        this.isHaveData=true;
      }else{
        this.isNoData=true;
        this.isHaveData=false;
      }
    },
    searchClick(){
      this.isLoading=true;
      this.addHandler(window,'message',this.GetSearchData);
    },
    addHandler(element,type,handler){
      if(element.addEventListener){
        element.addEventListener(type,handler,false);
      }else if(element.attachEvent){
        element.attachEvent(type,handler);
      }else{
        element['on'+type]=handler;
      }
    },
    extractFilename(path){
      if(path.lastIndexOf('\\')>=0){
        return path.substr(path.lastIndexOf('\\')+1);//windows
      }else if(path.lastIndexOf('/')>=0){
        return path.substr(path.lastIndexOf('/')+1);//Unix
      }else{
        return path;
      }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.actionHref='http://171.221.202.190:11111/yunwei/index.php/cdr/findcdr?sessionid='+this.sessionid;
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../../style/charts/cdrChild/CDR.less';
</style>















