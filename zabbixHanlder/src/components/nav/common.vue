<template>
  <div class="Content">
    <div class="ContentTop">
      <div class="ContentInputRow">
        <span>字段名:</span>
        <div class="selectContainer">
          <select v-model="FormData.fileName" @focus="isPromptError=false">
            <option label="gslb_gslbpisection" value="gslb_gslbpisection"></option>
            <option label="gslb_gslbnodeitem" value="gslb_gslbnodeitem"></option>
          </select>
        </div>
      </div>
      <div class="searchButton">
        <el-form>
          <el-form-item>
            <el-button :loading="isLoading" @click="searchClick" class="searchButton">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <div class="ContentBottom" v-show="isHaveData"></div>
    <div class="promptError" v-show="isPromptError">请填写完整信息！</div>
    <SNButton v-show="isHaveData" class="ContentButton" :maxPage="pageAll" v-on:sendNewAjax="changePage"></SNButton>
  </div>
</template>
<script>
import $ from 'jquery'
import SNButton from '../../components/button/button'
import {} from '../../api/http'
export default{
  data(){
    return {
      isLoading:false,
      isHaveData:false,
      isPromptError:false,
      FormData:{
        fileName:"gslb_gslbpisection"
      },
      pageAll:0
    }
  },
  components:{'SNButton':SNButton},
  methods:{
    searchClick(){},
    changePage(Page){}
  }
}
</script>
<style lang="less" scoped>
  @import '../../style/search/ippool.less';
</style>











