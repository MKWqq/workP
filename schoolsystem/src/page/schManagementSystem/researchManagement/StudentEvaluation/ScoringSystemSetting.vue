<template>
    <div class="ScoringSystemSetting">
      <h3>评分方式设置</h3>
      <el-col :span="12" :offset="6" class="ScoringSystemSetting-content-top">
        <el-col :span="24">
          <span class="ScoringSystemSetting-span1">分数评分</span>
          <span class="ScoringSystemSetting-span2">（统计平均分，排名）</span>
        </el-col>
        <el-col :span="23" :offset="1" class="ScoringSystemSetting-text-top">
          <el-col :span="4">满分分数：</el-col>
          <el-col :span="20">
            <el-input></el-input>
          </el-col>
        </el-col>
        <el-col :span="24" class="ScoringSystemSetting-text-top">
          <span class="ScoringSystemSetting-span1">字段评分</span>
          <span class="ScoringSystemSetting-span2">（统计各层次数，各层次率）</span>
        </el-col>
        <el-col :span="23" :offset="1" class="ScoringSystemSetting-text-top">
          <el-col :span="4">添加评分意见：</el-col>
          <el-col :span="20">
            <el-input
              class="input-new-tag"
              v-model="inputValue"
              ref="saveTagInput"
              @keyup.enter.native="handleInputConfirm"
              @blur="handleInputConfirm"
            >
            </el-input>
          </el-col>
          <el-col :span="20" :offset="4">
            <el-tag
              :key="tag"
              v-for="tag in dynamicTags"
              :closable="true"
              :close-transition="false"
              @close="handleClose(tag)"
            >
              {{tag}}
            </el-tag>
          </el-col>
        </el-col>
        <el-col :span="24" class="ScoringSystemSetting-text-top">
          <span class="ScoringSystemSetting-span1">星级评分</span>
          <span class="ScoringSystemSetting-span2">（统计平均分，排名，各层次数，各层次率）</span>
        </el-col>
        <el-col :span="23" :offset="1" class="ScoringSystemSetting-text-top">
          <el-col :span="4">满分星数：</el-col>
          <el-col :span="20">
            <el-rate v-model="Ratevalue"
                     :colors="['#F08BC5', '#F08BC5', '#F08BC5']"></el-rate>
          </el-col>
        </el-col>
        <el-col :span="24">
          <el-button type="primary" class="ScoringSystemSetting-btn">保存</el-button>
        </el-col>
      </el-col>
    </div>
</template>
<script>
    export default{
        data(){
            return {
              dynamicTags: ['满意', '一般', '不满意'],
              inputValue: '',
              Ratevalue:null,
            }
        },
      methods:{
        handleClose(tag) {
          this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
        },

        showInput() {
          this.inputVisible = true;
          this.$nextTick(_ => {
            this.$refs.saveTagInput.$refs.input.focus();
          });
        },

        handleInputConfirm() {
          let inputValue = this.inputValue;
          if (inputValue) {
            this.dynamicTags.push(inputValue);
          }
          this.inputVisible = false;
          this.inputValue = '';
        },
      }
    }
</script>
<style lang="less">
  .ScoringSystemSetting{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .ScoringSystemSetting-content-top{
    padding-top: 3.8rem;
  }
  .ScoringSystemSetting-text-top{
    margin-top:2.4rem;
  }
  .ScoringSystemSetting-span1{
    font-size:1.1rem;
    color: #373737;
  }
  .ScoringSystemSetting-span2{
    color:#A6A6A6;
    font-size: 0.95rem;
  }
  .ScoringSystemSetting .el-tag{
    background-color:#89BCF5 ;
    margin-left:1.8rem;
    margin-top: 1.6rem;
    padding: .3rem .6rem;
    height: 100%;
  }
  .ScoringSystemSetting .el-tag:nth-of-type(1){
    margin-left:0;
  }
  .ScoringSystemSetting-btn{
    width: 100%;
    margin:3.8rem 0 8rem 0;
  }
</style>
