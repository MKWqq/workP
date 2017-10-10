<template>
  <div class="g-container">
    <header class="g-textHeader g-flexStartRow">
      <el-button @click="goBackParent" class="g-gobackChart g-imgContainer RedButton">
        <img src="../../../../assets/img/commonImg/icon_return.png" />
        返回
      </el-button>
      <span class="selfCenter" v-text="headerText[id]"></span>
    </header>
    <section>
      <div class="g-QNSetContainer" v-for="(content,index) in QuestionNaireForm.QNArray">
        <div v-if="content.type==0" class="g-singleTopic">
          <!--单选题-->
          <div class="g-QNSetTopicContainer g-liOneRow">
            <h2 v-text="'Q'+(index+1)+':'"></h2>
            <div class="g-QNSetContent selfSpace">
              <h2 v-text="content.title"></h2>
              <div class="g-addQuestion">
                <div class="g-addQuestionRow g-liOneRow" v-for="(question,qIndex) in content.QNSetting">
                  <el-radio v-model="question.isChoose" class="selfCenter g-chooseBox" disabled>{{question.value}}</el-radio>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="content.type==1" class="g-multipleChoose">
          <!--多选题-->
          <div class="g-QNSetTopicContainer g-liOneRow">
            <h2 v-text="'Q'+(index+1)+':'"></h2>
            <div class="g-QNSetContent selfSpace">
              <h2 v-text="content.title"></h2>
              <div class="g-addQuestion g-checkboxMore">
                <div class="g-addQuestionRow g-flexStartWrapRow">
                  <el-checkbox v-for="(question,qIndex) in content.QNSetting" :key="qIndex" v-model="question.isChoose" class="selfCenter g-chooseBox g-checkbox" disabled>{{question.value}}</el-checkbox>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="content.type==2" class="g-fillInBlank">
          <!--填空题-->
          <div class="g-QNSetTopicContainer g-liOneRow">
            <h2 v-text="'Q'+(index+1)+':'"></h2>
            <div class="g-QNSetContent selfSpace">
              <h2 v-text="content.title"></h2>
              <div class="g-addQuestion">
                <div class="g-addQuestionRow g-liOneRow">
                  <span>答:</span>
                  <el-input v-model="content.QNSetting.value" disabled placeholder=""></el-input>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="content.type==3" class="g-scoresTopic">
          <!--分数题-->
          <div class="g-QNSetTopicContainer g-liOneRow">
            <h2 v-text="'Q'+(index+1)+':'"></h2>
            <div class="g-QNSetContent selfSpace">
              <h2 v-text="content.title"></h2>
              <div class="g-addQuestion">
                <div class="g-addQuestionRow g-liOneRow">
                  <span>答:</span>
                  <el-input v-model="content.QNSetting.value" disabled placeholder=""></el-input>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="content.type==4" class="g-paragraphDescript">
          <!--段落说明-->
          <div class="g-QNSetTopicContainer g-liOneRow">
            <div class="g-QNParagraph selfSpace">
              <div class="g-addQuestion">
                <div class="g-addQuestionRow g-liOneRow">
                  <p class='g-paragraphContent' v-text="content.description"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
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
        headerText:['预览问卷','查看问卷','查看答案'],
        /*路由参数*/
        id:'',
        /*问卷题目设置*/
        QuestionNaireForm:{
          title:'',
          description:'',
          /*单选多选题等数据总和*/
          QNArray:[
            /*0为单选题，依次往下*/
            {
              type:'0',
              title:'radio',
              QNSetting:[
                {
                  isChoose:false,
                  value:'qq',//选项值
                },
                {
                  isChoose:false,
                  value:'qq',//选项值
                },
              ]
            },{
              type:'1',
              title:'',
              QNSetting:[
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
                {
                  isChoose:false,
                  value:'ww',//选项值
                },
              ]
            },{
              type:'2',
              title:'',
              QNSetting:{
                value:'',//选项值
              },
            },
            {
              type:'3',
              title:'',
              QNSetting:{
                value:'',//选项值
              },
            },{
              type:'4',
              description:'123',
            }
          ],
        },
      }
    },
    methods:{
      goBackParent(){
        if(this.id==0){
          this.$router.push('/questionNaireRecord');
        }
        else if(this.id==1){
          this.$router.push('/questionNaireStatistic');
        }
        else if(this.id==2){
          this.$router.push('/fillInTask');
        }
      },
    },
    created(){
      this.id=this.$route.params.id;
    }
  }
</script>
<style lang="less" scoped>
  @import '../../../../style/style';
  .g-container{
    header.g-textHeader{border:none;padding-bottom:70/16rem;
      span{.fontSize(19);color:@HColor;.marginLeft(40,1582);}
    }
    section{/*1105*/
      .width(1105,1582);margin:0 auto;
    }
    .g-footer{width:100%;}
  }

  .g-QNSetContainer{padding:20/16rem 32/16rem;}
  .g-QNSetContainer h2{margin-right:2%;}
  /*段落说明容器*/
  .g-QNParagraph{background:#fff;}
  .g-QNParagraph .g-addQuestion{padding-top:0;padding-bottom:0;}
  /*设置单选题内容容器*/
  .g-QNSetTopicContainer{padding-right:2rem;}
  .g-addQuestion{/*比例*/
    width:100%;padding:20/16rem 0;
    .g-addQuestionRow:not(:first-of-type){.marginTop(15);}
    .topicHandler{flex-basis:9.6rem;border-left:0;.border-top-left-radius(0);.border-bottom-left-radius(0)}
    &.g-checkboxMore{width:40%;}
  }
  .g-addQuestionRow{
    .g-chooseBox{margin-right:1rem;}
    .g-checkbox{margin-bottom:15/16rem;}
    span{margin-right:15/16rem;}
    p.g-paragraphContent{padding:15/16rem 20/16rem;width:100%;background:@backgroundBlueOpacity;}
  }

  .g-container .g-questionNaire{/*1000*/
    .width(1000,1582);margin:30/16rem auto;
    &>header.g-textHeader{.marginBottom(30);}
    &>header.g-textHeader h2{text-align:center;.fontSize(24);}
    .g-prompt{padding:10/16rem 0;}
  }
</style>




