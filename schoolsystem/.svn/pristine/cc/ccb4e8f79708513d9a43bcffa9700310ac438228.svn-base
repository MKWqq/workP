import pinyin from 'chinese-to-pinyin'
const fuzzyQuery=(input,arrTarget)=>{
  /*处理input框数据,如果是中文转为拼音*/
  input=toPinyin(input).replace(/ /g,'').toLocaleLowerCase();
  return arrTarget.filter((valueObj,index,arr)=>{
    /*判断数组的成分类型*/
    if(valueObj instanceof Object){
      for(let keys in valueObj){
        /*处理每条数据,中文转为拼音*/
        const filterArr=toPinyin(valueObj[keys]).toLocaleLowerCase();
        /*全拼若匹配则返回数据*/
        if(filterMsg(input,filterArr.replace(/ /g,''))>-1){
          return true;
        }else{
          /*全拼不匹配,如果是中文则匹配首字母*/
          let firstMsg=filterArr.split(' ').reduce((prev,next,index,arr)=>{
            return prev.slice(0,1).concat(next.slice(0,1));
          });
          if(filterMsg(input,firstMsg)>-1){
            return true;
          }
        }
      }
    }
  });
};
const toPinyin=(value)=>{
  if(!/^[0-9a-zA-Z]*$/.test(value)){
    value=pinyin(value,{noTone:true,filterChinese:true});
  }
  return value;
};
const filterMsg=(input,arrMsg)=>{
  return arrMsg.indexOf(input);
};
export {fuzzyQuery}




