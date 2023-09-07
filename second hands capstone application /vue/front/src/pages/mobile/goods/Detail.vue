<template>
  <div class="mobile-good-detail">
    <wd-swipe>
      <wd-swipe-item v-for="item in info.picture" :key="this" style="background: #333;height: 200px">
        <el-image :src="sourceUrl+item" :fit="'contain'" style="width: 100%;height: 200px"></el-image>
      </wd-swipe-item>
    </wd-swipe>
    <div style="padding: 15px">
      <div style="font-weight: bold;font-size: 18px">{{info.name}}</div>
      <div style="color: #ff5959;margin: 20px 0 10px;font-size: 18px;font-weight: bold">${{info.price}}</div>
      <div>
        <!--<el-tag effect="dark">{{info.level}} 成新</el-tag>-->
        <el-tag effect="dark" type="success" size="mini">{{info.free_shipping==1?'free shipping':'not free shipping'}}</el-tag>
        <el-tag effect="dark" type="info" size="mini" style="margin-left: 5px">{{info.buy_time}} Buy</el-tag>
        <el-tag effect="dark" type="warning" size="mini" style="margin-left: 5px">{{info.view}} view</el-tag>
      </div>
      <div style="margin-top: 10px">Seller： <span style="color: var(--blue);cursor: pointer" @click="toUser(info.user_id)">{{info.user_name}}</span></div>
      <el-row :gutter="20" >
        <el-col :span="8"><wd-button type="success" style="flex: 1;margin: 20px 0" @click="handleFavourite">Favorite</wd-button></el-col>
        <el-col :span="8"><wd-button type="success" style="flex: 1;margin: 20px 0" @click="handleCart">Cart</wd-button></el-col>
        <el-col :span="8"><wd-button style="flex: 1;margin: 20px 0"  @click="handleBuy">Buy</wd-button></el-col>
      </el-row>
      <el-tabs v-model="activeName" style="margin-top: 20px;margin-bottom: 20px">

        <el-tab-pane label="Description" name="first">
          <div style="background: white;border:1px solid #ccc;padding: 10px;min-height: 200px">
            {{info.desc}}
          </div>

        </el-tab-pane>
        <el-tab-pane :label="'Comment('+listTotal+')'" name="second">
          <el-button   @click="handleComment" type="primary" size="small">Comment</el-button>
          <div  style="background: white;border:1px solid #ccc;padding: 10px;margin-top: 15px" v-if="list.length">

            <div v-for="item in list" class="comment-item">
              <div>
                <img :src="sourceUrl+item.avatar" style="float:left;width: 50px;height: 50px;cursor: pointer;border-radius: 50%" @click="toUser(item.user_id)">
                <span style="float: right;color: var(--blue);font-size: 14px;cursor:pointer" v-if="item.canReplay == 1" @click="handleReply(item.id)">Replay</span>
                <div style="margin: 0 50px 0 60px;font-size: 13px;line-height: 20px;color: #333">
                  <span style="color: var(--blue);cursor: pointer" @click="toUser(item.user_id)">{{item.name}}</span>：{{item.content}}
                  <div class="comment-reply" v-if="item.reply && item.reply.length">
                    <span style="color: var(--blue);cursor: pointer" @click="toUser(info.user_id)">{{info.user_name}}</span>：{{item.reply}}
                  </div>
                  <div style="color: #999;font-size: 12px;margin-top: 10px">{{item.create_time}}</div>
                </div>

                <!--<span style="font-size: 15px;color: #666">{{item.name}}</span>-->
                <!--<span style="margin-left: 15px;font-size: 14px;color: #aaa">{{item.create_time}}</span>-->


              </div>
              <!--<div style="font-size: 17px;line-height: 1.5;margin-top: 5px">{{item.content}}</div>-->
              <!--<div class="comment-reply" v-if="item.reply && item.reply.length">卖家回复: {{item.reply}}</div>-->
            </div>
            <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @update='initComment' style="margin-bottom: 0px"></pagination>

          </div>
        </el-tab-pane>
      </el-tabs>
    </div>
    <order :dialog="dialog"></order>
  </div>
</template>

<script>
  import { getToken } from '@/utils/auth'
  import {getGoodsDetail,addFavourite,addCart,addComment,getComment,addReply,addScore} from '@/api/home/home'
  export default {
    name: "Detail",
    data() {
      return {
        activeName:'first',
        info:{},
        sourceUrl:window.sourceUrl,
        nowImage:'',
        listQuery:{
          page: 1,
          limit: 20
        },
        listTotal: 0,
        list: [],
        listLoading: true,
        dialog:{
          show:false,
          id:[]
        }
      }
    },
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
      Order: () => import('@/components/Order/Mobile'),
    },
    methods: {
      toUser(id){
        this.$router.push({
          path: "/mobile/user",
          query: {id:id}
        })
      },
      handleBuy(){
        this.dialog = {
          show:true,
          id:[this.info.id]
        }
      },
      handleComment(){
        this.$prompt('Please enter a comment', 'Tip', {
        }).then(({ value }) => {
          if(value.length){
            addComment({content:value,goods_id:this.info.id}).then(()=>{
              this.listQuery.page = 1
              this.initComment()
            }).catch(()=>{return})
          }else{
            return
          }
        }).catch(() => {
          return
        })
      },
      handleReply(id){
        this.$prompt('Please enter a replay', 'Tip', {
        }).then(({ value }) => {
          if(value.length){
            addReply({reply:value,id:id}).then(()=>{
              this.initComment()
            }).catch(()=>{return})
          }else{
            return
          }
        }).catch(() => {
          return
        })
      },
      changeImage(data){
        this.nowImage = this.sourceUrl+data
      },
      handleFavourite(){
        addFavourite({id:this.info.id}).then(()=>{
          return
        }).catch(()=>{return})
      },
      handleCart(){
        addCart({id:this.info.id}).then(()=>{
          return
        }).catch(()=>{return})
      },
      initComment(){
        this.listLoading = true
        var data = JSON.parse(JSON.stringify(this.listQuery))
        data.token = getToken()
        data.id = this.info.id
        getComment(data).then((res)=>{
          this.list = res.list
          this.listTotal = res.total
          this.listLoading = false
        }).catch(()=>{
          this.listLoading = false
        })
      }

    },
    mounted() {
      var that = this
      getGoodsDetail({id:this.$route.query.id}).then((res=>{
        this.info = res
        this.nowImage = window.sourceUrl+res.picture[0]
        this.listQuery.id = res.id
        this.initComment()
        setTimeout(()=>{
          addScore({id:res.classify_id,token: getToken()}).then(()=>{return}).catch(()=>{return})
        },30000)
      })).catch(()=>{
        return
      })


    }
  }
</script>
