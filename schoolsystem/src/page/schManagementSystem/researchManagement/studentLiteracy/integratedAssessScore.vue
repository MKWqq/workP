<template>
  <div class="g-container">
    <header class="g-textHeader">
      <h2>综合素养成绩</h2>
      <div class="g-flexStartRow">
        <span class="selfCenter" style="margin-right:1.25rem;">方案名称:</span>
        <el-select v-model="repairForm.name">
          <el-option value="0" label="ggg"></el-option>
        </el-select>
      </div>
    </header>
    <section class="">
      <header class="g-textHeader g-contentHeader">
        <h2 class="g-centerH" v-text="">123</h2>
        <p class="g-prompt">eee</p>
        <ul class="g-flexCenterRow">
          <li>
            <span>姓名:</span>
            <span v-text="">12</span>
          </li>
          <li>
            <span>满分:</span>
            <span v-text="">50</span>
          </li>
          <li>
            <span>得分:</span>
            <span v-text="">12</span>
          </li>
          <li>
            <span>考核人:</span>
            <span v-text="">rgr</span>
          </li>
        </ul>
      </header>
      <!--el-table-->
      <treeTable :columns="columns" :dataSource="assetTypeTable"></treeTable>
    </section>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import treeTable from '../../../../components/treeTable/treeTable.vue'
  export default{
    data(){
      let _self=this;
      return{
        /*模糊查询*/
        fuzzyInput:'',
        evaluationName:'',
        /*form表单*/
        repairForm:{
          name:'',
        },
        /*table*/
        classesTimeSetTable:[{name:1}],
        pickerOptionStart:{
          disabledDate(time){
            if(_self.repairForm.endTime){
              return time.getTime()>Date.parse(_self.repairForm.endTime);
            }
          }
        },
        pickerOptionEnd:{
          disabledDate(time){
            if(_self.repairForm.startTime){
              return time.getTime()<Date.parse(_self.repairForm.startTime);
            }
          }
        },
        /*弹框——维修详情*/
        isDetailDialog:false,
        detailForm:{
          type:'',
          address:'',
          things:'',
          tel:'',
          content:'',
          uploadImg:''
        },
        detailImgUpload:[
          {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
        ],
        /*table组件*/
        columns:[
          /*props为列绑定数据*/
          {name:'考核项目',props:'type'},
          {name:'具体条例',props:'code'},
          {name:'分值（分）',props:'code'},
          {name:'得分（分）（班主任评20%）',props:'code'},
          {name:'合计',props:'code'},
        ],
        assetTypeTable:[
          /*tree数据*/
          {type:'是否有',code:'1打断点',
            /*isSpecific判断哪条数据为具体条例，因为button不同*/
            children:[{type:'电脑',code:'1-1',children:[{type:'',code:'1-1-1',isSpecific:true}]},
              {type:'dfa',code:'1-1'}
            ],
          },
          {type:'no项',code:'淡淡的'}
        ],
      }
    },
    components:{treeTable},
    methods:{
      /*点击返回流程图按钮*/
      goBackChart(){
        this.$router.push({name:'evaluationManagement'});
      },
      /*table*/
      handleSelectionChange(choose){
        console.log(choose);
      },
      sortChange(value){
        console.log(value);
      },
      /*模糊查询*/
      fuzzyClick(){
        /*模糊查询执行回调*/
      },
      /*弹框——维修详情*/
      handlerDetailClose(done){
        done();
      },
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  .g-textHeader>div{.marginTop(20);}
  .g-contentHeader{
    width:100%;text-align:center;
    .g-prompt{.fontSize(14);margin:10/16rem 0 30/16rem;}
    ul{.widthRem(580);margin:0 auto;text-align:center;
      li{.fontSize(14);color:@normalColor;}
      li:not(:first-of-type){margin-left:20/16rem;}
    }
  }
</style>


