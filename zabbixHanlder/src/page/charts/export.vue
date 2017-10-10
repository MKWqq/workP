<template>
  <div class="Content" id="myexport"
       v-loading.body="isLoading"
       element-loading-text="拼命加载中...">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span>选择报表:</span>
        <div class="selectContainer">
          <select class="reportType" id="tableType">
            <option label="CDN服务器资源报表" value="1">CDN服务器资源报表</option>
            <option label="各CDN服务器hls连接数据表" value="2">各CDN服务器hls连接数据表</option>
            <option label="各服务器分类数据报表" value="3">各服务器分类数据报表</option>
          </select>
        </div>
      </div>
      <div class="ContentInputRow">
        <div class="block">
          <span class="demonstration">开始时间:</span>
          <el-date-picker class="dateInput" v-model="dateStart" type="date" placeholder="选择日期"
                          :picker-options="pickerOptions_start"></el-date-picker>
        </div>
      </div>
      <div class="ContentInputRow">
        <div class="block">
          <span class="demonstration">结束时间:</span>
          <el-date-picker class="dateInput" v-model="dateEnd" type="date" placeholder="选择日期"
                          :picker-options="pickerOptions_end"></el-date-picker>
        </div>
      </div>
      <div class="searchButton" @click="queryData()">
        <a class="searchButton">查询</a>
      </div>
      <div class="searchButton" @click="exportExcel()" >
        <a :href='searchClickHref' class="exportBtn">导出</a>
      </div>
    </div>
    <div class="contenttext" v-if="dateInSelect.length">
      <div class="contentLeft">
        <div class="leftBtn" :class="{ 'leftBtn-active' : date.isSelect, 'leftBtn': !date.isSelect}"
             @click="toggle(index)" v-for="date,index in dateInSelect">{{date.text}}
        </div>
      </div>
      <div class="contentRight">
        <div class="firstTable" v-if="tableType!=='3'">
          <el-table
            ref="singleTable"
            stripe
            :data="tableData.list.left"
            highlight-current-row
            @current-change="handleCurrentChange"
            style="width: 100%">
            <el-table-column
              v-for="(column,index) in tableData.columns"
              :property="column.property"
              :label="column.label"
              :key="index"
              :width="column.width">
            </el-table-column>
          </el-table>
        </div>
        <div class="firstTable" style="margin-left: 14px"  v-if="tableType!=='3'">
          <el-table
            stripe
            ref="singleTable"
            :data="tableData.list.right"
            highlight-current-row
            @current-change="handleCurrentChange"
            style="width: 100%">
            <el-table-column
              v-for="(column,index) in tableData.columns"
              :property="column.property"
              :label="column.label"
              :key="index"
              :width="column.width">
            </el-table-column>
          </el-table>
        </div>
        <div class="thirdTable"  v-if="tableType==='3'">
          <el-table
            stripe
            ref="singleTable"
            :data="tableData.list"
            highlight-current-row
            @current-change="handleCurrentChange"
            style="width: 100%">
            <el-table-column
              v-for="(column,index) in tableData.columns"
              :property="column.property"
              :label="column.label"
              :key="index"
              :width="column.width">
            </el-table-column>
          </el-table>
        </div>
      </div>
      <div class="barBottom">
        <el-pagination
          :current-page="page"
          @current-change="changePage"
          :page-size="22"
          layout="prev, pager, next, jumper"
          :total="total">
        </el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
  /*export*/
  const ExportHTTP_one=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_cpu_merr.php',type:"post",data:params,dataType:'jsonp'}).then(data=>data)};
   const ExportHTTP_two=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_num_cli.php',type:"get",data:params,dataType:'jsonp'}).then(data=>data)};
   const ExportHTTP_three=params=>{return $.ajax({url:'http://171.221.202.190:11111/phpexcel/export_error.php',type:"get",data:params,dataType:'jsonp'}).then(data=>data)};
  const LoginHTTP=params=>{return $.ajax({url:"http://113.106.250.156:8000/zabbix/sessionid.php",type:"get",dataType:"jsonp",jsonp:"cb"}).then(data=>data)};
  //  import {LoginHTTP, ExportHTTP_one, ExportHTTP_two, ExportHTTP_three, searchCDN} from '../../api/http'
  const searchCDN=params=>$.ajax({url:`http://171.221.202.190:11111/yunwei/index.php/${params.type}/show`,type:"get",data:params,dataType:"jsonp",jsonp:"cb"});

  import $ from 'jquery'

  const oneDay = 24 * 60 * 60 * 1000;
  export default {
    data() {
      let _this = this;
      return {
        originData:{},
        tableType: '1',
        tableData: {
          columns: [],
          list: []
        },
        dateType: '',
        currentRow: null,
        total: 0,//总数
        page: 1,//当前page
        sessionid: '',
        dateInSelect: [],
        isLoading: false,
        searchClickHref: 'javascript:void(0);',
        dateStart: '',
        dateEnd: '',
        pickerOptions_start: {
          disabledDate(time) {
            let timeDistance = 6 * oneDay,
              endTime = Date.parse(_this.dateEnd) - timeDistance;

            if (_this.dateEnd) {
              return time.getTime() < endTime || time.getTime() > Date.parse(_this.dateEnd);
            } else {
              return time.getTime() > Date.now();
            }
          }
        },
        pickerOptions_end: {
          disabledDate(time) {
            let timeDistance = 6 * oneDay,
              startTime = Date.parse(_this.dateStart) + timeDistance;

            if (_this.dateStart) {
              return time.getTime() < Date.parse(_this.dateStart) || time.getTime() > Date.now() || time.getTime() > startTime;
            } else {
              return time.getTime() > Date.now();
            }
          }
        }
      }
    },
    created() {
      LoginHTTP().then(data => {
        if (!data.return) {
          window.location.href = 'http://113.106.250.156:8000/zabbix/index.php';
        } else {
          this.sessionid = data.return;
        }
      });
    },
    methods: {
      handleCurrentChange(val) {
        this.currentRow = val
      },
      toggle(index) {
        this.dateInSelect.forEach((val, idx) => {
          val.isSelect = idx === index;
        });
        this.dateType = this.dateInSelect[index].value;
        this.searchData(1,22,this.dateType)
      },
      queryData(){
        if (this.dateStart === '' || this.dateEnd === '') {
          alert("请选择查询时间！");
          return;
        }

        this.isLoading = true;

        this.tableType = $('#tableType').val();


        let type;

        if (this.tableType === '3') {
          type = 'Errorss';
        } else if (this.tableType === '2') {
          type = 'Numcli';
        } else {
          type = 'Cpumerr';
        }

        this.originData={};
        this.dateInSelect = [];
        this.tableData= {
          columns: [],
          list: []
        };

        if (this.tableType === '3') {
          type = 'Errorss';
          this.dateType = 'total';
          this.dateInSelect.push({
            text: 'TOTAL',
            value: 'total',
            isSelect: true
          });
          setTimeout(()=>{
            this.tableData.columns=[{
              property: 'state',
              label: '状态',
              width: '100'
            },{
              property: '5',
              label: '服务器警报',
              width: '200'
            },{
              property: '4',
              label: '直播频道',
              width: '200'
            },{
              property: '3',
              label: '转码和采集',
              width: '200'
            },{
              property: '2',
              label: 'CDN监控',
              width: '200'
            },{
              property: '1',
              label: '客户端网络',
              width: '200'
            },{
              property: '0',
              label: '其他',
              width: '200'
            }]
          },10)
        } else if (this.tableType === '2') {
          type = 'Numcli';
          this.dateType = 'max';
          this.dateInSelect.push({
            text: 'MAX',
            value: 'max',
            isSelect: true
          });
          setTimeout(()=>{
            this.tableData.columns=[{
              property: 'index',
              label: '序号',
              width: '100'
            },{
              property: 'ip_address',
              label: 'IP',
              width: '200'
            },{
              property: 'avg',
              label: 'HttpMax',
              width: '160'
            },{
              property: 'rudpmax',
              label: 'RudpMax',
              width: '160'
            },{
              property: 'total',
              label: 'Total'
            }]
          },10)
        } else {
          type = 'Cpumerr';
          this.dateType = 'avg';
          this.dateInSelect.push({
            text: '平均',
            value: 'avg',
            isSelect: true
          });
          setTimeout(()=>{
            this.tableData.columns=[{
              property: 'index',
              label: '序号',
              width: '70'
            },{
              property: 'ip_address',
              label: 'IP',
              width: '160'
            },{
              property: 'Disk space usage',
              label: '负载',
              width: '100'
            },{
              property: 'Memory usage',
              label: '磁盘',
              width: '100'
            },{
              property: 'up',
              label: '上行宽带',
              width: '145'
            },{
              property: 'down',
              label: '上行宽带',
              width: '145'
            }]
          },10)
        }

        let timeStart = Date.parse(this.dateStart) + oneDay,
          timeEnd = Date.parse(this.dateEnd) + oneDay;
        for (let i = timeStart; i <= timeEnd; i += oneDay) {
          this.dateInSelect.push({
            text: new Date(i).toJSON().slice(0, 10),
            isSelect: false,
            value: new Date(i).toJSON().slice(0, 10)
          })
        }

        searchCDN({
          type,
          sessionid: this.sessionid,
          start_time: new Date(timeStart).toJSON().slice(0, 10),
          end_time: new Date(timeEnd).toJSON().slice(0, 10)
        }).then(data => {
          for (let key in data) {
            let item = data[key],
              index = 1;
            this.originData[key] = [];
            for (let subKey in item) {
              let subItem = item[subKey];

              if(type==='Errorss'){
                subItem.state = subKey === 'all' ? '总数' : subKey === 'yes' ? '已解决' : '未解决';
              }else{
                subItem.index = index++;
                subItem.ip_address = subKey;
              }
              this.originData[key].push(subItem);
            }
          }

          this.searchData(1,22,this.dateType)
          this.isLoading = false;
        });
      },
      searchData(page,pageSize,dateType){
        if(page!==this.page){
          this.page = page;
        }
        let finalList;
        if(this.tableType==='3'){
          finalList = [];
          finalList = this.originData[dateType];
        }else{
          if(this.tableType==='2'){
            setTimeout(()=>{
              this.tableData.columns=[{
                property: 'index',
                label: '序号',
                width: '100'
              },{
                property: 'ip_address',
                label: 'IP',
                width: '200'
              },{
                property: dateType==='max' ? 'max_avg' : 'avg',
                label: 'HttpMax',
                width: '160'
              },{
                property: dateType==='max' ? 'max_rudpmax' : 'rudpmax',
                label: 'RudpMax',
                width: '160'
              },{
                property: 'total',
                label: 'Total'
              }]
            },10)
          }
          finalList = {
            total:[],
            left:[],
            right:[]
          };
          finalList.total = this.originData[dateType].slice((page-1)*pageSize,page*pageSize);
          finalList.left = finalList.total.slice(0,pageSize/2);
          finalList.right = finalList.total.slice(pageSize/2,pageSize);
        }

        this.tableData.list = finalList;
        this.total = this.originData[dateType].length;
      },
      changePage(page) {
        this.page = page;
        this.searchData(page,22,this.dateType)
      },
      exportExcel() {
        if (this.dateStart === '' || this.dateEnd === '') {
          alert("请选择导出时间！");
        } else {
          let type;
          if (this.tableType === '1') {
            type = 'cpu_merr';
          } else if (this.tableType === '2') {
            type = 'num_cli';
          } else {
            type = 'error';
          }
          this.searchClickHref = `http://171.221.202.190:11111/phpexcel/export_${type}.php?start_time=${this.checkDateFormat(this.dateStart)}&end_time=${this.checkDateFormat(this.dateEnd)}&sessionid=${this.sessionid}`;
        }
      },
      checkDateFormat(dateObj) {
        return dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate();
      }
    }
  }
</script>
<style lang='less' scoped>
  /*@import '../../style/charts/export.less';*/
  .box-sizing(@value){-moz-box-sizing:@value;-ms-box-sizing:@value;-o-box-sizing:@value;-webkit-box-sizing:@value;box-sizing:@value;}
  .box-shadow(@value){-moz-box-shadow:@value;-o-box-shadow:@value;-ms-box-shadow:@value;-webkit-box-shadow:@value;box-shadow:@value;}
  .rotate(@value){-moz-transform:rotate(@value);-ms-transform:rotate(@value);-o-transform:rotate(@value);-webkit-transform:rotate(@value);transform:rotate(@value);}
  .Content{@winWidth:1920px;
    width:100%;height:833px;
    .ContentTop{@inputHeight:28px;
      .box-sizing(border-box);width:(@winWidth)-64px;margin:0 32px;height:66px;border-bottom:1px solid #c9c9c9;
      .ContentInputRow:nth-of-type(1){margin-left:360px;}
      .ContentInputRow{
        height:@inputHeight;margin-left:46px;margin-top:26px;margin-bottom:12px;float:left;
        span{margin-right:12px;font-size:14px;height:@inputHeight;line-height:@inputHeight;color:#4a4a4a;display:inline-block;}
        .dateInput{width:234px;height:26px;border-radius:26/2px;border:1px solid #c2c2c2;}
        input,div.selectContainer{@inputWidth:234px;
          .box-sizing(border-box);width:@inputWidth;height:@inputHeight;text-indent:14px;border:1px solid #c2c2c2;border-radius:(@inputHeight)/2;font-size:14px;color:#4a4a4a;
          &:focus{outline:none;}
        }
        div.selectContainer{@inputWidth:234px;float:right;
          select{width:(@inputWidth)-28px;color:#4a4a4a;font-size:13px;height:@inputHeight;border:none;background:none;
            option{color:#4a4a4a;font-size:13px;border:#b5b5b5;height:40px;line-height:40px;display:inline-block;}
            &:focus{outline:none;}
          }
        }
      }
      .searchButton{float:left;height:@inputHeight;margin:26px 0 12px 32px;width:85px;
        a.searchButton{.box-sizing(border-box);margin:0;border-radius:(@inputHeight)/2;width:100%;height:@inputHeight;line-height:@inputHeight;font-size:14px;color:#fff;text-align:center;background:#448aca;text-decoration:none;border:1px solid transparent;
          &:focus{outline:none;}
          &:hover{cursor:pointer;}
        }
      }
    }
    .ContentBottom{width:(@winWidth)-64px;margin:0 32px 0;.box-sizing(border-box);height:663px;border-bottom:1px solid #c9c9c9;

    }
  }
  .Content .ContentTop {
    height: 88px;
  }

  .Content {
    overflow-x: auto;
    min-width: 1200px;
  }

  .barBottom {
    position: fixed;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
  }

  .Content .ContentBottom {
    border: none;
  }

  .exportBtn {
    height: 28px;
    width: 90px;
    line-height: 28px;
    font-size: 14px;
    text-align: center;
    border-radius: 6px;
    border: 1px solid #c2c2c2;
    float: left;
    margin-left: 150px;
    cursor: pointer;
    color: #464646;
    text-decoration: none;
  }

  .contenttext, .contenttext2, .contenttext3 {
    margin-top: 22px;
  }

  .contentRight {
    float: left;
    min-height: 645px;
  }

  .contentLeft {
    border: 1px solid #bbbbbb;
    width: 120px;
    margin: 0 32px;
    border-radius: 8px;
    overflow: hidden;
    float: left;
  }

  .leftBtn {
    height: 40px;
    border-bottom: 1px solid #bbbbbb;
    font-size: 15px;
    text-align: center;
    line-height: 40px;
    cursor: pointer;
  }

  .leftBtn:last-child {
    border-bottom: none;
  }

  .leftBtn-active {
    background: #ff7988;
    border: none;
    color: white;
  }

  .firstTable {
    width: 838px;
    float: left;
  }

  .thirdTable {
    float: left;
    margin-top: 50px;
    margin-left: 120px;
  }
</style>
