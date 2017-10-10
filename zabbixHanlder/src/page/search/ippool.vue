<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span>选择数据表:</span>
        <div class="selectContainer">
          <select v-model="FormData.fileTable" @focus="isPromptError=false">
            <option label="gslb_gslbipsection" value="gslb_gslbipsection">gslb_gslbipsection</option>
            <option label="gslb_gslbnodeitem" value="gslb_gslbnodeitem">gslb_gslbnodeitem</option>
          </select>
        </div>
      </div>
      <div class="searchButton">
        <el-form>
          <el-form-item>
            <el-button :loading="isLoading" @click="searchClick" class="searchButton">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
      <headerButton :BtnArray="HeaderBtnArray" v-on:add='AddClick' v-on:statistical="StatisticalClick"></headerButton>
    </div>
    <div class="ContentBottom" v-show="isHaveData">
      <table cellspacing="0" cellpadding="0">
        <tr v-if="isSecondChoose">
          <th v-for="tableNav in TableThData.ipSection" v-text="tableNav"></th>
        </tr>
        <tr v-if="!isSecondChoose">
          <th v-for="tableNav in TableThData.nodeItem" v-text="tableNav"></th>
        </tr>
        <tr v-for="(content,index) in data.value">
          <template v-if="isSecondChoose">
            <td v-text="index+1"></td>
            <td v-text="content[TableThData.ipSection[1]]"></td>
            <td v-text="content[TableThData.ipSection[2]]"></td>
            <td v-text="content[TableThData.ipSection[3]]"></td>
            <td v-text="content[TableThData.ipSection[4]]"></td>
            <td v-text="content[TableThData.ipSection[5]]"></td>
            <td v-text="content[TableThData.ipSection[6]]"></td>
          </template>
          <template v-else>
            <td v-text="index+1"></td>
            <td v-text="content[TableThData.nodeItem[1]]"></td>
            <td v-text="content[TableThData.nodeItem[2]]"></td>
            <td v-text="content[TableThData.nodeItem[3]]"></td>
            <td v-text="content[TableThData.nodeItem[4]]"></td>
            <td v-text="content[TableThData.nodeItem[5]]"></td>
            <td v-text="content[TableThData.nodeItem[6]]"></td>
          </template>
          <td>
            <button :data-item="content.id" @click="ModifyClick">修改</button>
            <button :data-item="content.id" @click="DeleteClick">删除</button>
          </td>
        </tr>
      </table>
    </div>
    <div class="promptError" v-show="isPromptError">请填写完整信息！</div>
    <SNButton v-show="isHaveData" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="sendAjax"></SNButton>
    <div class="statistical" v-show="isStatistical">
      <div class="statisticalContainer">
        <div class="statisticalHeader">
          <p @click="changeStatistical">国家<i v-show="statisUnderline[0]"></i></p>
          <p @click="changeStatistical">HICNODEID<i v-show="statisUnderline[1]"></i></p>
          <p @click="changeStatistical">ONMNODEID<i v-show="statisUnderline[2]"></i></p>
          <img src="../../assets/img/icon_guanbi.png" @click="isStatistical=false" />
        </div>
        <div class="statisticalContent">
          <table>
            <tr>
              <th v-text="StatisticalText"></th>
              <th>IP段数量</th>
            </tr>
            <tr v-for="value in StatisticalData">
              <td v-text="value.name"></td>
              <td v-text="value.count"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="ModifyAdd" v-show="isModifyAdd">
      <div class="ModifyAddContainer">
        <div class="ModifyAddHeader">
          <h1 v-text="ModifyAddH1"></h1>
        </div>
        <div class="ModifyAddMain">
          <template v-if="isSecondChoose">
            <div class="ModifyAddRow ipSection" v-for="rowData in ModifyAddHeader.ipSection">
              <span v-text='rowData'></span>
              <input type='text' v-model="ModifyAddForm[rowData]" />
            </div>
          </template>
          <template v-else>
            <div class="ModifyAddRow nodeItem" v-for="rowData in ModifyAddHeader.nodeItem">
              <span v-text='rowData'></span>
              <input type='text' v-model="ModifyAddForm[rowData]" />
            </div>
          </template>
        </div>
        <div class="ModifyAddButton">
          <el-form>
            <el-form-item>
              <el-button @click="cancelModifyAdd">取消</el-button>
              <el-button @click="confirmModifyAdd" :loading="ModifyAddLoad">确定</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import headerButton from '../../components/featureButton'
import {LoginHTTP,ippoolLoginCheckHTTP,ippoolDataHTTP,ippoolnsertHTTP,ippoolUpdateHTTP,ippoolDeleteHTTP,ippoolTotalHTTP} from '../../api/http'
export default{
  data(){
    return {
      sessionid:'',
      data:[],
      StatisticalData:[],
      StatisticalOldData:[],
      HeaderBtnArray:{HeaderBtnMsg:['添加数据','统计'],
        HeaderBtnClick:['add','statistical']
      },
      StatisticalText:"",
      ModifyAddHttp:"",
      isLoading:false,
      isHaveData:false,
      isPromptError:false,
      isHeaderButton:false,
      isSecondChoose:false,
      isModifyAdd:false,
      isStatistical:false,
      statisUnderline:[false,false,false],
      ModifyAddLoad:false,
      FormData:{
        fileTable:"gslb_gslbipsection"
      },
      ModifyAddForm:{
        StartAddr:"",EndAddr:"",NmNodeId:"",OnmNodeId:"",HlcNodeId:"",ip_start:"",ip_end:"",country:"",
        ParentHlcNodeId:"",ParentNmNodeId:"",NmNodeId:"",ParentOnmNodeId:"",HlcNodeId:"",OnmNodeId:"",Mp2pPort:"",Mp2pAddr:""
      },
      ModifyAddH1:"",
      TableThData:{
        ipSection:['序号','id','StartAddr','EndAddr','OnmNodeId','HlcNodeId','country','管理'],
        nodeItem:['序号','id','ParentHlcNodeId','HlcNodeId','ParentOnmNodeId','OnmNodeId','Mp2pAddr','管理']
      },
      ModifyAddHeader:{
        ipSection:['StartAddr','EndAddr','NmNodeId','OnmNodeId','HlcNodeId','ip_start','ip_end','country'],
        nodeItem:['ParentHlcNodeId','ParentNmNodeId','NmNodeId','ParentOnmNodeId','HlcNodeId','OnmNodeId','Mp2pPort','Mp2pAddr']
      },
      pageAll:1,
      page:1
    }
  },
  components:{'SNButton':SNButton,'headerButton':headerButton},
  watch:{
    data(newValue){
      if(this.FormData.fileTable=='gslb_gslbipsection'){
        this.isSecondChoose=true;
        this.HeaderBtnArray={HeaderBtnMsg:['添加数据','统计'],
          HeaderBtnClick:['add','statistical']
        }
      }else if(this.FormData.fileTable=='gslb_gslbnodeitem'){
        this.isSecondChoose=false;
        this.HeaderBtnArray={HeaderBtnMsg:['添加数据'],
          HeaderBtnClick:['add']
        }
      }
    }
  },
  methods:{
    StatisticalClick(){
      ippoolTotalHTTP({sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isStatistical=true;
          if(data!=null && data!=undefined && data!=""){
            this.StatisticalOldData=data;
            this.changeStatisContent($($('.statisticalHeader>p')[0]));
          }else{
            alert("无数据")
          }
        }
      });
    },
    changeStatistical(event){
      const e=$(event.target||event.srcElement);
      this.changeStatisContent(e);
    },
    changeStatisContent(target){
      this.StatisticalText=target.text();
      let statisHeader=$(".statisticalHeader>p");
      for(let i=0;i<statisHeader.length;i++){
        if(target[0]==statisHeader[i]){
          $(statisHeader[i]).css({'color':'#448aca','font-weight':'bold'});
          this.statisUnderline[i]=true;
        }else{
          $(statisHeader[i]).css({'color':'#9d9d9d','font-weight':''});
          this.statisUnderline[i]=false;
        }
      };
      switch(this.StatisticalText){
        case 'HICNODEID':
          this.StatisticalData=this.StatisticalOldData.HlcNodeId;
          break;
        case 'ONMNODEID':
          this.StatisticalData=this.StatisticalOldData.OnmNodeId;
          break;
        default:
          this.StatisticalData=this.StatisticalOldData.country;
          break;
      }
    },
    ModifyClick(event){
      const e=$(event.target || event.srcElement);
      this.isModifyAdd=true;
      this.ModifyAddHttp="ippoolUpdateHTTP",
      this.changeModifyAddH1(e);
      this.checkTable();
      for(let i=0;i<this.data.value.length;i++){
        if(this.data.value[i].id==e.attr("data-item")){
          this.setModifyAdd(this.data.value[i]);
        }
      }
    },
    DeleteClick(event){
      const e=$(event.target || event.srcElement);
      ippoolDeleteHTTP({id:e.attr("data-item"),sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.result=="success"){
            this.sendDataAjax();
          }else{
            alert("删除数据失败，请重试！");
          }
        }
      });
    },
    AddClick(event){
      const e=$(event.target||event.srcElement);
      this.isModifyAdd=true;
      this.ModifyAddHttp="ippoolnsertHTTP",
      this.changeModifyAddH1(e);
      this.checkTable();
    },
    changeModifyAddH1(target){
      this.ModifyAddH1=target.text();
    },
    cancelModifyAdd(){
      this.isModifyAdd=false;
    },
    confirmModifyAdd(){
      this.ModifyAddLoad=true;
      switch(this.ModifyAddHttp){
        case 'ippoolnsertHTTP':
          ippoolnsertHTTP(this.ModifyAddForm).then(data=>{
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              this.ModifyAddLoad=false;
              if(data.result=="success"){
                this.isModifyAdd=false;
                this.sendDataAjax();
              }else{
                alert("添加数据失败，请重试！");
              }
            }
          });
          break;
        case 'ippoolUpdateHTTP':
          ippoolUpdateHTTP(this.ModifyAddForm).then(data=>{
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              this.ModifyAddLoad=false;
              if(data.result=="success"){
                this.isModifyAdd=false;
                this.sendDataAjax();
              }else{
                alert("修改数据失败，请重试！");
              }
            }
          });
          break;
      }
    },
    searchClick(){
      if(this.checkForm()){
        this.loading=true;
        this.sendDataAjax();
      }else{
        this.isPromptError=true;
      }
    },
    sendDataAjax(){
      ippoolDataHTTP({table:this.FormData.fileTable,page:this.page,sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.isHeaderButton=true;
          this.loading=false;
          this.isHaveData=true;
          if(data!="" && data!=null && data!=undefined && data.result!="false"){
            this.pageAll=data.pageall;
            this.data=data;
          }else{
            this.data=[];
            this.pageAll=1;
            alert("no data");
          }
        }
      });
    },
    sendAjax(ThisPage){
      this.page=ThisPage;
      this.sendDataAjax();
    },
    checkTable(){
      if(this.isSecondChoose){
        this.ModifyAddForm={id:"",StartAddr:"",EndAddr:"",NmNodeId:"",OnmNodeId:"",HlcNodeId:"",ip_start:"",ip_end:"",country:"",sessionid:''};
      }else{
        this.ModifyAddForm={id:"",ParentHlcNodeId:"",ParentNmNodeId:"",NmNodeId:"",ParentOnmNodeId:"",HlcNodeId:"",OnmNodeId:"",Mp2pPort:"",Mp2pAddr:"",sessionid:this.sessionid};
      }
    },
    setModifyAdd(oldValue){
      for(let key in this.ModifyAddForm){
        if(key=='sessionid'){
          this.ModifyAddForm.sessionid=this.sessionid;
        }else{
          this.ModifyAddForm[key]=oldValue[key];
        }
      }
    },
    checkForm(){
      if(this.FormData.fileTable==""){
        return false;
      }else{
        return true;
      }
    }
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        ippoolLoginCheckHTTP({sessionid:this.sessionid}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data.result==false){
              this.$router.push('/ippool');
            }
          }
        });
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/search/ippool.less';
</style>







