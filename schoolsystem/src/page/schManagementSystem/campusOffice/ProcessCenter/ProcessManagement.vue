<template>
  <div class="ProcessManagement">
    <h3>流程管理</h3>
    <el-col :span="24" class="ProcessManagement-top">
      <el-row class="alertsList">
        <el-table
          :data="tableData"
          style="width: 100%">
          <el-table-column
            type="index"
            label="序号"
            align="center"
            width="80">
          </el-table-column>
          <el-table-column
            prop="title"
            label="流程类型"
            align="center">
          </el-table-column>
          <el-table-column
            prop="name"
            label="流程名称"
            align="center">
          </el-table-column>
          <el-table-column
            prop="createTime"
            label="审批需要环节"
            align="center">
            <template scope="scope">
              <span></span>
            </template>
          </el-table-column>
          <el-table-column
            label="操作"
            align="center">
            <template scope="scope">
              <span style="color:#4da1ff;cursor: pointer;border-right:1px solid #d2d2d2;padding-right: .6rem" @click="ShowDatils(scope.row)">编辑</span>
              <span style="color:#ff6a6a;cursor: pointer;padding-left: .6rem" @click="Delectlist(scope.row)">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </el-row>
      <el-dialog title="流程编辑" v-if="dialogTableVisible" :modal="false" :visible.sync="dialogTableVisible">
        <el-col style="height:42rem;">
          <el-col :span="24">
            <el-col :span="3" style="padding-top: .4rem;">流程类型：</el-col>
            <el-col :span="5">
              <el-select v-model="value" placeholder="请选择">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
            <el-col :span="3" style="padding-top: .4rem;" :offset="1">审批环节：</el-col>
            <el-col :span="5">
              <el-select v-model="value0" placeholder="请选择">
                <el-option
                  v-for="item in options0"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-col>
          </el-col>
          <el-col :span="24" style="padding-top:1.4rem;">
            <el-col :span="3" style="padding-top: .4rem;">流程名称：</el-col>
            <el-col :span="14">
              <el-input placeholder="请输入"></el-input>
            </el-col>
          </el-col>
          <el-col :span="24" style="padding-top:1.4rem;">
            <el-col :span="7" class="ProcessManagement-name">
              <el-col :span="24">
                <div class="ProcessManagement-dialog-top">待选人员</div>
              </el-col>
              <el-col :span="24">
                <el-tree
                  :data="data"
                  :props="defaultProps"
                  accordion
                  @node-click="handleNodeClick">
                </el-tree>
              </el-col>
            </el-col>
            <el-col :span="16" :offset="1" class="ProcessManagement-link">
              <el-col :span="24">
                <div class="ProcessManagement-dialog-top" style="border-bottom: none">环节设置</div>
              </el-col>
              <el-col>
                <el-row class="alertsList">
                  <el-table
                    :data="tableData"
                    style="width: 100%"
                    border>
                    <el-table-column
                      type="index"
                      label="环节"
                      align="center"
                      width="80">
                    </el-table-column>
                    <el-table-column
                      prop=""
                      label="审批人"
                      align="center">
                      <template scope="scope">
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
                          @blur="handleInputConfirm">
                        </el-input>
                        <el-button v-else class="button-new-tag" size="small" @click="showInput">添加审批人</el-button>
                      </template>
                    </el-table-column>
                  </el-table>
                </el-row>
              </el-col>
            </el-col>
          </el-col>
          <el-col :span="4" :offset="10">
            <el-button type="primary" class="Field-save">保存</el-button>
          </el-col>
        </el-col>
      </el-dialog>
    </el-col>
  </div>
</template>
<script>
    export default{
        data(){
            return{
              tableData:[{title:'111'}],
              dialogTableVisible:false,
              value:'请选择',
              value0:'请选择...',
              options: [{
                value: '1',
                label: '1'
              },{
                value: '1',
                label: '1'
              }],
              options0: [{
                value: '2',
                label: '2'
              },{
                value: '2',
                label: '2'
              }],

              data: [
                  {
                label: '一级 1',
                children: [{
                  label: '二级 1-1',
                  children: [{
                    label: '三级 1-1-1'
                  }]
                }]
              }, {
                label: '一级 2',
                children: [{
                  label: '二级 2-1',
                  children: [{
                    label: '三级 2-1-1'
                  }]
                }, {
                  label: '二级 2-2',
                  children: [{
                    label: '三级 2-2-1'
                  }]
                }]
              }, {
                label: '一级 3',
                children: [{
                  label: '二级 3-1',
                  children: [{
                    label: '三级 3-1-1'
                  }]
                }, {
                  label: '二级 3-2',
                  children: [{
                    label: '三级 3-2-1'
                  }]
                }]
              }],
              defaultProps: {
                children: 'children',
                label: 'label'
              },
              dynamicTags: ['标签一', '标签二', '标签三'],
              inputVisible: false,
              inputValue: ''
            }
        },
      created(){},
      methods:{
        ShowDatils(){
            this.dialogTableVisible=true;
        },
        Delectlist(){

        },
        handleNodeClick(data) {
//          console.log(data);
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
  .ProcessManagement{
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }
 .ProcessManagement .el-tree{
    border: none;
  }
  .ProcessManagement-top{
    padding-top:46/16rem;
  }
  .Field-save{
    padding: .52rem 2.8rem;
    border-radius: 1.1rem;
    margin: 2rem 0;
  }
  .ProcessManagement-name,.ProcessManagement-link{
    height:450/16rem;
    border: 1px solid #d2d2d2;
    overflow-y: auto;
    border-radius: .3rem;
  }
  .ProcessManagement-dialog-top{
    padding:.5rem .3rem;
    border-bottom: 1px solid #E7E7E7;
    font-size: 1rem;
  }
  .ProcessManagement-dialog-input{
    display: inline-block;
    width:6rem;
    margin-right: 0;
  }
  .ProcessManagement .el-tag{
    background-color:#F08BC5 ;
    margin-left: .3rem;
  }
</style>
