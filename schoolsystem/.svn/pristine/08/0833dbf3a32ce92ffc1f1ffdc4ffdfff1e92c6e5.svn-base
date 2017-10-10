<template>
  <div class="SeatingArrangement">
    <h3>座位布局</h3>
    <el-row style="margin-top: 2rem;height:3.8rem; border-bottom: 1px solid #d2d2d2">
      <el-col :span="24">
        <el-col :span="3">
          <el-col :span="11" style="margin-top:.5rem">
            座位组数：
          </el-col>
          <el-col :span="13">
            <el-input v-model="inputnum" placeholder="请输入内容"></el-input>
          </el-col>
        </el-col>
        <el-col :span="2" style="margin-left:1rem;border-right:1px solid #d2d2d2;">
          <el-col :span="14">
            <div class="Seat-top-btn">生成座位图</div>
          </el-col>
        </el-col>
        <el-col :span="3" style="margin: .5rem -1rem 0 1rem;">
          学生总数：<span>53</span>
        </el-col>
        <el-col :span="2" style="margin-top:.5rem">
          组数：<span>{{inputnum}}</span>
        </el-col>
        <el-col :span="2" style="margin-top:.5rem">
          座位数：<span>53/64</span>
        </el-col>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <div class="Seats-top">讲台</div>
      </el-col>
      <el-col :span="24">
        <div class="Seat-content">
          <div>
            <img class="Seat-btn-jian" src="../../../../../assets/img/ClassManagement/buttton_jian.png" alt="">
            <img class="Seat-btn-jia" src="../../../../../assets/img/ClassManagement/button_jia.png" alt="">
          </div>
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
          <div>
            <img class="Seat-btn-jian" src="../../../../../assets/img/ClassManagement/buttton_jian.png" alt="">
            <img class="Seat-btn-jia" src="../../../../../assets/img/ClassManagement/button_jia.png" alt="">
          </div>
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
          <div>
            <img class="Seat-btn-jian" src="../../../../../assets/img/ClassManagement/buttton_jian.png" alt="">
            <img class="Seat-btn-jia" src="../../../../../assets/img/ClassManagement/button_jia.png" alt="">
          </div>
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
          <div>
            <img class="Seat-btn-jian" src="../../../../../assets/img/ClassManagement/buttton_jian.png" alt="">
            <img class="Seat-btn-jia" src="../../../../../assets/img/ClassManagement/button_jia.png" alt="">
          </div>
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
              inputnum:4,
            }
        },
      methods:{
        SeatsliActive(){

        },
      }
    }
</script>
<style>
  .SeatingArrangement{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Seat-top-btn{
    background: #4da1ff;
    color: white;
    width: 7.20875rem;
    height:2.25rem;
    line-height: 2.25rem;
    text-align: center;
    border-radius: .3rem;cursor: pointer;
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
  .Seats-ul{
    display: inline-block;
    margin-left: 1.5rem;
  }
  .Seats-ul-1{
    margin-left: 0;
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
  .Seats-li:first-child{
    margin-top: 2rem;
  }
  .Seats-black{
    text-align: center;
    font-size: 1.5rem;
    color: #999999;
    display: inline-block;
    width:9.5rem;
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
  .Seat-btn-jian,.Seat-btn-jia{
    cursor: pointer;
  }
  .Seat-btn-jia{
    margin-left: 1.5rem;
  }
</style>
