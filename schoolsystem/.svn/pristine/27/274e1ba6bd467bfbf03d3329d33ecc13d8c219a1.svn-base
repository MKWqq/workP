<template>
  <div class="printCenter">
    <router-view></router-view>
  </div>
</template>
<script>
    export default{
        data(){
            return {}
        },
        methods: {}
    }
</script>
<style>
  .printCenter {
    padding: 1.25rem 2rem;
    box-shadow: 0 0.1875rem 0.375rem 0.125rem rgba(0, 0, 0, 0.2);
    border-radius: .5rem;
    margin: 1.25rem 0;
    background-color: #fff;
  }

  .printCenter h3 {
    font-size: 1.25rem;
  }

  .printCenter .printCenter_row {
    margin-top: 3.125rem;
  }
  .printCenter .printCenter_row_sec {
    margin: 2.25rem 0 1.5rem 0;
  }
  .printCenter .printCenter_row_thd {
    margin: 1.25rem 0;
  }

  .printCenter .exam_subTitle {
    display: inline-block;
    padding:.3rem 1.25rem;
    border-radius: 0 20px 20px 0;
    -webkit-box-shadow: 0 5px 5px 0 #ddd;
    -moz-box-shadow: 0 5px 5px 0 #ddd;
    box-shadow: 0 5px 5px 0 #ddd;
    background-color: #89bcf5;
    border-color: #89bcf5;
    color: #fff;
    text-align: center;
  }
  .printCenter .templateList{
    float: left;
    width:10rem;
  }
  .printCenter .templateList+.templateList{
    margin-left:3.3rem;
  }
  .printCenter .templateList_bg{
    color: #fff;
    position: relative;
  }
  .printCenter .templateList_bg>span{
    position: absolute;
    bottom:0;
    left:0;
    margin:.5rem;
    z-index:1;
  }
  .printCenter .templateList_bg img{
    width:100%;
  }
  .printCenter .templateList_txt{
    text-align: center;
    margin-top: 1.25rem;
  }
  .printCenter .templateList_txt p{
    margin:.75rem 0;
  }
  .printCenter .layTypeAll{
    font-size:.875rem;
  }
  .printCenter .maskLayer{
    display: none;
    position: absolute;
    z-index:2;
    width:100%;
    height:100%;
    background: rgba(0,0,0,.5);
    top:0;
    left:0;
  }
  .printCenter .templateList_bg:hover .maskLayer{
    display: block;
  }
  .printCenter .maskLayer>div{
    width:6rem;
    position: absolute;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    -o-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    font-size:0;
  }
  .printCenter .maskLayer span{
    width:48%;
    font-size:.875rem;
    text-align: center;
    display: inline-block;
    background-color: #40bae3;
    padding:.2rem 0;
    cursor: pointer;
  }
  .printCenter .maskLayer span+span{
    margin-left:4%;
  }
</style>
