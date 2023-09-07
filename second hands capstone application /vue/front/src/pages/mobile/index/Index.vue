<template>
  <div class="mobile-index">
    <wd-swipe>
      <wd-swipe-item v-for="item in notice" :key="this">
        <div class="swipe-item" v-html="item.title" @click="toNotice(item.id)"></div>
      </wd-swipe-item>
    </wd-swipe>
    <wd-search v-model="listQuery.name" @search="handleFilter" @cancel="handleFilter" @clear="handleFilter" light cancel-txt="search"></wd-search>
    <wd-col-picker label="Classify" v-model="listQuery.classify" :columns="nowList" :column-change="columnChange" align-right :display-format="displayFormat"></wd-col-picker>
    <div style="padding:0 10px 10px ">
      <el-row :gutter="10" v-loading="listLoading">
        <el-col :span="12" v-for="(item,index) in list" :key="index">
          <div class="goods-item" @click="toDetail(item.id)">
            <el-image :src="sourceUrl+item.picture" :fit="'cover'" class="goods-image"></el-image>
            <div class="goods-title">{{item.name}}</div>
            <div class="good-price">
              <div style="flex: 1;color: #ff5959;font-size: 18px;font-weight: bold">${{item.price}}</div>
              <div><i class="el-icon-view" style="margin-right: 5px"></i>{{item.view}}</div>
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import {getClassify,getNocite,getGoods} from '@/api/home/home'
  export default {
    name: "MainIndex",
    data() {
      return {
        sourceUrl:window.sourceUrl,
        classifyList:[],
        nowList:[],
        notice:[],
        listQuery:{
          classify:[-2],
          name:'',
          page: 1,
          limit: 24,
        },
        listTotal: 0,
        list: [],
        listLoading: true,
      }
    },
    methods: {
      initNotice(){
        getNocite().then(res=>{
          this.notice = res
        }).catch(()=>{return})
      },
      toNotice(id){
        this.$router.push({
          path: "/mobile/notice",
          query: {id:id}
        })
      },
      toDetail(id){
        this.$router.push({
          path: "/mobile/goodDetail",
          query: {id:id}
        })
      },
      displayFormat (selectedItems) {
        return  selectedItems[selectedItems.length - 1].label
      },
      initClassify(){
        getClassify({type:1}).then((res)=>{
          var temp = [
            {id:-1,title:'All products',children:[
                {id:-2,title:'Latest release'},
                {id:-3,title:'Most views'},
              ]}
          ]
          this.classifyList = [...temp,...res]
          var demo = []
          for(let i in this.classifyList){
            demo.push({
              value:this.classifyList[i].id,
              label:this.classifyList[i].title,
            })
          }
          this.nowList =  [[...demo]]

        })
      },
      initGoods(){
        this.listLoading = true
        var data =Object.assign({}, this.listQuery)
        data.classify = data.classify[ data.classify.length -1]

        getGoods(data).then(res=>{
          this.list = res.list
          this.listTotal = res.total
          this.listLoading = false
        }).catch(()=>{
          this.listLoading = true
        })
      },
      columnChange({ selectedItem, resolve, finish }){

        var demo = []
        var sign = true
        for(let i in this.classifyList){
          if(this.classifyList[i].id == selectedItem.value){

            for(let j in this.classifyList[i]['children']){
              demo.push({
                value:this.classifyList[i]['children'][j].id,
                label:this.classifyList[i]['children'][j].title,
              })
            }
            sign = false
            resolve(demo)

          }

        }
        if(sign){
          finish()
          this.handleFilter()
        }

      },
      handleFilter(){
        this.listQuery.page = 1
        this.initGoods()
      }
    },
    mounted() {
      this.initClassify()
      this.initGoods()
      this.initNotice()
    }
  }
</script>
