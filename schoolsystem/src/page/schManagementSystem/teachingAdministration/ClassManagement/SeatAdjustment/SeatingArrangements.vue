<template>
  <div class="SeatingArrangements">
    <h3>座位安排</h3>
    <el-row style="margin-top: 2rem;border-bottom: 1px solid #d2d2d2">
      <el-col :span="11">
        <el-col :span="18">
          <el-form  style="height: 106px" :inline="true" :model="formInline" class="demo-form-inline">
            <el-form-item label="排序依据：">
              <el-select v-model="formInline.region" placeholder="请选择排序依据">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="性别规则：">
              <el-radio-group v-model="Sexradio">
                <el-radio :label="1">随机</el-radio>
                <el-radio :label="2">男女同桌</el-radio>
                <el-radio :label="3">男女不同桌</el-radio>
              </el-radio-group>
            </el-form-item>
          </el-form>
        </el-col>
        <el-col :span="4" style="border-right: 1px solid #d2d2d2">
            <div class="Seats-title" style="margin-left: -5rem">
              <span>生成<br>座位</span>
            </div>
        </el-col>
      </el-col>
      <el-col :span="11">
        <el-col :span="19" :offset="1">
            <el-col :span="24">
              <el-col :span="12">
                全体下移&nbsp;&nbsp;<el-input-number size="small" v-model="downnum1"></el-input-number>&nbsp;行
              </el-col>
              <el-col :span="12" style="text-align: right;">
                全体右移&nbsp;&nbsp;<el-input-number size="small" v-model="downnum2"></el-input-number>&nbsp;行
              </el-col>
            </el-col>
            <el-col :span="24" style="margin-top:1.8rem">
              <span style="color:#ff6a6a;font-size: 1rem">*</span>&nbsp;&nbsp;&nbsp;
              <span style="color:#888888">负数即为相反方向</span>
            </el-col>
        </el-col>
        <el-col :span="3" :offset="1">
          <div class="Seats-title">
            <span>快速<br>调整</span>
          </div>
        </el-col>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <el-col :span="22">
          <div class="Seats-top">讲台</div>
        </el-col>
        <el-col :span="2" class="alertsBtn Seats-Btn">
          <el-button class="delete" title="打印">
            <img class="delete_unactive"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin.png"
                 alt="">
            <img class="delete_active"
                 src="../../../../../assets/img/schManagementSystem/baseSettings/userManager/teacher/icon_dayin_highlight.png"
                 alt="">
          </el-button>
        </el-col>
      </el-col>
      <el-col :span="24">
        <div class="Seat-content">
          <ul class="Seats-ul Seats-ul-1">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
          <ul class="Seats-ul">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
        </div>
        <div class="Seats-black">过<br>道</div>
        <div class="Seat-content">
          <ul class="Seats-ul Seats-ul-1">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
          <ul class="Seats-ul">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
        </div>
        <div class="Seats-black">过<br>道</div>
        <div class="Seat-content">
          <ul class="Seats-ul Seats-ul-1">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
          <ul class="Seats-ul">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
        </div>
        <div class="Seats-black">过<br>道</div>
        <div class="Seat-content">
          <ul class="Seats-ul Seats-ul-1">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
          <ul class="Seats-ul">
            <li class="Seats-li" v-for="a in 8" @click="SeatsliActive">
              张三
            </li>
          </ul>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
    export default{
        data(){
            return{
              formInline: {
                region: ''
              },
              Sexradio:1,
              downnum1:1,
              downnum2:2,
            }
        },
      methods:{
        SeatsliActive(){

        },
      }
    }
</script>
<style>
  .SeatingArrangements{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Seats-title{
    background: #4da1ff;
    color: #ffffff;
    width: 4.395rem;
    height: 4.395rem;
    text-align: center;
    cursor: pointer;
    border-radius: .45rem;
  }
  .Seats-title>span{
    display: inline-block;
    padding-top: 1rem;
  }
  .SeatingArrangements .el-input__inner{
    height: 35px;
  }
  .Seats-top{
    width:37rem;
    height: 2.5rem;
    background: #d2d2d2;
    margin:2.25rem auto 0 auto;
    border-radius: .5rem;
    line-height: 2.5rem;
    text-align: center;
    font-size: 1rem;
  }
  .Seats-li{
    width: 6.875rem;
    height: 2.5rem;
    border: 1px solid #d2d2d2;
    border-radius: .3rem;
    text-align: center;
    line-height: 2.5rem;
    margin-top: 1rem;
    cursor: pointer;
  }
  .Seats-Btn{
    margin-top: 2.25rem;
    margin-bottom:0;
    text-align: right;
  }
  .Seats-ul{
    display: inline-block;
    margin-left: 1.5rem;
  }
  .Seats-ul-1{
    margin-left: 0;
  }
  .Seats-black{
    text-align: center;
    font-size: 1.5rem;
    color: #999999;
    display: inline-block;
    width: 9.5rem;
    top:-18rem;
    position: relative;
  }
  @media screen and (max-width:1280px) {
    .Seats-black{
      width:7.3rem;
    }
  }
  .Seat-content{
    display: inline-block;
    text-align: center;
    margin-top: 3.5rem;
  }
</style>
