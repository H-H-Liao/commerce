<template>
    <div>
        <div class="breadcrumbs">
            <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首頁</el-breadcrumb-item>
            <el-breadcrumb-item><a href="/order">訂單列表</a></el-breadcrumb-item>
            <el-breadcrumb-item><a href="/">訂單</a></el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="order_header">
        <el-button>退貨</el-button>
        <el-button>出貨單</el-button>
        </div>
        <div class="order_main">
        <div class="main_item-left">
            <order-card title="商品明細">
            <el-table
                :data="product_list"
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
            </order-card>
        </div>
        <div class="main_item-right">
            <order-card title="訂單資訊">
            <el-descriptions title="訂購資訊" :column="2">
                <el-descriptions-item label="訂單號碼">WLR20200103003</el-descriptions-item>
                <el-descriptions-item label="訂單時間">2021-01-03 12:00:23</el-descriptions-item>
                <el-descriptions-item label="訂單總金額">$3,210</el-descriptions-item>
                <el-descriptions-item label="訂單來源">
                <el-tag size="small">電商</el-tag>
                </el-descriptions-item>
            </el-descriptions>
            <el-descriptions title="訂購者資訊" :column="2">
                <el-descriptions-item label="訂購人">王小明</el-descriptions-item>
                <el-descriptions-item label="訂購email">test@wanliroad.com</el-descriptions-item>
                <el-descriptions-item label="電話號碼">+886-912-345678</el-descriptions-item>
                <el-descriptions-item label="訂購帳號">123091230</el-descriptions-item>
            </el-descriptions>
            </order-card>
            <order-card title="付款資訊">
            <el-descriptions :column="2">
                <el-descriptions-item label="付款方式">線上支付</el-descriptions-item>
                <el-descriptions-item label="付款狀態">未付款</el-descriptions-item>
            </el-descriptions>
            </order-card>
            <order-card title="運送資訊">
            <el-descriptions :column="2">
                <el-descriptions-item label="運送方式">宅配</el-descriptions-item>
                <el-descriptions-item label="運送狀態">未配送</el-descriptions-item>
            </el-descriptions>
            </order-card>
            <order-card title="變更紀錄">
            <el-timeline>
                <el-timeline-item
                v-for="(activity, index) in activities"
                :key="index"
                :timestamp="activity.timestamp">
                {{activity.content}}
                </el-timeline-item>
            </el-timeline>
            </order-card>
        </div>
        </div>
    </div>
</template>
<script>
import OrderCard from '../../components/order/OrderCard.vue'
export default {
    components: { OrderCard },
    data:function(){
        return {
            tab:"first",
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
                            },
                            {
                            id:2,
                            name:"泡麵",
                            image_url:"https://www.bestbakery.com.tw/upload/20201203092824g4kta1.jpg",
                            price:300,
                            amount:2,
                            sum:600,
                            spec:'紅色',
                            cost:200,
                            rate:30
                            },
                            {
                            id:3,
                            name:"泡麵",
                            image_url:"https://www.bestbakery.com.tw/upload/20201203092824g4kta1.jpg",
                            price:300,
                            amount:2,
                            sum:600,
                            spec:'紅色',
                            cost:200,
                            rate:30
                            }
                        ],
            activities: [{
                content: '活动按期开始',
                timestamp: '2018-04-15'
                }, {
                content: '通过审核',
                timestamp: '2018-04-13'
                }, {
                content: '创建成功',
                timestamp: '2018-04-11'
                }]
        }
    }

}
</script>

<style scoped>
    .order_header{
        margin:12px 18px;
        padding:12px;
        margin-bottom: 0px;
        background-color: white;
    }
    .order_main{
        display: flex;
        padding:6px;
        padding-top:0px;
    }
    .main_item-left{
        flex: 0 0 60%;
        padding:12px;
        padding-right: 6px;
        box-sizing: border-box;
    }
    .main_item-right{
        flex: 0 0 40%;
        padding:12px;
        padding-left: 6px;
        box-sizing: border-box;
    }
    .product_image{
        width: 100%;
    }
</style>
