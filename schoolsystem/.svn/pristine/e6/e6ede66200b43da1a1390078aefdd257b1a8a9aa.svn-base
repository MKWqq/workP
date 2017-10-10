<template>
  <div class="g-container">
    <header v-show="isAdd=='add'" class="g-textHeader g-liOneRow">
      <h2>新建问卷</h2>
      <el-button class="radiusButton" type="primary">保存</el-button>
    </header>
    <header class="g-textHeader g-liOneRow" v-show="isAdd!='add'">
      <div class="g-flexStartRow g-liOneRow selfSpace">
        <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
          <img src="../../../../assets/img/commonImg/icon_return.png" />
          返回
        </el-button>
        <span class="selfCenter">处理任务</span>
      </div>
      <div>
        <el-button class="radiusButton" type="primary">预览</el-button>
        <el-button class="radiusButton" type="primary">保存</el-button>
      </div>
    </header>
    <section class="g-liOneRow g-tree_content">
      <div class="g-QNContent">
        <header>
          <div class="g-flexStartRow">
            <span class="g-label selfCenter">选择题型:</span>
            <ul class="g-flexStartWrapRow selfSpace">
              <li class="normalLi" data-msg="0" @click="QNLiClick">单选题</li>
              <li class="normalLi" data-msg="1" @click="QNLiClick">多选题</li>
              <li class="normalLi" data-msg="2" @click="QNLiClick">填空题</li>
              <li class="normalLi" data-msg="3" @click="QNLiClick">分数题</li>
              <li class="normalLi" data-msg="4" @click="QNLiClick">段落说明</li>
              <li class="normalLi" data-msg="5" @click="QNLiClick">批量添加</li>
            </ul>
          </div>
          <div class="g-flexStartRow g-QNSwitch">
            <el-switch v-model="isNameReal" on-text="实名" off-text="非实名" on-color="" off-color="#ff5b5b"></el-switch>
            <span class="g-prompt selfCenter">注:若选中为实名问卷，则会搜集填写问卷用户的姓名，否则不搜集</span>
          </div>
        </header>
        <section>
          <div class="g-QNaireTitle">
            <div class="g-QNaireTitleRow">
              <span class="g-label">问卷标题:</span>
              <el-input v-model="QuestionNaireForm.title" placeholder="请填写标题，100字以内"></el-input>
            </div>
            <div class="g-QNaireTitleRow">
              <span class="g-label">问卷说明:</span>
              <el-input v-model="QuestionNaireForm.description" placeholder="请填写问卷说明，2000字以内"></el-input>
            </div>
          </div>
          <div class="g-QNSetContainer" v-for="(content,index) in QuestionNaireForm.QNArray">
            <div v-if="content.type==0" class="g-singleTopic">
              <!--单选题-->
              <div class="g-QNSetTopicContainer g-liOneRow">
                <h2 v-text="'Q'+(index+1)"></h2>
                <div class="g-QNSetContent selfSpace">
                  <el-input v-model="content.title" class="g-QRTitle" placeholder="请输入单选题题目"></el-input>
                  <div class="g-addQuestion">
                    <div class="g-addQuestionRow g-liOneRow" v-for="(question,qIndex) in content.QNSetting">
                      <el-radio v-model="question.isChoose" class="selfCenter g-chooseBox" disabled></el-radio>
                      <el-input v-model="question.value" placeholder="请输入单选选项"></el-input>
                      <div class="g-QNHandlerContainer topicHandler">
                        <span class="icon_Add" :data-id="index" @click="addTopicClick"></span>
                        <span class="icon_goUp" data-msg="top" :data-id="index+'_'+qIndex" @click="topicGoUpClick"></span>
                        <span class="icon_goDown" data-msg="down" :data-id="index+'_'+qIndex" @click="topicGoUpClick"></span>
                        <span class="icon_shutDown" :data-id="index+'_'+qIndex" @click="deleteTopicClick"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="g-QNSetFooter g-liOneRow">
                <el-checkbox class="g-QRSetMust" v-model="content.isMust">必填项<span>(单选题)</span></el-checkbox>
                <div class="g-QNHandlerContainer">
                  <span class="icon_goUp" data-msg="top" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_goDown" data-msg="down" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_shutDown" :data-id="index" @click="deleteProblemTypeClick"></span>
                </div>
              </div>
            </div>
            <div v-if="content.type==1" class="g-multipleChoose">
              <!--多选题-->
              <div class="g-QNSetTopicContainer g-liOneRow">
                <h2 v-text="'Q'+(index+1)"></h2>
                <div class="g-QNSetContent selfSpace">
                  <el-input v-model="content.title" class="g-QRTitle" placeholder="请输入多选题题目"></el-input>
                  <div class="g-addQuestion">
                    <div class="g-addQuestionRow g-liOneRow" v-for="(question,qIndex) in content.QNSetting">
                      <el-checkbox v-model="question.isChoose" class="selfCenter g-chooseBox" disabled></el-checkbox>
                      <el-input v-model="question.value" placeholder=""></el-input>
                      <div class="g-QNHandlerContainer topicHandler">
                        <span class="icon_Add" data-msg="check" :data-id="index" @click="addTopicClick"></span>
                        <span class="icon_goUp" data-msg="top" :data-id="index+'_'+qIndex" @click="topicGoUpClick"></span>
                        <span class="icon_goDown" data-msg="down" :data-id="index+'_'+qIndex" @click="topicGoUpClick"></span>
                        <span class="icon_shutDown" data-msg="check" :data-id="index+'_'+qIndex" @click="deleteTopicClick"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="g-QNSetFooter g-liOneRow">
                <div class="g-flexStartRow">
                  <el-checkbox class="g-QRSetMust" v-model="content.isMust">必填项<span>(单选题)</span></el-checkbox>
                  <div class="g-optionNum">
                    <span>最多可选</span>
                    <el-input-number class="g-courseNum" v-model="content.optionNum" :min="1" :max="maxOptionNum"></el-input-number>
                    <span>项</span>
                  </div>
                </div>
                <div class="g-QNHandlerContainer">
                  <span class="icon_goUp" data-msg="top" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_goDown" data-msg="down" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_shutDown" :data-id="index" @click="deleteProblemTypeClick"></span>
                </div>
              </div>
            </div>
            <div v-if="content.type==2" class="g-fillInBlank">
              <!--填空题-->
              <div class="g-QNSetTopicContainer g-liOneRow">
                <h2 v-text="'Q'+(index+1)"></h2>
                <div class="g-QNSetContent selfSpace">
                  <el-input v-model="content.title" class="g-QRTitle" placeholder="请输入填空题题目"></el-input>
                  <div class="g-addQuestion">
                    <div class="g-addQuestionRow g-liOneRow">
                      <el-input v-model="content.QNSetting.value" disabled placeholder=""></el-input>
                    </div>
                  </div>
                </div>
              </div>
              <div class="g-QNSetFooter g-liOneRow">
                <div class="g-flexStartRow">
                  <el-checkbox class="g-QRSetMust" v-model="content.isMust">必填项<span>(单选题)</span></el-checkbox>
                </div>
                <div class="g-QNHandlerContainer">
                  <span class="icon_goUp" data-msg="top" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_goDown" data-msg="down" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_shutDown" :data-id="index" @click="deleteProblemTypeClick"></span>
                </div>
              </div>
            </div>
            <div v-if="content.type==3" class="g-scoresTopic">
              <!--分数题-->
              <div class="g-QNSetTopicContainer g-liOneRow">
                <h2 v-text="'Q'+(index+1)"></h2>
                <div class="g-QNSetContent selfSpace">
                  <el-input v-model="content.title" class="g-QRTitle" placeholder="请输入填空题题目"></el-input>
                  <div class="g-addQuestion">
                    <div class="g-addQuestionRow g-liOneRow">
                      <el-input v-model="content.QNSetting.value" disabled placeholder=""></el-input>
                    </div>
                  </div>
                </div>
              </div>
              <div class="g-QNSetFooter g-liOneRow">
                <div class="g-flexStartRow">
                  <el-checkbox class="g-QRSetMust selfCenter" v-model="content.isMust">必填项<span>(单选题)</span></el-checkbox>
                  <div class="g-optionNum">
                    <span>限定最大值</span>
                    <el-input class="defineInputWidth" v-model="content.maxScore"></el-input>
                    <span>分</span>
                  </div>
                  <div class="g-prompt selfCenter">注：此题只能用数字作答，且可在问卷统计中统计求和、平均结果。</div>
                </div>
                <div class="g-QNHandlerContainer">
                  <span class="icon_goUp" data-msg="top" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_goDown" data-msg="down" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_shutDown" :data-id="index" @click="deleteProblemTypeClick"></span>
                </div>
              </div>
            </div>
            <div v-if="content.type==4" class="g-paragraphDescript">
              <!--段落说明-->
              <div class="g-QNSetTopicContainer g-liOneRow">
                <div class="g-QNParagraph selfSpace">
                  <div class="g-addQuestion">
                    <div class="g-addQuestionRow g-liOneRow">
                      <el-input v-model="content.description" placeholder="段落说明"></el-input>
                    </div>
                  </div>
                </div>
              </div>
              <div class="g-QNSetFooter g-flexEndRow">
                <div class="g-QNHandlerContainer">
                  <span class="icon_goUp" data-msg="top" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_goDown" data-msg="down" :data-id="index" @click="ProblemTypeGoUpClick"></span>
                  <span class="icon_shutDown" :data-id="index" @click="deleteProblemTypeClick"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="g-batchAdd"><!--批量添加--></div>
        </section>
      </div>
      <div class="g-sectionL">
        <header class="gL-header">
          <h2>候选人员名单</h2>
          <el-input @input="fuzzyClick" v-model="fuzzyInput" class="fuzzyInput" placeholder="请输入教师姓名" icon="search"></el-input>
        </header>
        <section class="gL-section">
          <el-tree :highlight-current="true" show-checkbox @check-change="handlerCheckChange" :data="treeData" :props="defaultProps" ref="allMsg" :filter-node-method="filterNode"></el-tree>
          <div class="g-treeBInput">
            <el-input placeholder="请输入添加学生名字" v-model="studentName">
            </el-input>
            <span class="searchBtn" @click="goSearchStudent">
                  <i class="el-icon-plus"></i>
                </span>
          </div>
        </section>
      </div>
    </section>
    <el-dialog class="headerNotBackground" title="批量添加题目" :modal="false" :visible.sync="isDialog" :before-close="handlerDetailClose">
      <el-input type="textarea" :autosize="{minRows:10}" v-model="addProblemFast"></el-input>
      <div class="g-prompt">
        <div>温馨提示:</div>
        <div>
          <p>1.在所有题目的标题后方，都需注明对应题型名字。例如单选题、多选题、填空题、分数题、段落说明需分别在题目标题后注明“[单选题]”、“[多选题]”、“[填空题]“、“[分数题]”、“[段落说明]”；</p>
          <p>2.第一行为题目标题，中间不要换行，不用加题目序号（即不用加1、2等，会自动生成）；</p>
          <p>3.对于单选题、多选题，回车后，下一行开始为选项行， 选项不要空行，一个选项单独一行；</p>
          <p>4.每道题之间需留一个空行；</p>
          <p>5.对于填空题、分数题、段落说明，在题目标题后分别注明“[填空题]“、“[分数题]”、“[段落说明]”，并在题目下方空一行即可。</p>
        </div>
      </div>
      <div class="g-button">
        <el-button type="primary">添加</el-button>
        <el-button @click="isDialog=false">关闭</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import {} from '@/api/http'
  import ElCheckbox from "../../../../../node_modules/element-ui/packages/checkbox/src/checkbox";
  export default{
    components: {ElCheckbox},
    data(){
      return{
        /*判断是编辑问卷还是新建问卷*/
        isAdd:'',
        /*是否实名*/
        isNameReal:false,
        /*问卷题目设置*/
        QuestionNaireForm:{
          title:'',
          description:'',
          /*单选多选题等数据总和*/
          QNArray:[
            /*0为单选题，依次往下*/
          ],
        },
        /*多选最多选项，最大值设置*/
        maxOptionNum:1,
        /*单选题默认数据*/
        singleTopic:{
          type:'0',
          isMust:false,//必选题?
          title:'',
          QNSetting:[
            {
              isChoose:false,
              value:'',//选项值
            },
          ]
        },
        /*多选题默认数据*/
        multipleChoose:{
          type:'1',
          title:'',
          isMust:false,//必选题?
          optionNum:1,//最多可选
          chooseNum:1,
          QNSetting:[
            {
              isChoose:false,
              value:'',//选项值
            },
          ]
        },
        /*填空题默认数据*/
        fillInBlank:{
          type:'2',
          title:'',
          isMust:false,//必选题?
          QNSetting:{
            value:'',//选项值
          },
        },
        /*分数题默认数据*/
        scoresTopic:{
          type:'3',
          title:'',
          isMust:false,//必选题?
          maxScore:'100',//限定最高分
          QNSetting:{
            value:'',//选项值
          },
        },
        /*段落说明默认数据*/
        paragraphDescript:{
          type:'4',
          description:'',
        },
        /*选项默认数据*/
        ChooseTopic:{
          isChoose:false,
          value:'',//选项值
        },
        /*模糊查询老师*/
        fuzzyInput:'',
        /*tree*/
        treeData:[
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
          label:'label',
        },
        /*tree下方input框*/
        studentName:'',
        /*弹框*/
        isDialog:false,
        addProblemFast:'',
      }
    },
    methods:{
      goBackParent(){
        this.$router.push('/questionNaireRecord');
      },
      /*教师信息模糊查询*/
      fuzzyClick(){
        /*input框输入值改变触发的函数*/
        this.$refs['allMsg'].filter(this.fuzzyInput);
      },
      filterNode(value, data) {
        /*筛选节点*/
        if (!value) return true;
        return data.label.indexOf(value) !== -1;
      },
      /*题目添加*/
      QNLiClick(event){
        const e=$(event.currentTarget);
        const type=e.data('msg');
        e.removeClass('normalLi');
        e.addClass('activeLi');
        e.siblings().removeClass('activeLi');
        e.siblings().addClass('normalLi');
        /*思路为储存问卷信息对象数组中添加相对应的默认信息*/
        if(type==0){
          this.QuestionNaireForm.QNArray.push(JSON.parse(JSON.stringify(this.singleTopic)));
        }
        else if(type==1){
          this.QuestionNaireForm.QNArray.push(JSON.parse(JSON.stringify(this.multipleChoose)));
        }
        else if(type==2){
          this.QuestionNaireForm.QNArray.push(JSON.parse(JSON.stringify(this.fillInBlank)));
        }
        else if(type==3){
          this.QuestionNaireForm.QNArray.push(JSON.parse(JSON.stringify(this.scoresTopic)));
        }
        else if(type==4){
          this.QuestionNaireForm.QNArray.push(JSON.parse(JSON.stringify(this.paragraphDescript)));
        }
        else if(type==5){
          this.isDialog=true;
        }
      },
      /*删除题目*/
      deleteProblemTypeClick(event){
        const e=$(event.currentTarget);
        const index=e.data('id');
        this.$confirm('是否删除数据？','提示',{
          confirmButtonText:'确定',
          type:'warning'
        }).then(()=>{
          this.QuestionNaireForm.QNArray.splice(index,1);
        }).catch(()=>{});
      },
      /*题目上移*/
      ProblemTypeGoUpClick(event){
        const e=$(event.currentTarget);
        const type=e.data('msg');
        /*题型index*/
        const index=Number(e.data('id'));
        const arr=this.QuestionNaireForm.QNArray;
        if(type=='top'){
          /*上移*/
          if(index>0){
            /*判断是否为第一个*/
            arr.splice(index-1,1,...arr.splice(index,1,arr[index-1]));
          }
          else{
            return
          }
        }
        else{
          /*下移*/
          if(index<arr.length-1){
            /*判断是否为第一个*/
            arr.splice(index,1,...arr.splice(index+1,1,arr[index]));
          }
          else{
            return
          }
        }
      },
      /*选项添加*/
      addTopicClick(event){
        const e=$(event.currentTarget);
        const index=e.data('id');
        /*添加的题型*/
        const problemType=e.data('msg');
        this.QuestionNaireForm.QNArray[index].QNSetting.push(JSON.parse(JSON.stringify(this.ChooseTopic)));
        if(problemType){
          this.maxOptionNum=this.QuestionNaireForm.QNArray[index].QNSetting.length;
        }
        else{
          return
        }
      },
      /*选项删除*/
      deleteTopicClick(event){
        const e=$(event.currentTarget);
        /*题型的index*/
        const parentIndex=e.data('id').split('_')[0];
        /*选项的index*/
        const childIndex=e.data('id').split('_')[1];
        /*添加的题型*/
        const problemType=e.data('msg');
        if(this.QuestionNaireForm.QNArray[parentIndex].QNSetting.length>1){
          this.QuestionNaireForm.QNArray[parentIndex].QNSetting.splice(childIndex,1);
        }
        else{
          return
        }
        /*减小多选题最多选项的最大值*/
        if(problemType){
          this.maxOptionNum=this.QuestionNaireForm.QNArray[parentIndex].QNSetting.length;
          /*判断最大选项最大值与当前最大选项值哪个大*/
          if(this.maxOptionNum<this.QuestionNaireForm.QNArray[parentIndex].optionNum){
            this.QuestionNaireForm.QNArray[parentIndex].optionNum=this.maxOptionNum;
          }
          else{
            return
          }
        }
        else{
          return
        }
      },
      /*选项上移及下移*/
      topicGoUpClick(event){
        const e=$(event.currentTarget);
        const type=e.data('msg');
        /*题型index*/
        const parentIndex=Number(e.data('id').split('_')[0]);
        /*选项index*/
        const childIndex=Number(e.data('id').split('_')[1]);
        const arr=this.QuestionNaireForm.QNArray[parentIndex].QNSetting;
        if(type=='top'){
          /*上移*/
          if(childIndex>0){
            /*判断是否为第一个*/
            arr.splice(childIndex-1,1,...arr.splice(childIndex,1,arr[childIndex-1]));
          }
          else{
            return
          }
        }
        else{
          /*下移*/
          if(childIndex<arr.length-1){
            /*判断是否为第一个*/
            arr.splice(childIndex,1,...arr.splice(childIndex+1,1,arr[childIndex]));
          }
          else{
            return
          }
        }
      },
      /*tree复选框选中事件*/
      handlerCheckChange(data, checked, indeterminate){
        /*点击节点回调*/
        /*点击名字发送请求，返回数据绑定在右边部分*/
        /*给每一级赋值一个唯一的id即可辨认点击的是几级*/
        console.log(data);
      },
      /*tree下方input框*/
      goSearchStudent(){//查询
        console.log(this.studentName);
      },
      /*弹框*/
      handlerDetailClose(done){
        done();
      },
    },
    created(){
      this.isAdd=this.$route.params.id;
    },
    beforeRouteUpdate(to){
      this.isAdd=this.$route.params.id;
    },
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/test';
  @import '../../../../style/style';
  header.g-textHeader{border:none;padding-bottom:20/16rem;
    span{.fontSize(19);color:@HColor;.marginLeft(40,1582);}
  }
  .g-QNSwitch{.marginTop(15);}
  .g-prompt{margin-left:20/16rem;}
  .g-container .g-tree_content{margin-top:0;}
  .g-container .g-QNContent{.width(1142,1582);}
  .g-QNContent{
    li{.widthRem(120);.height(40);text-align:center;.border-radius(4/16rem);
      &:hover{cursor:pointer;}
    }
    li:not(:first-of-type){margin-left:30/16rem;}
    .activeLi{background:@buttonActive;color:#fff;border:none;}
    .normalLi{background:none;color:@buttonActive;border:1px solid @buttonActive;}
  }
  /*问卷设置*/
  .g-QNaireTitle{margin:20/16rem 0;}
  .g-QNaireTitleRow{.flex();justify-content:flex-start;}
  .g-QNaireTitleRow:not(:first-of-type){.marginTop(20);}
  .g-QNaireTitleRow .g-label{display:inline-block;.widthRem(80);text-align:center;align-self:center;margin-right:20/16rem;}

  /*选择题*/
  .g-QNSetContainer{padding:20/16rem 32/16rem;border:1px solid @borderColor;}
  .g-QNSetContainer:not(:first-of-type){.marginTop(20);}
  .g-QNSetContainer h2{margin-right:2%;}
  .g-QNSetContent{background:@backgroundGrad;}
  /*段落说明容器*/
  .g-QNParagraph{background:#fff;}
  .g-QNParagraph .g-addQuestion{padding-top:0;padding-bottom:0;}
  /*设置单选题内容容器*/
  .g-QNSetTopicContainer{padding-right:2rem;}
  .g-addQuestion{/*比例*/
    .width(845,980);padding:20/16rem 55/980*100%;
    .g-addQuestionRow:not(:first-of-type){.marginTop(10);}
    .topicHandler{flex-basis:9.6rem;border-left:0;.border-top-left-radius(0);.border-bottom-left-radius(0)}
  }
  .g-addQuestionRow{
    .g-chooseBox{.marginRight(15,980);}
  }
  .g-QNSetFooter{.marginTop(20);
    .g-QRSetMust{.fontSize(14);color:@normalColor;
      span{color:@buttonActive;}
      &.el-checkbox__input{margin-right:2%;}
    }
    .g-optionNum{margin-right:20/16rem;margin-left:20/16rem;
      .g-courseNum{margin:0 15/16rem;}
    }
  }
  /*操作图标*/
  .g-QNHandlerContainer{
    padding:7/16rem 12/16rem;border:1px solid @borderColor;.border-radius(4/16rem);background:#fff;
    span{display:inline-block;.widthRem(20);.height(20);font-weight:bold;
      &:hover{cursor:pointer;}
      &:hover:before{color:@buttonActive;}
    }
    span:not(:first-of-type){margin-left:7/16rem;}
  }
  /*弹框*/
  .g-hasHeightTextarea{.NotLineheight(300);overflow-x:hidden;overflow-y:auto;}
  .g-prompt>div{text-align:left;}
  .g-prompt>div:first-of-type{margin:15/16rem 0;.fontSize(15);}
</style>


