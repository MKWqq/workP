/**
 * Created by wqq on 2017/3/17.
 */
import {CheckedLoginHTTP} from '../api/http'
const CheckLogin=(state)=>{
  CheckedLoginHTTP().then(data=>{
    if(!data.logincheck){
      //this.$router.push({name:'loginStart'});
      state.userName='';
    }else{
      state.userName=data.user;
    }
  });
}
export {CheckLogin}











