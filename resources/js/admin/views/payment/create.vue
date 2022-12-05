<template>
    <div>
        <div class="breadcrumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/dashboard' }">首頁</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/payment' }">付款設定</el-breadcrumb-item>
                <el-breadcrumb-item>新增付款設定</el-breadcrumb-item>
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
            <el-form-item label="付款方式">
                <el-select v-model="form.method" placeholder="請選擇一種付款方式">
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
            <el-form-item label="排除的運送方式">
                <el-select v-model="form.dev" multiple placeholder="請選擇欲排除的運送方式">
                <el-option
                    v-for="item in delivery_list"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                </el-option>
                </el-select>
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
            },
            option_list:[
            {
                label:"線上刷卡(綠界)",
                value:"1"
            },
            {
                label:"ATM(綠界)",
                value:"2"
            },
            {
                label:"ATM",
                value:"3"
            }
            ],
            delivery_list:[
            {
                label:"宅配",
                value:"1"
            },
            {
                label:"面交",
                value:"2"
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
