<template>
    <div class="container" v-loading="loading">
        <div class="row mt-3">
            <div class="col-7">
                <h5>Dealers</h5>
            </div>
            <div class="col-3">
                <el-input @change="getUsers" v-model="search" size="small" placeholder="Type to search" />
            </div>
            <div class="col-2">
                <el-button class="add-price-list-btn" @click="dialog= true" size="small" type="primary" plain><el-icon><plus /></el-icon> Add Dealer</el-button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <el-dialog
                        v-model="dialog"
                        title="Add Dealer"
                        width="500px">

                    <el-form
                            ref="ruleForm"
                            :model="ruleForm"
                            :rules="rules">
                        <el-form-item required>
                            <el-col :span="11">
                                <el-form-item prop="first">
                                    <el-input
                                            v-model="ruleForm.first"
                                            placeholder="First"
                                            style="width: 100%"

                                    />
                                </el-form-item>
                            </el-col>
                            <el-col class="text-center" :span="2">
                            </el-col>
                            <el-col :span="11">
                                <el-form-item prop="last">
                                    <el-input
                                            v-model="ruleForm.last"
                                            placeholder="Last"
                                            style="width: 100%"

                                    />
                                </el-form-item>
                            </el-col>
                        </el-form-item>
                        <el-form-item prop="email">
                            <el-input
                                    v-model="ruleForm.email"
                                    type="email"
                                    placeholder="Email"
                                    style="width: 100%"

                            />
                        </el-form-item>
                        <el-form-item>
                            <el-button @click="dialog = false">Cancel</el-button>
                            <el-button type="primary" v-loading="loading" @click="addUser()">Create</el-button>
                        </el-form-item>
                    </el-form>


                </el-dialog>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-12">
                <el-table :data="users" style="width: 100%" v-loading="loading">
                    <el-table-column prop="ID" width="80" label="ID"  />
                    <el-table-column prop="user_email" label="Email"  />
                    <el-table-column prop="status" width="100" label="Status" >
                        <template #default="scope">
                            <el-badge type="primary" :value="scope.row.status" ></el-badge>
                        </template>
                    </el-table-column>
                    <el-table-column prop="dp_opt_in_marketing" label="Opt-In"  />
                    <el-table-column prop="created" label="Created"  />
                    <el-table-column align="right" label="Actions">
                        <template #default="scope">
                            <!--<el-button  size="small" type="primary" plain><el-icon><edit /></el-icon></el-button>-->
                            <el-popconfirm
                                    confirm-button-text="OK"
                                    cancel-button-text="No, Thanks"
                                    :icon="InfoFilled"
                                    icon-color="red"
                                    title="Are you sure to delete this role?"
                                    @confirm="deleteUser(scope.row.ID)"
                                    @cancel="">
                                <template #reference>
                                    <el-button size="small" type="primary" plain><el-icon><delete-filled /></el-icon></el-button>
                                </template>
                            </el-popconfirm>
                        </template>
                    </el-table-column>

                </el-table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-3">
                <span class="pagination-footer-count-text">showing {{ length > userTotal ? userTotal : length }} of {{ userTotal }} </span>
            </div>
            <div class="col-6">
                <div class="product-footer-pagination">
                    <el-pagination
                            layout="prev, pager, next"
                            v-model:current-page="currentPage"
                            :page-size="length"
                            :total="userTotal"
                            @current-change="changePage"
                    />
                </div>
            </div>
            <div class="col-3">
                <el-select size="small" class="page-length" @change="getUsers" v-model="length" placeholder="Select">
                    <el-option :key="5" :value="5" label="5" />
                    <el-option :key="10" :value="10" label="10" />
                    <el-option :key="15" :value="15" label="15" />
                    <el-option :key="20" :value="20" label="20" />
                </el-select>
            </div>
        </div>
    </div>
</template>

<script>
    const axios = require('axios');
    import { ElMessage } from 'element-plus';
    import { DeleteFilled,Edit, InfoFilled, QuestionFilled, Plus } from '@element-plus/icons-vue';

    export default {
        components:{
            DeleteFilled, Edit, InfoFilled, QuestionFilled, Plus
        },
        data() {
            return {
                search: '',
                length: 10,
                userTotal: 0,
                currentPage: 1,
                users:[],
                ruleForm:{
                    first: '',
                    last: '',
                    email: ''
                },
                price_list:{
                    description: '',
                    id_parent: '0',
                    percent: 50
                },
                loading: false,
                dialog: false,
                rules:{
                    first: [
                        { required: true, message: 'Please input first name', trigger: 'blur' },
                    ],
                    last: [
                        { required: true, message: 'Please input last name', trigger: 'blur' },
                    ],
                    email: [
                        { required: true, message: 'Please input email', trigger: 'blur' },
                        { type: 'email', message: 'Please enter a valid email', trigger: 'blur' },
                    ],
                }
            }
        },
        computed:{

        },
        created(){
            this.getUsers();
        },
        methods:{
            getUsers(){
                this.loading = true;
                const formData = new FormData();
                formData.append('action', 'get_dealers');
                formData.append('start', (this.currentPage -1) * this.length);
                formData.append('length', this.length);
                formData.append('search', this.search);
                axios.post(dp_params.ajax_url, formData)
                    .then( response => {
                        if(response.data.success){
                            this.users = response.data.users;
                            this.userTotal = response.data.totalMatches;
                        }else{
                            ElMessage.error('There was an error trying to get the users')
                        }
                        this.loading = false;
                    })
                    .catch( error => {
                        ElMessage.error(error.message);
                        this.loading = false;
                    });
            },
            changePage(){
                this.getUsers()
            },
            addUser(){
                this.$refs.ruleForm.validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        const formData = new FormData();
                        formData.append('action', 'dp_add_user');
                        formData.append('first', this.ruleForm.first);
                        formData.append('last', this.ruleForm.last);
                        formData.append('email', this.ruleForm.email);

                        axios.post(dp_params.ajax_url, formData)
                            .then( response => {
                                if(response.data.success){
                                    ElMessage.success(response.data.msg);
                                    this.dialog = false;
                                    this.getUsers();
                                    this.$refs.ruleForm.resetFields();

                                }else{
                                    ElMessage.error(response.data.msg);
                                }
                                this.loading = false;
                            })
                            .catch( error => {
                                ElMessage.error(error.message);
                                this.loading = false;
                            });
                    } else {
                        return false;
                    }
                });
            },
            deleteUser(id){
                this.loading = true;
                const formData = new FormData();
                formData.append('action', 'dp_remove_user');
                formData.append('id', id);

                axios.post(dp_params.ajax_url, formData)
                    .then( response => {
                        if(response.data.success){
                            ElMessage.success(response.data.msg);
                            this.getUsers();
                        }else{
                            ElMessage.error(response.data.msg);
                        }
                        this.loading = false;
                    })
                    .catch( error => {
                        ElMessage.error(error.message);
                        this.loading = false;
                    });
            }
        }
    }
</script>

<style>
    .price_lists{
        font-size: 12px;
    }

    .add-price-list-btn{
        float: right;
    }

    .select-pl, .factor-field{
        width: 100% !important;
    }

    .info-field{
        font-size: 11px;
        width: fit-content !important;
        margin-bottom: 0 !important;
    }

    .percent-cell.above{
        color: green;
    }

    .cell{
        font-size: 12px !important;
    }

    .percent-cell.below{
        color: red;
    }

    .el-badge__content{
        font-size: 10px !important;
    }

    .btn-prev, .btn-next{
        margin-top: -6px !important;
    }

    .product-footer-pagination{
        display: flex;
        justify-content: center;
        align-content: center;
    }

    .pagination-footer-count-text{
        font-size: 12px;
    }

    .page-length{
        width: 80px;
        float: right;
    }

</style>
