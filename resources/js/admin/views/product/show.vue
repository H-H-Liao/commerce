<template>
  <div>
      <v-breadcrumbs
          class="breadcrumbs"
          :items="breadcrumbs"
          divider=">"
      ></v-breadcrumbs>
      <div class="button_group">
          <el-pagination>更新</el-pagination>
      </div>
      <v-tabs
      class="content"
      v-model="tab"
      >
          <v-tab>基本資料</v-tab>
          <v-tab>規格</v-tab>
          <v-tab>價格</v-tab>
          <v-tab>其他設定</v-tab>
          <v-tab>修改紀錄</v-tab>
      </v-tabs>
      <v-tabs-items class="tabs_items" v-model="tab">
          <v-tab-item class="tab-item_content">
                  上架區間
              開放預訂時間
              <el-input
              v-model="firstname"
              :rules="nameRules"
              :counter="20"
              label="商品名稱"
              required
              />
              <v-textarea
              name="input-7-1"
              label="簡介"
              value="The Woodman set to work at once, and so sharp was his axe that the tree was soon chopped nearly through."
              hint="Hint text"
              :counter="300"
              ></v-textarea>
              <div class="section_header">
                  <h4>產品圖片</h4>
                  <el-pagination small>上傳</el-pagination>
              </div>
              <div class="product_image-list">
                  <div class="product_image-item">
                  </div>
              </div>
          </v-tab-item>
          <v-tab-item class="tab-item_content">
              <div class="option_group divider">
                  <div>
                      是否啟動規格功能?
                  </div>
                  <v-switch
                      v-model="show_spec"
                      inset
                  ></v-switch>
              </div>
              <hr>
              <div>
                  <h3>規格名稱</h3>
                  <div>
                      規格及選項名稱會依默認語言顯示，你可以點選「編輯規格 / 選項名稱」來修改名稱或新增其他語言。
                  </div>
                  <div class="spec_group">
                      <div class="spec_item">
                          <div class="spec-item_type">
                              <el-input
                                      v-model="firstname"
                                      :rules="nameRules"
                                      :counter="8"
                                      label="規格種類"
                                      required
                                      class="spec_type"
                                  />
                              <span class="delete_text">刪除</span>
                          </div>
                          <div class="spec-item_content">
                              <div class="spec-item_add_group">
                                  <el-input
                                      class="spec-item_add_input"
                                      v-model="firstname"
                                      :rules="nameRules"
                                      :counter="12"
                                      label="新增規格選項"
                                      required
                                  />
                                  <el-pagination small>新增</el-pagination>
                              </div>
                              <div>
                                  <template >
                                      <thead>
                                          <tr>
                                          <th class="text-left">
                                          圖片
                                          </th>
                                          <th class="text-left">
                                          選項
                                          </th>
                                          <th class="text-left">
                                          功能
                                          </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>
                                                  <div class="spec_image"></div>
                                              </td>
                                              <td>
                                                  黃色
                                              </td>
                                              <td>
                                                  <el-pagination>編輯</el-pagination>
                                                  <el-pagination>刪除</el-pagination>
                                              </td>
                                          </tr>
                                          </tbody>
                                  </template>
                              </div>
                          </div>
                      </div>
                  </div>
                  <el-pagination>增加新規格種類</el-pagination>
              </div>

          </v-tab-item>
          <v-tab-item class="tab-item_content">

              <el-input
              class="price_input"
              v-model="firstname"
              :rules="nameRules"
              type="number"
              label="定價"
              required
              />
              <el-input
              class="price_input"
              v-model="firstname"
              :rules="nameRules"
              type="number"
              label="售價"
              required
              />
              <el-input
              class="price_input"
              v-model="firstname"
              :rules="nameRules"
              type="number"
              label="成本"
              messages="非必填，報表使用"
              required
              />
              <hr>
              <div>
                  <template >
                      <thead>
                          <tr>
                              <th class="text-left">
                              圖片
                              </th>
                              <th class="text-left">
                              顏色規格
                              </th>
                              <th class="text-left">
                              尺寸種類
                              </th>
                              <th class="text-left">
                              貨號
                              </th>
                              <th class="text-left">
                              原價
                              </th>
                              <th class="text-left">
                              價格
                              </th>
                              <th class="text-left">
                              成本價
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>
                                  <div class="spec_image"></div>
                              </td>
                              <td>
                                  黃色
                              </td>
                              <td>
                                  XL
                              </td>
                              <td>
                                  230-3
                              </td>
                              <td>
                                  <el-input  class="price_input" value=""/>
                              </td>
                              <td>
                                  <el-input  class="price_input" value=""/>
                              </td>
                              <td>
                                  <el-input  class="price_input" value=""/>
                              </td>
                          </tr>
                          </tbody>
                  </template>
              </div>
          </v-tab-item>
          <v-tab-item class="tab-item_content">
              重量
              <div class="option_group">
                  <div>
                      指定銷售時間
                  </div>
                  <v-switch
                      v-model="show_spec"
                      inset
                  ></v-switch>
              </div>
              日期選擇器

              排除的付款方式
              排除的運送方式
          </v-tab-item>
          <v-tab-item class="tab-item_content">
              <div>
              <h3>修改紀錄</h3>
              <v-timeline
                  align-top
                  dense
              >
                  <v-timeline-item
                  color="pink"
                  fill-dot
                  >
                      <template v-slot:icon>
                          <v-avatar>
                              <img src="https://i.pravatar.cc/64">
                          </v-avatar>
                      </template>
                      <div>
                          2021/12/23 13:00:24 由 王小姐修改
                      </div>
                      <div class="log_content">
                          修改狀態
                      </div>
                  </v-timeline-item>
                  <v-timeline-item
                  color="pink"
                  fill-dot
                  >
                      <template v-slot:icon>
                          <v-avatar>
                              <img src="https://i.pravatar.cc/64">
                          </v-avatar>
                      </template>
                      <div>
                          2021/12/23 13:00:24 由 王小姐修改
                      </div>
                      <div class="log_content">
                          修改狀態
                      </div>
                  </v-timeline-item>
              </v-timeline>
              </div>
          </v-tab-item>
      </v-tabs-items>
    </div>
</template>

<script>
export default {
    data:function(){
        return {
            tab:4,
            show_spec:true,
            breadcrumbs: [
                {
                  text: '商品及分類',
                  disabled: false,
                  href: '/',
                },
                {
                  text: '商品',
                  disabled: false,
                  href: '/product',
                },
            ]
        }
    }
}
</script>

<style scoped>
    .app{
        padding:12px;
    }
    .content{
        border:1px solid gainsboro;
    }
    .tabs_items{
        border:1px solid gainsboro;
        border-top:0px;
    }
    .tab-item_content{
        padding:12px;
    }

    .product_image-item{
        background-color: aqua;
        width: 240px;
        height: 240px;
    }

    .spec_item{
        display: flex;
        margin-top:12px;
    }
    .spec-item_type{
        flex:0 0 30%;
    }
    .spec-item_content{
        flex:0 0 70%;
    }



    .spec_type{
        width: 80%;
    }
    .spec_image{
        background-color: aqua;
        width: 80px;
        height: 80px;
    }
    .spec-item_add_group{
        display: flex;
        align-items: center;
    }
    .spec-item_add_input{
        flex: 0 0 30%;
        margin-right: 12px;
    }
    .price_input{
        width: 300px;
        max-width:20%;
    }
    .section_header{
        display: flex;
    }
    .delete_text{
        cursor: pointer;
        color:rgb(165, 0, 0);
        font-size: 12px;
    }
    .log_content{
        background-color: rgb(248, 248, 248);
        margin-top:12px;
        padding:12px;
    }
    .button_group{
        padding: 12px;
        background-color: white;
        margin-bottom: 12px;
        border:1px solid gainsboro;
    }
</style>
