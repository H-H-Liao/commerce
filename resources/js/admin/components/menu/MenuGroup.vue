<template>
    <div class="group">
        <div class="group_title_group" @click="switchGroup()">
            <div class="group_title">
                <div class="item">{{title}} </div>
            </div>
            <div>
                <svg v-if="open" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        </div>
        <div v-if="open" class="group_content">
            <slot></slot>
        </div>
    </div>
</template>

<script>

export default {
    props:{
        title:{
            type:String,
            require:true
        },
        icon:{
            type:String,
            required:false
        },
    },
    data:function(){
        return {
            open: false
        }
    },
    mounted:function(){

    },
    methods:{
        switchGroup:function(){
            this.open=!this.open;
        }
    }

}
</script>

<style scoped>
    .group{
        margin: 24px 12px ;
    }
    .group_title_group{
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .group_title{
        display: flex;

    }
    .item{
        padding-left: 12px;
    }
    .group_content{
        border-left: 1px solid white;
        margin-left: 16px;
    }
</style>
