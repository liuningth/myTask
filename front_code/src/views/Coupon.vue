<template>
  <div class="about">
    <div style="margin: 0 auto;text-align: center">
      <el-button type="primary" plain @click="dialogFormVisibleAdd = true">添加</el-button>
    </div>
    <table class="table table-bordered" style="width: 80%;margin: 20px auto">
      <thead>
        <tr>
          <th>序号</th>
          <th>金额</th>
          <th>开始日期</th>
          <th>结束日期</th>
          <th>使用产品</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in list" :key="index">
          <td>{{ index+1 }}</td>
          <td>{{item.money}}</td>
          <td>{{item.start_time}}</td>
          <td>{{item.end_time}}</td>
          <td>{{item.products}}</td>
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
        <el-form-item label="金额" :label-width="formLabelWidth">
          <el-input v-model="formAdd.money" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="开始日期" :label-width="formLabelWidth">
          <el-date-picker
            v-model="formAdd.start_time"
            type="datetime"
            placeholder="选择日期时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="结束日期" :label-width="formLabelWidth">
          <el-date-picker
            v-model="formAdd.end_time"
            type="datetime"
            placeholder="选择日期时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="选择使用产品" :label-width="formLabelWidth">
          <el-select v-model="formAdd.products" multiple placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.id"
              :label="item.name"
              :value="item.id">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisibleAdd = false">取 消</el-button>
        <el-button type="primary" @click="addSubmit">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog title="编辑" :visible.sync="dialogFormVisibleEdit">
      <el-form :model="formEdit">
        <el-form-item label="金额" :label-width="formLabelWidth">
          <el-input v-model="formEdit.money" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="开始日期" :label-width="formLabelWidth">
          <el-date-picker
            v-model="formEdit.start_time"
            type="datetime"
            placeholder="选择日期时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="结束日期" :label-width="formLabelWidth">
          <el-date-picker
            v-model="formEdit.end_time"
            type="datetime"
            placeholder="选择日期时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="选择使用产品" :label-width="formLabelWidth">
          <el-select v-model="formEdit.products" multiple placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.id"
              :label="item.name"
              :value="item.id">
            </el-option>
          </el-select>
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
  name: 'coupon',
  data() {
    return {
      list: [],
      total: 0,

      loading: '',

      options: [],

      dialogFormVisibleAdd: false,
      dialogFormVisibleEdit: false,
      formAdd: {
        money: '',
        start_time: '',
        end_time: '',
        products: '',
        admin_id: '',
      },
      formEdit: {
        money: '',
        start_time: '',
        end_time: '',
        products: '',
      },
      formLabelWidth: '120px'
    }
  },

  created() {
    this.formAdd.admin_id = localStorage.getItem('userID') || 1
    this.getListData()
    this.getProduct()
  },

  methods: {
    getListData() {
      this.openFullScreen()
      this.$http.get('/coupon/list').then(res => {
        this.list = res.data.data
        this.total = res.data.total
        this.closeFullScreen()
      })
    },

    getProduct() {
      this.$http.get('/coupon/productList').then(res => {
        this.options = res.data
      })
    },

    addSubmit() {
      this.openFullScreen()
      this.$http.post('/coupon/create', this.formAdd).then(res => {
        console.log(res)
        this.formAdd = {
          money: '',
          start_time: '',
          end_time: '',
          products: '',
          admin_id: '',
        }
        this.$message({
          message: '添加成功',
          type: 'success'
        });
        this.dialogFormVisibleAdd = false
        this.getListData()
        this.closeFullScreen()
      })
    },

    edit(id) {
      this.dialogFormVisibleEdit = true
      this.$http.get('/coupon/details', {id}).then(res => {
        this.formEdit = res.data
      })
    },

    editSubmit() {
      this.openFullScreen()
      this.$http.post('/coupon/edit', this.formEdit).then(res => {
        console.log(res)
        this.formEdit = {
          money: '',
          start_time: '',
          end_time: '',
          products: '',
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
          this.$http.post('/coupon/delete', {id}).then(res => {
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

