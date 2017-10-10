/**
 * Created by wqq on 2017/6/20.
 */
const CommitChangeUser=({commit},payload)=>{
  commit('changeUser',payload);
};
const initNavAction=({commit},payload)=>{
  commit('initNavMutation',payload);
};
export {CommitChangeUser,initNavAction}

