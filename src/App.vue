<template>

  <el-col class="container-fluid dp-admin-main p-0 m-0" v-loading="loading">
    <el-row class="tac">
      <el-col :span="4" class="dp-sidebar">
        <el-menu
                default-active="1"
                class="el-menu-vertical-main">
          <el-menu-item index="1" @click="changeScreen('users')">
            <el-icon><user-filled /></el-icon>
            <span>Users</span>
          </el-menu-item>
          <!--<el-menu-item index="4" @click="changeScreen('settings')">
            <el-icon><setting /></el-icon>
            <span>Settings</span>
          </el-menu-item>-->

        </el-menu>
      </el-col>
      <el-col :span="20" class="main-area">

       <Users></Users>

    </el-col>
  </el-row>
  </el-col>
</template>

<script>
  const axios = require('axios');
  import { Setting,Plus , UserFilled } from '@element-plus/icons-vue';
  import { ElMessage } from 'element-plus';
  import Users from './Users.vue';

  export default {
    components:{
      Setting,Plus ,UserFilled, Users
    },
    data() {
      return {
        loading: false,
        plugin_url: dp_params.plugin_url,
        ajax_url: dp_params.ajax_url,
        active_screen: 'users',
      }
    },
    computed:{

    },
    created(){

    },
    methods:{

    }
  }
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,500;0,800;1,800&family=Poppins:ital,wght@0,200;0,400;1,700&display=swap');

  #wpcontent {
    padding-left: 0 !important;
  }

  #dp-app{
    background: #eef1f5 !important;
    height: 100vh;
    font-family: 'Poppins' !important;
    font-size: 12px !important;
    position: fixed !important;
    right: 0;
    left: 160px;
  }

  .notice.notice-warning, .updraftmessage{
    display:none !important;
  }

  .el-input__inner{
    background: white !important;
  }

  .product-footer-pagination{
    display: flex;
    justify-content: center;
    align-content: center;
  }

  .dp-admin-main, .dp-admin-main > .el-row, .dp-admin-main .dp-sidebar, .dp-sidebar > .el-menu{
    height: 100vh !important;
  }

</style>
