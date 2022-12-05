<template>
    <router-link :to="url">
        <div class="menu">
            <div class="item">  {{title}} </div>
        </div>
    </router-link>
</template>
<script>
export default {
    props:{
        title:{
            type:String,
            required:true
        },
        icon:{
            type:String,
            required:false
        },
        url:{
            type:String
        }
    }
}
</script>
<style scoped>
    a{
        text-decoration:none;
        color:inherit;
    }
    .menu{
        display: flex;
        margin: 24px 12px;
    }
    .item{
        padding-left: 12px;
    }
</style>
