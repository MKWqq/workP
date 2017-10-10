<template>
  <div class="g-evaluationGroup g-container">
    <header class="g-evaluationGroupHeader">
      <el-button class="g-gobackChart g-imgContainer RedButton" @click="goBackChart">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回流程图
      </el-button>
      <el-button @click="addGroupClick" class="g-imgContainer blueButton">
        <img class="" src="../../../../assets/img/commonImg/icon_add_01.png" />
        新建被评分组
      </el-button>
      <el-button @click="saveAjaxClick" class="blueButton">保存</el-button>
    </header>
    <section class="g-sectionMargin">
      <div class="g-eg_part">
        <div class="g-eg_part_left">
          <el-form ref="egGroupForm" :model="egGroupForm" :rules="groupRules" label-width="138px" label-position="left">
            <el-row class="hasBorderBottom" v-for="(row,rowIndex) in egGroupForm.formData" :key="rowIndex">
              <div class="g-liOneRow_space">
                <div class="g-eg-item">
                  <el-form-item label="被考评人分组名称:" required prop="name">
                    <el-input placeholder="请输入分组名称" class="g-eg-groupName" v-model="row.name"></el-input>
                  </el-form-item>
                  <el-form-item class="g-hasMoreInput" required label="各组评委权重:">
                    <div class="g-eg-column" v-for="(col,colIndex) in row.judgeWeight">
                      <span v-text="col.name"></span>
                      <el-input v-model="col.value" class="defineInputWidth"></el-input>
                      <span>%</span>
                    </div>
                  </el-form-item>
                </div>
                <div class="g-eg-img">
                  <span class="el-icon-close" @click="deleteClick" :data-msg="row.id"><!--delete删除--></span>
                </div>
              </div>
            </el-row>
          </el-form>
        </div>
        <div class="g-eg_part_right"></div>
      </div>
    </section>
  </div>
</template>
<script>
  import {judgeGroupLoad,//点击新增
    judgeGroupSave,//得到数据与保存接口
  } from '@/api/http'
  export default{
    data(){
      return{
        /*form表单单条数据，添加直接为formData中添加该数据字段*/
        formOneObject:{},
        /*form表单*/
        egGroupForm:{
          /*ajax*/
          formData:[],
        },
        /*rule*/
        groupRules:{
          /*name:[{required:'true'}]*/
        }
      }
    },
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*点击新建被评分组*/
      addGroupClick(){
        this.egGroupForm.formData.push(Object.assign({},this.formOneObject));
      },
      /*ajax*/
      /*得到初始数据*/
      getLoadAjax(){
        judgeGroupSave({id:23}).then(data=>{
          console.log(data);
          this.egGroupForm.formData=this.handlerData(data);
          /*提出单条数据*/
          if(this.egGroupForm.formData.length>0){
            for(let key in this.egGroupForm.formData[0]){
              if(this.egGroupForm.formData[0][key] instanceof Array){
                /*设置该键的值为数组*/
                this.formOneObject[key]=[];
                this.egGroupForm.formData[0][key].forEach((value,index)=>{
                  /*给数组插入对象值*/
                  this.formOneObject[key].push(Object.assign({},value));
                  for(let childKey in this.formOneObject[key][index]){
                    /*清空数组对象value值*/
                    if(childKey=='name'){
                      continue;
                    }
                    else{
                      this.formOneObject[key][index][childKey]='';
                    }
                  }
                });
              }
              else{
                this.formOneObject[key]='';
              }
            }
          }
        });
      },
      /*删除*/
      deleteClick(event){
        const id=$(event.currentTarget).data('msg');
        if(id){
          this.$confirm('是否删除此条考评分组？','提示',{
            confirmButtonText:'确定',
            type:'warning'
          }).then((value)=>{
            /*点击确定执行*/
            console.log('调用删除接口');
          }).catch((value)=>{
            /*取消执行*/
//           console.log(value);
          });
        }
        else{
         this.$confirm('是否删除此条考评分组？','提示',{
           confirmButtonText:'确定',
           type:'warning'
         }).then((value)=>{
           /*点击确定执行*/
           this.egGroupForm.formData.pop();
         }).catch((value)=>{
           /*取消执行*/
//           console.log(value);
         });
        }
      },
      /*保存*/
      saveAjaxClick(){
        this.$refs['egGroupForm'].validate((valid)=>{
          console.log(valid);
        });
      },
      /*处理数据*/
      handlerData(data){
        if(data.status){
          return data.data;
        }else{
          this.$alert('加载失败,请重新加载页面!','提示',{
            confirmButtonText:'确定',
            type:'error',
            callback:action=>{}
          });
        }
      },
    },
    created(){
      this.getLoadAjax();
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.css';
  @import '../../../../style/researchManagement/teacherEvaluation/teacherEvaluation.less';
  .g-eg-column{
    span{.fontSize(14);color:@normalColor;}
  }
</style>


