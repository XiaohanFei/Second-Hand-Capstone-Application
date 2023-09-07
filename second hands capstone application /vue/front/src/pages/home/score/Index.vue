<template>
  <div class="score-container">
    <el-row :gutter="20">
      <el-col :span="8">
        <div style="width: 100%;height: 88px;background: #409EFF;border-radius: 5px;color:white;padding:10px 20px">
          <div style="font-size:15px;font-weight: bold">My score</div>
          <div style="margin-top: 5px;font-size: 40px;font-weight: bold">{{info.score}}</div>
        </div>
      </el-col>
      <el-col :span="16">
        <el-alert
                title="Notice"
                type="success"
                :closable="false"
                description="The points obtained by users through the task system will be converted into US dollars at the rate of 1 point = 0.001 US dollars every Saturday night and donated to Tucson's local non-profit organization. Weekly donation details will be posted on the bulletin board on the website home page.">
        </el-alert>
      </el-col>
      <el-col :span="12">
        <div class="task-box" >
          <div style="font-size:18px;font-weight: bold">Daily task</div>
          <el-checkbox-group v-model="daily" class="task-checkbox">
            <el-checkbox :label="1">Browse {{info.daily_score_desc}} 30 seconds (+1 score)</el-checkbox>
            <el-checkbox :label="2">Comment on two goods (+5 score)</el-checkbox>
            <el-checkbox :label="3">Successful sale of second-hand books (+10 score)</el-checkbox>
            <el-checkbox :label="4"> Successful sale of second-hand clothing (+5 score)</el-checkbox>
          </el-checkbox-group>
        </div>
      </el-col>
      <el-col :span="12">
        <div class="task-box" >
          <div style="font-size:18px;font-weight: bold">Long term task</div>
          <el-checkbox-group v-model="long" class="task-checkbox">
            <el-checkbox :label="11">Purchase goods 3 times (+3 score)</el-checkbox>
            <el-checkbox :label="12">Update user Avatar (+5 score)</el-checkbox>
            <el-checkbox :label="13">Update user nickname (+10 score)</el-checkbox>
          </el-checkbox-group>
        </div>
      </el-col>

    </el-row>
    <el-table
            style="margin-top: 20px"
            :data="list"
            row-key="id"
            height="calc(100vh - 540px)"
            border
            size="small"
            v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="45" :index="tableIndex"></el-table-column>
      <el-table-column prop="type" :show-overflow-tooltip="true" label="Type"></el-table-column>
      <el-table-column prop="desc" :show-overflow-tooltip="true" label="Description"></el-table-column>
      <el-table-column prop="create_time" label="Add time"></el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
  </div>
</template>

<script>
  import {getMyScore,getScoreList} from '@/api/home/home'
  export default {
    name: "MainIndex",
    data() {
      return {
        info:{},
        listQuery: {
          page: 1,
          limit: 20
        },
        list: [],
        listLoading: true,
        listTotal: 0,
        daily:[],
        long:[]
      }
    },
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    methods: {
      tableIndex(index) {
        let {page, limit} = this.listQuery
        return (page - 1) * limit + index + 1
      },
      async getList() {
        this.listLoading = true
        const {list, total} = await getScoreList(this.listQuery)
        this.list = list
        this.listTotal = total
        this.listLoading = false
      },
    },
    mounted() {
      getMyScore().then(res=>{
        this.info = res
        this.daily = res.daily
        this.long = res.long
        this.getList()
      }).catch(()=>{return})

    }
  }
</script>

<style scoped>
  /deep/.el-alert__description{
    font-size: 14px;
  }
</style>
