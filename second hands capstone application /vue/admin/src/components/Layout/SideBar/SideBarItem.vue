<template>
  <div>
    <template v-if="showChildren(item)">
      <el-submenu popper-append-to-body :index="'index-'+item.id" >
        <template slot="title">
          <svg-icon v-if='item.icon' :icon-class="item.icon"></svg-icon>
          <span v-else class="icon-placeholder"></span>
          <span>{{item.name}}</span>
        </template>
        <side-bar-item
                v-for="child in item.children"
                :key="child.path"
                :item="child">
        </side-bar-item>
      </el-submenu>
    </template>

    <template v-else>
      <el-menu-item :index="item.path" @click="handleNodeClick(item)" :class="this.navId == item.id?'is-current':''">
        <svg-icon v-if='item.icon' :icon-class="item.icon"></svg-icon>
        <span v-else class="icon-placeholder"></span>
        <span>{{item.name}}</span>
      </el-menu-item>
    </template>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  export default {
    name: "SideBarItem",
    data() {
      return {}
    },
    computed: {
      ...mapGetters([
        'navId'
      ]),
    },
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    methods:{
      showChildren(item){
        if( item.hasOwnProperty('children') && item['children'].length >0){
          return true
        }else{
          return false
        }
      },
      handleNodeClick(node){
        if(node.component_type == 2){
          window.open(node.component,'_blank')
        }else{
          this.$store.dispatch('system/setNavId',node.id)
          this.$router.push('/page/'+node.path)
        }
      }
    }
  }
</script>
