<template>
  <div class="BindAccount">
    <h3>账号绑定</h3>
    <el-col :span="24" class="BindAccount-top">
      <span class="BindAccount-red"></span>
      <span>绑定第三方账号，可以直接登录，还可以将内容同步到以下平台，与更多好友分享</span>
    </el-col>
    <el-col :span="24">
      <el-col :span="8" class="BindAccount-share-box">
        <el-col :span="14" :offset="5" class="BindAccount-box-1">
          <div class="BindAccount-box-1-2" style="background: #6eb9ff">
            <img src="./../../../../assets/img/schManagementSystem/baseSettings/systemset/icon_qq.png" alt="">
          </div>
          <div class="BindAccount-btn">
            <el-button class="BindAccount-btn-1">立即绑定</el-button>
          </div>
        </el-col>
        <el-col :span="14" :offset="5" style="text-align: center;padding-top:1.5rem;">
          <span style="color: #4da1ff ">未绑定QQ账号</span>
        </el-col>
      </el-col>
      <el-col :span="8" class="BindAccount-share-box">
        <el-col :span="14" :offset="5" class="BindAccount-box-1">
          <div class="BindAccount-box-1-2" style="background: #49dfc8">
            <img src="./../../../../assets/img/schManagementSystem/baseSettings/systemset/icon_weixin.png" alt="">
          </div>
          <div class="BindAccount-btn">
            <el-button class="BindAccount-btn-1">立即绑定</el-button>
          </div>
        </el-col>
        <el-col :span="14" :offset="5" style="text-align: center;padding-top:1.5rem ">未绑定微信账号</el-col>
      </el-col>
      <el-col :span="8" class="BindAccount-share-box">
        <el-col :span="14" :offset="5" class="BindAccount-box-1">
          <div class="BindAccount-box-1-2" style="background: #13b5b1">
            <img src="./../../../../assets/img/schManagementSystem/baseSettings/systemset/icon_hao.png" alt="">
          </div>
          <div class="BindAccount-btn">
            <el-button class="BindAccount-btn-1">立即绑定</el-button>
          </div>
        </el-col>
        <el-col :span="14" :offset="5" style="text-align: center;padding-top:1.5rem ">未绑定微信公众号</el-col>
      </el-col>
    </el-col>
  </div>
</template>
<script>
    export default{
      data(){
        return{

        }
      }
    }
</script>
<style lang="less">
  .BindAccount{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .BindAccount-top{
    margin-top: 2rem;
    color: #ADADAD;
  }
  .BindAccount-red{
    background-color: #FF8686;
    display: inline-block;
    width: .5rem;
    height: .5rem;
    border-radius:.5rem;
    margin-right:.6rem;
  }
  .BindAccount-share-box{
    height:30rem;
    margin-top: 150/16rem;
  }
  .BindAccount-box-1{
    border: 1px solid #d2d2d2;
    border-radius: .6rem;
  }
  .BindAccount-box-1-2{
    background: #bebebe;
    width:8rem;
    height:8rem;
    border-radius:8rem;
    margin: 54/16rem auto 58/16rem auto;
    text-align: center;
    line-height: 8rem;
    cursor: pointer;
  }
  .BindAccount-btn{
    margin:0 auto 47/16rem auto;
    text-align: center;
  }
  .BindAccount-btn-1{
    background: #bebebe;
    color: #FFFFFF;
    padding-left: 1.5rem;
    border-color: #bebebe;
    padding-right: 1.5rem;
  }
  .BindAccount-btn-1:hover{
    border-color: #bebebe;
    color: #FFFFFF;
    background: #bebebe;
  }
  .BindAccount-btn-1:focus{
    border-color: #bebebe;
    color: #FFFFFF;
    background: #bebebe;
  }
</style>
