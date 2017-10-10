<template>
  <div class="Approvalsettings">
    <el-col :span="24">
      <el-col :span="22">
        <h3>审批设置</h3>
      </el-col>
      <el-col :span="2">
        <el-button type="primary" class="CreateProcess-top-btn">保存</el-button>
      </el-col>
    </el-col>
    <el-col :span="24">
      <el-col :span="17" class="Appset-left">
        <div class="Appset-left-title">审批人</div>
        <el-tag
          :key="tag"
          v-for="tag in dynamicTags"
          :closable="true"
          :close-transition="false"
          @close="handleClose(tag)">
          {{tag}}
        </el-tag>
        <el-input
          class="input-new-tag"
          v-if="inputVisible"
          v-model="inputValue"
          ref="saveTagInput"
          size="mini"
          @keyup.enter.native="handleInputConfirm"
          @blur="handleInputConfirm"
        >
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>

      </el-col>
      <el-col :span="6" :offset="1" class="Appset-right">
        <div class="Appset-right-title">选择审批人</div>
        <el-col :span="22" :offset="1" class="Appset-right-input1">
          <el-input
            placeholder="请输入查询关键字"
            icon="search"
            v-model="input2"
            :on-icon-click="handleIconClick">
          </el-input>
        </el-col>
        <div class="Appset-right-border"></div>
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
        <el-col :span="22" :offset="1" class="Appset-right-input">
          <el-input
            placeholder="手动添加学生名字"
            icon="plus"
            v-model="input2"
            :on-icon-click="handleIconClick">
          </el-input>
        </el-col>
      </el-col>
    </el-col>
  </div>
</template>
<script>
  export default{
    data(){
      return{
        input2: '',
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
        dynamicTags: ['标签一标签', '标签二', '标签三'],
        inputValue: '',
        inputVisible:false,
      }
    },
    methods:{
      handleIconClick(ev) {
        console.log(ev);
      },
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
  .Approvalsettings{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
  .Approvalsettings  .CreateProcess-top-btn{
    padding:.5rem 2.8rem ;
    border-radius: 1.1rem;
    cursor: pointer;
  }
  .Appset-left,.Appset-right{
    border: 1px solid #d2d2d2;
    height:43.5rem;
    margin-top: 2rem;
    border-radius: .4rem;
    overflow-y: auto;
    margin-bottom: 1rem;
    box-shadow: 0 0.1rem 0.1rem 0.12rem rgba(0, 0, 0, 0.09) inset;
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
  .Approvalsettings .Appset-right-input1 .el-input__inner{
    height:28/16rem;
    border-radius:.8rem ;
  }
  .Appset-right-border{
    border: 1px solid #d2d2d2;
    margin-top:2.9rem;
  }
  .Approvalsettings .el-tree{
    border: none;
    margin-bottom:3rem;
  }
  .Approvalsettings .Appset-right-input .el-input__inner{
    height:36/16rem;
    border-radius:1.1rem ;
    border-color: #4da1ff;
  }
  .Approvalsettings .el-tag{
    background-color:#F08BC5 ;
    margin-left: 1rem;
  }
</style>
