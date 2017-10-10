<template>
  <div class="SNContent">
    <div class="SNContentTop">
      <div class="SNContentInputRow">
        <span>输入数据表:</span>
        <input @focus="isPromptError=false" v-model="SNFormData.dataChart" />
      </div>
      <div class="SNContentInputRow">
        <span>字段名:</span>
        <div class="selectContainer">
          <select v-model="SNFormData.fileName" @focus="isPromptError=false">
            <option label="CLIENT_SN" value="CLIENT_SN">CLIENT_SN</option>
            <option label="CLIENT_IP" value="CLIENT_IP">CLIENT_IP</option>
          </select>
        </div>
      </div>
      <div class="SNContentInputRow">
        <span>字段值:</span>
        <input placeholder="请输入字段值" @focus="isPromptError=false" v-model="SNFormData.fileValue" />
      </div>
      <div class="searchButton">
        <el-form>
          <el-form-item>
            <el-button :loading="isLoading" @click="sendMsgAjax" class="searchButton">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <div class="SNContentBottom" v-show="isHaveData">
      <table cellspacing="0" cellpadding="0">
        <tr>
          <th>id</th>
          <th>client_sn</th>
          <th>client_ip</th>
          <th>channel_name</th>
          <th>hlc_ip</th>
          <th>hls_ip</th>
          <th>token</th>
          <th>login_time</th>
          <th>logout_time</th>
          <th>log_spend</th>
          <th>record_time</th>
          <th>详细信息</th>
        </tr>
        <tr v-for="content in data.value">
          <td v-text="content.id"></td>
          <td v-text="content.client_sn"></td>
          <td v-text="content.client_ip"></td>
          <td v-text="content.channel_name"></td>
          <td v-text="content.hlc_ip"></td>
          <td v-text="content.hls_ip"></td>
          <td v-text="content.token"></td>
          <td v-text="content.login_time"></td>
          <td v-text="content.logout_time"></td>
          <td v-text="content.log_spend"></td>
          <td v-text="content.record_time"></td>
          <td @click="sendDetailAjax">详细信息</td>
        </tr>
      </table>
    </div>
    <div class="promptError" v-show="isPromptError">请填写完整信息！</div>
    <SNButton v-show="isHaveData" class="SNContentButton" :maxPage="pageAll" v-on:sendNewAjax="sendAjax"></SNButton>
    <div class="DetailContainer" v-show="HasDetail">
      <div class="DetailContent">
        <table>
          <tr>
            <th>字段名</th>
            <th>字段值</th>
          </tr>
          <tr v-for="detail in detailData">
            <td v-text="detail.name"></td>
            <td v-text="detail.value"></td>
          </tr>
        </table>
        <img src="../../assets/img/icon_guanbi.png" @click="HasDetail=!HasDetail" class="closeDetail" />
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import {LoginHTTP,SNLoginCheckHTTP,SNDataHTTP,SNDetailHTTP} from '../../api/http'
export default{
  data(){
    return {
      sessionid:'',
      data:[],
      detailData:[],
      page:1,
      pageAll:1,
      isHaveData:false,
      isPromptError:false,
      isLoading:false,
      HasDetail:false,
      SNFormData:{
        dataChart:'gslb_statistics',
        fileName:'CLIENT_SN',
        fileValue:''
      }
    }
  },
  methods:{
    sendAjax(ThisPage){
      this.page=ThisPage;
      SNDataHTTP({sessionid:this.sessionid,table:this.SNFormData.dataChart,field:(this.SNFormData.fileName).toLowerCase(),value:this.SNFormData.fileValue,page:this.page}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data!=null && data!=undefined && data!=""){
            this.data=data;
            this.pageAll=Number(data.pageall);
          }else{
            this.data=[]
          }
        }
      });
    },
    sendMsgAjax(){
      if(this.checkForm()){
        this.isLoading=true;
        SNDataHTTP({sessionid:this.sessionid,table:this.SNFormData.dataChart,field:(this.SNFormData.fileName).toLowerCase(),value:this.SNFormData.fileValue,page:this.page}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.isLoading=false;
            if(data.value!=null && data.value!=undefined && data.value!=""){
              this.isHaveData=true;
              this.data=data;
              this.pageAll=Number(data.pageall);
            }else{
              this.isHaveData=false;
              this.data=[];
              this.pageAll=1;
              alert('没有相关数据!');
            }
          }
        });
      }else{
        this.isPromptError=true;
      }
    },
    sendDetailAjax(event){
      const e=event.target||event.srcElement;
      SNDetailHTTP({sessionid:this.sessionid,id:$($(e).parent().children()[0]).text()}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data!=null && data!=undefined && data!=""){
            this.HasDetail=true;
            this.detailData=data;
          }else{
            console.log("no data");
          }
        }
      });
    },
    checkForm(){
      if(this.SNFormData.dataChart==""||this.SNFormData.fileName==""||this.SNFormData.fileValue==""){
        return false;
      }else{
        return true;
      }
    }
  },
  components:{'SNButton':SNButton},
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        SNLoginCheckHTTP({sessionid:this.sessionid}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(this.result==false){
              this.$router.push('/SN');
            }
          }
        });
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/search/SN.less';
</style>









