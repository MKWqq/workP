<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span>输入channel值:</span>
        <div class="selectContainer">
          <input v-model="channelValue" />
        </div>
      </div>
      <div class="searchButton">
        <el-form>
          <el-form-item>
            <el-button @click="searchClick" class="searchButton">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
      <div class="clearNoContainer">
        <span class='clearNo' @click="deleteAllClick">清除失效链接</span>
      </div>
      <headerButton :BtnArray="HeaderBtnArray" v-on:ShowTotalData="ShowTotal" v-on:AddClick="AddDataClick"></headerButton>
    </div>
    <div class="ContentBottom" v-show="isHaveData">
      <table cellpadding='0' cellspacing='0'>
        <tr>
          <th>channel</th>
          <th>link</th>
          <th>language</th>
          <th>status</th>
          <th>操作</th>
        </tr>
        <tr v-for="content in data">
          <td v-text='content.channel' :style="{color:content.status=='1'?'#4a4a4a':'#a9a9a9'}"></td>
          <td v-text="content.link" :style="{color:content.status=='1'?'#4a4a4a':'#a9a9a9'}"></td>
          <td v-text="content.language" :style="{color:content.status=='1'?'#4a4a4a':'#a9a9a9'}"></td>
          <td v-if="content.status=='1'">链接可用</td>
          <td v-else :style="{color:content.status=='1'?'#4a4a4a':'#a9a9a9'}">链接失效</td>
          <td>
            <span @click="showUpdate" :data-channel="content.channel">修改</span>
            <span @click="deleteClick" :data-channel="content.channel">删除</span>
          </td>
        </tr>
      </table>
    </div>
    <SNButton v-show="isHaveData" :activePage='childPage' class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
    <div class="channelUpdate" v-show="isUpdate">
      <div class="channelUpdateContainer">
        <div class="UpdateHeader">
          <h1>修改数据</h1>
        </div>
        <div class="UpdateContent">
          <div class="ContentRow">
            <span>link:</span>
            <input type="text" v-model="ChannelLink" />
          </div>
          <div class="ContentRow">
            <span>language:</span>
            <input type="text" v-model="ChannelLanguage" />
          </div>
        </div>
        <div class="UpdateFooter">
          <button @click="isUpdate=false">取消</button>
          <button :loading="isLoading" @click="confirmUpdate">确定</button>
        </div>
      </div>
    </div>
    <div class="addChannel" v-show="isAddChannel">
      <div class="addChannelContainer">
        <div class="addChannelHeader">
          <h1>添加数据</h1>
          <img src="../../assets/img/icon_guanbi.png" @click="isAddChannel=false" />
        </div>
        <div class="addChannelContent">
          <el-table :data="addTableData" style="width:1250px" height="529" max-height="529" @select-all="checkIsAllChecked" @select="checkIsChecked">
            <el-table-column @select="selectChecked(selection,row)" @select-all="selectAllChecked(selection)" type="selection" width="103"></el-table-column>
            <el-table-column label="channel" width="227">
              <template scope="scope"><input class="addInput" v-model="scope.row.channel" type="text" /></template>
            </el-table-column>
            <el-table-column label="link" width="778" show-overflow-tooltip>
              <template scope="scope"><input class="addInput" v-model="scope.row.link" type="text" /></template>
            </el-table-column>
            <el-table-column label="language" width="142">
              <template scope="scope"><input class="addInput" v-model="scope.row.language" type="text" /></template>
            </el-table-column>
          </el-table>
        </div>
        <div class="addChannelFooter">
          <button class="addTR" @click="addTR">增加</button>
          <button class="deleteTR" @click="deleteTR">删除</button>
          <button class="submitAdd" @click="submitAdd">提交</button>
        </div>
      </div>
    </div>
    <div class='successPrompt' v-show="isInsertSuccess">
      <div class='successPromptContainer'>
        <div class='successPromptContent'>
          <p>添加成功</p>
        </div>
        <div class='successPromptButton'>
          <button @click="isInsertSuccess=false;">确定</button>
        </div>
      </div>
    </div>
    <div class='failPrompt' v-show="isInsertFail">
      <div class='failPromptContainer'>
        <div class='failPromptHeader'>
          <h1>添加失败</h1>
        </div>
        <div class='failPromptContent'>信息添加失败!</div>
        <div class='failPromptButton'>
          <button @click='isInsertFail=false'>取消</button>
          <button @click='InsertAgain'>重试</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import headerButton from '../../components/featureButton'
import {LoginHTTP,channelDataHTTP,channelSearchHTTP,channelUpdateHTTP,channelInsertHTTP,channelDeleteHTTP,channelDeleteAllHTTP} from '../../api/http'
export default{
  data(){
    return{
      sessionid:'',
      data:[],
      addTableData:[{channel:'',link:'',language:''},
        {channel:'',link:'',language:''}],
      addTableDataHTTP:[],
      isLoading:false,
      isHaveData:false,
      isUpdate:false,
      isAddChannel:false,
      isInsertSuccess:false,
      isInsertFail:false,
      InsertFailMsg:'',
      isAllCheckedIndex:0,
      isCheckedObj:[],
      channelValue:'',
      ChannelLink:'',
      ChannelLanguage:'',
      channelName:'',
      childPage:'',
      page:1,
      pageAll:1,
      HeaderBtnArray:{HeaderBtnMsg:['全部数据','添加数据'],HeaderBtnClick:['ShowTotalData','AddClick']}
    }
  },
  components:{'SNButton':SNButton,'headerButton':headerButton},
  methods:{
    submitAdd(){
      //handle data
      this.addTableData.every((value,index)=>{
        value.channel=encodeURIComponent(value.channel);
        value.link=encodeURIComponent(value.link);
        return value;
      });
      this.isAddChannel=false;
      channelInsertHTTP({sessionid:this.sessionid,data:JSON.stringify(this.addTableData)}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.result=='success'){
            this.isInsertSuccess=true;
          }else{
            this.isInsertFail=true;
            this.InsertFailMsg=data.value;
          }
          this.childPage=1;
          this.page=1;
          this.ShowTotal();
        }
      });
    },
    InsertAgain(){
      this.AddDataClick(this.InsertFailMsg);
      this.isInsertFail=false;
    },
    deleteTR(){
      if(this.isCheckedObj==this.addTableData){
        //checked all
        this.addTableData=[];
      }else{
        for(let index=0;index<this.addTableData.length;index++){
          this.isCheckedObj.forEach((checkedValue,checkedIndex)=>{
            if(this.addTableData[index]==checkedValue){
              this.addTableData.splice(index,1);
              index--;
            }
          });
        }
      }
    },
    addTR(){
      if(this.addTableData.length==0){
        this.addTableData.splice(0,0,{channel:'',link:'',language:''});
      }else{
        const len=this.addTableData.length;
        this.addTableData.splice(len-1,0,{channel:this.addTableData[len-1].channel,link:this.addTableData[len-1].link,language:this.addTableData[len-1].language});
      }
    },
    checkIsAllChecked(selection){
      this.isCheckedObj=selection;
    },
    checkIsChecked(selection,row){
      this.isCheckedObj=selection;
    },
    searchClick(){
      if(this.channelValue==''||this.channelValue==undefined||this.channelValue==null){
        alert('请输入channel值');
      }else{
        channelSearchHTTP({sessionid:this.sessionid,channel:encodeURIComponent(this.channelValue)}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.pageAll=1;
            this.page=1;
            this.childPage=1;
            this.data=data;
          }
        })
      }
    },
    changePage(page){
      this.page=page;
      this.ShowTotal();
    },
    AddDataClick(Obj){
      if(Obj instanceof Array){
        this.addTableData=Obj;
      }else{
        this.addTableData=[{channel:'',link:'',language:''},{channel:'',link:'',language:''}]
      }
      this.isAddChannel=true;
    },
    showUpdate(event){
      const e=$(event.target||event.srcElement);
      this.data.forEach((value,index)=>{
        if(value.channel==e.attr("data-channel")){
          this.ChannelLink=value.link;
          this.ChannelLanguage=value.language;
          this.channelName=value.channel;
        }
      });
      this.isUpdate=true;
    },
    confirmUpdate(){
      this.isLoading=true;
      channelUpdateHTTP({sessionid:this.sessionid,channel:encodeURIComponent(this.channelName),link:encodeURIComponent(this.ChannelLink),language:this.ChannelLanguage}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isUpdate=false;
          this.isLoading=false;
          if(data.result=='success'){
            this.ShowTotal();
          }else{
            alert("修改失败");
          }
        }
      });
    },
    ShowTotal(){
      channelDataHTTP({sessionid:this.sessionid,page:this.page}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isHaveData=true;
          this.childPage=this.page;
          this.pageAll=data.pageall;
          this.data=data.value;
        }
      });
    },
    deleteAllClick(){
      channelDeleteAllHTTP({sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.result=='success'){
            this.childPage=this.page;
            this.ShowTotal();
          }else{
            alert("删除失败");
          }
        }
      });
    },
    deleteClick(event){
      const e=$(event.target||event.srcElement);
      channelDeleteHTTP({sessionid:this.sessionid,channel:encodeURIComponent(e.attr('data-channel'))}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.result=='success'){
            this.childPage=this.page;
            this.ShowTotal();
          }else{
            alert("删除失败");
          }
        }
      });
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.ShowTotal();
      }
    });
  }
}
</script>
<style lang='less' scoped>
  @import '../../style/charts/channel.less';
</style>









