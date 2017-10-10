<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回
      </el-button>
      <span class="selfCenter">处理任务</span>
    </header>
    <section>
      <div class="g-repairDetail">
        <div class="g-liOneWrapRow">
          <div class="g-detailRow">
            <span class="g-detailLable">报修单号:</span>
            <span>1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">维修地点:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">报修物品:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">联系方式:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">资产编号:</span>
            <span v-text="">1</span>
          </div>
          <div class="g-detailRow">
            <span class="g-detailLable">报修类别:</span>
            <span v-text="">1</span>
          </div>
        </div>
        <div class="g-detailRow">
          <span class="g-detailLable">报修内容:</span>
          <span v-text="">1</span>
        </div>
        <div class="g-detailRow g-repairPerson g-liOneRow">
          <span class="g-detailLable">图片:</span>
          <ul class="g-flexStartWrapRow">
            <li v-for="url in detailImgUpload">
              <img :src="url.url" alt="" />
            </li>
          </ul>
        </div>
      </div>
      <div class="g-spaceDetail">维修中...</div>
      <div>
        <div class="g-contentOne_header">维修结果</div>
        <el-form :model="handlerForm" label-width="100px" label-position="right">
          <div class="g-liOneWrapRow">
            <el-form-item label="维修结果:">
              <el-select v-model="handlerForm.type">
                <el-option value="0" label="完成"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="维修方法:">
              <el-input v-model="handlerForm.address"></el-input>
            </el-form-item>
            <el-form-item label="故障原因:">
              <el-input v-model="handlerForm.things"></el-input>
            </el-form-item>
            <el-form-item label="更换备件类型:">
              <el-input v-model="handlerForm.tel"></el-input>
            </el-form-item>
          </div>
          <el-form-item label="维修反馈:">
            <el-input type="textarea" v-model="handlerForm.address"></el-input>
          </el-form-item>
          <el-form-item label="上传图片:">
            <el-upload
              class="avatar-uploader pictureCardUpload"
              action="https://jsonplaceholder.typicode.com/posts/"
              :show-file-list="true"
              :on-success="handleAvatarSuccess"
              :on-remove="handlerAvatarRemove"
              :file-list="imgUpload"
              list-type="picture-card"
              :before-upload="beforeAvatarUpload">
              <i class="el-icon-plus avatar-uploader-icon"></i>
              <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2M</div>
            </el-upload>
          </el-form-item>
        </el-form>
      </div>
      <div class="g-footer">
        <el-button type="primary" class="largeButton">提交</el-button>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*form表单*/
        handlerForm:{
          type:'',
          address:'',
          things:'',
          tel:'',
          content:'',
          uploadImg:''
        },
        imgUpload:[
          {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
          {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}
        ],
        /*图片信息*/
        detailImgUpload:[
          {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
        ],
      }
    },
    methods:{
      goBackParent(){
        this.$router.push('/serviceTask');
      },
      /*form表单*/
      /*图片上传*/
      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        console.log(file);
        const isJPG = file.type === 'image/jpeg' || file.type ==='image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG或PNG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      },
      handlerAvatarRemove(file,fileList){
        console.log(file);
        console.log(fileList);
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-container{
    header.g-textHeader{border:none;padding-bottom:70/16rem;
      span{.fontSize(19);color:@HColor;.marginLeft(40,1582);}
    }
    section{/*1105*/
      .width(1105,1582);margin:0 auto;
    }
    .g-footer{width:100%;}
  }
  /*添加与编辑弹框*/
  .g-liOneWrapRow .el-form-item{.widthRem(385);}
  .g-liOneWrapRow .el-select{width:100%;}
  /*维修详情弹框*/
  .g-repairDetail{}
  .g-liOneWrapRow .g-detailRow{.widthRem(385);}
  .g-detailRow{width:100%;.marginBottom(36);
    .g-detailLable{display:inline-block;.widthRem(80);text-align:right;margin-right:10/16rem;}
    span{.fontSize(14);color:@normalColor;}
  }
  .g-repairPerson{
    ul{width:100%;}
    li{width:7.5rem;height:7.5rem;margin-right:10/16rem;.marginBottom(10);
      img{width:100%;}
    }
  }
  .g-spaceDetail{.marginBottom(30);border:1px dashed @backgroundBlue;width:100%;.height(42);text-align:center;color:@buttonActive;background-color:@backgroundBlueOpacity;.box-sizing();}
</style>




