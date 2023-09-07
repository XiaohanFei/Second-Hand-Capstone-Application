<template>
  <div class="main-box home-index-container">
    <el-row :gutter="20">
      <el-col :span="8">
        <div class="w-title"><i class="el-icon-caret-right"></i>Classification</div>
        <el-cascader-panel :options="classifyList" :props="{label:'title',value:'id',expandTrigger:'click',emitPath:false}"
                           v-model="listQuery.classify" @change="handleFilter" class="demo1"></el-cascader-panel>
      </el-col>
      <el-col :span="16">
        <div class="w-title"><i class="el-icon-caret-right"></i>Search</div>
        <div class="search-box">
          <el-input  v-model="listQuery.name" clearable class="search-input"></el-input>
          <el-button type="primary" icon="el-icon-search" @click="handleFilter">Search</el-button>
        </div>

        <div class="w-title" style="margin-top: 20px"><i class="el-icon-caret-right"></i>Notice</div>
        <div class="notice-body">
          <ul style="margin: 0;padding-left: 10px">
            <li v-for="(item,index) in notice" class="notice-li" :key="item.id" @click="toNotice(item.id)" v-html="(index+1)+'、'+item.title"></li>
          </ul>
        </div>
      </el-col>
    </el-row>
    <div class="w-title" style="margin-top: 30px;margin-bottom: 10px"><i class="el-icon-caret-right"></i>List</div>
    <el-row :gutter="20" v-loading="listLoading">
      <el-col :span="6" v-for="(item,index) in list" :key="index">
        <div class="goods-item" @click="toDetail(item.id)">
          <el-image :src="sourceUrl+item.picture" :fit="'cover'" class="goods-image"></el-image>
          <div class="goods-title">{{item.name}}</div>
          <div class="good-price">
            <div style="flex: 1;color: #ff5959;font-size: 18px;font-weight: bold">${{item.price}}</div>
            <div><i class="el-icon-view" style="margin-right: 5px"></i>{{item.view}}</div>
          </div>
          <div class="goods-classify">{{item.classify_name}}</div>
        </div>
      </el-col>
    </el-row>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @update='initGoods'></pagination>
  </div>
</template>

<script>
  import {getClassify,getNocite,getGoods} from '@/api/home/home'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    data() {
      return {
        sourceUrl:window.sourceUrl,
        classifyList:[],
        notice:[],
        listQuery:{
          classify:-2,
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
      toNotice(id){
        this.$router.push({
          path: "/home/notice",
          query: {id:id}
        })
      },
      toDetail(id){
        // let routeUrl = this.$router.resolve({
        //   path: "/home/goodDetail",
        //   query: {id:id}
        // })
        // window.open(routeUrl.href, '_blank')
        this.$router.push({
              path: "/home/goodDetail",
              query: {id:id}
            })
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
        })
      },
      initNotice(){
        getNocite().then(res=>{
          this.notice = res
        }).catch(()=>{return})
      },
      initGoods(){
        this.listLoading = true
        getGoods(this.listQuery).then(res=>{
          this.list = res.list
          this.listTotal = res.total
            this.listLoading = false
        }).catch(()=>{
          this.listLoading = true
        })
      },
      handleFilter(){
        this.listQuery.page = 1
        this.initGoods()
      }
    },
    mounted() {
      this.initClassify()
      this.initNotice()
      this.initGoods()
    }
  }
</script>

