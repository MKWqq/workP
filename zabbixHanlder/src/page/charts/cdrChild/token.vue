<template>
  <div class="ContentBottom">
    <div class="ContentHeader">
      <div class="ContentRow">
        <span>YEAR</span>
        <input type="text" v-model="TokenForm.year" />
      </div>
      <div class="ContentRow">
        <span>MONTH</span>
        <input type="text" v-model="TokenForm.month" />
      </div>
      <div class="ContentButton">
        <el-button class="searchButton" :loading="isLoading" @click="searchClick">查询</el-button>
      </div>
    </div>
    <div class="content_cont" v-show="isHaveData">
      <div class="DataHeader">
        <h1>查询结果</h1>
      </div>
      <div class="DataContent">
        <div class="tableContainer">
          <table>
            <tr>
              <th>TV</th>
              <th>SN</th>
              <th>clientip</th>
              <th>cdn_ip</th>
              <th>token</th>
              <th>medianame</th>
              <th>start_time</th>
              <th>end_time</th>
            </tr>
            <tr v-for="(content,index) in data">
              <td v-text="content.tv"></td>
              <td v-text="content.sn"></td>
              <td v-text="content.clientip"></td>
              <td v-text="content.cdn_ip"></td>
              <td>
                <span class='detailMsgSpan' :data_id='index' @mouseover='DetailMouseOver' @mouseout='DetailMouseOut' @click='DetailClick' v-text="content.token"></span>
              </td>
              <td v-text="content.medianame"></td>
              <td v-text="content.start_time"></td>
              <td v-text="content.end_time"></td>
            </tr>
          </table>
          <div v-show='isShowDetail' :style="{top:tokenDetailTop+'px'}" class='DetailContainer'>
            <div v-text='DetailMsg' class='detailToken'></div>
            <img src="../../../assets/img/icon_guanbi.png" @click="closeTokenDetail" />
          </div>
        </div>
        <SNButton class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
      </div>
    </div>
    <div class="promptMsg" v-show="isNoData">数据为空</div>
  </div>
</template>
<script>
import $ from 'jquery'
import {LoginHTTP,cdrDataHTTP} from '../../../api/http'
import SNButton from '../../../components/button/button'
export default{
  data(){
    return {
      data:[],
      pageAll:1,
      isLoading:false,
      isHaveData:false,
      isNoData:false,
      isShowDetail:false,
      isTokenDetailClick:false,
      tokenDetailTop:0,
      DetailMsg:'',
      TokenForm:{
        name:'token',
        page:1,
        year:new Date().getFullYear(),
        month:(new Date().getMonth())+1,
        sessionid:''
      }
    }
  },
  components:{'SNButton':SNButton},
  methods:{
    DetailMouseOver(event){
      if(this.isTokenDetailClick){return;}
      this.showDetailMsg(event);
    },
    DetailMouseOut(){
      if(this.isTokenDetailClick){return;}
      this.isShowDetail=false;
    },
    DetailClick(event){
      this.isTokenDetailClick=true;
      this.showDetailMsg(event);
    },
    showDetailMsg(e){
      let TargetId=$(e.srcElement||e.target).attr('data_id');
      this.DetailMsg=this.data[TargetId].token;
      this.isShowDetail=true;
      if(e.clientY>=700){
        this.tokenDetailTop=e.clientY-342-33;
      }else{
        this.tokenDetailTop=e.clientY-342+33;
      }
    },
    closeTokenDetail(){
      this.isTokenDetailClick=false;
      this.isShowDetail=false;
    },
    DOCCloseTokenDetail(){
      $(document).click((event)=>{
        const e=event.srcElement||event.target;
        const checkedEle1=$($('.DetailContainer')[0]);
        const checkedEle2=$('.detailMsgSpan');
        if(!checkedEle1.is(e.className?'.'+e.className:e) && (checkedEle1.has(e).length===0) && !checkedEle2.is(e.className?'.'+e.className:e)){
          this.closeTokenDetail();
        }
      });
    },
    sendAjax(){
      cdrDataHTTP(this.TokenForm).then(data=>{
        console.log(data);
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isLoading=false;
          if(data.value==null){
            this.isHaveData=false;
            this.isNoData=true;
            this.data=[];
            this.pageAll=1;
          }else{
            this.isHaveData=true;
            this.isNoData=false;
            this.data=data.value;
            this.pageAll=data.pageall;
          }
        }
      });
    },
    searchClick(){
      this.isLoading=true;
      this.TokenForm.page=1;
      this.sendAjax();
    },
    changePage(page){
      this.TokenForm.page=page;
      this.sendAjax();
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.TokenForm.sessionid=data.return;
        this.DOCCloseTokenDetail();
      }
    });
  }
}
</script>
<style lang='less' scoped>
  @import '../../../style/charts/cdrChild/token.less';
</style>







