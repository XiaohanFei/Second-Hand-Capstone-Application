<template>
  <div class="main-box home-chat-container">
    <el-row :gutter="20">
      <el-col :span="14">
        <div class="shadow-box" >
          <div>
            <div v-for="item in list" :key="this" style="padding: 20px;border-bottom: 1px solid #ccc">
              <div class="chat-item" @click="toDetail(item.id)">{{item.content}}</div>
              <div style="display: flex;flex-direction: row;align-items: center;margin-top: 10px;color: #999;font-size: 15px">
                <img :src="sourceUrl+item.avatar" style="width: 30px;height: 30px;border-radius: 50%;cursor: pointer" @click="toUser(item.user_id)">
                <div style="margin: 0 20px;"><span style="color: var(--blue);cursor: pointer" @click="toUser(item.user_id)">{{item.name}}</span></div>
                <div>{{item.create_time}}</div>
                <div style="margin: 0 20px;"><i class="el-icon-s-comment"></i>{{item.reply}} reply</div>
                <span style="color: var(--red);cursor:pointer" v-if="item.canDelete == 1" @click="handleDelete(item.id)">Delete</span>
              </div>
            </div>
          </div>
          <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @update='getList' style="margin-bottom: 0px"></pagination>
        </div>
      </el-col>
      <el-col :span="10">
        <div class="shadow-box" >
          <div style="display: flex;flex: 1;align-items: center">
            <img :src="sourceUrl+info.avatar" style="width: 60px;height: 60px;">
            <div style="margin-left: 10px;font-size: 20px;font-weight: bold">{{info.nickname}}</div>
          </div>
          <el-input type="textarea" :rows="8" placeholder="Say something" v-model="content" style="margin: 20px 0"></el-input>
          <el-button round  type="primary" @click="handleAdd">Add</el-button>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import {getChatList,addChat,deleteChat} from '@/api/home/home'
  import {notification} from '@/utils/index'

  export default {
    name: "MainIndex",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    data() {
      return {
        info:{},
        listQuery:{
          page: 1,
          limit: 20
        },
        listTotal: 0,
        list: [],
        listLoading: true,
        sourceUrl:window.sourceUrl,
        content:''
      }
    },
    methods: {
      toDetail(id){
        this.$router.push({
          path: "/home/chatDetail",
          query: {id:id}
        })
      },
      toUser(id){
        this.$router.push({
          path: "/home/user",
          query: {id:id}
        })
      },
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
        addChat({content:this.content,pid:0}).then(()=>{
          this.content = ''
          this.getList()
        }).catch(()=>{return})
      },
      getList(){
        getChatList(this.listQuery).then((res=>{
          this.info = res.info
          this.list = res.list
          this.listTotal = res.total
        })).catch(()=>{
          return
        })
      }
    },
    mounted() {
      this.getList()
    }
  }
</script>

<style lang="scss" scoped>

</style>