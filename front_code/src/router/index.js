import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/Coupon',
    name: 'Coupon',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Coupon.vue')
  },
  {
    path: '/Login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "about" */ '../views/Login.vue')
  },
]



const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

// 全局路由守卫
router.beforeEach((to, from, next) => {
  // console.log(to,from)
  next();
  // return 
  // to: Route: 即将要进入的目标 路由对象
  // from: Route: 当前导航正要离开的路由
  // next: Function: 一定要调用该方法来 resolve 这个钩子。执行效果依赖 next 方法的调用参数。

  let isLogin = localStorage.getItem('userID');  // 是否登录
  // console.log(isLogin)
  // 未登录状态；当路由到nextRoute指定页时，跳转至login
  
  // 已登录状态；当路由到login时，跳转至home 
  if (to.name === 'Login') {
    if (isLogin) {
      router.push({ name: 'Home' });
    }
  }
  else {
    if (!isLogin) {
      // console.log('what fuck');
      router.push({ name: 'Login' })
    }
  }
  next();
});

export default router
