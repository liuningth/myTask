<template>
    <div class="login-container">
        <el-form :model="ruleForm2" :rules="rules2"
         status-icon
         ref="ruleForm2" 
         label-position="left" 
         label-width="0px" 
         class="demo-ruleForm login-page">
            <h3 class="title">系统登录</h3>
            <el-form-item prop="userAccount">
                <el-input type="text" 
                    v-model="ruleForm2.name" 
                    auto-complete="off" 
                    placeholder="账号"
                ></el-input>
            </el-form-item>
                <el-form-item prop="userPassword">
                    <el-input type="password" 
                        v-model="ruleForm2.pass" 
                        auto-complete="off" 
                        placeholder="密码"
                    ></el-input>
                </el-form-item>
            <!-- <el-checkbox 
                v-model="checked"
                class="rememberme"
            >记住密码</el-checkbox> -->
            <el-form-item style="width:100%;">
                <el-button type="primary" style="width:100%;" @click="handleSubmit" :loading="logining">登录</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            logining: false,
            ruleForm2: {
                name: '',
                pass: '',
            },
            rules2: {
                name: [{required: true, message: 'please enter your account', trigger: 'blur'}],
                pass: [{required: true, message: 'enter your password', trigger: 'blur'}]
            },
            checked: false
        }
    },
    methods: {
        handleSubmit(event){
            console.log(event)
            this.$refs.ruleForm2.validate((valid) => {
                if(valid){
                    this.logining = true;
                    if(this.ruleForm2.name && this.ruleForm2.pass) {
                        this.$http.post('/login ', this.ruleForm2).then(res => {
                            this.$message({
                                message: '登录成功',
                                type: 'success'
                            });
                            this.logining = false;
                            localStorage.setItem('userID', res.data.id)
                            this.$router.push({path: '/'});
                        }).catch(() => {
                            this.logining = false;
                        })
                    }else{
                        this.logining = false;
                        this.$alert('username or password wrong!', 'info', {
                            confirmButtonText: 'ok'
                        })
                    }
                }else{
                    this.logining = false;
                    console.log('error submit!');
                    return false;
                }
            })
        }
    }
};
</script>

<style >
/* html /deep/ body {
    height: auto !important;
} */
.login-container {
    width: 100%;
    height: 100%;
}
.login-page {
    -webkit-border-radius: 5px;
    border-radius: 5px;
    margin: 180px auto;
    width: 350px;
    padding: 35px 35px 15px;
    background: #fff;
    border: 1px solid #eaeaea;
    box-shadow: 0 0 25px #cac6c6;
}
label.el-checkbox.rememberme {
    margin: 0px 0px 15px;
    text-align: left;
}
</style>