<template>
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
</template>
<script>
import $ from 'jquery'
export default{
  data(){
    return {
      isBeforeNotUsed:false,
      isAfterNotUsed:false,
      beforeMore:false,
      afterMore:false,
      inputPage:"",
      page:1,
      pageArray:[0,0,0,0,0],
      activeClass:[true,false,false,false,false],
      buttonIndexShow:[true,true,true,true,true],
    }
  },
  props:['maxPage','activePage'],
  methods:{
    beforePage(){
      if(this.page>1){
        this.page=this.page-1;
      }else{
        this.page=1;
      }
      this.$emit('sendNewAjax',this.page);
      this.checkButton();
    },
    afterPage(){
      if(this.page<this.maxPage){
        this.page=this.page+1;
      }else{
        this.page=this.maxPage;
      }
      this.$emit('sendNewAjax',this.page);
      this.checkButton();
    },
    getThisPage(event){
      this.page=Number($(event.target || event.srcElement).text());
      this.$emit('sendNewAjax',this.page);
      this.checkButton();
    },
    pageGo(){
      if(this.inputPage==""){
        this.inputPage=1;
      }else if(this.inputPage>=this.maxPage){
        this.inputPage=this.maxPage;
      }
      this.page=Number(this.inputPage);
      this.$emit('sendNewAjax',this.page);
      this.checkButton();
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
    checkActiveIndex(){
      for(let i=0;i<this.pageArray.length;i++){
        if(this.page>this.maxPage){this.page=this.maxPage;}
        if(this.page==this.pageArray[i]){
          this.activeClass[i]=true;
        }else{
          this.activeClass[i]=false;
        }
      }
    },
    checkButton(){
      this.pageSkipButton();
      this.checkMore();
      this.checkActiveIndex();
      this.checkUsed();
    }
  },
  watch:{
    activePage(newValue){
      if(this.activePage!=''&&this.activePage!=undefined&&this.activePage!=null){
        this.page=this.activePage;
      }
      this.checkButton();
    },
    maxPage(){
      this.checkButton();
    }
  },
  created(){
    this.checkButton();
  }
}
</script>
<style lang="less" scoped>
  @import './button.less';
</style>












