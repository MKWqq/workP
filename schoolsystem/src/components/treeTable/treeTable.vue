<template>
  <el-table class="g-NotHover" ref="treeTable" :data="tableData" style="width:100%" @sort-change="sortChange"
            @select="handleStudentTable" :row-style="showTr">
    <el-table-column v-for="(column,columnIndex) in columns" :label="column.name" :key="columnIndex">
      <template scope="props">
        <span class="g-tree-space" v-if="spaceIconShow(columnIndex)" v-for="(space,levelIndex) in props.row._level"></span>
        <span class="g-iconC" v-if="toggleIconShow(columnIndex,props.row)" @click="toggle(props.$index)">
          <i class="el-icon-plus" v-if="!props.row._expand"></i>
          <i class="el-icon-minus" v-if="props.row._expand"></i>
        </span>
        <span class="g-tree-space"  v-if="!toggleIconShow(columnIndex,props.row) && columnIndex===0"></span>
        {{props.row[column.props]}}
      </template>
    </el-table-column>
    <el-table-column type="selection" label="全选" v-if="isChecked"></el-table-column>
    <el-table-column label="操作" fixed="right" v-if="handleButton.parentHandle.length>0 || handleButton.childHandle.length>0">
      <template scope="props">
        <el-button v-if="props.row.isSpecific" type="text" v-for="(buttonTxt,bIndex) in handleButton.childHandle" @click="handleDialog" :data-msg="buttonTxt.msg" :key="bIndex" v-text="buttonTxt.name" :class="[buttonTxt.cls?buttonTxt.cls:'']"></el-button>
        <el-button v-if="!props.row.isSpecific" type="text" v-for="(buttonTxt,bIndex) in handleButton.parentHandle" @click="handleDialog" :data-msg="buttonTxt.msg" :key="bIndex" v-text="buttonTxt.name" :class="[buttonTxt.cls?buttonTxt.cls:'']"></el-button>
      </template>
    </el-table-column>
  </el-table>
</template>
<script>
  import {} from '@/api/http'
  import initData from './utils/index'
  export default{
    data(){
      return {
        /*复选框选择的值*/
        multipleData:[],
        isCheckAll:true,//选中或取消选中
      }
    },
    props: {
      /*操作中button循环*/
      handleButton:{
        type:Object,
        default:function(){
          return {parentHandle:[],childHandle:[]}
        }
      },
      /*是否有复选框*/
      isChecked:{
        type:Boolean,
        default:function(){
          return false
        }
      },
      /*列循环*/
      columns: {
        type:Array,
        default: function () {
          return [];
        }
      },
      /*循环数据*/
      dataSource: {
        type:Array,
        default: function () {
          return [];
        }
      },
      /*是否展开*/
      expand: {
        type: Boolean,
        default: function () {
          return false;
        }
      },
      /*是否满足树表格数据循环格式*/
      treeStructure: {
        type: Boolean,
        default: function () {
          return false;
        }
      },
      /*给一个index，为了方便检测复选框选中数据的位置*/
      treeIndex:{
        type:Number,
        default:0
      },
    },
    computed: {
      tableData(){
        let _self = this;
        if (!_self.treeStructure) {
          let data = initData.treeToArray(_self.dataSource, null, null, _self.expand);
          return data;
        }
        return _self.dataSource;
      }
    },
    watch:{
      multipleData(newValue){
      }
    },
    methods: {
      /*table*/
      handleStudentTable(section){
        /*section为选择项行信息组成的数组*/
        let isHasChild/*含有子节点*/,isChild/*是子节点*/;
        section.forEach((value,index)=>{
          isHasChild=Object.keys(value).includes('children');
          isChild=!Object.keys(value).includes('children');
          if(isHasChild){
            this.checkChildChoose(value.children);
          }
        });
        console.log(section);
      },
      sortChange(column){
        /*table排序回调*/
//        console.log(column)
      },
      /*选中父级，子级一起选中*/
      checkChildChoose(obj){
        const _self=this;
        obj.forEach((value,index)=>{
          _self.$refs.treeTable.toggleRowSelection(_self.tableData[Number(value._index)],_self.isCheckAll);
          if(value.children){
            _self.checkChildChoose(value.children);
          }
        });
      },
      /*自定义*/
      /*显示行*/
      showTr(row, index){
        let show = (row._parent ? (row._parent._expand && row._parent._show) : true);
        row._show = show;
        return show ? '' : 'display:none;'
      },
      /*展开下级*/
      toggle(trIndex){
        let _self = this;
        _self.tableData[trIndex]._expand=!_self.tableData[trIndex]._expand;
        _self.showTr(_self.tableData[trIndex]);
      },
      /*显示层级关系空格或图标*/
      spaceIconShow(index){
        let _self = this;
        if (index === 0) {
          return true;
        }
        return false;
      },
      /*点击展开和关闭图标切换*/
      toggleIconShow(index, record){
        let _self = this;
        if (index === 0 && record.children && record.children.length > 0) {
          return true;
        }
        return false;
      },
      /*操作弹框显示*/
      handleDialog(event){
        const e=$(event.currentTarget);
        this.$emit('handleDialog',e.data('msg'));
      },
    },
    created(){
    }
  }
</script>
<style lang="less" scoped>
  @import '../../style/test';
  @import '../../style/style';
</style>





