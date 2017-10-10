import $ from 'jquery'

/*checked*/
export const CheckedLoginHTTP=params=>{return $.ajax({url:'http://171.221.202.190:11111/cms/index.php/logincheck/logintest',type:'get',data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)};
/*login*/
export const LoginHTTP=params=>{return $.ajax({url:'http://171.221.202.190:11111/cms/index.php/login/login/',type:'get',data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)};
export const LoginOutHTTP=params=>{return $.ajax({url:'http://171.221.202.190:11111/cms/index.php/login/loginout/',type:'get',dataType:'jsonp',jsonp:'cb'}).then(data=>data)};
export const UpdateLoginHTTP=params=>{return $.ajax({url:'http://171.221.202.190:11111/cms/index.php/password/update',type:'get',data:params,dataType:'jsonp',jsonp:'cb'}).then(data=>data)};


