process.env.BASE_API = 'http://localhost:3000'

import axios from 'axios'
// import store from '@/store'
import { Message  } from 'element-ui'
import router from '../router'

// import qs from 'qs'

const CancelToken = axios.CancelToken
// let cancel;
var service=axios.create({
    baseURL:'/api',
    timeout:5000
})



//添加请求拦截器
service.interceptors.request.use(function(config){
    
    return config
},function(error){
    return Promise.reject(error)
})
//添加响应拦截器
service.interceptors.response.use(function(response){
   /**
   * 下面的注释为通过在response里，自定义code来标示请求状态
   * 当code返回如下情况则说明权限有问题，登出并返回到登录页
   * 如想通过xmlhttprequest来状态码标识 逻辑可写在下面error中
   */
  // response => {
  //   const res = response.data
  //   if (res.code !== 20000) {
  //     })
  //     // 50008:非法的token; 50012:其他客户端登录了;  50014:Token 过期了;
  //     if (res.code === 50008 || res.code === 50012 || res.code === 50014) {
  //       }).then(() => {
  //         })
  //       })
  //     }
  //     return Promise.reject('error')
  //   } else {
  //     return response.data
  //   }
  // },
    return response
},function(error){
    console.log('err'+error)
    // store.commit('closeFullScreen')
    Message({
        message: '系统错误',
        type:'error',
        duration:5*1000 
    })
    return Promise.reject(error)
}
)
export default {
    //get请求
    get(url,param){
        // 打开加载动画
        // store.commit('openFullScreen')
        return new Promise((resolve, reject)=>{
            service({
                method:'get',
                url,
                params:param,
                headers: {
                    authorization: localStorage.getItem('token')
                },
                cancelToken:new CancelToken(c=>{
                    return c
                    // cancel=c
                    // console.log(c)
                })
            }).then(res=>{  //axios返回的是一个promise对象
                // console.log(res)
                if(res.status == 200 && res.data.code == 200) {
                    resolve(res.data)  //resolve在promise执行器内部 
                } 
                else if(res.status == 200 && res.data.code == 201) {
                    Message({
                        message: '非法访问错误',
                        type:'error'
                    })
                    router.push({ name: '404' })
                } 
                else if(res.data.code == 422222) {
                    Message({
                        message: '身份过期请重新登录',
                        type:'error'
                    })
                    setTimeout(() => {
                        localStorage.clear()
                        router.push({ name: 'login' })
                    }, 1500)
                   
                }
                else {
                    Message({
                        message: res.data.msg || '系统错误',
                        type:'error',
                        duration:5*1000 
                    })
                    reject()
                }
                // return store.commit('closeFullScreen')
            }).catch(err=>{
                console.log(err,'异常')
            })

        })
    },
    //post请求
    post(url,param){
        return new Promise((resolve, reject)=>{
            service({
                method:'post',
                url,
                // data: qs.stringify(param),
                data: param,
                headers: {
                    ContentType: 'application/x-www-form-urlencoded',
                    authorization: localStorage.getItem('token')
                },
                cancelToken:new CancelToken(c=>{
                    // cancel = c
                    console.log(c)
                })
            }).then(res=>{
                // console.log(res)
                if(res.status == 200 && res.data.code == 200) {
                    resolve(res.data)  //resolve在promise执行器内部 
                } 
                else {
                    Message({
                        message: res.data.msg || '系统错误',
                        type:'error',
                        duration:5*1000 
                    })
                    reject()
                }
                // store.commit('closeFullScreen')
            }).catch(err=>{
                console.log(err,'异常')
            })
        })
    }
}
// export default service