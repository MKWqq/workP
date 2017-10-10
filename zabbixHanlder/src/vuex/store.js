/**
 * Created by wqq on 2017/3/17.
 */
import Vue from "vue"
import Vuex from "vuex"
import actions from "./actions"
import mutations from "./mutations"
Vue.use(Vuex);
const state={
  loginState:{
    loginStart:{
      inputType:true,
      NotSeePwd:true},
    loginSuccess:{},
    loginModdify:{}
  }
};
export default new Vuex.Store({
  state,
  mutations,
  actions
})







