<template>
  <div id="app">
    <div id="login" class="clear_fix" v-if="loginState">
      <div class="login_content">
        <div class="student_entrance">
          <i class="el-icon-d-arrow-right"> 新生专用入口</i>
        </div>
        <el-row class="login_text">
          <el-col :span="12" class="login_text_l">
            <img src="./assets/img/login/logo_n.png" alt="logo">
          </el-col>
          <el-col :span="12" class="login_text_r">
            <el-row class="login_entrance">
              <h3>登录</h3>
              <p>LOGIN</p>
              <el-row class="login_entrance_input">
                <div><input type="text" placeholder="请输入你的账号" v-model="username"></div>
                <div class="login_line"></div>
                <div class="login_pwd">
                  <div v-show="passwordState">
                    <input type="text" placeholder="请输入你的密码" v-model="password">
                    <img src="./assets/img/login/login_eye_normal.png" alt="显示密码" class="login_pwd_show"
                         @click="passwordState=!passwordState">
                  </div>
                  <div v-show="!passwordState">
                    <input type="password" placeholder="请输入你的密码" v-model="password">
                    <div class="login_pwd_hide" @click="passwordState=!passwordState">
                      <img src="./assets/img/login/login_eye_pre.png" alt="隐藏密码">
                      <p>隐藏密码</p>
                    </div>
                  </div>
                </div>
                <div class="mistakeMsg" v-show="mistake">{{mistakeMsg}}</div>
              </el-row>
              <el-row class="login_pwd_btn">
                <el-col :span="12" class="login_pwd_btnL">
                  <el-checkbox v-model="pwdChecked">记住密码</el-checkbox>
                </el-col>
                <el-col :span="12" class="login_pwd_btnR"><a href="javascript:void(0)" @click="showMistake(1)"
                                                             class="forgetPwd">忘记密码？</a></el-col>
              </el-row>
              <el-row class="login_btn" :class="{'login_btn_active':isLogin}">
                <div @click="login">
                  点击登录
                </div>
              </el-row>
              <el-row type="flex" justify="center" class="login_type">
                <el-col :span="5"><span class="login_type_line"></span></el-col>
                <el-col :span="10">
                  <img src="./assets/img/login/login_qq_n.png" alt="qq"><img class="weixin"
                                                                             src="./assets/img/login/login_wechat_n.png"
                                                                             alt="weixin">
                </el-col>
                <el-col :span="5"><span class="login_type_line"></span></el-col>
              </el-row>
            </el-row>
          </el-col>
        </el-row>
      </div>
    </div>
    <div class="common clear_fix" v-else>
      <div class="common_LContainer">
        <div class="logo_con">
          <img src="./assets/img/commonNav/home_logo.png"/>
        </div>
        <div class="Nav_container">
          <ul class="Nav_One" v-show="isMainNav">
            <!--每个三级、二级导航从上到下顺序即为控制其显示还是隐藏的boolean数组位置-->
            <!--修改3_index、2_index、data-text="One"控制arr遍历数组内容,通过One进行判断active的三级导航-->
            <li v-for="(contentOne,indexOne) in NavInfo" v-if="contentOne.parentId==0">
              <!--一级导航文本-->
              <p v-text="contentOne.modelName" :data-msg="contentOne.url" @click="oneNavClick"></p>
              <!--二级导航-->
              <!--NavArr.twoNavArr[0]-->
              <div class="Nav_Two" v-show="false">
                <div class="Nav_TwoRow" v-for="(contentTwo,indexTwo) in NavInfo" v-if="contentOne.modelId==contentTwo.parentId">
                  <div class="Nav_TwoContent" @click="twoNavClick" >
                    <img class="NavTwo_Icon" src="./assets/img/commonNav/icon_1.png"/>
                    <p v-text="contentTwo.modelName" :data-msg="contentTwo.url"></p>
                    <img class="NavTwo_arrowR" v-show="true"
                         src="./assets/img/commonNav/home_daohang_arrow.png"/>
                    <img class="NavTwo_arrowD" v-show="false"
                         src="./assets/img/commonNav/home_daohang_arrow_down.png"/>
                  </div>
                  <!--NavArr.threeNavArr[0]-->
                  <div class="Nav_Three" v-show="false">
                    <section v-for="(contentThree,indexThree) in NavInfo" v-if="contentTwo.modelId==contentThree.parentId">
                      <i></i>
                      <span
                        @click="ThreeNavClick" :data-id="contentThree.parentId" :data-childId="contentThree.modelId" :data-msg="contentThree.url" v-text="contentThree.modelName"></span>
                    </section>
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <div class="childNav" v-show="!isMainNav" v-if="Nav_Three.length>0">
            <header class="childNavHeader" @click="NavBackClick">
              <img src="./assets/img/commonNav/icon_fanhui.png"/>
              <span v-text="Nav_Three[0].modelName"></span>
            </header>
            <ul class="nav_four">
              <li v-for="(contentFour,indexFour) in NavInfo" v-if="contentFour.parentId==Nav_Three[0].modelId">
                <div class="fourNavRow" @click="fourNavClick" :data-msg="contentFour.url" :data-ModelId="contentFour.modelId">
                  <i></i>
                  <span v-text="contentFour.modelName"></span>
                  <img class="NavTwo_arrowR" v-if="Nav_Five[contentFour.modelId].length>0" v-show="true"
                       src="./assets/img/commonNav/home_daohang_arrow.png"/>
                  <img class="NavTwo_arrowD" v-if="Nav_Five[contentFour.modelId].length>0" v-show="false"
                       src="./assets/img/commonNav/home_daohang_arrow_down.png"/>
                </div>
                <div class="fiveNav" v-show="false">
                  <section @click="fiveNavClick"
                           v-for="(fiveContent,fiveIndex) in NavInfo" v-if="fiveContent.parentId==contentFour.modelId"
                           v-text="fiveContent.modelName" :data-msg="fiveContent.url" :data-ModelId="fiveContent.modelId"></section>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="common_RContainer">
        <div class="common_RHeader" :style="isHome?homeHeaderCss:NothomeHeaderCss">
          <div class="weatherCon">
            <div class="g-weatherImg">
              <img src="./assets/img/commonNav/icon_duoyun.png"/>
            </div>
            <span>weather</span>
          </div>
          <div class="rightCon">
            <div class="userCon">
              <div class="g-userCon">
                <img src="./assets/img/commonNav/top_touxiang_no.png"/>
              </div>
              <span>dddd</span>
            </div>
            <div class="emailCon">
              <img src="./assets/img/commonNav/icon_xiaoxi.png"/>
            </div>
            <div class="shareCon">
              <img src="./assets/img/commonNav/icon_signout.png"/>
            </div>
          </div>
        </div>
        <div class="common_RContent clear_fix" :style="isHome?homeContentCss:NothomeContentCss">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapState} from 'vuex'
  import '../static/jcookie/jquery.cookie'
  import req from '@/assets/js/common'
  export default {
    name: 'app',
    data(){
      return{
        /*wy*/
        username: '',
        password: '',
        passwordState: true,
        pwdChecked: false,
        mistake: false,
        mistakeMsg: '',
        loginState:true,
        /*wqq*/
        isMainNav: true,//显示123级导航还是45级导航
        isHome: true,//home主体内容header高度不一样
        homeHeaderCss: {height: '10.375rem', boxShadow: ''},
        NothomeHeaderCss: {height: '5.625rem', boxShadow: '0 0.3125rem 0.625rem rgba(0,0,0,0.2)'},
        homeContentCss: {bottom: '4.75rem', position: 'relative', zIndex: '10'},
        NothomeContentCss: {bottom: '', position: '', zIndex: ''},
        Nav_Three:[],//点击三级导航的信息对象组成的数组，因为用得是filter所以是数组
        Nav_Four:[],
        /*//所有四级导航的五级导航，对象名是四级导航的modelId，对象值为每一个四级导航的五级导航组成的数组*/
        Nav_Five:{},
        changeRouteModel:'',//记录四级导航更改路由的情况
        changeRouteFiveModel:'',//记录五级导航更改路由的情况,四级导航modelId_五级导航modelId
        cssInit:{
          navNormalThree(){
            $('.Nav_Three span').css({background:'',color:'#6a6a6a'});
            $('.Nav_Three i').css({borderColor:'#4da1ff',background:'#4da1ff'});
          },
          navActiveThree(e){
            e.css({background:'#4da1ff',color:'#fff'});
            e.prev().css({borderColor:'#fff',background:'#fff'});
          },
          navNormalFour(){
            $('.fourNavRow span').css({color:'#595959'});
            $('.fourNavRow i').css({background:'#595959',borderColor:'#595959'});
          },
          navActiveFour(e){
              e.find('span').css({color:'#4da1ff'});
              e.find('i').css({background:'#4da1ff',borderColor:'#4da1ff'});
          },
          navNormalFive(){
              $('.fiveNav section').css({background:'',color:'#595959'});
          },
          navActiveFive(e){
              e.css({background:'#4da1ff',color:'#fff'});
          }
        },
      }
    },
    computed: {
      /*wy*/
        isLogin(){   //判断账号密码是否填写,登录按钮能否点击
        var self = this;
        return (self.username && self.password);
      },
      userInfo () {   //获取登录后的用户信息
        return this.$store.state.userInfo;
      },
      /*wqq*/
      ...mapState(['NavInfo'])
    },
    watch: {},
    methods: {
      /*wqq*/
      oneNavClick(event){
        const e=$(event.currentTarget);
        const url=e.data('msg');
        if(url){
          /*清除三级导航active*/
          this.cssInit.navNormalThree();
          this.$router.push('/'+url);
          this.isHome = true;
        }
        else{
          this.showNav(e,'.Nav_Two');
        }
      },
      twoNavClick(event){
        const e=$(event.currentTarget);
        this.showNav(e,'.Nav_Three');
      },
      ThreeNavClick(event){
        const e = $(event.currentTarget);
        const url=e.attr('data-msg');
        /*给当前点击的三级导航添加activeClass*/
        this.cssInit.navNormalThree();
        this.cssInit.navActiveThree(e);
        if(url){
          this.$router.push('/'+url);
          this.isHome = false;
        }
        else{
          this.isMainNav=false;
          this.Nav_Three=this.NavInfo.filter((value,index,arr)=>{
            return value.parentId==e.attr('data-id') && value.modelId==e.attr('data-childId');
          });
          /*init fourNav img 判断是否有五级导航*/
          /*this.Nav_Five[contentFour.modelId].length>0即该四级导航有五级导航*/
          this.Nav_Four=this.NavInfo.filter((value,index,arr)=>{
            return value.parentId==this.Nav_Three[0].modelId;
          });
          this.Nav_Four.forEach((fourNav,fourIndex)=>{
            this.Nav_Five[fourNav.modelId]=[];
            this.NavInfo.forEach((value,index,arr)=>{
              if(value.parentId==fourNav.modelId){
                this.Nav_Five[fourNav.modelId].push(value);
              }
            });
          });
          const timer1=setTimeout(this.setActiveNav,100);
        }
      },
      fourNavClick(event){
        const e = $(event.currentTarget);
        let url='';
        url=e.attr('data-msg');
        /*为四级导航添加active*/
        this.cssInit.navNormalFour();
        this.cssInit.navActiveFour(e);
        if(url){
          this.changeRouteModel=e.attr('data-ModelId');
          this.$router.push('/'+url);
          this.isHome = false;
        }
        else{
          this.showNav(e,'.fiveNav');
        }
/*        if(this.Nav_Five[e.attr('data-ModelId')].length==0){
            this.changeRouteModel=e.attr('data-ModelId');
            this.changeRouter(e.find('span').text());
        }else{
            return
        }*/
      },
      fiveNavClick(event){
        const e = $(event.currentTarget);
        const url=e.attr('data-msg');
        if(url){
          this.$router.push('/'+url);
          this.isHome = false;
        }
        else{}
        this.cssInit.navNormalFive();
        this.cssInit.navActiveFive(e);
//        this.changeRouteModel=e.parent().parent().find('.fourNavRow').attr('data-ModelId');
        this.changeRouteFiveModel=e.parent().parent().find('.fourNavRow').attr('data-ModelId')+'_'+e.attr('data-ModelId');
      },
      showNav(e,childNav){
          /*childNav是需要隐藏或显示的n级导航的className*/
          /*展示自导航公共方法*/
        if(e.siblings().css('display')=='none'){
          e.siblings().css({display:'block'});
          e.find('.NavTwo_arrowD').css({display:'block'});
          e.find('.NavTwo_arrowR').css({display:'none'});
        }else{
          e.siblings().css({display:'none'});
          e.find('.NavTwo_arrowR').css({display:'block'});
          e.find('.NavTwo_arrowD').css({display:'none'});
        }
        e.parent().siblings().find(childNav).css({display:'none'});
        e.parent().siblings().find('.NavTwo_arrowR').css({display:'block'});
        e.parent().siblings().find('.NavTwo_arrowD').css({display:'none'});
      },
      setActiveNav(){
        /*初始化四五级导航的activeClass状态*/
        this.cssInit.navNormalFour();
        this.cssInit.navNormalFive();
        /*给修改路由的四级导航添加activeClass*/
        /*判断是否有四级导航修改导航没*/
        if(this.changeRouteModel){
          this.Nav_Four.forEach((value,index)=>{
            /*判断修改路由四级导航是否在此次遍历中*/
            /*给改变路由的四级导航一个activeClass*/
            if(value.modelId==this.changeRouteModel){
              this.cssInit.navActiveFour($('.nav_four div[data-ModelId=' + value.modelId + ']'));
            }
          });
        }
        else{
          /*五级导航修改路由，需找改变路由的五级导航是否在此次遍历中，给改变路由的五级导航一个activeClass*/
          const fiveModelId=this.changeRouteFiveModel.split('_')[1];
          const fourModelId=this.changeRouteFiveModel.split('_')[0];
          if(fourModelId && this.Nav_Five[fourModelId].length>0){
            this.Nav_Five[fourModelId].forEach((value,index)=>{
              if(value.modelId==fiveModelId){
                this.cssInit.navActiveFive($('.fiveNav section[data-ModelId=' + value.modelId + ']'));
              }
            });
          }
        }
      },
      NavBackClick(){
          this.isMainNav=true;
      },
      /*wy*/
      showMistake(type){
        if (type == 1) {
          this.mistakeMsg = '忘记密码？请联系本班老师';
        } else {
          this.mistakeMsg = '密码错误，请重试';
        }
        this.mistake = true;
      },
      login(){
        var self=this;
        if (!self.isLogin) {
          return false;
        }
        var param={
          account:self.username,
          password:self.password
        };
        req.ajaxSend('/school/user/doLogin','post',param,function (res) {
            if(res.statu==1){   //登录成功
              /*wqq*/
              self.NavTotalArr=res.model;
              /*wy*/
              self.loginState=false;
              self.$store.dispatch({type:'initNavAction',NavInfo:res.model});
              self.$store.dispatch({type:'CommitChangeUser',userInfo:res.user});
              sessionStorage.userInfo=JSON.stringify(res);
              if(self.pwdChecked){
                $.cookie('account', self.username, { expires: 7, path: '/' });
                $.cookie('password', self.password, { expires: 7, path: '/' });
              }else{
                $.cookie('account', null, { expires:-1,path: '/' });
                $.cookie('password', null, { expires:-1,path: '/' });
              }
            }else{
              self.showMistake(0);
            }
         },false);
      }
    },
    created(){
      var userInfo,self=this;
      if(sessionStorage.userInfo){  //先判断session是否存在，会话是否结束，避免在当前位置刷新跳出登录
        self.loginState=false;
        userInfo=JSON.parse(sessionStorage.userInfo);
        self.$store.dispatch({type:'CommitChangeUser',userInfo:userInfo.user});
        self.$store.dispatch({type:'initNavAction',NavInfo:userInfo.model});
      }else{   //判断是否记住密码
        self.loginState=true;
        if($.cookie('account')&&$.cookie('password')){
          self.pwdChecked=true;
          self.username=$.cookie('account');
          self.password=$.cookie('password');
        }else{
          self.pwdChecked=false;
        }
        self.$router.push('/Home');
      }
    }
  }
</script>
<style lang="less" scoped>
  @import 'style/App.less';

  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
  }

  #login {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-image: url(../static/img/bg.png);
    -webkit-background-size: cover;
    background-size: cover;
  }

  .login_content {
    width: 85.38rem;
    height: 48rem;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    background-color: #fff;
    border-radius: .8rem;
  }

  .student_entrance {
    position: absolute;
    right: 4rem;
    top: 2.12rem;
    width: 8.75rem;
    height: 2.5rem;
    line-height: 2.5rem;
    border: 1px solid #4ba8ff;
    text-align: center;
    font-size: 0.875rem;
    color: #4ba8ff;
    cursor: pointer;
  }

  .student_entrance:before {
    content: '';
    position: absolute;
    display: block;
    height: 1px;
    background-color: #4ba8ff;
    width: 4.1rem;
    top: 50%;
    right: -4.1rem;
  }

  .login_text {
    height: 33.5rem;
    margin: 7.25rem 0;
  }

  .login_text > div {
    height: 100%;
    text-align: center;
  }

  .login_text_l {
    border-right: 1px solid #a3a3a3;
  }

  .login_text_l img {
    width: 12.5rem;
    height: auto;
    margin: 12rem 0;
  }

  .login_pwd {
    position: relative;
  }

  .login_pwd img {
    width: 1.875rem;
  }

  .login_pwd_hide, .login_pwd_show {
    cursor: pointer;
    position: absolute;
    right: 0;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
  }

  .login_pwd_hide {
    font-size: .75rem;
    color: #999999;
  }

  .login_text_r {
    padding-top: 1rem;
  }

  .login_entrance {
    width: 25.625rem;
    margin: auto;
  }

  .login_entrance > h3 {
    font-size: 1.875rem;
    color: #212121;
  }

  .login_entrance > p {
    margin-top: .5rem;
    font-size: 1.125rem;
    color: #212121;
  }

  .login_entrance_input {
    position: relative;
    margin: 2.875rem auto 0;
    height: 10.625rem;
    padding: 0 1.5rem;
    border: 1px solid #a3a3a3;
  }

  .mistakeMsg {
    color: #fff;
    font-size: 0.875rem;
    background-color: #ff6772;
    text-align: center;
    padding: .2rem 0;
    width: 54%;
    position: absolute;
    top: -1px;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
  }

  .login_entrance_input > div:nth-child(3) {
    padding-right: 2rem;
  }

  .login_entrance_input input {
    width: 100%;
    height: 5rem;
    font-size: 1.125rem;
    border: none;
    color: #878787;
  }

  .login_entrance_input input:focus {
    outline: none;
  }

  .login_entrance_input :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color: #878787;
  }

  .login_entrance_input ::-moz-placeholder { /* Mozilla Firefox 19+ */
    color: #878787;
  }

  .login_entrance_input input:-ms-input-placeholder {
    color: #878787;
  }

  .login_entrance_input input::-webkit-input-placeholder {
    color: #878787;
  }

  .login_pwd_btn {
    margin-top: 1.25rem;
  }

  .login_pwd_btn .el-checkbox__label {
    font-size: 1rem;
  }

  .login_pwd_btnL {
    text-align: left;
  }

  .login_pwd_btnR {
    text-align: right;
    font-size: 1rem;
  }

  .login_btn {
    margin-top: 3.125rem;
    height: 2.875rem;
    line-height: 2.875rem;
    font-size: 1.125rem;
    color: #fff;
    background-color: #a5d3ff;
  }

  .login_btn_active {
    background-color: #4ba8ff;
    cursor: pointer;
  }

  .login_type {
    margin-top: 2.25rem;
  }

  .login_type img {
    width: 2.5rem;
    height: auto;
    cursor: pointer;
  }

  .login_type img.weixin {
    margin-left: 1.75rem;
  }

  .login_type_line, .login_line {
    border-bottom: 1px solid #a3a3a3;
  }

  .login_type_line {
    display: block;
    height: 1.25rem;
  }
</style>
