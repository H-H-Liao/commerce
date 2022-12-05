<template>
    <div>
        <div class="breadcrumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首頁</el-breadcrumb-item>
                <el-breadcrumb-item>訂單列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="main">

        <el-table
                ref="multipleTableRef"
                :data="list"
                stripe
            >
                <el-table-column type="expand">
                <template slot-scope="props">
                    <div class="product_list">
                    <el-table
                        :data="props.row.product_list"
                        :show-header="true"
                        title="商品"
                    >
                        <el-table-column label="商品照片"  width="100">
                            <template #default="scope">
                                <img class="product_image" :src="scope.row.image_url">
                            </template>
                        </el-table-column>
                        <el-table-column  label="商品名稱" property="name"  width="120" />

                        <el-table-column  label="規格" property="spec" width="120" />
                        <el-table-column label="數量" property="amount"  width="120" />
                        <el-table-column  label="單價" property="price" width="120" />
                        <el-table-column  label="成本" property="cost" width="120" />
                        <el-table-column  label="利潤率"  width="120" >
                        <template slot-scope="scope">
                            <div>{{ scope.row.rate }}%</div>
                        </template>
                        </el-table-column>
                        <el-table-column label="小計" property="sum"   />
                    </el-table>
                    </div>
                </template>
                </el-table-column>
                <el-table-column  property="number" label="訂單號碼" width="150" />
                <el-table-column  property="date" label="訂單日期" width="120" />
                <el-table-column  property="order_state" label="訂單狀態" width="120" />
                <el-table-column  property="payment_state" label="付款狀態" width="120" />
                <el-table-column  property="deliver_state" label="送貨狀態" width="120" />
                <el-table-column  property="order_buyer" label="訂購人" width="120" />
                <el-table-column  property="sum" label="金額" width="120" />
                <el-table-column  property="sum" label="運費" width="120" />
                <el-table-column  width="50" label="備註" >
                <template slot-scope="scope">
                    <el-tooltip class="item" effect="dark" :content="scope.row.memo" placement="bottom">
                    <div class="memo_text">明細</div>
                    </el-tooltip>
                </template>
                </el-table-column>
                <el-table-column fixed="right" label="功能" >
                    <template>
                        <el-button @click="gotoDetail">管理訂單</el-button>
                    </template>
                </el-table-column>
        </el-table>
        </div>
    </div>
</template>
<script>
export default {
    data:function(){
        return {
        list:[
                {
                    id:1,
                    number:"XC0123213",
                    date:"2021-12-01",
                    order_state:"完成",
                    payment_state:"已付款",
                    deliver_state:"已到貨",
                    order_buyer:"王先生",
                    sum:100,
                    memo:"無",
                    product_list:[
                                    {
                                    id:1,
                                    name:"泡麵",
                                    image_url:"https://www.bestbakery.com.tw/upload/20201203092824g4kta1.jpg",
                                    price:300,
                                    amount:2,
                                    sum:600,
                                    spec:'紅色',
                                    cost:200,
                                    rate:30
                                }
                                ]
                }
            ]
        }
    },
    methods:{
    gotoDetail:function(){
        this.$router.push('/order/show');
    }
    }
}
</script>

<style>
    .el-tag{
        margin-left: 4px;
        margin-right: 4px;
        cursor: pointer;
    }
    .state_process.active{
        background-color: red !important;
        color:white !important;
    }
    .state_unpayment.active{
        background-color: orange !important;
        color:white !important;
    }
    .state_wait.active{
        background-color: yellowgreen !important;
        color:white !important;
    }
    .complate.active{
        background-color: blue !important;
        color:white !important;
    }
    .el-pagination{
        margin-left: 4px;
        margin-right: 4px;
    }
    .search_type{
        max-width: 120px !important;
    }
    .memo_text{
        cursor: pointer;
    }
    .product_image{
        width: 100%;
    }
    .product_list{
        padding:12px;
        border:1px solid gainsboro
    }
</style>
