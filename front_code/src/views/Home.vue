<template>
  <div class="home">
    <div style="margin: 0 auto;text-align: center">
      <el-button type="primary" plain @click="dialogFormVisibleAdd = true">添加</el-button>
    </div>
    <table class="table table-bordered" style="width: 80%;margin: 20px auto">
      <thead>
        <tr>
          <th>序号</th>
          <th>名称</th>
          <th>SKU</th>
          <th>照片</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in list" :key="index">
          <td>{{ index+1 }}</td>
          <td>{{item.name}}</td>
          <td>{{item.sku}}</td>
          <td>
            <img :src="item.image" alt="" style="height: 50px">
          </td>
          <td>
            <el-button type="primary" icon="el-icon-edit" circle @click="edit(item.id)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="del(item.id)"></el-button>
          </td>
        </tr>
      </tbody>
    </table>
    <div style="margin: 0 auto; text-align: center">
      <el-pagination
        background
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="添加" :visible.sync="dialogFormVisibleAdd">
      <el-form :model="formAdd">
        <el-form-item label="产品名称" :label-width="formLabelWidth">
          <el-input v-model="formAdd.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="产品图片" :label-width="formLabelWidth">
          <el-upload
            style="width: 400px"
            class="no-print upload-demo"
            drag
            action="/api/uploadImage"
            multiple
            name="image"
            accept="image/*"
            :before-upload="beforeUpload"
            :on-success="successFile"
            :on-error="errorUpload">
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            <div class="el-upload__tip" slot="tip">只能上传jpg/jpeg/png文件</div>
          </el-upload>
        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisibleAdd = false">取 消</el-button>
        <el-button type="primary" @click="addSubmit">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog title="编辑" :visible.sync="dialogFormVisibleEdit">
      <el-form :model="formEdit">
        <el-form-item label="产品名称" :label-width="formLabelWidth">
          <el-input v-model="formEdit.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="产品图片" :label-width="formLabelWidth">
          <el-upload
            style="width: 400px"
            class="no-print upload-demo"
            drag
            action="/api/uploadImage"
            multiple
            name="image"
            accept="image/*"
            :before-upload="beforeUpload"
            :on-success="successFile"
            :on-error="errorUpload">
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            <div class="el-upload__tip" slot="tip">只能上传jpg/jpeg/png文件</div>
          </el-upload>
        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisibleEdit = false">取 消</el-button>
        <el-button type="primary" @click="editSubmit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { Loading } from 'element-ui';

export default {
  name: 'Home',
  data() {
    return {
      list: [],
      total: 0,

      loading: '',

      dialogFormVisibleAdd: false,
      dialogFormVisibleEdit: false,
      formAdd: {
          name: '',
          image: ''
      },
      formEdit: {
          name: '',
      },
      formLabelWidth: '120px'
    }
  },

  created() {
    this.getListData()
  },

  methods: {
    // 上传之前
    beforeUpload(file) {
      this.openFullScreen()
        console.log(file)
        const testmsg = file.name.substring(file.name.lastIndexOf('.')+1)
        console.log(testmsg)
        const extension = testmsg === 'jpg' || testmsg === 'jpeg' || testmsg === 'png'
        if(!extension) {
            this.$message({
                message: '上传文件只能是jpg、jpeg、png格式',
                type: 'warning'
            });
        }
        return extension
    },

    // 上传失败
    errorUpload(err) {
        this.$message({
            message: '上传失败',
            type: 'error'
        });
        this.closeFullScreen()
        return err
    },

    successFile(result) {
        console.log(result)
        if(result.code == 200) {
            this.formAdd.image = result.data
            this.formEdit.image = result.data
            this.$message({
              message: result.msg,
              type: 'success'
            });
        }
        else if(result.code == 422222) {
            this.$message({
                message: '身份过期请重新登录',
                type: 'error'
            });
            setTimeout(() => {
                localStorage.clear()
                this.$router.push({ name: 'login' })
            }, 1500)
        }
        else {
            this.$message({
                message: result.msg || '上传失败',
                type: 'error'
            });
        }
        this.closeFullScreen()
    },

    getListData() {
      this.openFullScreen()
      this.$http.get('/product/list').then(res => {
        this.list = res.data.data
        this.total = res.data.total
        this.closeFullScreen()
      })

    },

    addSubmit() {
      this.openFullScreen()
      this.$http.post('/product/create', this.formAdd).then(res => {
        console.log(res)
        this.formAdd = {
          name: '',
          image: ''
        }
        this.$message({
          message: '添加成功',
          type: 'success'
        });
        this.dialogFormVisibleAdd = false
        this.getListData()
        this.closeFullScreen()
      })
      .catch(() => {
        this.closeFullScreen()
      })
    },

    edit(id) {
      this.dialogFormVisibleEdit = true
      this.$http.get('/product/details', {id}).then(res => {
        this.formEdit = res.data
      })
    },

    editSubmit() {
      this.openFullScreen()
      this.$http.post('/product/edit', this.formEdit).then(res => {
        console.log(res)
        this.formEdit = {
          name: '',
          image: ''
        }
        this.$message({
          message: '修改成功',
          type: 'success'
        });
        this.dialogFormVisibleEdit = false
        this.getListData()
        this.closeFullScreen()
      })
    },

    del(id) {
      this.$confirm('确认删除？')
      .then(() => {
          this.$http.post('/product/delete', {id}).then(res => {
              this.$message({
                  message: res.msg,
                  type: 'success'
              });
              this.getListData()
          })
      })
      .catch(() => {
          console.log('取消了')
      });
    },

    // 打开加载动画
    openFullScreen() {
      this.loading = Loading.service({
          lock: true,
          text: 'Loading',
          spinner: 'el-icon-loading',
          background: 'rgba(0, 0, 0, 0.7)'
      });
    },
    // 关闭加载动画
    closeFullScreen() {
      this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
        if(this.loading) {
          this.loading.close();
        }
        // state.loading = ''
      });
    },
  }
}
</script>
