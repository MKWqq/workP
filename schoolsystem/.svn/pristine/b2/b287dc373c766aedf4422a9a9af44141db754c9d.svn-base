<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
        <img src="../../../assets/img/commonImg/icon_return.png" />
        返回
      </el-button>
      <span class="selfCenter" v-text="headerText[id]"></span>
    </header>
    <section>
      <el-form class="g-form_twoColumn" :model="dataForm" label-width="120px">
        <div class="g-form-row g-liOneRow">
          <el-form-item label="姓名:" required>
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="性别:">
            <el-radio-group>
              <el-radio label="女" value="0"></el-radio>
              <el-radio label="男" value="1"></el-radio>
            </el-radio-group>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item label="准考证号:" required>
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="出生日期:">
            <el-date-picker type="date"></el-date-picker>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item label="中学学校:">
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="联系方式:">
            <el-input></el-input>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item label="签约承诺:">
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="家庭地址:">
            <el-cascader placeholder="请选择省/市/县、区" :options="options2" :props="city_prop" @change="getCity_one"></el-cascader>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item label="户口所在地:">
            <el-cascader placeholder="请选择省/市/县、区" :options="options2" :props="city_prop" @change="getCity_one"></el-cascader>
          </el-form-item>
          <el-form-item>
            <el-input placeholder="家庭详细地址"></el-input>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item label="邮政编码:">
            <el-input></el-input>
          </el-form-item>
          <el-form-item label="现住地址:">
            <el-cascader placeholder="请选择省/市/县、区" :options="options2" :props="city_prop" @change="getCity_one"></el-cascader>
          </el-form-item>
        </div>
        <div class="g-form-row g-liOneRow">
          <el-form-item></el-form-item>
          <el-form-item>
            <el-input placeholder="现住详细地址"></el-input>
          </el-form-item>
        </div>
      </el-form>
      <div class="g-footer">
        <el-button type="primary" class="largeButton">保存</el-button>
      </div>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  export default{
    data(){
      return{
        /*form表单*/
        dataForm:{},
        /*确定是添加还是修改操作*/
        headerText:['添加签约生','编辑签约生信息'],
        /*路由参数*/
        id:'',
        /*地区选择*/
        options2: [
          {
            value: 'zhinan',
            label: '指南',
            children: [{
              value: 'shejiyuanze',
              label: '设计原则',
              children: [{
                value: 'yizhi',
                label: '一致'
              }, {
                value: 'fankui',
                label: '反馈'
              }, {
                value: 'xiaolv',
                label: '效率'
              }, {
                value: 'kekong',
                label: '可控'
              }]
            }]
          }
        ],
        city_prop:{
          label:'label',
          children:'children'
        },
        /*        startTimePOptions:{
         disabledDate(time){
         return time.getTime()<Date.now()-8.64e7;
         }
         },*/
      }
    },
    methods:{
      goBackParent(){
        this.$router.push('/SignUpStudentManagement');
      },
      getCity_one(city){
        console.log('选中的城市：'+city);
      },
    },
    created(){
      this.id=this.$route.params.id;
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../style/style';
  .g-container{
    header.g-textHeader{border:none;padding-bottom:70/16rem;
      span{.fontSize(19);color:@HColor;.marginLeft(40,1582);}
    }
    section{/*1105*/
      .width(1105,1582);margin:0 auto;
    }
    .g-footer{width:100%;}
  }
</style>




