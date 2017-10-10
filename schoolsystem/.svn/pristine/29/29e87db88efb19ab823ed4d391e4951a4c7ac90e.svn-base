<template>
  <div id='myDiv'>
    <h1 v-text='psw'></h1>
    <input type='checkbox' v-model='a' v-bind:true-value='box' />
  </div>
</template>
<script>
import $ from 'jquery'
export default{
  data(){
    return{
      psw:'123',
      a:'',
      box:''
    }
  },
  watch:{
    a(newValue){console.log(newValue)}
  },
  methods:{},
  created(){
    $(window).on('load',function(){
      $('#myDiv').mCustomScrollbar();
    });
  }
}
</script>
<style lang='less' scoped>
  div{width:100px;height:100px;overflow:auto;border:1px solid red;}
  h1{width:100px;height:200px;}
</style>


