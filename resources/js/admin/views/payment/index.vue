<template>
    <div>
      <div class="breadcrumbs">
          <el-breadcrumb separator="/">
              <el-breadcrumb-item :to="{ path: '/dashboard' }">首頁</el-breadcrumb-item>
              <el-breadcrumb-item>付款設定</el-breadcrumb-item>
          </el-breadcrumb>
      </div>
        <div class="main">
          <div class="flex">
            <h2>付款設定</h2>
            <router-link to="/payment/create"><el-button>新增</el-button></router-link>
          </div>
          <el-table :data="list">
            <el-table-column fixed type="selection" width="55" />
            <el-table-column label="狀態" width="60">
              <template slot-scope="scope">
                <el-switch
                  v-model="scope.row.state"
                  active-color="#13ce66"
                  inactive-color="#ff4949">
                </el-switch>
              </template>
            </el-table-column>
            <el-table-column property="name" label="名稱" width="auto"></el-table-column>
            <el-table-column property="method" label="付款方式" width="auto"></el-table-column>
            <el-table-column  label="排序" width="80">
              <template slot-scope="scope">
                <el-input number v-model="scope.row.sort" size="small" />
              </template>
            </el-table-column>
            <el-table-column  width="auto">
              <template>
                <el-button @click="gotoCreate">管理</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
    </div>
</template>

<script>
export default {
  head:{
    title:"付款設定"
  },
  data:function(){
    return {
      list:[
        {
          state:true,
          name:"第一種方法",
          method:"信用卡(綠界科技)",
          sort:"1"
        }
      ]
    }
  },
  methods:{
    gotoCreate:function(){
      this.$router.push('/payment/create');
    }
  }
}
</script>

<style>
  .options{
    padding:12px;
  }
</style>
