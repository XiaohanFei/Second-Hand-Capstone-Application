<template>
  <div class="main-box">
    <el-row :gutter="20">
      <el-col :span="14">
        <div class="shadow-box">
          <div style="font-size: 17px;line-height: 24px">{{info.content}}</div>
          <div style="display: flex;flex-direction: row;align-items: center;margin-top: 10px;color: #999;font-size: 15px;margin-bottom: 20px">
            <img :src="sourceUrl+info.avatar" style="width: 30px;height: 30px;border-radius: 50%;cursor: pointer" @click="toUser(info.user_id)">
            <div style="margin: 0 20px;"><span style="color: var(--blue);cursor: pointer" @click="toUser(info.user_id)">{{info.nickname}}</span></div>
            <div>{{info.create_time}}</div>
          </div>

          <div class="w-title" style="margin-top: 40px"><i class="el-icon-caret-right"></i>Reply List</div>

          <div  style="background: white;" v-if="list.length">

            <div v-for="item in list" class="comment-item" style="border-bottom: 1px solid #ccc;
      padding:10px 0;">
              <div>
                <img :src="sourceUrl+item.avatar" style="float:left;width: 50px;height: 50px;cursor: pointer" @click="toUser(item.user_id)">
                <span style="float: right;color: var(--red);font-size: 14px;cursor:pointer" v-if="item.canDelete == 1" @click="handleDelete(item.id)">Delete</span>
                <div style="margin: 0 50px 0 60px;font-size: 13px;line-height: 20px;color: #333">
                  <span style="color: var(--blue);cursor: pointer" @click="toUser(item.user_id)">{{item.nickname}}</span>：{{item.content}}
                  <div style="color: #999;font-size: 12px;margin-top: 10px">{{item.create_time}}</div>
                </div>

              </div>
              <!--<div style="font-size: 17px;line-height: 1.5;margin-top: 5px">{{item.content}}</div>-->
              <!--<div class="comment-reply" v-if="item.reply && item.reply.length">卖家回复: {{item.reply}}</div>-->
            </div>
            <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @update='getList' style="margin-bottom: 0px"></pagination>

          </div>
        </div>
      </el-col>
      <el-col :span="10">
        <div class="shadow-box" >
          <div style="display: flex;flex: 1;align-items: center">
            <img :src="sourceUrl+info.user_avatar" style="width: 60px;height: 60px;">
            <div style="margin-left: 10px;font-size: 20px;font-weight: bold">{{info.nickname}}</div>
          </div>
          <el-input type="textarea" :rows="8" placeholder="Say something" v-model="content" style="margin: 20px 0"></el-input>
          <el-button round  type="primary" @click="handleAdd">Reply</el-button>
        </div>
      </el-col>
    </el-row>

  </div>
</template>

<script>
  import {getChatDetail,addChat,deleteChat} from '@/api/home/home'
  export default {
    name: "MainIndex",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    data() {
      return {
        listQuery:{
          page: 1,
          limit: 20,
          id:0
        },
        content:'',
        info:{},
        listTotal: 0,
        list: [],
        listLoading: true,
        sourceUrl:window.sourceUrl,
      }
    },
    methods: {
      handleDelete(id){
        this.$confirm('Confirm Delete?', 'Tip', {
          type: 'warning'
        }).then(() => {
          deleteChat({id:id}).then(()=>{
            this.getList()
          }).catch(()=>{return})
        }).catch(() => {
          return
        })
      },
      handleAdd(){
        if(!this.content){
          notification("Say something")
          return
        }
        addChat({content:this.content,pid:this.info.id}).then(()=>{
          this.content = ''
          this.getList()
        }).catch(()=>{return})
      },
      toUser(id){
        this.$router.push({
          path: "/home/user",
          query: {id:id}
        })
      },
      getList(){
        getChatDetail(this.listQuery).then((res=>{
          this.info = res.info
          this.list = res.list
          this.listTotal = res.total
        })).catch(()=>{
          return
        })
      }
    },
    mounted() {
      this.listQuery.id = this.$route.query.id
      this.getList()
    }
  }
</script>

<style lang="scss" scoped>

</style>