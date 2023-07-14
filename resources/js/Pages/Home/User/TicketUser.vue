<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="7"></all-user>
            <div class="allUserIndexInfo">
                <label>درخواست های من</label>
                <div class="allUserIndexInfoPayFilter">
                    <div class="allUserIndexInfoPayFilterItem" @click="btnTicket(0)">
                            <span class="active" v-if="show == 0">همه</span>
                            <span v-else>همه</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnTicket(1)">
                        <span class="active" v-if="show == 1">پاسخ داده شده</span>
                        <span v-else>پاسخ داده شده</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnTicket(2)">
                        <span class="active" v-if="show == 2">در انتظار بررسی</span>
                        <span v-else>در انتظار بررسی</span>
                    </div>
                </div>
                <div class="paginate" v-if="tickets.links">
                    <paginate-panel :link="tickets.links"></paginate-panel>
                </div>
                <div class="allUserIndexInfoPay">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>درخواست</th>
                            <th>پاسخ</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        <div class="showTr">
                            <tr v-for="(item , index) in tickets.data">
                                <td>
                                    <span>{{++index}}</span>
                                </td>
                                <td>
                                    <span>{{item.body}}</span>
                                </td>
                                <td>
                                    <span>{{item.answer}}</span>
                                </td>
                                <td>
                                    <span>{{item.created_at}}</span>
                                </td>
                                <td>
                                    <i @click="remove(item.id)">
                                        <svg-icon :icon="'#trash'"></svg-icon>
                                    </i>
                                </td>
                            </tr>
                        </div>
                    </table>
                </div>
                <div class="paginate" v-if="tickets.links">
                    <paginate-panel :link="tickets.links"></paginate-panel>
                </div>
            </div>
            <div class="archiveLoader" v-if="showLoader">
                <div class="archiveLoaderItem">
                    <img src="/img/loadingImage.gif" alt="صبر کنید">
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import SvgIcon from "../../Svg/SvgIcon";
import PaginatePanel from "../../Admin/PaginatePanel";
import AllUser from './AllUser';
export default {
    name: "PayUser",
    components:{
        HomeLayout,
        SvgIcon,
        PaginatePanel,
        AllUser
    },
    props: ['tickets','title'],
    metaInfo() {
        return {
            title: `درخواست های من - ${this.title}`,
            htmlAttrs: {
                lang: 'fa',
                amp: true
            },
            htmlAttrs: {
                reptilian: 'gator'
            },
            headAttrs: {
                nest: 'eggs'
            },
            meta: [
                { charset: 'utf-8' },
            ]
        }
    },
    data() {
        return {
            showLoader : false,
            show : 0,
        }
    },
    methods:{
        btnTicket(index){
            const url = `/profile/ticket`;
            this.showLoader = true;
            this.show = index;
            this.$inertia.post(url , {
                show : this.show,
            })
                .then(response=>{
                    this.showLoader = false;
                })
        },
        remove(id){
            this.$swal.fire({
                title: 'آیا مطمینی ؟',
                text: "فایل وارد سطل اشغال میشود و سپس حذف میشود!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'پشیمون شدم'
            }).then((result) => {
                if (result.value) {
                    const url = `/profile/ticket`;
                    this.showLoader = true;
                    this.$inertia.post(url , {
                        removeId : id,
                        show : this.show,
                    })
                        .then(response=>{
                            this.showLoader = false;
                        })
                }
            })
        },
    }
}
</script>

