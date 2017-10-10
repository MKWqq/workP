<template>
  <div class="NewfieldDetails">
    <el-col :span="24">
      <el-button type="primary" @click="returnBack()"
        style="background-color: #FE8687;border-color: #FE8687;border-radius: 1.2rem;padding: .43rem 1.6rem;">
        <img src="../../../../../assets/img/schManagementSystem/teachingAdministration/schoolExam/icon_return.png">
        <span>返回</span>
      </el-button>
    </el-col>
    <el-col :span="24" style="margin-top: 2rem">
      <el-col :span="11">
        <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 标题：</el-col>
        <el-col :span="20">
          <el-input v-model="title"></el-input>
        </el-col>
      </el-col>
      <el-col :span="11" :offset="2">
        <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span>类型：</el-col>
        <el-col :span="20">
          <el-select style="width: 100%" v-model="name" placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1.2rem">
      <el-col :span="11">
        <el-col :span="4" class="newDoc-top-title"> 使用场地：</el-col>
        <el-col :span="20">
          <el-input v-model="title"></el-input>
        </el-col>
      </el-col>
      <el-col :span="11" :offset="2">
        <el-col :span="4" class="newDoc-top-title">详细地址：</el-col>
        <el-col :span="20">
          <el-input v-model="title" placeholder="请输入具体详细地址"></el-input>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1.2rem">
      <el-col :span="6">
        <el-col :span="8" class="newDoc-top-title" style="margin-left: -.6rem"> 使用日期：</el-col>
        <el-col :span="16">
          <el-date-picker
            v-model="selectTime"
            type="datetime"
            placeholder="选择日期时间">
          </el-date-picker>
        </el-col>
      </el-col>
      <el-col :span="14" :offset="1">
        <el-col :span="3" class="newDoc-top-title">使用时间：</el-col>
        <el-col :span="18" :offset="1">
          <el-slider v-model="usetime"></el-slider>
        </el-col>
        <el-col :span="1" :offset="1">
            <span class="NewfieldDetails-add" @click="AdduseTime()">+</span>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1.2rem">
      <el-col :span="11">
        <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 负责人：</el-col>
        <el-col :span="20">
          <el-input v-model="title"></el-input>
        </el-col>
      </el-col>
      <el-col :span="11" :offset="2">
        <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span>联系方式：</el-col>
        <el-col :span="20">
          <el-input v-model="title" placeholder="请输入联系方式"></el-input>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1.2rem">
      <el-col :span="11">
        <el-col :span="4" class="newDoc-top-title"><span style="color:red">*</span> 申请人：</el-col>
        <el-col :span="20">
          <el-input v-model="title"></el-input>
        </el-col>
      </el-col>
      <el-col :span="11" :offset="2">
        <el-col :span="4" class="newDoc-top-title">配置选择：</el-col>
        <el-col :span="20">
          <el-col :span="1" :offset="1">
            <span class="NewfieldDetails-add" @click="Showdialog()">+</span>
          </el-col>
          <el-col :span="21" :offset="1" style="padding-top: .3rem;">
            已选：<span>1111（钢琴）</span>
          </el-col>
        </el-col>
      </el-col>
    </el-col>
    <el-col :span="24" style="margin-top: 1.2rem">
      <el-col :span="2" class="newDoc-top-title" style="margin-left: -.6rem"><span style="color:red">*</span> 说明：</el-col>
      <el-col :span="22">
        <textarea type="text" placeholder="请输入LED电子屏标语或备注内容，没有内容可填写“无”" class="NewfieldDetails-reason"></textarea>
      </el-col>
    </el-col>
    <el-col :span="24"  style="margin: 4rem 0 3rem 0">
      <el-col :span="22" class="Car-footer">
        <el-col>场地申请填表说明：</el-col>
        <el-col>1. 请至少提前12小时上网预约场地准备。如遇急用，请上网预约后致电审批人。</el-col>
        <el-col>2.“场地负责人”一栏请填写您的真实姓名。</el-col>
        <el-col>3. 提交表单前请核实“使用场地”和“使用时间”是否正确，以免造成延误。</el-col>
        <el-col>4. 标红色* 号栏目不可留空，否则无法提交。</el-col>
      </el-col>
      <el-col :span="2">
        <el-button  type="primary" class="Car-btn">发布</el-button>
      </el-col>
    </el-col >
    <el-dialog title="选择配置" :visible.sync="dialogTableVisible" :modal="false">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%">
          <el-table-column
            type="index"
            label="序号"
            width="66">
          </el-table-column>
          <el-table-column
            prop="name"
            label="名称"
            align="center">
          </el-table-column>
          <el-table-column
            prop="opinion"
            label="选项"
            align="center"
            width="500">
            <template  scope="scope">
              <el-radio-group v-model="radiovalue">
                <el-radio :label="index" :key="index" v-for="list,index in radiolists">{{list.val}}</el-radio>
              </el-radio-group>
            </template>
          </el-table-column>
        </el-table>
        <el-col :span="1" :offset="11" style="position: absolute;bottom: 1rem;">
          <el-button type="primary" style="padding:.6rem 2.5rem;border-radius:1.1rem;">确定</el-button>
        </el-col>
      </el-row>
    </el-dialog>

  </div>
</template>
<script>
    export default{
        data(){
            return{
              title:'',
              name:'',
              options:[],
              usetime:0,
              selectTime:new Date(),
              tableData: [
                {name:'1111'},
              ],
              dialogTableVisible: false,
              radiovalue:0,
              radiolists:[{val:'钢琴1'},{val:'钢琴2'},{val:'钢琴3'},{val:'钢琴4'},{val:'钢琴5'}]
            }
        },
      created(){

      },
      methods:{
        AdduseTime(){

        },
        Showdialog(){
            this.dialogTableVisible=true;
        },
        returnBack(){
            this.$router.push("/NewfieldHome")
        },
        formatTooltip(val) {
          return val / 100;
        }
      }
    }
</script>
<style lang="less">
.newDoc-top-title{
  margin-top: 0.5rem;
  text-align: right;
}
  .NewfieldDetails-reason{
    width: 100%;
    padding-top:1rem;
    height: 12rem;
    outline:none;
    border-color: #BFCBD9;
    border-radius: .6rem;
  }
.Car-footer{
  font-size:14/16rem ;
  color: #999999;
  letter-spacing:.1rem;
}
.Car-btn{
  width: 90%;
  margin-top:4rem;
}
  .NewfieldDetails-add{
    border: 1.4px solid #9ACAFD;
    display: inline-block;
    color: #9ACAFD;
    padding: .16rem .53rem;
    cursor: pointer;
    font-weight: bold;
    font-size: 1.1rem;
    border-radius: .1rem;
  }
</style>
