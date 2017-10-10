<template>
  <div class="ContentBottom">
    <div class="ContentHeader">
      <div class="ContentRow">
        <span>TV/VOD</span>
        <input type="text" v-model="TVForm.tv" />
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
    </div>
    <div class="promptMsg" v-show="isNoData">数据为空</div>
  </div>
</template>
<script>
import {LoginHTTP,cdrDataHTTP} from '../../../api/http'
import $ from 'jquery'
export default{
  data(){
    return {
      data:[],
      isLoading:false,
      isHaveData:false,
      isNoData:false,
      isShowDetail:false,
      isTokenDetailClick:false,
      tokenDetailTop:0,
      DetailMsg:'',
      TVForm:{
        name:'tv',
        tv:'',
        sessionid:''
      }
    }
  },
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
      let positionY=e.clientY+($('.DataContent').scrollTop());
      this.DetailMsg=this.data[TargetId].token;
      this.isShowDetail=true;
      if(e.clientY>=700){
        this.tokenDetailTop=positionY-342-33;
      }else{
        this.tokenDetailTop=positionY-342+33;
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
    searchClick(){
      if(this.TVForm.tv=='1'){
        alert("请完善信息！");
      }else{
        this.isLoading=true;
        cdrDataHTTP(this.TVForm).then(data=>{
          console.log(data);
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.isLoading=false;
            if(data==null){
              this.isHaveData=false;
              this.isNoData=true;
              this.data=[];
            }else{
              this.isHaveData=true;
              this.isNoData=false;
              this.data=data;
            }
          }
        });
      }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.TVForm.sessionid=data.return;
        this.DOCCloseTokenDetail();
      }
    });
  }
}
</script>
<style lang='less' scoped>
  @import '../../../style/charts/cdrChild/TV.less';
</style>








