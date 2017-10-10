<template>
  <div class="content">
    <div class="contentTop">
      <img src="../../assets/img/icon_fanhui.png" @click="goBackParent" />
      <h1 v-text="headerText"></h1>
    </div>
    <div class="contentBottom">
      <table v-if="isHaveData" cellpadding="0" cellspacing="0">
        <tr>
          <th class="others">Name</th>
          <th class="others">PID</th>
          <th @click="sortClick">1月</th>
          <th @click="sortClick">2月</th>
          <th @click="sortClick">3月</th>
          <th @click="sortClick">4月</th>
          <th @click="sortClick">5月</th>
          <th @click="sortClick">6月</th>
          <th @click="sortClick">7月</th>
          <th @click="sortClick">8月</th>
          <th @click="sortClick">9月</th>
          <th @click="sortClick">10月</th>
          <th @click="sortClick">11月</th>
          <th @click="sortClick">12月</th>
        </tr>
        <tr v-for="content in data">
          <td v-text="content['0'].v_prog"></td>
          <td v-text="content.pid"></td>
          <td v-text="content['0'].views"></td>
          <td v-text="content['1'].views"></td>
          <td v-text="content['2'].views"></td>
          <td v-text="content['3'].views"></td>
          <td v-text="content['4'].views"></td>
          <td v-text="content['5'].views"></td>
          <td v-text="content['6'].views"></td>
          <td v-text="content['7'].views"></td>
          <td v-text="content['8'].views"></td>
          <td v-text="content['9'].views"></td>
          <td v-text="content['10'].views"></td>
          <td v-text="content['11'].views"></td>
        </tr>
      </table>
      <p v-else class="promptMsg">无数据！</p>
    </div>
    <SNButton v-show="isHaveData" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
  </div>
</template>
<script>
  import {LoginHTTP,ScanDetailHTTP} from '../../api/http'
  import SNButton from '../../components/button/button'
  import $ from 'jquery'
  export default{
    data(){
        return {
          data:[],
          sortInc:1,
          sessionid:'',
          headerText:'',
          channelType:'',
          monthText:'',
          searchYear:'',
          isHaveData:false,
          pageAll:1,
          page:1
        }
    },
    components:{SNButton},
    methods:{
      changePage(ThisPage){
          this.page=ThisPage;
      },
      changePage(Page){
        this.page=Page;
        this.sendAjax();
      },
      goBackParent(){
          this.$router.go(-1);
      },
      sortClick(event){
          const e=$(event.target||event.srcElement);
          this.sortInc=this.sortInc*-1;
          this.monthText=Number(e.text().slice(0,1));
          this.sendAjax();
      },
      sortArray(month){
          let order=this.sortInc||1;
          this.data.sort(function(value1,value2){
              if(Number(value1[month-1].views)-Number(value2[month-1].views)<0){
                  return -1*order;
              }else if(Number(value1[month-1].views)-Number(value2[month-1].views)>0){
                  return 1*order;
              }else{
                  return 0*order;
              }
          });
      },
      sendAjax(){
          if(this.monthText){
            ScanDetailHTTP({sessionid:this.sessionid,month:this.monthText,order:this.sortInc>0?'asc':'desc',type:this.channelType,year:this.searchYear,page:this.page,lang:this.headerText}).then(data=>{
              if(data.data.length){
                this.isHaveData=true;
                this.pageAll=data.maxpage;
                this.data=data.data;
              }else{
                this.isHaveData=false;
              }
            });
          }else{
            ScanDetailHTTP({sessionid:this.sessionid,type:this.channelType,page:this.page,year:this.searchYear,lang:this.headerText}).then(data=>{
              if(data.data.length){
                this.isHaveData=true;
                this.pageAll=data.maxpage;
                this.data=data.data;
              }else{
                this.isHaveData=false;
              }
            });
          }
      }
    },
    created(){
        this.headerText=(this.$route.params.detail).split('_')[0];
        this.channelType=(this.$route.params.detail).split('_')[1];
        this.searchYear=(this.$route.params.detail).split('_')[2];
        LoginHTTP().then(data=>{
        if(data.return==false){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.sessionid=data.return;
          this.sendAjax()
        }
      });
    }
  }
</script>
<style lang="less" scoped>
  @import '../../style/charts/programRanking_details';
</style>





