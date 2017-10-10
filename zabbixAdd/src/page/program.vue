<template>
  <div>
    <div id="Header">
      <h2>PROGRAM REPORT</h2>
    </div>
    <div id="Main">
      <div id="programData">
        <div class="programDataHeader">
          <ul>
            <li @click="showLanguageNav" class="languageContainer">
              语言
              <div v-show="isLanguageNav" class="languageNav">
                <p class="languageText" v-for="language in languageData" @click="chooseLanguage" v-text="language.language"></p>
                <p class="languageText" @click="showAllLanguage" style="background:#808080;color:#fff;">All</p>
              </div>
            </li>
            <li>主机IP</li>
            <li>频道</li>
            <li>节目名称</li>
            <li>中断时间</li>
            <li @click="sortingClick">正常时间</li>
          </ul>
        </div>
        <div class="programDataMain">
          <div class="contentTop">
            <div class="programLeft">
              <table>
                <tr v-for="content in data" :data-id="content.itemid" @click="detailClick">
                  <template v-if="detailIndex==content.itemid">
                    <td v-text="content.language" style="color:#03a0aa" :data-id="content.itemid"></td>
                    <td v-text="content.hostName" style="color:#03a0aa" :data-id="content.itemid"></td>
                    <td v-text="content.name" :data-id="content.itemid" style="color:#03a0aa"></td>
                    <td v-text="content.v_prog" :data-id="content.itemid" style="color:#03a0aa">Cut Bank - Assassinato por  Encomenda 2(017)</td>
                    <td v-text="content.no_time" :data-id="content.itemid" style="color:#03a0aa"></td>
                    <td v-text="content.percentage" :data-id="content.itemid" style="color:#03a0aa"></td>
                  </template>
                  <template v-else>
                    <td v-text="content.language" :data-id="content.itemid">Portuguese</td>
                    <td v-text="content.hostName" :data-id="content.itemid">Portuguese</td>
                    <td v-text="content.name" :data-id="content.itemid"></td>
                    <td v-text="content.v_prog" :data-id="content.itemid">Cut Bank - Assassinato por  Encomenda 2(017)</td>
                    <td v-text="content.no_time" :data-id="content.itemid"></td>
                    <td v-text="content.percentage" :data-id="content.itemid"></td>
                  </template>
                </tr>
              </table>
            </div>
            <div class="programRight">
              <div class="programRightCon">
                <ul>
                  <li>问题</li>
                  <li>开始时间</li>
                  <li>结束时间</li>
                  <li>持续时间</li>
                </ul>
                <div class="tableContainer">
                  <table>
                    <tr v-for="detail in detailData">
                      <td v-text="detail.des"></td>
                      <td v-text="detail.start_time"></td>
                      <td v-text="detail.end_time"></td>
                      <td v-text="detail.long"></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class='contentFooter'>
            <ul>
              <button :class="['turnBefore',{notBefore:isBeforeNotUsed}]" :disabled="isBeforeNotUsed" @click="beforePage"><span></span></button>
              <button :class="['turnAfter',{notAfter:isAfterNotUsed}]" :disabled="isAfterNotUsed" @click="afterPage"><span></span></button>
              <li @click="getThisPage" :class="['pageValue',{activeIndex:activeClass[0]}]" v-text="pageArray[0]"></li>
              <li @click="getThisPage" class="more" v-show="beforeMore">......</li>
              <li @click="getThisPage" :class="['pageValue',{activeIndex:activeClass[1]}]" v-show="buttonIndexShow[1]" v-text="pageArray[1]"></li>
              <li @click="getThisPage" :class="['pageValue',{activeIndex:activeClass[2]}]" v-show="buttonIndexShow[2]" v-text="pageArray[2]"></li>
              <li @click="getThisPage" :class="['pageValue',{activeIndex:activeClass[3]}]" v-show="buttonIndexShow[3]" v-text="pageArray[3]"></li>
              <li class="more" v-show="afterMore">......</li>
              <li :class="['pageValue',{activeIndex:activeClass[4]}]" @click="getThisPage" v-show="buttonIndexShow[4]" v-text="pageArray[4]"></li>
              <li><input type="text" v-model="inputPage" @focus="inputPage=''" /></li>
              <li @click="pageGo">Go</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="return" @click="returnClick" v-show="hasReturn"></div>
    <div id="search" :class="{'notSearchInput':!isSearch,'searchInput':isSearch}">
      <div class="searchInputCon" v-show="isSearch">
        <input placeholder="search" v-model="searchValue" />
        <img src="../assets/img/icon_delete.png" @click="searchClear" />
      </div>
      <div class="searchButton" v-show="isSearch" @click="sendSearch"></div>
      <div class="notSearchButton" v-show="!isSearch" @click="startSearch"></div>
    </div>
  </div>
</template>
<script>
import {LoginHTTP,programMsgHTTP} from '../api/http'
import $ from 'jquery'
export default {
  data(){
    return {
      sessionid:'',
      data:[],
      detailData:[],
      isBeforeNotUsed:false,
      isAfterNotUsed:false,
      beforeMore:false,
      afterMore:false,
      isSearch:false,
      isLanguageNav:false,
      hasReturn:false,
      sort:"inc",
      searchValue:"",
      inputPage:"",
      page:1,
      maxPage:0,
      pageArray:[0,0,0,0,0],
      activeClass:[true,false,false,false,false],
      buttonIndexShow:[true,true,true,true,true],
      detailIndex:0,
      languageData:[],
      languageValue:""
    }
  },
  methods:{
    sendSearch(){
      this.searchValue=$.trim(this.searchValue);
      this.sendAjax();
      this.isSearch=false;
    },
    startSearch(){
      this.isSearch=true;
    },
    searchClear(){
      this.searchValue="";
    },
    sortingClick(){
      if(this.sort==="desc"){
        this.sort="inc";
      }else{
        this.sort="desc"
      }
      this.sendAjax();
    },
    returnClick(){
      this.searchValue="";
      this.page=1;
      this.sort="inc";
      this.hasReturn=false;
      this.sendAjax();
    },
    showAllLanguage(event){
      let e=event.target || event.srcElement;
      this.languageValue="";
      this.sendAjax();
      this.changeLanguageCss($(e).text());
    },
    showLanguageNav(){
      this.isLanguageNav=!this.isLanguageNav;
    },
    chooseLanguage(event){
      let e=event.target || event.srcElement;
      this.languageValue=$.trim($(e).text());
      this.sendAjax();
      this.changeLanguageCss(this.languageValue);
    },
    changeLanguageCss(value){
      for(let i=0;i<$(".languageNav p").length;i++){
        if($($(".languageNav p")[i]).text()==value){
          $($(".languageNav p")[i]).css({color:"#fff",background:"#808080"})
        }else{
          $($(".languageNav p")[i]).css({color:"",background:""})
        }
      }
    },
    beforePage(){
      if(this.page>1){
        this.page=this.page-1;
      }else{
        this.page=this.page;
      };
      this.sendAjax();
    },
    afterPage(){
      if(this.page<this.maxPage){
        this.page=this.page+1;
      }else{
        this.page=this.page;
      };
      this.sendAjax();
    },
    getThisPage(event){
      this.page=Number($(event.target || event.srcElement).text());
      this.sendAjax();
    },
    pageGo(){
      if(this.inputPage==""){
        this.inputPage=1;
      }else if(this.inputPage>=this.maxPage){
        this.inputPage=this.maxPage;
      }
      this.page=Number(this.inputPage);
      this.sendAjax();
    },
    pageSkipButton(){
      if(this.maxPage>=5){
        this.buttonIndexShow=[true,true,true,true,true];
        if(this.page>=3 && this.page<=(this.maxPage-2)){
          this.pageArray=[1,(this.page-1),this.page,(this.page+1),this.maxPage];
        }else if(this.page<3){
          this.pageArray=[1,2,3,4,this.maxPage];
        }else if(this.page>(this.maxPage-2)){
          this.pageArray=[1,(this.maxPage-3),(this.maxPage-2),(this.maxPage-1),this.maxPage];
        }
      }else{
        switch (this.maxPage){
          case 4:
            this.pageArray=[1,2,3,0,this.maxPage];
            this.buttonIndexShow=[true,true,true,false,true];
            break;
          case 3:
            this.pageArray=[1,2,0,0,this.maxPage];
            this.buttonIndexShow=[true,true,false,false,true];
            break;
          case 2:
            this.pageArray=[1,0,0,0,this.maxPage];
            this.buttonIndexShow=[true,false,false,false,true];
            break;
          case 1:
            this.pageArray=[1,0,0,0,0];
            this.buttonIndexShow=[true,false,false,false,false];
            break;
        }
      }
    },
    checkUsed(){
      if(this.page===1 && this.maxPage!=1){
        this.isBeforeNotUsed=true;
        this.isAfterNotUsed=false;
      }else if(this.page===this.maxPage && this.maxPage!=1){
        this.isAfterNotUsed=true;
        this.isBeforeNotUsed=false;
      }else if(this.maxPage==1){
        this.isAfterNotUsed=true;
        this.isBeforeNotUsed=true;
      }else{
        this.isAfterNotUsed=false;
        this.isBeforeNotUsed=false;
      }
    },
    checkMore(){
      let thisLength=this.pageArray.length;
      if(this.maxPage>5){
        if(this.page<=3){
          this.beforeMore=false;
          this.afterMore=true;
        }else if(this.page>=(this.maxPage-2) && this.pageArray[this.pageArray.length-2]>=this.maxPage-1){
          this.beforeMore=true;
          this.afterMore=false;
        }else if(this.page>=(this.maxPage-2) && this.pageArray[1]<=3){
          this.beforeMore=false;
          this.afterMore=true;
        }else{
          this.beforeMore=true;
          this.afterMore=true;
        }
      }else{
        this.beforeMore=false;
        this.afterMore=false;
      }
    },
    sendAjax(){
      if(this.searchValue==="" && this.languageValue===""){
        programMsgHTTP({sessionid:this.sessionid,type:'channelList',page:this.page,sort:this.sort}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data.length!=0){
              this.data=data;
              this.detailData=data[0].times;
              this.detailIndex=data[0].itemid;
              this.maxPage=data[0].maxpage;
              this.pageSkipButton();
              this.checkMore();
              this.checkActiveIndex();
              this.checkUsed();
            }else{
              alert("no data");
              this.data=data;
              this.detailData=data;
              this.detailIndex=data;
              this.maxPage=1;
              this.pageSkipButton();
              this.checkMore();
              this.checkActiveIndex();
              this.checkUsed();
            }
          }
        });
      }else if(this.searchValue!=""){
        programMsgHTTP({sessionid:this.sessionid,type:'channelList',page:this.page,sort:this.sort,value:this.searchValue}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.hasReturn=true;
            if(data.length!=0){
              this.data=data;
              this.detailData=data[0].times;
              this.detailIndex=data[0].itemid;
              this.maxPage=data[0].maxpage;
              this.pageSkipButton();
              this.checkMore();
              this.checkActiveIndex();
              this.checkUsed();
            }else{
              this.data=data;
              this.detailData=data;
              this.detailIndex=data;
              this.maxPage=1;
              this.pageSkipButton();
              this.checkMore();
              this.checkActiveIndex();
              this.checkUsed();
            }
          }
        });
      }else if(this.languageValue!=""){
       programMsgHTTP({sessionid:this.sessionid,type:'channelList',page:this.page,sort:this.sort,languge:encodeURIComponent(this.languageValue)}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
           if(data.length!=0){
             this.data=data;
             this.detailData=data[0].times;
             this.detailIndex=data[0].itemid;
             this.maxPage=data[0].maxpage;
             this.pageSkipButton();
             this.checkMore();
             this.checkActiveIndex();
             this.checkUsed();
           }else{
             console.log("no data");
             this.data=data;
             this.detailData=data;
             this.detailIndex=data;
             this.maxPage=1;
             this.pageSkipButton();
             this.checkMore();
             this.checkActiveIndex();
             this.checkUsed();
           }
          }
        });
      }
    },
    sendLanguageAjax(){},
    checkActiveIndex(){
      for(let i=0;i<this.pageArray.length;i++){
        if(this.page==this.pageArray[i]){
          this.activeClass[i]=true;
        }else{
          this.activeClass[i]=false;
        }
      }
    },
    chooseDetail(){
      for(let i=0;i<this.data.length;i++){
        if(this.detailIndex==this.data[i].itemid){
          this.detailData=this.data[i].times;
        }
      }
    },
    detailClick(event){
      this.detailIndex=$(event.target || event.srcElement).attr("data-id");
      this.chooseDetail();
    }
  },
  beforeCreate(){
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.sendAjax();
        programMsgHTTP({sessionid:this.sessionid,type:'languge'}).then((data)=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.languageData=data
          }
        });
      }
    });
    $(document).click((event)=>{
      let _targetElement=$("#search");
      let _languageElement=$(".languageContainer");
      let e=event.target || event.srcElement;
      if(!_targetElement.is(e.id?'#'+e.id:e)&& _targetElement.has(e.className?'.'+e.className:e).length===0 && !_languageElement.is(e.className?'.'+e.className:e) && _languageElement.has(e.className?'.'+e.className:e).length===0){
        this.isSearch=false;
        this.isLanguageNav=false;
      }else if(_languageElement.is(e.className?'.'+e.className:e) || _languageElement.has(e.className?'.'+e.className:e).length!==0){
        this.isSearch=false;
      }else if(_targetElement.is(e.id?'#'+e.id:e) || _targetElement.has(e.className?'.'+e.className:e).length!==0){
        this.isLanguageNav=false;
      }
    });
  }
}
</script>
<style lang='less'>
  @import '../style/program.less';
</style>




