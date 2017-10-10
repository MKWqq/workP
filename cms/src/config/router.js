export default {
  routes:[
    {
      path:'/',
      //component:require('../page/yunwei/content.vue')
      redirect:'/login/loginStart'
    },
    {
      path:"/login",
      component:require('../page/login/login.vue'),
      children:[
        {
          path:"loginStart",
          name:"loginStart",
          component:require('../page/login/login_start.vue')
        },
        {
          path:"loginSuccess",
          name:"loginSuccess",
          component:require("../page/login/login_success.vue")
        },
        {
          path:"loginModifyPwd",
          name:"loginModifyPwd",
          component:require("../page/login/login_modifyPwd.vue")
        },
        {
          path:"loginAbout",
          name:"loginAbout",
          component:require("../page/login/login_about.vue")
        }
      ]
    },
    {
      path:"/content",
      name:'content',
      component:require('../page/yunwei/content.vue')
    }
  ]}

/*  router.map({
    '/':{name:'index',component:require('../page/login.vue')},
    '/content':{name:'content',component:require('../page/content.vue')}
  });*/


