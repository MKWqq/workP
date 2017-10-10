<template>
  <div class="NewEvaluationTeacher">
    <el-col :span="24">
      <h3>创建教学评价</h3>
    </el-col>
    <el-col :span="24">
      <el-col :span="6" class="Appset-right">
        <div class="Appset-right-title">学生评教范围</div>
        <div class="Appset-border"></div>
        <el-col :span="24">
          <el-tree
            accordion
            :data="data2"
            show-checkbox
            node-key="id"
            :default-expanded-keys="[2, 3]"
            :default-checked-keys="[5]"
            :props="defaultProps">
          </el-tree>
        </el-col>
      </el-col>
      <el-col :span="17" :offset="1" class="NewEvaluationTeacher-right">
        <el-col :span="18" :offset="3">
          <el-col :span="24">
            <el-col :span="4">学年学期：</el-col>
            <el-col :span="20">
              <el-select v-model="value" placeholder="请选择" style="width: 100%;">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4">评教名称：</el-col>
            <el-col :span="20">
              <el-input placeholder="请输入评教名称"></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4">学生范围：</el-col>
            <el-col :span="20">
              <el-input placeholder="请在左侧学生评教范围中选择"></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4">考评时间：</el-col>
            <el-col :span="20">
              <el-col :span="10">
                <el-date-picker
                  style="width: 100%"
                  v-model="startTime"
                  type="date"
                  placeholder="选择日期"
                  :picker-options="pickerOptions0">
                </el-date-picker>
              </el-col>
              <el-col :span="2" :offset="2">-</el-col>
              <el-col :span="10">
                <el-date-picker
                  style="width: 100%"
                  v-model="endTime"
                  type="date"
                  placeholder="选择日期"
                  :picker-options="pickerOptions1">
                </el-date-picker>
              </el-col>
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4">评教方式：</el-col>
            <el-col :span="16">
              <el-checkbox-group v-model="checkList">
                <el-checkbox label="统计均分，排名"></el-checkbox>
                <el-checkbox label="统计各层次数，各层次率" style="margin-left:3rem;"></el-checkbox>
                <el-checkbox label="统计均分，排名，统计各层次数，各层次率" style="margin-left: 0;margin-top: 1.6rem"></el-checkbox>
              </el-checkbox-group>
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4" style="margin-top: .48rem;">分数采样：</el-col>
            <el-col :span="20">
              本组最高分去除 <el-input style="width:12%"></el-input> %的人， 本组最低分去除 <el-input style="width:12%"></el-input> %的人。
            </el-col>
          </el-col>
          <el-col :span="24" class="NewEvaluationTeacher-margin-top">
            <el-col :span="4" style="margin-top: .48rem;">评语字数：</el-col>
            <el-col :span="20">
              评语字数最少输入 <el-input style="width:12%"></el-input> 字。
            </el-col>
          </el-col>
          <el-col :span="24">
            <el-button type="primary" class="NewEvaluationTeacher-right-btn">创建</el-button>
          </el-col>
        </el-col>
      </el-col>
    </el-col>
  </div>
</template>
<script>
  export default{
    data(){
      return{
        data2: [
          {
            id: 1,
            label: '一级 1',
            children: [{
              id: 4,
              label: '二级 1-1',
              children: [{
                id: 9,
                label: '三级 1-1-1'
              }, {
                id: 10,
                label: '三级 1-1-2'
              }]
            }]
          }, {
            id: 2,
            label: '一级 2',
            children: [{
              id: 5,
              label: '二级 2-1'
            }, {
              id: 6,
              label: '二级 2-2'
            }]
          }, {
            id: 3,
            label: '一级 3',
            children: [{
              id: 7,
              label: '二级 3-1'
            }, {
              id: 8,
              label: '二级 3-2'
            }]
          }],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        options: [{
          value: '选项1',
          label: '黄金糕'
        }],
        value: '',
        pickerOptions0: {
          disabledDate(time) {
            return time.getTime() < Date.now() - 8.64e7;
          }
        },
        startTime:new Date(),
        endTime:new Date(),
        pickerOptions1: {
          disabledDate(time) {
            return time.getTime() < Date.now() - 8.64e7;
          }
        },
        checkList: [],
      }
    },
    methods:{

    }
  }
</script>
<style lang="less">
  .NewEvaluationTeacher{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .NewEvaluationTeacher  .CreateProcess-top-btn{
    padding:.5rem 2.8rem ;
    border-radius: 1.1rem;
    cursor: pointer;
  }
  .Appset-right{
    border: 1px solid #d2d2d2;
    height:43.5rem;
    margin-top: 2rem;
    border-radius: .4rem;
    overflow-y: auto;
    margin-bottom: 1rem;
    box-shadow: 0 0.1rem 0.1rem 0.12rem rgba(0, 0, 0, 0.09) inset;
  }
  .NewEvaluationTeacher-right{
    height:43.5rem;
    margin-top: 2rem;
    padding-top:3rem;
  }
  .Appset-left-title{
    font-size: 1.1rem;
    padding: 1.6rem 0 1.6rem 1rem;
  }
  .Appset-right-title{
    padding: .8rem 0 .8rem .8rem;
    font-weight: bold;
    font-size: 0.95rem;
  }
  .NewEvaluationTeacher .Appset-border{
    border: 1px solid #d2d2d2;
  }
  .NewEvaluationTeacher .el-tree{
    border: none;
    margin-bottom:3rem;
  }
  .NewEvaluationTeacher-margin-top{
    margin-top: 1.8rem;
  }
  .NewEvaluationTeacher-right-btn{
    width: 100%;
    margin-top:3.8rem;
  }
</style>
