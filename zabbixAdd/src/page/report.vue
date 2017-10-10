<template>
<div>
  <div id="Header">
    <h2>REPORT FORM</h2>
  </div>
  <div id="Main">
    <div id="report">
      <div class="reportHeader">
        <ul>
          <li>公网IP</li>
          <li>局域网IP</li>
          <li>详情</li>
        </ul>
      </div>
      <div class="reportMain">
        <div class="reportMLeft">
          <table class="reportTotal">
            <tr v-for="content in reportTotal">
              <template v-if="content.hostid===HostId">
                <td><span v-text="content.host1" style="color:#03a0aa"></span></td>
                <td v-text="content.host2" style="color:#03a0aa""></td>
                <td class="reportDetail">
                  <button :data-id="content.hostid" @click="showDetailInput" style="color:#03a0aa">查看详情</button>
                </td>
              </template>
              <template v-else>
                <td><span v-text="content.host1" style="color:#4b4b4b;"></span></td>
                <td v-text="content.host2" style="color:#4b4b4b;"></td>
                <td class="reportDetail">
                  <button :data-id="content.hostid" @click="showDetailInput" style="color:#4b4b4b;">查看详情</button>
                </td>
              </template>
            </tr>
          </table>
        </div>
        <div class="reportMRight">
          <div class="line"></div>
          <div class="reportMRMain">
            <div class="serverContain">
              <div class="serverHeader" @click="changeDetail">服务器信息内容
                <img src="../assets/img/zabbix_arrow.png" v-show="isActive.serverActive" />
                <img src="../assets/img/zabbix_arrow_normal.png" v-show="!isActive.serverActive" />
              </div>
              <div class="serverMain" v-show="isActive.serverActive">
                <div v-for="content in serverMain" class="MoreServerMsg">
                  <template v-if="content.detail !==undefined">
                    <div class="serverTitle" v-text="content.title"></div>
                    <div class="serverContent hasBandwidthDetail" @mouseover="bandwidthMouseover" @mouseout="bandwidthMouseout" @click="showBandwidthDetail" v-text="content.content"></div>
                    <div class="bandwidthContainer" :style="{left:bandwidthClientX+'px',top:bandwidthClientY+'px'}" v-show="showBandwidth">
                      <img src="../assets/img/small_icon_guanbi.png" @click="closeBandwidthDetail" />
                      <table class="bandwidthDetail">
                        <tr>
                          <td class="netTh">网卡</td>
                          <td>
                            <tr>
                              <td class="spaceTh"></td>
                              <td class="usedTh">占用带宽</td>
                              <td class="remainingTh">剩余带宽</td>
                              <td class="usedPercentTh">使用率</td>
                              <td class="maxTh">峰值</td>
                            </tr>
                          </td>
                        </tr>
                        <tr v-for="detail in content.detail">
                          <td v-text="detail.name"></td>
                          <td>
                            <tr style="background:#d8eced;">
                              <td>上行带宽(avg)</td>
                              <td v-text="detail.shang.avg"></td>
                              <td v-text="detail.shang.surplus"></td>
                              <td v-text="detail.shang.useRate"></td>
                              <td v-text="detail.shang.max"></td>
                            </tr>
                            <tr>
                              <td>下行带宽(avg)</td>
                              <td v-text="detail.xia.avg"></td>
                              <td v-text="detail.xia.surplus"></td>
                              <td v-text="detail.xia.useRate"></td>
                              <td v-text="detail.xia.max"></td>
                            </tr>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </template>
                  <template v-else>
                    <div class="serverTitle" v-text="content.title"></div>
                    <div class="serverContent" v-text="content.content"></div>
                  </template>
                </div>
                <div class="serverFooter">
                  <button v-text="buttonType" :disabled="notButton" :style="{background:notButton?'#7e7e7e':'#03a0aa'}" @click="AddMsg"></button>
                </div>
              </div>
            </div>
            <div class="businessContain">
              <div class="businessHeader" @click="changeDetail">业务内容处理
                 <img src="../assets/img/zabbix_arrow.png" v-show="isActive.businessActive" />
                 <img class="imgHidden" src="../assets/img/zabbix_arrow_normal.png" v-show="!isActive.businessActive" />
              </div>
              <div class="businessMain" v-show="isActive.businessActive">
                <div v-for="content in businessMain" class="MoreBusinessMsg">
                  <div class="businessTitle" v-text="content.title"></div>
                  <div class="businessContent" v-text="content.content"></div>
                </div>
              </div>
            </div>
            <div class="CDNContain">
              <div class="CDNHeader" @click="changeDetail">CDN配置信息
                 <img src="../assets/img/zabbix_arrow.png" v-show="isActive.CDNActive" />
                 <img class="imgHidden" src="../assets/img/zabbix_arrow_normal.png" v-show="!isActive.CDNActive" />
              </div>
              <div class="CDNMain" v-show="isActive.CDNActive">
                <template v-if="isCDNServer">
                  <div v-for="content in CDNServerData" class="MoreCDNMsg">
                    <div class="CDNTitle" v-text="content.name"></div>
                    <div class="CDNContent" v-text="content.value"></div>
                  </div>
                </template>
                <div class="notCNDServer" v-else>非CDN服务器!</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="BandMsgContainer"  v-show="isModifyIng">
          <div class="BandMsgMain">
            <div class="BandHeader">
              <h2 v-text="buttonType"></h2>
              <img @click="AddMsg" src="../assets/img/big_icon_guanbi.png" />
            </div>
            <div class="BandMain">
              <div class="BandRow">
                <div>Ssh端口</div>
                <div><input v-model="formData.ssh" type="text" /></div>
              </div>
              <div class="BandRow">
                <div>Zabbix端口</div>
                <div><input v-model="formData.zabbix" type="text" /></div>
              </div>
              <div class="BandRow">
                <div>系统类型</div>
                <div><input v-model="formData.system" type="text" /></div>
              </div>
              <div class="BandRow">
                <div>带宽</div>
                <div><input v-model="formData.bandwidth" type="text" /></div>
              </div>
              <div class="BandRow">
                <button class="BandCancel" @click="AddMsg">取消</button>
                <button class="BandSubmit" @click="submitData">确定</button>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
</template>
<script>
  import {LoginHTTP,loadingDataHTTP,serverDataHTTP,buttonTypeHTTP,insertDataHTTP,updateDataHTTP,CDNDataHTTP} from '../api/http'
  import $ from 'jquery'
  export default {
    data(){
      return {
        sessionid:'',
        formData:{
          ssh:"",
          zabbix:"",
          system:"",
          bandwidth:""
        },
        buttonType:"",
        notButton:false,
        normalColor:'#b3b3b3',
        activeColor:'#4a4a4a',
        HostId:"",
        showBandwidth:false,
        bandwidthClientX:"",
        bandwidthClientY:"",
        bandwidthMouseover:"",
        bandwidthMouseout:"",
        isModifyIng:false,
        isCDNServer:true,
        CDNServerData:[],
        isActive:{
          serverActive:false,
          businessActive:false,
          CDNActive:false
        },
        reportTotal:[],
        serverMain:[
          {title:"主机IP",content:""},
          {title:"服务器类型",content:""},
          {title:"负载",content:""},
          {title:"内存",content:""},
          {title:"主机可用时间",content:""},
          {title:"Ssh端口",content:""},
          {title:"Zabbix端口",content:""},
          {title:"系统类型",content:""},
          {title:"带宽(总带宽)",content:"",detail:[]}
        ],
        businessMain:[
          {title:"主机IP",content:""},
          {title:"HttpMax",content:""},
          {title:"RudpMax",content:""},
          {title:"总值",content:""},
          {title:"服务器报警(总数/处理数/未处理数)",content:""}
         ]
      }
    },
    methods:{
      changeDetail(event){
        let e=event.target || event.srcElement;
        if($(e).is('.serverHeader')){
          this.detailActiveCheck('serverActive');
        }else if($(e).is('.businessHeader')){
          this.detailActiveCheck('businessActive');
        }else if($(e).is(".CDNHeader")){
          this.detailActiveCheck('CDNActive');
        }
      },
      detailActiveCheck(value){
        if(this.isActive[value]){
          for(let key in this.isActive){
            this.isActive[key]=false;
          }
        }else{
          for(let key in this.isActive){
            if(key==value){
              this.isActive[key]=true;
            }else{
              this.isActive[key]=false;
            }
          }
        }
      },
      showBandwidthDetail(){
        this.bandwidthMouseout=()=>{};
        this.bandwidthMouseover=()=>{};
        this.showBandwidth=true;
      },
      closeBandwidthDetail(){
        this.showBandwidth=false;
        this.bandwidthMouseover=(event)=>{
          this.showBandwidth=true;
          this.bandwidthClientX=(event || window.event).clientX-$(".bandwidthContainer").css("width").replace(/px/,"");
          this.bandwidthClientY=(event || window.event).clientY-$(".bandwidthContainer").css("height").replace(/px/,"")-30;
        }
        this.bandwidthMouseout=()=>{
          this.showBandwidth=false;
        }
      },
      bandwidthMouseover(event){

      },
      bandwidthMouseout(event){

      },
      AddMsg(){
        this.isModifyIng=!this.isModifyIng;
        this.showBandwidth=false;
        this.bandwidthMouseover=(event)=>{
          this.showBandwidth=true;
          this.bandwidthClientX=(event || window.event).clientX-$(".bandwidthContainer").css("width").replace(/px/,"");
          this.bandwidthClientY=(event || window.event).clientY-$(".bandwidthContainer").css("height").replace(/px/,"")-30;
        }
        this.bandwidthMouseout=()=>{
          this.showBandwidth=false;
        }
      },
      ModifyMsg(){},
      showDetailInput(event){
        this.showBandwidth=false;
        this.bandwidthMouseover=(event)=>{
          this.showBandwidth=true;
          this.bandwidthClientX=(event || window.event).clientX-$(".bandwidthContainer").css("width").replace(/px/,"");
          this.bandwidthClientY=(event || window.event).clientY-$(".bandwidthContainer").css("height").replace(/px/,"")-30;
        }
        this.bandwidthMouseout=()=>{
          this.showBandwidth=false;
        }
        this.HostId=$(event.target || event.srcElement).attr("data-id");
        this.judgeButtonType();
        this.notButton=true;
        this.getDetailData();
      },
      getDetailData(){
        serverDataHTTP({sessionid:this.sessionid,type:"serverInformation",hostid:this.HostId}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.notButton=false;
            this.serverMain[0].content=data.serverHost;
            this.serverMain[1].content=data.serverType;
            this.serverMain[2].content=data.cupLoad;
            this.serverMain[3].content=data.usageMemory+"、"+data.totalMemory;
            this.serverMain[4].content=data.server_use;
            this.serverMain[5].content=data.sshPort;
            this.serverMain[6].content=data.zabbixPort;
            this.serverMain[7].content=data.systemType;
            this.serverMain[8].content=data.totalBroadband;
            this.serverMain[8].detail=data.networkCard;
            this.formData.ssh=data.sshPort;
            this.formData.zabbix=data.zabbixPort;
            this.formData.system=data.systemType;
            this.formData.bandwidth=data.totalBroadband;
          }
        });
        serverDataHTTP({sessionid:this.sessionid,type:"business",hostid:this.HostId}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            this.businessMain[0].content=data.serverHost;
            this.businessMain[1].content=data.httpMax;
            this.businessMain[2].content=data.rudpMax;
            this.businessMain[3].content=data.all;
            this.businessMain[4].content=data.errorAll+"/"+data.errorYes+"/"+data.errorNo;
          }
        });
        CDNDataHTTP({sessionid:this.sessionid,hostid:this.HostId}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data==null){
              this.isCDNServer=false;
            }else{
              this.isCDNServer=true;
              this.CDNServerData=data;
            }
          }
        });
      },
      judgeButtonType(){
        buttonTypeHTTP({sessionid:this.sessionid,hostid:this.HostId}).then(data=>{
          if('loginCheck' in data){
            window.location.href='http://113.106.250.156:8000/zabbix/index.php';
          }else{
            if(data===null){
              this.buttonType="添加";
            }else{
              this.buttonType="修改";
            }
          }
        });
      },
      submitData(){
        if(this.buttonType==="添加"){
          insertDataHTTP({sessionid:this.sessionid,hostid:this.HostId,ssh:this.formData.ssh,zabbix:this.formData.zabbix,system:this.formData.system,bandwidth:this.formData.bandwidth}).then(data => {
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              if(data){
                this.judgeButtonType();
                this.notButton=true;
                this.getDetailData();
                this.isModifyIng=false;
              }else{
                alert("插入数据失败");
              }
            }
          });
        }else{
          updateDataHTTP({sessionid:this.sessionid,hostid:this.HostId,ssh:this.formData.ssh,zabbix:this.formData.zabbix,system:this.formData.system,bandwidth:this.formData.bandwidth}).then(data => {
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              if(data){
                this.judgeButtonType();
                this.notButton=false;
                this.getDetailData();
                this.isModifyIng=false;
              }else{
                alert("修改数据失败");
              }
            }
          });
        }
      }
    },
    beforeCreate(){
    },
    created(){
      LoginHTTP().then(data=>{
        if(data.return==false){
          window.location.href='http://113.106.250.156:8000/zabbix/index.php';
        }else{
          this.sessionid=data.return;
          loadingDataHTTP({sessionid:this.sessionid}).then(data => {
            if('loginCheck' in data){
              window.location.href='http://113.106.250.156:8000/zabbix/index.php';
            }else{
              this.HostId=data[0].hostid;
              this.judgeButtonType();
              this.notButton=true;
              this.getDetailData();
              this.reportTotal=data;
            }
          });
          //$(".reportMLeft").mCustomScrollbar();
        }
      });
      this.bandwidthMouseover=(event)=>{
        this.showBandwidth=true;
        this.bandwidthClientX=(event || window.event).clientX-$(".bandwidthContainer").css("width").replace(/px/,"");
        this.bandwidthClientY=(event || window.event).clientY-$(".bandwidthContainer").css("height").replace(/px/,"")-30;
      }
      this.bandwidthMouseout=()=>{
        this.showBandwidth=false;
      }
    }
  }
</script>
<style lang="less" scoped>
  @import "../style/report.less";
</style>



