<template>
    <div>
        <div class="breadcrumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/dashboard' }">首頁</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/delivery' }">運送設定</el-breadcrumb-item>
                <el-breadcrumb-item>新增運送設定</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="main">
            <el-form :model="form" label-width="120px">
                <el-form-item label="名稱">
                    <el-input v-model="form.name" />
                </el-form-item>
                <el-form-item label="狀態">
                    <el-radio-group v-model="form.resource">
                        <el-radio label="啟用" />
                        <el-radio label="關閉" />
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="運送方式">
                    <el-select v-model="form.method" placeholder="請選擇一種運送方式">
                    <el-option
                        v-for="item in option_list"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item v-if="isECPay(form.method)" label="特店編號">
                <el-input v-model="form.n1" placeholder="請輸入綠界科技提供的特店編號"></el-input>
                </el-form-item>
                <el-form-item v-if="isECPay(form.method)" label="HashKey">
                    <el-input v-model="form.n1" placeholder="請輸入綠界科技提供的HashKey"></el-input>
                </el-form-item>
                <el-form-item v-if="isECPay(form.method)" label="HashIV">
                    <el-input v-model="form.n1" placeholder="請輸入綠界科技提供的HashIV"></el-input>
                </el-form-item>
                <el-form-item label="運費">
                <el-select v-model="form.calc_method" placeholder="請選擇運費計算方式">
                    <el-option
                    v-for="item in delivery_list"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
                </el-form-item>
                <el-form-item v-if="form.calc_method == 1" >
                    <el-input v-model="form.price" >
                    <template slot="prepend">NT$</template>
                    </el-input>
                </el-form-item>
                <el-form-item  v-if="form.calc_method == 2" >
                <div class="calc_method-group">
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">公克</template>
                    </el-input>
                    </div>
                    <div  class="calc_method-item">
                    ～
                    </div>
                    <div  class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">公克</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">NT$</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-button>增加</el-button>
                    </div>
                </div>
                </el-form-item>
                <el-form-item v-if="form.calc_method == 3" >
                <div class="calc_method-group">
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">件</template>
                    </el-input>
                    </div>
                    <div  class="calc_method-item">
                    ～
                    </div>
                    <div  class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">件</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">每件增加NT$</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-button>增加</el-button>
                    </div>
                </div>
                </el-form-item>
                <el-form-item v-if="form.calc_method == 4">
                <div class="calc_method-group">
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">件</template>
                    </el-input>
                    </div>
                    <div  class="calc_method-item">
                    ～
                    </div>
                    <div  class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="append">件</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">NT$</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-button>增加</el-button>
                    </div>
                </div>
                </el-form-item>
                <el-form-item v-if="form.calc_method == 5">
                <div class="calc_method-group">
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">長</template>
                    </el-input>
                    </div>
                    <div  class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">寬</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">高</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">重量限制</template>
                        <template slot="append">公克</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-input v-model="form.price" >
                        <template slot="prepend">NT$</template>
                    </el-input>
                    </div>
                    <div class="calc_method-item">
                    <el-button>增加</el-button>
                    </div>
                </div>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit()">更新</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
export default {
    data:function(){
        return {
        form:{
            name:"123",
            region:"shanghai",
            price:0,
        },
        option_list:[
            {
            label:"宅配(綠界)",
            value:"1"
            },
            {
            label:"7-11取貨(綠界)",
            value:"2"
            },
            {
            label:"自訂",
            value:"3"
            }
        ],
        delivery_list:[
            {
            label:"固定運費",
            value:1
            },
            {
            label:"按重量計算",
            value:2
            },
            {
            label:"按數量計算(固定)",
            value:3
            },
            {
            label:"按數量計算(累進)",
            value:4
            },
            {
            label:"按體積計算",
            value:5
            }
        ]
        }
    },
    methods:{
        isECPay:function($value){
            if($value == 1){
                return true;
            }
            if($value == 2){
                return true;
            }
            return false
        },
        onSubmit:function(){
        this.$notify({
            title: '新增成功',
            message: '新增成功',
            duration: 0
            });
        }
    }
}
</script>

<style scoped>
    .calc_method-group{
        display: flex;
    }
    .calc_method-item{
        padding-left: 4px;
        padding-right: 4px;
    }
</style>
