<template>
    <div class="startDesign">
      <el-row type="flex" align="middle">
        <el-col :span="12">
          <h3>开始设计</h3>
        </el-col>
        <el-col :span="12" class="custom">
          <el-button type="primary" icon="plus" @click="createSize">自定义尺寸创建</el-button>
        </el-col>
      </el-row>
      <el-row class="printCenter_row">
        <el-row>
          <span class="exam_subTitle">常用尺寸</span>
        </el-row>
        <el-row class="printCenter_row_sec">
          <div class="direction">
            <span class="horizontal" :class="{'active':layout=='horizontal'}" @click="changeLayout('horizontal','layout')">竖向</span>
            <span class="vertical" :class="{'active':layout=='vertical'}" @click="changeLayout('vertical','layout')">横向</span>
          </div>
        </el-row>
        <el-row v-show="layout=='horizontal'">
          <span class="sizeList" @click="changeLayout('A4','laySize')">A4 (210*297mm)</span>
          <span class="sizeList" @click="changeLayout('A3','laySize')">A3 (297*420mm)</span>
          <span class="sizeList" @click="changeLayout('B4','laySize')">B4 (257*364mm)</span>
          <span class="sizeList" @click="changeLayout('B5','laySize')">B5 (176*250mm)</span>
          <span class="sizeList" @click="changeLayout('8K','laySize')">8K (260*368mm)</span>
          <span class="sizeList" @click="changeLayout('16K','laySize')">16K (184*286mm)</span>
        </el-row>
        <el-row v-show="layout=='vertical'">
          <span class="sizeList" @click="changeLayout('A4','laySize')">A4 (297*210mm)</span>
          <span class="sizeList" @click="changeLayout('A3','laySize')">A3 (420*297mm)</span>
          <span class="sizeList" @click="changeLayout('B4','laySize')">B4 (364*257mm)</span>
          <span class="sizeList" @click="changeLayout('B5','laySize')">B5 (250*176mm)</span>
          <span class="sizeList" @click="changeLayout('8K','laySize')">8K (368*260mm)</span>
          <span class="sizeList" @click="changeLayout('16K','laySize')">16K (286*184mm)</span>
        </el-row>
      </el-row>
      <el-row class="printCenter_row">
        <el-row>
          <span class="exam_subTitle">模板中心</span>
        </el-row>
        <el-row class="printCenter_row_sec">
          <el-row>
            <div class="g-fuzzyInput">
              <el-input
                placeholder=""
                icon="search"
                v-model="searchValue"
                :on-icon-click="goSearch">
              </el-input>
            </div>
          </el-row>
          <el-row class="d_line printCenter_row_thd"></el-row>
          <el-row class="printCenter_row_thd layTypeAll">
            <span>类型：</span>
            <span class="layType" :class="{'active':layType=='all'}" @click="changeLayout('all','layType')">全部</span>
            <span class="layType" :class="{'active':layType=='certificate'}" @click="changeLayout('certificate','layType')">奖状</span>
            <span class="layType" :class="{'active':layType=='studentCard'}" @click="changeLayout('studentCard','layType')">学生证</span>
            <span class="layType" :class="{'active':layType=='ticket'}" @click="changeLayout('ticket','layType')">准考证</span>
            <span class="layType" :class="{'active':layType=='cert'}" @click="changeLayout('cert','layType')">证书</span>
            <span class="layType" :class="{'active':layType=='other'}" @click="changeLayout('other','layType')">其他</span>
          </el-row>
          <el-row class="printCenter_row_thd layTypeAll">
            <span>尺寸：</span>
            <span class="layType" :class="{'active':layAllSize=='A4'}" @click="changeLayout('A4','layAllSize')">A4</span>
            <span class="layType" :class="{'active':layAllSize=='A3'}" @click="changeLayout('A3','layAllSize')">A3</span>
            <span class="layType" :class="{'active':layAllSize=='B5'}" @click="changeLayout('B5','layAllSize')">B5</span>
            <span class="layType" :class="{'active':layAllSize=='B6'}" @click="changeLayout('B6','layAllSize')">B6</span>
            <span class="layType" :class="{'active':layAllSize=='8K'}" @click="changeLayout('8K','layAllSize')">8K</span>
            <span class="layType" :class="{'active':layAllSize=='16K'}" @click="changeLayout('16K','layAllSize')">16K</span>
            <span class="layType" :class="{'active':layAllSize=='other'}" @click="changeLayout('other','layAllSize')">其他</span>
          </el-row>
          <el-row class="printCenter_row_sec layTypeAll">
            <div class="templateList">
              <div class="templateList_bg">
                <img
                  src="../../../../../assets/img/schManagementSystem/teachingAdministration/educationalAdministration/templateBg.png"
                  alt="">
                <span>采用次数：122次</span>
                <div class="maskLayer">
                  <div>
                    <span>采用</span>
                    <span>套打</span>
                  </div>
                </div>
              </div>
              <div class="templateList_txt">
                <p>学生成绩单</p>
                <p>类型：其他</p>
                <p>尺寸：A4(767×1089px)</p>
              </div>
            </div>
            <div class="templateList">
              <div class="templateList_bg">
                <img
                  src="../../../../../assets/img/schManagementSystem/teachingAdministration/educationalAdministration/templateBg.png"
                  alt="">
                <span>采用次数：122次</span>
                <div class="maskLayer">
                  <div>
                    <span>采用</span>
                    <span>套打</span>
                  </div>
                </div>
              </div>
              <div class="templateList_txt">
                <p>学生成绩单</p>
                <p>类型：其他</p>
                <p>尺寸：A4(767×1089px)</p>
              </div>
            </div>
          </el-row>
        </el-row>
      </el-row>
      <el-dialog
        title="自定义尺寸创建"
        :visible.sync="dialogVisible"
        :modal="false"
        :before-close="handleClose">
        <el-row>
          <el-form :inline="true" :model="form">
            <el-form-item>
              <el-input v-model="form.width" placeholder="1" class="wth"></el-input>
            </el-form-item>
            <el-form-item>
              <span>×</span>
            </el-form-item>
            <el-form-item>
              <el-input v-model="form.height" placeholder="1" class="hgt"></el-input>
            </el-form-item>
            <el-form-item>
              <el-select v-model="form.unit" placeholder="单位" class="unit">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
          <p class="tip">
            备注：比例为1mm=3.667px,例如A4(297*210mm)转为像素为(1089*767.574px)
          </p>
        </el-row>
        <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="save()">创建</el-button>
        <el-button @click="dialogVisible = false">取消</el-button>
      </span>
      </el-dialog>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              layout:'horizontal',
              laySize:'A4',
              layType:'all',
              layAllSize:'A4',
              searchValue:'',
              dialogVisible: false,
              form:{
                  width:'',
                height:'',
                unit:''
              }
            }
        },
        methods: {
          changeLayout(type,i){
            this[i]=type;
          },
          goSearch(ev) {  //查询
            console.log(ev);
          },
          handleClose(done) {
            done();
          },
          createSize(){
            this.dialogVisible = true;
          },
          save(){
            this.dialogVisible = false;
          }
        }
    }
</script>
<style>
  .startDesign .custom{
    text-align: right;
  }
  .startDesign .custom .el-button{
    border-radius: 20px;
    padding:.6rem 1.5rem;
  }
.startDesign .direction{
  font-size:0;
}
  .startDesign .horizontal{
    display: inline-block;
    padding:.5rem 1.75rem;
    border-radius: 20px 0 0 20px;
    font-size:.875rem;
    border-left:1px solid #d2d2d2;
    border-top:1px solid #d2d2d2;
    border-bottom:1px solid #d2d2d2;
    cursor: pointer;
  }
.startDesign .vertical{
  display: inline-block;
  padding:.5rem 1.75rem;
  border-radius: 0 20px 20px 0;
  font-size:.875rem;
  border: 1px solid #d2d2d2;
  cursor: pointer;
}
.startDesign .horizontal.active,.startDesign .vertical.active{
  background-color: #09baa7;
  color: #fff;
}
  .startDesign .sizeList{
    display: inline-block;
    width:11.25rem;
    border: 1px solid #09baa7;
    color: #09baa7;
    text-align: center;
    padding:1.25rem 0;
    cursor: pointer;
  }
.startDesign .sizeList:hover{
  background-color: #09baa7;
  color: #fff;
  -webkit-box-shadow: 0 0 10px 1px #d2d2d2;
  -moz-box-shadow: 0 0 10px 1px #d2d2d2;
  box-shadow: 0 0 10px 1px #d2d2d2;
}
.startDesign .sizeList+.sizeList{
  margin-left:2.5rem;
}
  .startDesign .layType{
    padding:0 1.5rem;
    cursor: pointer;
  }
.startDesign .layType.active{
  color: #09baa7;
}

  .startDesign .el-dialog--small {
    width: 600px;
  }
  .startDesign .hgt,.startDesign .wth,.startDesign .unit{
    width:160px;
  }
  .startDesign .tip{
    text-align: center;
    color: #888888;
  }
</style>
