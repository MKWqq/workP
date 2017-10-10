<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="buttonContainer">
        <button @click="updateAddClick">添加</button>
        <button @click="ConfirmDeleteClick">删除</button>
        <button @click="updateAddClick">修改</button>
        <button @click="isShowImport=true;">导入Excel</button>
        <a @click="showExportContainer" :href="ExportExcelHref">导出Excel</a>
      </div>
      <div class="searchContainer">
        <input type='text' v-model='searchMsg' placeholder='可以根据采集服务器/频道/唯一标识' />
        <button @click="searchClick">搜索</button>
      </div>
    </div>
    <div class="ContentBottom" v-show="isHaveData">
      <div class="ContentLeft">
        <el-table :data="data" style="width:100%;" @row-click="CellClick" @select='SelectClick' @select-all='SelectClick'>
          <el-table-column type="selection" width='54'></el-table-column>
          <el-table-column label='采集服务器' width='142' prop='ip'></el-table-column>
          <el-table-column label='卫星' width='111' prop='satellite'></el-table-column>
          <el-table-column label='采集卡' width='108' prop='card'></el-table-column>
          <el-table-column label='频点' width='145' prop='frequency'></el-table-column>
          <el-table-column label='频道' width='118' prop='channel'></el-table-column>
          <el-table-column label='采集方式' width='141' prop='collectionWay'></el-table-column>
          <el-table-column label='采集服务器所在地' width='167' prop='decryptionMethod'></el-table-column>
          <el-table-column label='语言' width='131' prop='language'></el-table-column>
          <el-table-column label='唯一标识' width='130' prop='uniqueIdentifier'></el-table-column>
          <el-table-column label='转码方式' width='109' prop='transformMethod'></el-table-column>
          <el-table-column label='转码' width='93' prop='code'></el-table-column>
        </el-table>
      </div>
      <div class="ContentRight">
        <h1>应用监控</h1>
        <div class="detailContent">
          <div class="detailRow">
            <span>采集url:</span>
            <span v-text='detailData.relayUrl'></span>
          </div>
          <div class="detailRow">
            <span>Channel List url:</span>
            <span v-text='detailData.withinURL'></span>
          </div>
          <div class="detailRow">
            <span>中继推流url:</span>
            <span v-text='detailData.acquisitionUrl'></span>
          </div>
        </div>
      </div>
    </div>
    <div class="promptMsg" v-show="isNoData">数据为空</div>
    <SNButton v-show="isHaveData" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
    <button class="showAllData" @click="sendAjax">显示全部数据</button>
    <div class="UpdateAdd" v-show='isShowAdd'>
      <div class="UpdateAddContainer">
        <div class='UpdateAddHeader'>
          <h1 v-text='AddUpdateMsg'></h1>
          <img src='../../assets/img/icon_guanbi.png' @click="cancelAddUpdate" />
        </div>
        <div class='UpdateAddContent'>
          <el-form :model='UpdateAddForm' label-position='center' label-width='164px' :rules='rules' class='UpdateAddForm' ref='UpdateAddForm'>
            <el-form-item label='采集服务器' prop='ip' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.ip' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='卫星' prop='satellite' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.satellite' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='采集卡' prop='card' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.card' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='频点' prop='frequency' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.frequency' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='频道' prop='channel' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.channel' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='语言' prop='language' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.language' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='采集服务器所在地' prop='decryptionMethod' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.decryptionMethod' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='采集方式' prop='collectionWay' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.collectionWay' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='唯一标识' prop='uniqueIdentifier' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.uniqueIdentifier' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='转码方式' prop='transformMethod' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.transformMethod' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='Channel List Url' prop='withinURL' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.withinURL' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='编码' prop='code' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.code' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='采集url' prop='acquisitionUrl' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.acquisitionUrl' class="UpdateAddInput"></el-input>
            </el-form-item>
            <el-form-item label='中继推流url' prop='relayUrl' class="UpdateAddRow">
              <el-input v-model='UpdateAddForm.relayUrl' class="UpdateAddInput"></el-input>
            </el-form-item>
          </el-form>
        </div>
        <div class='UpdateFooter'>
          <button @click="cancelAddUpdate">取消</button>
          <button @click="resetForm">重置</button>
          <button @click="confirmAddUpdate">确定</button>
        </div>
      </div>
    </div>
    <div class="ImportFile" v-show="isShowImport">
      <div class="ImportFileContainer">
        <div class='ImportFileHeader'>
          <h1>导入数据</h1>
          <img src='../../assets/img/icon_guanbi.png' @click="cancelImportFile" />
        </div>
        <div class='ImportFileContent'>
          <form action='http://171.221.202.190:11111/show/server/upload.php' method='post' enctype="multipart/form-data" target="importFile">
            <div class="ImportFormContent">
              <p v-text='importFileName'></p>
              <input type='file' name='file' v-on:change="getImportFileName" />
              <button>选择文件</button>
            </div>
            <div class='ImportFormFooter'>
              <button class='ImportFormButton' @click="cancelImportFile">取消</button>
              <input class="ImportFormButton" @click='submitImportFile' type='submit' />
            </div>
          </form>
          <iframe name="importFile" style="display:none;"></iframe>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import headerButton from '../../components/featureButton'
import {LoginHTTP,AcquisitionDataHTTP,AcquisitionAddHTTP,AcquisitionDeleteHTTP,AcquisitionSearchHTTP} from '../../api/http'
export default{
  data(){
    return {
      sessionid:'',
      data:[],
      selectData:[],
      detailData:{relayUrl:'',withinURL:'',acquisitionUrl:''},
      HTTPType:'all',
      isHaveData:false,
      isNoData:false,
      isShowAdd:false,
      //isShowModify:false,
      isShowImport:false,
      importFileName:'',
      ExportExcelHref:'',
      searchMsg:'',
      pageAll:1,
      page:1,
      AddUpdateMsg:'添加',
      UpdateAddType:'',
      UpdateParams:{},
      AddParams:{},
      UpdateId:'',
      UpdateAddForm:{
        ip:'',card:'',frequency:'',channel:'',collectionWay:'',decryptionMethod:'',
        acquisitionUrl:'',language:'',uniqueIdentifier:'',transformMethod:'',code:'',
        withinURL:'',relayUrl:'',satellite:'',type:''
      },
      rules:{
        ip:[{required:true,message:'请输入相关信息',trigger:'blur'}],card:[{required:true,message:'请输入相关信息',trigger:'blur'}],
        frequency:[{required:true,message:'请输入相关信息',trigger:'blur'}],channel:[{required:false}],
        collectionWay:[{required:false}],decryptionMethod:[{required:true,message:'请输入相关信息',trigger:'blur'}],
        acquisitionUrl:[{required:true,message:'请输入相关信息',trigger:'blur'}],language:[{required:true,message:'请输入相关信息',trigger:'blur'}],
        uniqueIdentifier:[{required:true,message:'请输入相关信息',trigger:'blur'}],transformMethod:[{required:true,message:'请输入相关信息',trigger:'blur'}],
        code:[{required:false}],withinURL:[{required:false}],
        relayUrl:[{required:true,message:'请输入相关信息',trigger:'blur'}],satellite:[{required:true,message:'请输入相关信息',trigger:'blur'}],
      },
      HeaderBtnArray:{HeaderBtnMsg:['添加','删除','修改','导入Excel','导出Excel'],HeaderBtnClick:['AddClick','DeleteClick','ModifyClick','ImportClick','exportExcel']},
    }
  },
  components:{'SNButton':SNButton,'headerButton':headerButton},
  methods:{
    cancelImportFile(){
      this.isShowImport=false;
    },
    getImportFileName(event){
      let e=$(event.target||event.srcElement);
      this.importFileName=this.extractFilename(e.val());
    },
    submitImportFile(){
      if(this.importFileName==''){
        alert('请选择上传文件！');
      }else{
        this.cancelImportFile();
        this.addHandler(window,'message',this.GetImportData);
      }
    },
    GetImportData(e){
      if(JSON.parse(e.data).detail=='success'){
        this.sendAjax();
      }else{
        alert("上传失败！");
      }
    },
    searchClick(){
      this.HTTPType='search';
      this.sendSearchHTTP();
    },
    changePage(Page){
      this.page=Page;
      if(this.HTTPType=='all'){
        this.sendAjax();
      }else{
        this.sendSearchHTTP();
      }
    },
    cancelAddUpdate(){
      this.isShowAdd=false;
      this.resetForm();
    },
    updateAddClick(event){
      let e=$(event.target||event.srcElement);
      this.AddUpdateMsg=e.text();
      if(this.AddUpdateMsg=='添加'){
        this.isShowAdd=true;
        this.UpdateAddForm.type='add';
      }else{
        if(this.selectData.length>1){
          alert('一次只能修改一条数据！');
        }else if(this.selectData.length==0){
          alert('请选择你要修改的数据！');
        }else{
          for(let key in this.UpdateAddForm){
            if(key=='type'){
              this.UpdateAddForm[key]='upload';
            }else{
              this.UpdateAddForm[key]=this.selectData[0][key];
            }
          }
          this.isShowAdd=true;
        }
      }
    },
    resetForm(){
      this.$refs['UpdateAddForm'].resetFields();
    },
    confirmAddUpdate(){
      this.$refs['UpdateAddForm'].validate((valid)=>{
        if(valid){
          if(this.UpdateAddForm.type=='upload'){
            for(let key in this.UpdateAddForm){
              this.UpdateParams[key]=encodeURIComponent(this.UpdateAddForm[key]);
            }
            this.UpdateParams['id']=encodeURIComponent(this.selectData[0]['id']);
            this.sendAddUpdateHTTP(this.UpdateParams);
          }else{
            for(let key in this.UpdateAddForm){
              this.AddParams[key]=encodeURIComponent(this.UpdateAddForm[key]);
            }
            this.sendAddUpdateHTTP(this.AddParams);
          }
        }
      });
    },
    sendAddUpdateHTTP(params){
      this.isShowAdd=false;
      this.resetForm();
      params.sessionid=this.sessionid;
      AcquisitionAddHTTP(params).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.detail=='success'){
            alert(this.AddUpdateMsg+"成功!");
            this.sendAjax();
          }else{
            alert(this.AddUpdateMsg+"失败!");
          }
        }
      });
    },
    ConfirmDeleteClick(){
      if(this.selectData.length==0){
        alert("请选择需要删除的数据！");
      }else{
        let deleteParams='';
        this.selectData.forEach((value,index)=>{
          if(index==0){
            deleteParams=value.id
          }else{
            deleteParams=deleteParams+','+value.id;
          }
        });
        AcquisitionDeleteHTTP({id:deleteParams,sessionid:this.sessionid}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data.detail=='success'){
              this.sendAjax();
            }else{
              alert('删除数据失败');
            }
          }
        });
      }
    },
    showExportContainer(){
      //修改href
    },
    SelectClick(selection){
      this.selectData=selection;
    },
    CellClick(row){
      for(let key in this.detailData){
        this.detailData[key]=row[key];
      }
    },
    sendSearchHTTP(){
      AcquisitionSearchHTTP({page:this.page,val:this.searchMsg,sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          if(data.allcount<=0){
            alert("没有相关信息数据！");
          }else{
            this.pageAll=data.maxpage;
            this.data=data.data;
            this.isHaveData=true;
            //init detail message
            for(let key in this.detailData){
              this.detailData[key]=this.data[0][key];
            }
          }
        }
      });
    },
    sendAjax(){
      this.HTTPType='all';
      AcquisitionDataHTTP({page:this.page,sessionid:this.sessionid}).then(data=>{
        if('loginCheck' in data){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.pageAll=data.maxpage;
          this.page=Number(data.page);
          this.data=data.data;
          this.isHaveData=true;
          //init detail message
          for(let key in this.detailData){
            this.detailData[key]=this.data[0][key];
          }
        }
      });
    },
    extractFilename(path){
      if(path.lastIndexOf('\\')>=0){
        return path.substr(path.lastIndexOf('\\')+1);//windows
      }else if(path.lastIndexOf('/')>=0){
        return path.substr(path.lastIndexOf('/')+1);//Unix
      }else{
        return path;
      }
    },
    addHandler(element,type,handler){
      if(element.addEventListener){
        element.addEventListener(type,handler,false);
      }else if(element.attachEvent){
        element.attachEvent(type,handler);
      }else{
        element['on'+type]=handler;
      }
    },
  },
  created(){
    LoginHTTP().then(data=>{
      if(data.return==false){
        window.location.href='http://113.106.250.156:8000/zabbix/index.php';
      }else{
        this.sessionid=data.return;
        this.ExportExcelHref='http://171.221.202.190:11111/yunwei/index.php/Action/operationApi?apiType=acqu&action=export&sessionid='+this.sessionid;
        this.sendAjax();
      }
    });
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/charts/acquisition.less';
</style>











