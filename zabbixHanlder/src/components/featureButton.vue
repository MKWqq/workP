<template>
  <div class="HeaderButton">
    <button :class="buttonClass" v-for="(msg,index) in BtnArray.HeaderBtnMsg" v-text="msg" @click="ButtonClick"></button>
  </div>
</template>
<script>
  import $ from 'jquery'
  export default{
    data(){
      return{}
    },
    props:['BtnArray','buttonClass'],
    methods:{
      ButtonClick(event){
        for(let i=0;i<this.BtnArray.HeaderBtnMsg.length;i++){
          if($(event.target||event.srcElement).text()==this.BtnArray.HeaderBtnMsg[i]){
            this.$emit(this.BtnArray.HeaderBtnClick[i],event);
          }
        }
      }
    }
  }
</script>
<style lang="less" scoped>
.box-sizing(@value){-moz-box-sizing:@value;-ms-box-sizing:@value;-o-box-sizing:@value;-webkit-box-sizing:@value;box-sizing:@value;}
.HeaderButton{position:absolute;top:20px;right:70px;
  button{.box-sizing(border-box);background:none;border:1px solid #c9c9c9;border-radius:4px;width:103px;height:35px;line-height:35px;text-align:center;font-size:14px;color:#5c5c5c;float:left;
    &:focus{outline:none;}
    &:hover{color:#fff;background:#448aca;cursor:pointer;}
  }
  button:nth-of-type(1){border-top-right-radius:0;border-bottom-right-radius:0;
    &.oneButton{border-top-right-radius:4px;border-bottom-right-radius:4px;}
  }
  button:nth-of-type(2){border-left:none;border-top-left-radius:0;border-bottom-left-radius:0;}
}
</style>







