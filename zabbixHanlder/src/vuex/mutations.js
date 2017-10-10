/**
 * Created by wqq on 2017/3/17.
 */
export default {
  changSee(state){
    state.NotSeePwd=!state.NotSeePwd;
    state.inputType=!state.inputType;
    window.setTimeout (function(){$(".userPwd input").focus();},0);
  }
}











