<template>
  <div class="programRanking">
    <el-row>
      <div class="operate">
        <span class="operate_btn operate_btn_left" @click="openRankingPop('add')">添加</span><span class="operate_btn operate_btn_center" @click="deleteMsg">删除</span><span class="operate_btn operate_btn_right" @click="openRankingPop('change')">修改</span>
      </div>
    </el-row>
    <div class="divide_line"></div>
    <el-table :data="tableData" ref="multipleTable" @selection-change="handleSelectionChange" border tooltip-effect="dark"  style="width: 100%" class="ranking">
      <el-table-column width="44" type="selection"></el-table-column>
      <el-table-column width="80" type="index" label="序号"></el-table-column>
      <el-table-column width="300" prop="ip" label="服务器IP"></el-table-column>
      <el-table-column width="80" label="IPsender">
        <template scope="scope">
          <span v-if="scope.row.IPsender==0">no</span>
          <span v-if="scope.row.IPsender==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column width="135" prop="use" label="用途"></el-table-column>
      <el-table-column width="300" prop="system" label="操作系统"></el-table-column>
      <el-table-column width="96" prop="ram" label="内存空间"></el-table-column>
      <el-table-column label="磁盘挂载">
        <template scope="scope">
          <span v-if="scope.row.diskMount==0">no</span>
          <span v-if="scope.row.diskMount==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="防火墙">
        <template scope="scope">
          <span v-if="scope.row.firewall==0">no</span>
          <span v-if="scope.row.firewall==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column prop="ssh" label="SSH端口"></el-table-column>
      <el-table-column label="账号管理">
        <template scope="scope">
          <span v-if="scope.row.account==0">no</span>
          <span v-if="scope.row.account==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="权限分配">
        <template scope="scope">
          <span v-if="scope.row.rightsAssignment==0">no</span>
          <span v-if="scope.row.rightsAssignment==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="内容配置">
        <template scope="scope">
          <span v-if="scope.row.content==0">no</span>
          <span v-if="scope.row.content==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="HLS配置">
        <template scope="scope">
          <span v-if="scope.row.hlsConfiguration==0">no</span>
          <span v-if="scope.row.hlsConfiguration==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="HLC注册口">
        <template scope="scope">
          <span v-if="scope.row.hlcRegistrationPort==0">no</span>
          <span v-if="scope.row.hlcRegistrationPort==1">yes</span>
        </template>
      </el-table-column>
      <el-table-column label="监控">
        <template scope="scope">
          <span v-if="scope.row.monitor==0">no</span>
          <span v-if="scope.row.monitor==1">yes</span>
        </template>
      </el-table-column>

    </el-table>
    <div class="divide_line_bottom"></div>
    <SNButton :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
    <div class="rankingPop" v-show="rankingPopState">
      <div class="rankingPop_content">
        <h3>{{title}}</h3>
        <img src="../assets/img/icon_guanbi.png" alt="" class="colse_rankingPop" @click="closeRankingPop(0)">
        <div class="rankingPop_content_center clearfix">
          <div>
            <ul>
              <li>服务器IP：</li>
              <li>用途：</li>
              <li>内存空间：</li>
              <li>防火墙：</li>
              <li>账号管理：</li>
              <li>内容配置：</li>
              <li>HLC注册口：</li>
            </ul>
            <ul class="write">
              <li>
                <input type="text" v-model="activeContent.ip">
              </li>
              <li>
                <input type="text" v-model="activeContent.use">
              </li>
              <li>
                <input type="text" v-model="activeContent.ram">
              </li>
              <li>
                <select name="" v-model="activeContent.firewall">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <select name="" v-model="activeContent.account">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <select name="" v-model="activeContent.content">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <select name="" v-model="activeContent.hlcRegistrationPort">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
            </ul>
          </div>
          <div>
            <ul>
              <li>IPsender：</li>
              <li>操作系统：</li>
              <li>磁盘挂载：</li>
              <li>SSH端口：</li>
              <li>权限分配：</li>
              <li>HLS配置：</li>
              <li>监控：</li>
            </ul>
            <ul class="write">
              <li>
                <select name="" v-model="activeContent.IPsender">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <input type="text" v-model="activeContent.system">
              </li>
              <li>
                <select name="" v-model="activeContent.diskMount">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <input type="text" v-model="activeContent.ssh">
              </li>
              <li>
                <select name="" v-model="activeContent.rightsAssignment">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <select name="" v-model="activeContent.hlsConfiguration">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
              <li>
                <select name="" v-model="activeContent.monitor">
                  <option value="0">no</option>
                  <option value="1">yes</option>
                </select>
              </li>
            </ul>
          </div>
        </div>
        <div class="rankingPop_content_footer">
          <el-button @click="closeRankingPop(0)">取消</el-button>
          <el-button @click="closeRankingPop(1)">重置</el-button>
          <el-button type="primary" @click="saveMsg">确定</el-button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import $ from 'jquery'
  import SNButton from '../components/button/button.vue'
  export default{
    beforeRouteEnter (to, from, next) {
      $.ajax({
        url:"http://113.106.250.156:8000/zabbix/sessionid.php",
        type:"get",
        dataType:"jsonp",
        jsonp:"cb",
        success:function(data){
          if(!data.return){
           window.location.href='http://113.106.250.156:8000/zabbix/index.php';
           }else{
            next(vm => {   // 通过 `vm` 访问组件实例
              vm.sessionid=data.return;
              //初始化请求数据
              var toData={
                page:1,
                sessionid:vm.sessionid
              };
              vm.sendAjax('/Hostinfomation/find','get',toData,function (res) {
                vm.tableData=res.value;
                vm.pageAll=res.pageall;
              })
            });
           }
        }
      })
    },
    data() {
      return {
        tableData: [],
        multipleSelection: [],
        sessionid:'',
        title:'',
        rankingPopState:false,
        pageAll:1,
        page:1,
        activeContent:{},
        orginMsg:{}
      }
    },
    methods:{
      sendAjax (url, type,param,fun) {
        $.ajax({
          url:'http://171.221.202.190:11111/yunwei/index.php'+url,
          type:type,
          dataType:"jsonp",
          data:param,
          jsonp:"cb",
          success:function(data){
            fun(data);
          }
        })
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      closeRankingPop(type){
        var self=this;
        if(type==0){  //关闭按钮
          self.rankingPopState=false;
          self.activeContent={};
        }else{   //重置按钮
          if(self.title=='修改'){
            $.extend(self.activeContent,self.orginMsg);
          }else{
            self.activeContent={};
          }
        }
      },
      openRankingPop(state){
        var self=this;
        if (state=='add') {       //添加
          self.rankingPopState=true;
          self.title='添加';
          self.activeContent={};
        }else{          //修改
          if(self.multipleSelection.length>1){
            alert('修改时只能选择一条信息进行修改！');
            return false;
          }
          if(self.multipleSelection.length==0){
            alert('请选择一条信息！');
            return false;
          }
          self.title='修改';
          self.rankingPopState=true;
          self.sendAjax('/Hostinfomation/findid','get',{id:self.multipleSelection[0].id,sessionid:self.sessionid},function (res) {
            self.activeContent=res[0];
            $.extend(self.orginMsg,res[0]);
          })
        }
      },
      changePage(val){
        var self=this;
        self.page=val;
        self.sendAjax('/Hostinfomation/find','get',{page:val,sessionid:self.sessionid},function (res) {
          self.tableData=res.value;
          self.pageAll=res.pageall;
        })
      },
      saveMsg(){
        var self=this;
        var url='';
        var changeData={
          IPsender: self.activeContent.IPsender,
          account: self.activeContent.account,
          bandwidth: self.activeContent.bandwidth,
          content: self.activeContent.content,
          diskMount: self.activeContent.diskMount,
          firewall: self.activeContent.firewall,
          hlcRegistrationPort: self.activeContent.hlcRegistrationPort,
          hlsConfiguration: self.activeContent.hlsConfiguration,
          ip: self.activeContent.ip,
          monitor:self.activeContent.monitor,
          ram: self.activeContent.ram,
          rightsAssignment: self.activeContent.rightsAssignment,
          ssh: self.activeContent.ssh,
          system: self.activeContent.system,
          use: self.activeContent.use,
          sessionid:self.sessionid
        };
        var resetData={
          page:self.page,
          sessionid:self.sessionid
        };
        if(self.title=='修改'){
          changeData.id=self.activeContent.id;
          url='/Hostinfomation/update';
        }else {
          changeData.id='';
          url='/Hostinfomation/insert';
        }
        self.sendAjax(url,'get',changeData,function (res) {
          if(res.result=='success'){
            self.rankingPopState=false;
            self.activeContent={};
            self.sendAjax('/Hostinfomation/find','get',resetData,function (res) {
              self.tableData=res.value;
              self.pageAll=res.pageall;
            })
          }else{
            alert('操作失败！');
          }
        })
      },
      deleteMsg(){
        var self=this;
        var delData={
          data:[],
          sessionid:this.sessionid
        };
        var resetData={
          page:self.page,
          sessionid:self.sessionid
        };
        self.multipleSelection.forEach(function (select) {
          delData.data.push({'id':select.id});
        })
        delData.data=JSON.stringify(delData.data);
        if(self.multipleSelection.length<=0){
            alert('请选择记录！');
            return false;
        }
        if(confirm('确定删除选择的记录吗？')){
          self.sendAjax('/Hostinfomation/del','get',delData,function (res) {
            if(res.result=='success'){
              self.sendAjax('/Hostinfomation/find','get',resetData,function (res) {
                self.tableData=res.value;
                self.pageAll=res.pageall;
              })
            }else{
              alert('删除失败！');
            }
          })
        }
      }
    },
    components:{
      SNButton:SNButton
    }
  }
</script>
<style>
  .clearfix{
    content: '';
    display: block;
    overflow: hidden;
    clear: both;
  }
  .programRanking{
    padding:0 30px;
    height:530px;
  }
  .operate{
    font-size:14px;
    text-align: left;
    margin-top:25px;
  }
  .operate_btn{
    display: inline-block;
    width:102px;
    height:30px;
    line-height:30px;
    border: 1px solid #d2d2d2;
    text-align: center;
    cursor: pointer;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .operate_btn:hover{
    border: 1px solid #20a0ff;
    color: #20a0ff;
  }
  .operate_btn_left{
    border-radius: 7px 0 0 7px;
  }
  .operate_btn_right{
    border-radius: 0 7px 7px 0;
  }
  .divide_line,.divide_line_bottom{
    width:100%;
    border-bottom:1px solid #d2d2d2;
    margin:25px 0;
  }
  .divide_line_bottom{
    margin:60px 0 20px 0;
  }
  .el-table.ranking th>.cell,.ranking .el-table-column--selection .cell{
    padding:0;
  }
  .el-table.ranking{
    border:1px solid #d2d2d2;
    text-align: center;
    max-height: 550px;
  }
  .el-table.ranking th{
    text-align: center;
  }
  .el-table.ranking th{
    background-color: #fff;
  }
  .ranking .el-table__footer-wrapper thead div, .ranking .el-table__header-wrapper thead div{
    background-color: #fff;
  }
  .el-table.ranking  td, .el-table.ranking th.is-leaf{
    border-bottom:1px solid #d2d2d2;
  }
  .el-table--border.ranking td,.el-table--border.ranking th{
    border-right:1px solid #d2d2d2;
  }
  .rankingPop{
    top: 0;
    left:0;
    width:100%;
    height:100%;
    position: fixed;
    background: rgba(0,0,0,.6);
    z-index:99999;
  }
  .colse_rankingPop{
    position: absolute;
    right:20px;
    top:20px;
    cursor: pointer;
  }
  .rankingPop_content{
    width:844px;
    height:608px;
    position: absolute;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    background-color: #fff;
  }
  .rankingPop_content h3{
    font-size:24px;
    text-align: left;
    padding:20px 0 20px 24px;
  }
  .rankingPop_content_center{
    padding:0 70px;
  }
  .rankingPop_content_center>div{
    float: left;
    width:310px;
  }
  .rankingPop_content_center>div:last-child{
    float: right;
  }
  .rankingPop_content_center ul{
    float: left;
    list-style-type:none;
    margin: -15px 0 0;
    padding:0;
    font-size:16px;
  }
  .rankingPop_content_center ul li{
    margin:30px 0;
    height:30px;
    line-height:30px;
  }
  .rankingPop_content_center li input,.rankingPop_content_center li select{
    width:100%;
    height:30px;
    line-height:30px;
  }
  .rankingPop_content_center>div>ul:first-child{
    text-align: left;
    width:120px;
  }
  .rankingPop_content_center>div>ul:last-child{
    width:190px;
  }
  .rankingPop_content_footer{
    margin:20px;
    text-align: center;
  }
  .rankingPop_content_footer .el-button{
    margin: 0 15px;
  }
</style>
