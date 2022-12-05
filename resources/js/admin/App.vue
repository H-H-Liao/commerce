<template>
    <div>
        <div class="side">
        <menu-item-extend url="/" icon="mdi-truck-delivery" title="訂單"></menu-item-extend>
        <menu-item-extend url="product" icon="mdi-truck-delivery" title="商品"></menu-item-extend>
        <menu-item-extend url="delivery" icon="mdi-truck-delivery" title="運送方式"></menu-item-extend>
        <menu-item-extend url="payment" icon="mdi-truck-delivery" title="付款方式"></menu-item-extend>

        <menu-item-extend url="logout" icon="mdi-logout"  title="登出後台"></menu-item-extend>
        </div>
        <div class="header">

        </div>
        <div class="content">
            <router-view v-if="isRouterAlive"></router-view>
        </div>
    </div>
</template>

<script>
import MenuItemExtend from './components/menu/MenuItemExtend.vue'
import MenuGroup from './components/menu/MenuGroup.vue';


export default {
    components: {
        MenuItemExtend,
        MenuGroup
    },
    provide () {
        return {
            reload: this.reload
        }
    },
    data () {
        return {
            isRouterAlive: true
        }
    },
    methods: {
        reload () {
            this.isRouterAlive = false
            this.$nextTick(function () {
                this.isRouterAlive = true
            })
        }
    }
}
</script>


<style >
    body{
        margin: 0px;
        font-family: 'Noto Sans TC', '微軟正黑體', sans-serif;
    }

    .header{
        position: fixed;
        top: 0px;
        left: 240px;
        width: calc(100% - 240px);
        background-color: white;
        height: 50px;
        box-shadow: -1px -3px 8px rgba(0, 0, 0, 0.3);
        z-index: 999;
    }
    .side{
        position: fixed;
        top: 0px;
        left: 0px;
        width: 240px;
        height: 100vh;
        overflow-y: auto;
        background-color: rgb(54,61,77);
        color:rgb(241,242,243);
    }
    .content{
        position: fixed;
        top: 50px;
        left: 240px;
        width: calc(100% - 240px);
        height: calc(100vh - 50px);
        overflow-y: auto;
        background-color: rgb(248, 248, 248);
        box-sizing: border-box;
    }
    @media (max-width:1024px) {
        .side{
            width: 0px;
        }
        .header{
            left: 0px;
            width: 100%;
            background-color: rgb(54,61,77);
        }
        .content{
            left: 0px;
            width: 100%;
        }
    }

    .breadcrumbs{
        background-color: white;
        padding:  18px 12px;
    }
    .main{
        margin:18px;
        padding:24px 12px;
        background-color: white;
    }
    .flex_cc{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .flex{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
