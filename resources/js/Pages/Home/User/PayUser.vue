<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="4"></all-user>
            <div class="allUserIndexInfo">
                <label>سفارشات من</label>
                <div class="allUserIndexInfoPayFilter">
                    <div class="allUserIndexInfoPayFilterItem" @click="btnPay(0)">
                            <span class="active" v-if="show == 0">همه</span>
                            <span v-else>همه</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnPay(1)">
                        <span class="active" v-if="show == 1">پرداخت شده</span>
                        <span v-else>پرداخت شده</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnPay(2)">
                        <span class="active" v-if="show == 2">پرداخت نشده</span>
                        <span v-else>پرداخت نشده</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnPay(3)">
                        <span class="active" v-if="show == 3">تحویل داده شده</span>
                        <span v-else>تحویل داده شده</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnPay(4)">
                        <span class="active" v-if="show == 4">در حال ارسال</span>
                        <span v-else>در حال ارسال</span>
                    </div>
                </div>
                <div class="paginate" v-if="pays.links">
                    <paginate-panel :link="pays.links"></paginate-panel>
                </div>
                <div class="allUserIndexInfoPay">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>وضعیت ارسال</th>
                            <th>شماره سفارش</th>
                            <th>وضعیت پرداخت</th>
                            <th>تاریخ سفارش</th>
                            <th>عملیات</th>
                        </tr>
                        <div class="showTr">
                            <tr v-for="(item , index) in pays.data" :key="index">
                                <td>
                                    <span>{{++index}}</span>
                                </td>
                                <td>
                                    <span class="unActive" v-if="item.deliver == 0">در حال ارسال</span>
                                    <span class="active" v-else>تحویل داده شده</span>
                                </td>
                                <td>
                                    <span>{{item.property}}</span>
                                </td>
                                <td>
                                    <span class="active" v-if="item.status == 100">پرداخت شده</span>
                                    <span class="active" v-else-if="item.status == 50">پرداخت بیعانه</span>
                                    <span class="unActive" v-else>پرداخت نشده</span>
                                </td>
                                <td>
                                    <span>{{item.created_at}}</span>
                                </td>
                                <td>
                                    <inertia-link :href="'/show-pay/'+item.property">
                                        <svg-icon :icon="'#left'"></svg-icon>
                                    </inertia-link>
                                </td>
                            </tr>
                        </div>
                    </table>
                </div>
                <div class="paginate" v-if="pays.links">
                    <paginate-panel :link="pays.links"></paginate-panel>
                </div>
            </div>

            <div class="allShowFastPost" v-if="showPayMeta != ''">
                <div class="allShowFastPostPanel">
                    <ul>
                        <li v-for="item in showPayMeta" :key="item.id">
                            <div class="payMetaItem" v-if="item.post == null">
                                <div class="payMetaPic"><img :src="item.pack.image"></div>
                                <div class="payMetaSubject">
                                    <div class="payMetaSubjectTitle">{{item.pack.title}}</div>
                                    <div class="payMetaSubjectItem" v-if="item.count">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                            <div class="payMetaItem" v-else>
                                <div class="payMetaPic"><img :src="JSON.parse(item.post.image)[0]"></div>
                                <div class="payMetaSubject">
                                    <div class="payMetaSubjectTitle">{{item.post.title}}</div>
                                    <div class="payMetaSubjectItem" v-if="item.color">
                                        <i>
                                            <svg-icon :icon="'#color'"></svg-icon>
                                        </i>
                                        {{item.color}}
                                    </div>
                                    <div class="payMetaSubjectItem" v-if="item.size">
                                        <i>
                                            <svg-icon :icon="'#size'"></svg-icon>
                                        </i>
                                        {{item.size}}
                                    </div>
                                    <div class="payMetaSubjectItem">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="buttons">
                        <button @click="showPayMeta = []">انصراف</button>
                    </div>
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
import AllUser from "./AllUser";
import SvgIcon from "../../Svg/SvgIcon";
import PaginatePanel from '../../Admin/PaginatePanel.vue';
export default {
    name: "PayUser",
    components:{
        HomeLayout,
        AllUser,
        SvgIcon,
        PaginatePanel,
    },
    props: ['pays','title'],
    data() {
        return {
            showPayMeta : [],
            showLoader : false,
            show : 0,
        }
    },
    metaInfo() {
        return {
            title: `پرداختی ها - ${this.title}`,
            htmlAttrs: {
                lang: 'fa',
                amp: true,
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
    methods:{
        btnPay(index){
            const url = `/profile/pay`;
            this.showLoader = true;
            this.show = index;
            this.$inertia.post(url , {
                show : this.show,
            })
                .then(response=>{
                    this.showLoader = false;
                })
        },
        btnShow(id){
            this.showLoader = true;
            const url = `/pay/${id}`;
            axios.get(url)
                .then(response=>{
                    this.showPayMeta = response.data;
                    this.showLoader = false;
                })
        },
    }
}
</script>

<style scoped>

</style>
