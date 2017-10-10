<template>
  <section class="gR-section">
    <el-form class="messageForm" ref="messageForm" :model="messageForm" label-width="112px">
      <el-form-item class="row" label="照片:">
        <div class="pictureContainer">
          <div class="imgContainer">
            <img :src="personPictureUrl" />
          </div>
          <el-upload v-show="isHandlerMsg" class="personPicture upload-demo" :show-file-list="false" action="https://jsonplaceholder.typicode.com/posts/" :on-preview="handlePreview" :on-remove="handleRemove" list-type="picture">
            <div slot="tip" class="el-upload__tip">尺寸:150*200</div>
            <div slot="tip" class="el-upload__tip">大小:小于5M</div>
            <el-button size="small" type="success">上传图片</el-button>
          </el-upload>
        </div>
      </el-form-item>
      <el-form-item class="row rowEven" label="姓名:">
        <el-input v-model="messageForm.userName" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.userName" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="年级:">
        <el-select v-model="messageForm.gradNum" v-show="isHandlerMsg">
          <el-option v-for="(option,key) in messageData.selectArr.gradMsg" :key="option" :value="option"></el-option>
        </el-select>
        <div v-text="messageData.gradNum" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row rowEven" label="班级:">
        <el-select v-model="messageForm.classNum" v-show="isHandlerMsg">
          <el-option v-for="(content,key) in messageData.selectArr.classMsg" :key="content" :value="content"></el-option>
        </el-select>
        <div v-text="messageData.classNum" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="班级序号:">
        <el-input v-model="messageForm.classOrdinal" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.classOrdinal" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="手机号码:">
        <el-input v-model="messageForm.tel" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.tel" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="性别:">
        <el-select v-model="messageForm.gender" v-show="isHandlerMsg">
          <el-option value="0" label="女"></el-option>
          <el-option value="1" label="男"></el-option>
        </el-select>
        <div v-text="messageData.gender" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="家庭住址:">
        <el-input v-model="messageForm.address" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.address" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="身高:">
        <el-input v-model="messageForm.personHeight" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.personHeight" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="家庭住址邮编:">
        <el-input v-model="messageForm.email" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.email" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="身份证号:">
        <el-input v-model="messageForm.IdCardNum" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.IdCardNum" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="现在住址:">
        <el-input v-model="messageForm.nowAddress" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.nowAddress" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="国籍:">
        <el-input v-model="messageForm.national" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.national" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="现在地址邮编:">
        <el-input v-model="messageForm.nowEmail" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.nowEmail" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="民族:">
        <el-input v-model="messageForm.local" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.local" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="宿舍栋号:">
        <el-input v-model="messageForm.buildingNum" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.buildingNum" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="政治面貌:">
        <el-input v-model="messageForm.plotical" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.plotical" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="宿舍楼层:">
        <el-input v-model="messageForm.floors" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.floors" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="入团时间:">
        <el-date-picker type="date" :picker-options="dateOption" placeholder="选择时间" v-model="messageForm.ploticalTime" v-show="isHandlerMsg"></el-date-picker>
        <div v-text="messageData.ploticalTime" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="宿舍号:">
        <el-input v-model="messageForm.dormitoryNum" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.dormitoryNum" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="入学时间:">
        <el-date-picker type="date" :picker-options="dateOption" placeholder="选择时间" v-model="messageForm.schoolTime" v-show="isHandlerMsg"></el-date-picker>
        <div v-text="messageData.schoolTime" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="学生卡号:">
        <el-input v-model="messageForm.studentIdCard" v-show="isHandlerMsg"></el-input>
        <div v-text="messageData.studentIdCard" v-show="!isHandlerMsg"></div>
      </el-form-item>
      <el-form-item class="row" label="入学方式:">
        <el-select v-model="messageForm.schoolType" v-show="isHandlerMsg">
          <el-option value="住校" label="住校"></el-option>
          <el-option value="走读" label="走读"></el-option>
        </el-select>
        <div v-text="messageData.schoolType" v-show="!isHandlerMsg"></div>
      </el-form-item>
    </el-form>
  </section>
</template>
<script>
  export default{
    data(){
      return{
        /*wqq*/
        personPictureUrl:'',
        dateOption:{
            disabledDate(time){
              return time.getTime()>Date.now();
            }
        }
      }
    },
    props:['messageForm','messageData','isHandlerMsg'],
    methods:{
      /*未完。。。*/
      /*头像部分*/
      handleRemove(file, fileList) {
        console.log(file, fileList);
      },
      handlePreview(file) {
        console.log(file);
      }
    },
    created(){}
  }
</script>
<style lang="less" scoped>
  @import '../../../../../../style/userManager/student/studentManager.less';
  @import '../../../../../../style/userManager/student/studentManager.css';
  @import '../../../../../../style/css/common.css';
</style>



