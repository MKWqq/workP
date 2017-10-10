<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回
      </el-button>
      <span class="selfCenter">分享</span>
    </header>
    <section>
      <div class="g-shareContent_one">
        <header class="g-sharePartHeader">问卷链接</header>
        <div class="g-prompt">温馨提示：复制或分享访问链接给他人填写，用户可通过链接进入问卷，但无法收集系统外用户的实名。</div>
        <div>
          <input class="g-defineInput" type="text" v-model="linkInput" />
          <button class="g-defineButton">复制</button>
        </div>
      </div>
      <div class="g-shareContent_two">
        <header class="g-sharePartHeader">问卷链接</header>
        <div class="g-prompt">温馨提示：用通过下载打印二维码，让用户扫码填写；通过微信、QQ、微博扫一扫分享给好友，让更多的用户填写。</div>
        <div class="g-flexStartRow g-QRCode">
          <div class="g-imgContainer">
            <img src="" />
          </div>
          <div class="selfCenter">
            <div class="g-textContainer">
              <p><span>问卷名:</span><span>1</span></p>
              <p><span>状态:</span><span>未使用</span></p>
            </div>
            <el-button type="primary" class="radiusButton">下载二维码</el-button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        linkInput:'123',
      }
    },
    methods:{
      goBackParent(){
        this.$router.push('/questionNaireRecord');
      },
    }
  }
</script>
<style lang="less" scoped>
  /*@import '../../../../style/test';*/
  @import '../../../../style/style';
  header.g-textHeader{border:none;padding-bottom:20/16rem;
    span{.fontSize(19);color:@HColor;.marginLeft(40,1582);}
  }

  .g-container header.g-sharePartHeader{.width(100,1582);.height(30);font-size:14/16rem;color:#fff;background:@backgroundBlue;.box-shadow(0 4/16rem 6/16rem 0 rgba(0,0,0,.2));text-align:center;.border-bottom-right-radius(15/16rem);.border-top-right-radius(15/16rem);margin:40/16rem 0 20/16rem;padding-bottom:0;}
  div.g-prompt{text-align:left;margin:20/16rem 0;}
  .g-defineInput{padding:10/16rem 15/16rem;.widthRem(500);.box-sizing();border:1px solid @borderColor;margin-right:0;}
  .g-defineButton{padding:10/16rem 30/16rem;background:@buttonActive;color:#fff;border:none;position:relative;top:1px;left:-4px;
    &:hover{cursor:pointer;}
    &:focus{outline:none;}
  }
  .g-QRCode{.NotLineheight(200);
    .g-imgContainer{
      .widthRem(200);margin-right:20/16rem;height:100%;border:1px solid red;
      img{}
    }
    .g-textContainer{.marginBottom(50);
      p{.fontSize(14);color:@promptColor;}
    }
  }
</style>
