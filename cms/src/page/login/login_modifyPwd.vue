<template>
  <div id="ModifyPwd">
    <el-form class="ModifyForm" ref="ModifyForm" :model="ModifyPwd" :rules="ModifyRules">
      <el-form-item label="Original password:" prop="oldPwd">
        <el-input type="text" v-model="ModifyPwd.oldPwd"></el-input>
      </el-form-item>
      <el-form-item label="New password:" prop="newPwdOne">
        <el-input type="text" v-model="ModifyPwd.newPwdOne" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item label="Comfirm password:" prop="newPwdTwo">
        <el-input type="text" v-model="ModifyPwd.newPwdTwo" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item>
        <div @click="confirmCancel" class="cancelModify">Cancel</div>
        <div @click="confirmModify('ModifyForm')" class="confirmModify">Ok</div>
      </el-form-item>
    </el-form>
    <template v-if="confirmCancelShow">
      <div class="confirmCancel">
        <div class="container">
          <div class="Main">
            <h4>Prompt</h4>
            <p>Are you sure leaving this page?</p>
            <div class="buttonContainer">
              <div @click="returnModify" class="return">No</div>
              <router-link to="loginSuccess" class="go">Yes</router-link>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>
<script>
import $ from "jquery";
import {CheckedLoginHTTP,UpdateLoginHTTP} from '../../api/http'
import {mapActions} from 'vuex'
export default{
    data(){
      var validatorOld=(rule,value,callback)=>{
        if(value==""){
          callback(new Error("Please enter the original password"));
        }else{
          callback();
        }
      }
      var validatorNewOne=(rule,value,callback)=>{
        if(value==""){
          callback(new Error("Please enter a new password"));
        }else{
          callback();
        }
      }
      var validatorNewTwo=(rule,value,callback)=>{
        if(value==""){
          callback(new Error("Please enter a new password again"));
        }else if(value !== this.ModifyPwd.newPwdOne){
          callback(new Error("Please enter the same password"));
        }else{
          callback();
        }
      }
      var validatorFormat=(rule,value,callback)=>{
        if(!/^[\w]{4,13}$/.test(value)){
          if(/^[\w]{14,1000}$/.test(value) || /^[\w]{0,3}$/.test(value)){
             callback(new Error("Please enter the password that was 4 to 13"));
          }else{
             callback("Please enter a valid characters");
          }
        }else{
          callback();
        }
      }
      return {
        confirmCancelShow:false,
        ModifyPwd:{
          oldPwd:"",
          newPwdOne:"",
          newPwdTwo:""
        },
        ModifyRules:{
          oldPwd:[{validator:validatorOld,trigger:"blur"}],
          newPwdOne:[{validator:validatorNewOne,trigger:"blur"},{validator:validatorFormat,trigger:"blur,change"}],
          newPwdTwo:[{validator:validatorNewTwo,trigger:"blur"},{validator:validatorFormat,trigger:"blur,change"}]
        }
      }
    },
    methods:{
      ...mapActions(['CheckLoginState']),
      confirmCancel(){
        this.confirmCancelShow=true;
      },
      returnModify(){
        this.confirmCancelShow=false;
      },
      confirmModify(formName){
        this.$refs[formName].validate((valid) => {
          if(valid){
            UpdateLoginHTTP({passold:this.ModifyPwd.oldPwd,passnew1:this.ModifyPwd.newPwdOne,passnew2:this.ModifyPwd.newPwdTwo}).then(data=>{
              if('logincheck' in data){
                this.$router.push({name:'loginStart'});
              }else if('pass' in data){
                alert('The original password mistake!');
              }else if(data.return){
                alert('Modify the success!');
              }else{
                alert('Modify the failure!');
              }
            });
            this.$router.push("loginSuccess");
          }else{
            console.log("submit error");
          }
        });
      }
    },
    created(){
      this.CheckLoginState();
    },
    beforeCreate(){
      CheckedLoginHTTP().then(data=>{
        if(!data.logincheck){
          this.$router.push({name:'loginStart'});
        }
      });
    }
  }
</script>
<style lang="less" scoped>
  @import "../../style/login/loginModifyPwd.less";
</style>











