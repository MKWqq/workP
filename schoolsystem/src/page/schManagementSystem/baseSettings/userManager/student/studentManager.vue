<template>
  <div class="g-container">
    <header class="g-header">学生个人信息</header>
    <section class="g-section clear_fix">
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>选择学生</h2>
          <el-input @input="fuzzyClick" v-model="fuzzyInput" class="fuzzyInput" placeholder="请输入查询分类或姓名" icon="search"></el-input>
        </header>
        <section class="gL-section">
          <el-tree :highlight-current="true" :data="data" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode" @node-click="handleNodeClick"></el-tree>
        </section>
      </div>
      <div class="g-sectionR">
        <header class="gR-header">
          <ul>
            <li data-msg="isBasic" @click="changeMsg" :style="{color:headerShow.isBasic?'#4da1ff':''}">基本信息</li>
            <li data-msg="isStatus" @click="changeMsg" :style="{color:headerShow.isStatus?'#4da1ff':''}">学籍信息</li>
            <li data-msg="isLocal" @click="changeMsg" :style="{color:headerShow.isLocal?'#4da1ff':''}">户籍信息</li>
            <li data-msg="isParent" @click="changeMsg" :style="{color:headerShow.isParent?'#4da1ff':''}">家长信息</li>
            <li data-msg="isMoney" @click="changeMsg" :style="{color:headerShow.isMoney?'#4da1ff':''}">学费信息</li>
            <li data-msg="isOthers" @click="changeMsg" :style="{color:headerShow.isOthers?'#4da1ff':''}">其他信息</li>
          </ul>
        </header>
        <basic v-show="headerShow.isBasic" :messageData="messageBasicData" :messageForm="messageBasicForm" :isHandlerMsg="isHandlerMsg"></basic>
        <footer class="gR-footer">
          <div class="gR-buttonContainer clear_fix">
            <el-button type="primary" class="msgButton" v-show="!isHandlerMsg" @click="handlerMsg">编辑</el-button>
            <el-button class="msgButton" v-show="isHandlerMsg" @click="isHandlerMsg=false">取消</el-button>
            <el-button type="primary" class="msgButton" v-show="isHandlerMsg" @click="confirmChange">保存</el-button>
          </div>
        </footer>
      </div>
    </section>
  </div>
</template>
<script>
  import basic from './managerChild/basicInformation.vue'
  import req from '@/assets/js/common'
  export default{
    data(){
      return{
        /*test*/
        data: [
        {
          id:1,
          label: '一级 1',
          children: [{
            label: '二级 1-1',
            children: [{
              label: '三级 1-1-1'
            }]
          }]
        }, {
          id:1,
          label: '一级 2',
          children: [{
            label: '二级 2-1',
            children: [{
              label: '三级 2-1-1'
            }]
          }, {
            label: '二级 2-2',
            children: [{
              label: '三级 2-2-1'
            }]
          }]
        }, {
          label: '一级 3',
          children: [{
            label: '二级 3-1',
            children: [{
              label: '三级 3-1-1'
            }]
          }, {
            label: '二级 3-2',
            children: [{
              label: '三级 3-2-1'
            }]
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        /*wqq*/
        isHandlerMsg:false,//是否为编辑个人信息
        fuzzyInput:'',
        headerShow:{
          isBasic:true,isStatus:false,isLocal:false,
          isParent:false,isMoney:false,isOthers:false
        },
        messageBasicForm:{
          /*编辑的form表单的所有数据*/
          userName:'',
          gradNum:'',//选中的年级
          classNum:'',//选中的班级
          classOrdinal:'',
          tel:'',
          gender:'',
          address:'',
          personHeight:'',
          email:'',
          IdCardNum:'',
          nowAddress:'',
          national:'',
          nowEmail:'',
          local:'',
          buildingNum:'',
          plotical:'',
          floors:'',
          ploticalTime:'',
          dormitoryNum:'',
          schoolTime:'',
          studentIdCard:'',
          schoolType:''
        },
        messageBasicData:{
          /*data返回的数据*/
          userName:'wqq',
          gradNum:'一年级',//当前的年级
          classNum:'1',//当前的班级
          classOrdinal:'05',//班级序号
          tel:'1356054665',
          gender:'女',//性别,
          address:'dfdafgf',
          personHeight:'184',
          email:'555555',//邮编
          IdCardNum:'513258632146',//身份证号
          nowAddress:'dfsdgger',
          national:'中国',//国籍
          nowEmail:'now34455',//现在邮编
          local:'汉',//民族
          buildingNum:'2栋',//栋数
          plotical:'团员',//政治面貌
          floors:'2楼',//楼层
          ploticalTime:'2017-8-7',//入团时间
          dormitoryNum:'501',//宿舍号
          schoolTime:'2017-8-7',//入学时间
          studentIdCard:'489347',//学生卡号
          schoolType:'住校',//入学方式
          selectArr:{
            gradMsg:['一年级','二年级'],
            classMsg:[1,2,3,4]
          }
        },
        dateOption:{
            disabledDate(time){
              return time.getTime()>Date.now();
            }
        }
      }
    },
    components:{'basic':basic},
    methods:{
      /*未完。。。*/
      /*tree功能*/
      filterNode(value, data) {
        /*筛选节点*/
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      fuzzyClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['allMsg'].filter(this.fuzzyInput);
      },
      handleNodeClick(data){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        console.log(data);
        this.getMsgAjax();
      },
      /*wqq*/
      confirmChange(){
        this.isHandlerMsg=false;
      },
      handlerMsg(){
        this.isHandlerMsg=true;
        this.getForm();
      },
      changeMsg(event){
        /*修改右边section内容部分*/
        const e=$(event.currentTarget);
        /*change css*/
        e.css({color:'#4da1ff'});
        e.siblings().css({color:''});
        /*change content*/
        for(let keys in this.headerShow){
          if(keys==e.attr('data-msg')){
            this.headerShow[keys]=true;
          }else{
            this.headerShow[keys]=false;
          }
        }
      },
      getMsgAjax(){
        req.ajaxSend('http://localhost/school/user/userGl?type=studentList&ListType=jbXi','get',{grade:1,class:[1]},function(data){
          console.log(data);
        });
      },
      getForm(){
        /*重置input框的值*/
        for(let keys in this.messageData){
          this.messageForm[keys]=this.messageData[keys];
        }
      }
    },
    created(){
      this.getForm();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../../style/userManager/student/studentManager.less';
  @import '../../../../../style/userManager/student/studentManager.css';
  @import '../../../../../style/css/common.css';
</style>



