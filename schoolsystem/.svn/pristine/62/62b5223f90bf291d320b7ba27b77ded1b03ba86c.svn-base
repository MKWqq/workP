<template>
  <div>
    <router-link @click='a' tag='li' to='loginChild' events>{{count}}</router-link>
    <router-view></router-view>
    <!--<ueditor></ueditor>-->
    <input type='text' v-model='searchQuery' />
    <div id="homeCalendar" style="width:500px;height:500px;"></div>
    <fuzzyQuery :data='gridData' :columns='gridColumns' :filter-key='searchQuery'></fuzzyQuery>
  </div>
</template>
<script>
import {mapState,mapActions} from 'vuex'
import {loginHTTP} from '@/api/http'
import ueditor from '@/components/ueditor.vue'
import fuzzyQuery from '@/components/FuzzyQuery.vue'
export default{
  data(){
    return{
      user:'0',
      editor:null,
      searchQuery: '',
      gridColumns: ['name', 'power'],
      gridData: [
        { name: 'Chuck Norris', power: Infinity },
        { name: 'Bruce Lee', power: 9000 },
        { name: 'Jackie Chan', power: 7000 },
        { name: 'Jet Li', power: 8000 }
      ]
    }
  },
  components:{ueditor,fuzzyQuery},
  computed:{
    ...mapState({
           count:state=>state.userName,
           getCounPlu(state){
             return state.userName+this.user
           }
         })
  },
  methods:{
    //...mapActions(['CommitChangeUser']),
    a(){
      alert(1);
    }
  },
  created(){
    this.$store.dispatch('CommitChangeUser');
    //this.CommitChangeUser();
  }
}
</script>
<style lang='less' scoped>
  @import '../style/common.less';
</style>




