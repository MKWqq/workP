<template>
  <div class="SNLogin">
    <div class="SNLoginContainer">
      <div class="SNLoginHeader">
        <h1>连接数据库</h1>
      </div>
      <div class="SNLoginMain">
        <el-form :model="SNForm" :rules="SNRules" ref="SNForm">
          <el-form-item label="服务器地址:" prop="serverAddress">
            <el-select class='serverSelect' v-model="SNForm.serverAddress" v-if="isSelect">
              <el-option v-for='content in selectData' :key='content.host' :value="content.host"></el-option>
            </el-select>
            <el-input class="loginInput" v-model="SNForm.serverAddress" v-else></el-input>
          </el-form-item>
          <el-form-item label="用户名:" prop="user">
            <el-input class="loginInput" v-model="SNForm.user"></el-input>
          </el-form-item>
          <el-form-item label="密码:" placeholder="请输入密码" prop="pwd">
            <el-input class="loginInput" v-model="SNForm.pwd"></el-input>
          </el-form-item>
          <el-form-item label="数据库名:" prop="serverName">
            <el-input class="loginInput" v-model="SNForm.serverName"></el-input>
          </el-form-item>
        </el-form>
      </div>
      <div class="SNLoginFooter">
        <el-form>
          <el-form-item>
            <el-button class="confirm" @click="confirmLogin" :loading="Loading">确定</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <div class="SNPrompt" v-show="Prompt">连接失败，请重试！</div>
  </div>
</template>
<script>
  import {SNGetServerMsgHTTP,LoginHTTP} from '../api/http'
  export default{
    data(){
      return{
        selectData:[],
        SNForm:{
          serverAddress:"",
          user:'root',
          pwd:"",
          serverName:'mocean_cdn',
          sessionid:''
        },
        SNRules:{
          serverAddress:[
            {required:true,message:'请选择服务器地址',trigger:'blur'}
          ],
          user:[
            {required:true,message:'请输入用户名',trigger:"blur"}
          ],
          pwd:[
            {required:true,message:"请输入密码",trigger:"blur"}
          ],
          serverName:[
            {required:true,message:"请输入数据库名",trigger:"blur"}
          ]
        }
      }
    },
    props:['Loading','Prompt','isSelect'],
    methods:{
      confirmLogin(){
        this.$refs['SNForm'].validate((valid)=>{
          if(valid){
            this.$emit('sendLogin',{host:this.SNForm.serverAddress,user:this.SNForm.user,pwd:this.SNForm.pwd,name:this.SNForm.serverName,sessionid:this.SNForm.sessionid})
          }
        });
      },
      getServerMsg(){
        if(!this.isSelect){return;}
        SNGetServerMsgHTTP({sessionid:this.SNForm.sessionid}).then(data=>{
          this.selectData=data;
        });
      }
    },
    created(){
      LoginHTTP().then(data=>{
        if(data.return==false){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.SNForm.sessionid=data.return;
          this.getServerMsg();
        }
      });
    }
  }
</script>
<style lang="less" scoped>
  @import '../style/search/LoginComponent.less';
</style>
















