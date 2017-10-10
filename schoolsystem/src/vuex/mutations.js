/**
 * Created by wqq on 2017/6/20.
 */
const changeUser=(state,payload)=>{
  state.userInfo=payload.userInfo;
};
const initNavMutation=(state,payload)=>{
  state.NavInfo=payload.NavInfo;
};
/*修改当前排课方案信息*/
const changeArrangeClasses=(state,payload)=>{
  state.theArrangeClasses=payload.name;
  state.pkListId=payload.id
};

export {changeUser,initNavMutation,changeArrangeClasses}
