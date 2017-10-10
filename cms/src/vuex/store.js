/**
 * Created by wqq on 2017/3/17.
 */
import Vue from "vue"
import Vuex from "vuex"
import * as actions from "./actions"
import * as mutations from './mutations'
/*console.log(mutations)*/
import $ from 'jquery'
Vue.use(Vuex);
const state={
  userName:'',
  AppHeight:$(window).height()
};
/*const mutations={
  defaultPsw(state){
    state.psw='12121';
  }
};*/
export default new Vuex.Store({
  state,
  mutations,
  actions
})







