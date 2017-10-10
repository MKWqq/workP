<template>
<div id='App' :style="{height:AppHeight+'px'}">
  <div id='Header'>
    <div class='Header_Logo'>
      <p>OPTION MANAGEMENT</p>
    </div>
    <div class='Header_Con'>
      <div class='Header_Img'>
        <img src='../../assets/img/general/icon_home_normal.png' @click="$router.push({name:'loginSuccess'})" />
      </div>
      <div class='Header_Img'>
        <img src='../../assets/img/general/icon_logout_normal.png' />
      </div>
      <div class='Header_Choose'>
        <NavComponent class='nav'></NavComponent>
      </div>
    </div>
  </div>
  <div id='Main'>
    <div class='Main_Nav'></div>
    <div class='Main_Con'></div>
  </div>
</div>
</template>
<script>
import $ from 'jquery'
import {mapActions,mapState,mapMutations} from 'vuex'
import {CheckedLoginHTTP} from '../../api/http'
import NavComponent from '../../components/hello'
export default{
  data(){
    return {}
  },
  computed:mapState(['AppHeight']),
  components:{'NavComponent':NavComponent},
  methods:{
    //...mapActions()
  },
  beforeCreate(){
    console.log(this.$route.path);
    CheckedLoginHTTP().then(data=>{
      if(!data.logincheck){
        this.$router.push({name:'loginStart'});
      }
    });
  },
  created(){}
}
</script>
<style lang='less' scoped>
  @import '../../style/yunwei/content.less';
</style>








