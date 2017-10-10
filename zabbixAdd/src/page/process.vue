<template>
  <div>
    <div id="Header">
      <h2>FEEDBACK PROCESS</h2>
      <button class="addButton" @click="addProblemMsg">添加</button>
    </div>
    <div id="Main">
      <div id="process">
        <div class="processHeader">
          <ul>
            <li>主机</li>
            <li>提交时间</li>
            <li>提交人</li>
            <li>问题描述</li>
            <li>处理人</li>
            <li>处理说明</li>
            <li>处理时间</li>
            <li class="showChildNav" @click="showNav">处理状态</li>
            <div v-show="childNavActive" class="childNavTotal">
              <template v-if="showChildNav.totalNav">
                <div style="background:#636363;color:#fff;" @click="totalMsg">全部</div>
                <div @click="handledMsg">已处理</div>
                <div @click="unhandledMsg">未处理</div>
              </template>
              <template v-if="showChildNav.handledNav">
                <div @click="totalMsg">全部</div>
                <div style="background:#636363;color:#fff" @click="handledMsg">已处理</div>
                <div @click="unhandledMsg">未处理</div>
              </template>
              <template v-if="showChildNav.unhandledNav">
                <div @click="totalMsg">全部</div>
                <div @click="handledMsg">已处理</div>
                <div style="background:#636363;color:#fff" @click="unhandledMsg">未处理</div>
              </template>
            </div>
          </ul>
        </div>
        <div class="processMain">
          <table>
            <tr v-for="findData in data">
              <td v-text="findData.host"></td>
              <td v-text="findData.time1"></td>
              <td v-text="findData.committer"></td>
              <td v-text="findData.describe1"></td>
              <td v-text="findData.handler"></td>
              <td v-text="findData.describe2"></td>
              <td v-text="findData.time2"></td>
              <td v-if="findData.state==='1'" class="handled" :data-index="findData.id">已处理</td>
              <td v-if="findData.state==='0'" class="unHandled"><button :data-index="findData.id" @click="handleProblem">点击处理</button></td>
            </tr>
          </table>
          <div v-show="addMsg" class="addPart">
            <div class="addcontainer">
              <div class="addHeader">
                <h2>添加问题</h2>
                <img src="../assets/img/big_icon_guanbi.png" @click="addProblemMsg" />
              </div>
              <div class="addMain">
                <div class="addRow">
                  <span>主机</span>
                  <input type="text" class="hostInput" @focus="getHostFocus" @blur="checkHostMsg" :style="{borderColor:addSpace.isHostSpace?'red':'#a5a5a5'}" v-model="addForm.host" />
                  <span class="supplyMsg" v-show="addSpace.isHostSpace">此处必填</span>
                </div>
                <div class="addRow">
                  <span>提交人</span>
                  <input type="text" class="submitPersonInput" @focus="getSubmitFocus" @blur="checkSubmitMsg" v-model="addForm.submitPerson" :style="{borderColor:addSpace.isSubmitSpace?'red':'#a5a5a5'}" />
                  <span class="supplyMsg" v-show="addSpace.isSubmitSpace">此处必填</span>
                </div>
                <div class="addRow textarea">
                  <span>问题描述</span>
                  <textarea class="problemInput" @focus="getProblemFocus" @blur="checkProblemMsg" v-model="addForm.problemMsg" :style="{borderColor:addSpace.isProblemSpace?'red':'#a5a5a5'}"></textarea>
                  <span class="supplyMsg" v-show="addSpace.isProblemSpace">此处必填</span>
                </div>
                <div class="addRow">
                  <button @click="addProblemMsg">取消</button>
                  <button @click="submitAddProblem">确定</button>
                </div>
              </div>
            </div>
          </div>
          <div v-show="handleMsg" class="handlePart">
            <div class="handlecontainer">
              <div class="handleHeader">
                <h2>问题处理</h2>
                <img src="../assets/img/big_icon_guanbi.png" @click="handleProblem" />
              </div>
              <div class="handleMain">
                <div class="handleRow">
                  <span>提交人</span>
                  <input type="text" class="submitPersonInput" @focus="getHandleFocus" @blur="checkHandleMsg" v-model="handleForm.handlePerson" :style="{borderColor:handleSpace.isHandleSpace?'red':'#a5a5a5'}" />
                  <span class="supplyMsg" v-show="handleSpace.isHandleSpace">此处必填</span>
                </div>
                <div class="handleRow textarea">
                  <span>问题描述</span>
                  <textarea class="problemInput" @focus="getDescribeFocus" @blur="checkDescribeMsg" v-model="handleForm.describeProblem" :style="{borderColor:handleSpace.isDescribeSpace?'red':'#a5a5a5'}"></textarea>
                  <span class="supplyMsg" v-show="handleSpace.isDescribeSpace">此处必填</span>
                </div>
                <div class="handleRow">
                  <button @click="handleProblem">取消</button>
                  <button @click="submitHandleProblem">确定</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {checkedHTTP,problemFindHTTP,addProblemHTTP,updateProblemHTTP} from '../api/http'
import $ from 'jquery'
export default{
  data(){
    return {
      data:"",
      idMsg:"",
      totalData:[],
      handledData:[],
      unhandledData:[],
      childNavActive:false,
      addMsg:false,
      addSpace:{
        isHostSpace:false,
        isSubmitSpace:false,
        isProblemSpace:false,
      },
      handleSpace:{
        isHandleSpace:false,
        isDescribeSpace:false
      },
      handleMsg:false,
      showChildNav:{
        totalNav:true,
        handledNav:false,
        unhandledNav:false
      },
      addForm:{
        host:"",
        submitPerson:"",
        problemMsg:""
      },
      handleForm:{
        handlePerson:"",
        describeProblem:""
      }
    }
  },
  methods:{
    showNav(event){
      this.childNavActive=!this.childNavActive;
    },
    totalMsg(){
      this.data=this.totalData;
      this.showChildNav={totalNav:true,handledNav:false,unhandledNav:false};
      this.childNavActive=!this.childNavActive;
    },
    handledMsg(){
      this.data=this.handledData;
      this.showChildNav={totalNav:false,handledNav:true,unhandledNav:false};
      this.childNavActive=!this.childNavActive;
    },
    unhandledMsg(){
      this.data=this.unhandledData;
      this.showChildNav={totalNav:false,handledNav:false,unhandledNav:true};
      this.childNavActive=!this.childNavActive;
    },
    checkSubmitMsg(){
      if(this.addForm.submitPerson==='' || this.addForm.submitPerson===undefined){
        this.addSpace.isSubmitSpace=true;
      }else{
        this.addSpace.isSubmitSpace=false;
      }
    },
    checkProblemMsg(event){
      if(this.addForm.problemMsg==='' || this.addForm.problemMsg===undefined){
        this.addSpace.isProblemSpace=true;
      }else{
        this.addSpace.isProblemSpace=false;
      }
    },
    checkHostMsg(event){
      if(this.addForm.host==='' || this.addForm.host===undefined){
        this.addSpace.isHostSpace=true;
      }else{
        this.addSpaceisHostSpace=false;
      }
    },
    getHostFocus(){this.addSpace.isHostSpace=false;},
    getSubmitFocus(){this.addSpace.isSubmitSpace=false;},
    getProblemFocus(){this.addSpace.isProblemSpace=false;},
    checkHandleMsg(){
      if(this.handleForm.handlePerson==='' || this.handleForm.handlePerson===undefined){
        this.handleSpace.isHandleSpace=true;
      }else{
        this.handleSpace.isHandleSpace=false;
      }
    },
    checkDescribeMsg(){
      if(this.handleForm.describeProblem==='' || this.handleForm.describeProblem===undefined){
        this.handleSpace.isDescribeSpace=true;
      }else{
        this.handleSpace.isDescribeSpace=false;
      }
    },
    getHandleFocus(){this.handleSpace.isHandleSpace=false;},
    getDescribeFocus(){this.handleSpace.isDescribeSpace=false;},
    addProblemMsg(){
      this.addMsg=!this.addMsg;
      this.addForm={host:"",submitPerson:"",problemMsg:""};
      this.addSpace={isHostSpace:false,isSubmitSpace:false,isProblemSpace:false};
    },
    submitAddProblem(){
      this.checkSubmitMsg();this.checkHostMsg();this.checkProblemMsg();
      if(!this.addSpace.isHostSpace && !this.addSpace.isSubmitSpace && !this.addSpace.isProblemSpace){
        addProblemHTTP({host:encodeURIComponent(this.addForm.host),committer:encodeURIComponent(this.addForm.submitPerson),describe1:encodeURIComponent(this.addForm.problemMsg)}).then(data=>{
          if(data){
            this.addMsg=!this.addMsg;
            problemFindHTTP().then(data=>{this.dataHandle(data);this.data=this.totalData;});
          }else{
            this.addMsg=!this.addMsg;
            alert("添加失败");
          }
        });
      }
    },
    handleProblem(event){
      this.handleMsg=!this.handleMsg;
      this.handleForm={handlePerson:"",describeProblem:""};
      this.handleSpace={isHandleSpace:false,isDescribeSpace:false};
      if($(event.target||event.srcElement).attr("data-index")!=""&&$(event.target||event.srcElement).attr("data-index")!=undefined&&$(event.target||event.srcElement).attr("data-index")!=null){
        this.idMsg=$(event.target||event.srcElement).attr("data-index");
      }
    },
    submitHandleProblem(){
      this.checkHandleMsg();this.checkDescribeMsg();
      if(this.handleForm.handlePerson!=""&&this.handleForm.describeProblem!=""){
        updateProblemHTTP({id:this.idMsg,handler:encodeURIComponent(this.handleForm.handlePerson),describe2:encodeURIComponent(this.handleForm.describeProblem)}).then(data=>{
            if(data){
              this.handleMsg=!this.handleMsg;
              problemFindHTTP().then(data=>{this.dataHandle(data);this.data=this.totalData;});
            }else{
              this.handleMsg=!this.handleMsg;
              alert("添加失败");
            }
        });
      }
    },
    dataHandle(data){
      this.totalData=data;
      for(let i=0;i<data.length;i++){
        if(data[i].state==='1'){
          this.handledData.push(data[i]);
        }else{
          this.unhandledData.push(data[i]);
        }
      }
    }
  },
  beforeCreate(){
        checkedHTTP().then(data => {
          if(data.return=="false"){
            window.location.href="http://113.106.250.156:8000/zabbix/index.php";
          }
        })
      },
  created(){
    problemFindHTTP().then(data => {
      this.dataHandle(data)
      this.data=this.totalData;
  });
  }
}
</script>
<style lang="less" scoped>
  @import "../style/process.less";
</style>






