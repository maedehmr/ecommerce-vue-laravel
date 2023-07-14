<template>
    <admin-layout>
        <div class="allDashboard">
            <div class="allDashboardTop">
                <h1>داشبورد</h1>
                <div class="allDashboardTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                </div>
            </div>
            <div class="allDashboardOptions">
                <div class="allDashboardOption">
                    <div class="allDashboardOptionTop">
                        <h3>کاربران</h3>
                        <h4>
                            <svg-icon :icon="'#user'"></svg-icon>
                            <span>{{users.length}}</span>
                        </h4>
                    </div>
                    <div class="allDashboardOptionMid">
                        <div class="allDashboardOptionMidItem">
                            <h4>{{onlineUser}}</h4>
                            <h5>کاربر آنلاین</h5>
                        </div>
                        <div class="allDashboardOptionMidItem">
                            <h4>{{offUser}}</h4>
                            <h5>کاربر آفلاین</h5>
                        </div>
                    </div>
                    <div class="allDashboardOptionBot">
                        <h4>امروز</h4>
                        <h5>{{todayUser}} کاربر</h5>
                    </div>
                </div>
                <div class="allDashboardOption">
                    <div class="allDashboardOptionTop">
                        <h3>پست ها</h3>
                        <h4>
                            <svg-icon :icon="'#post'"></svg-icon>
                            <span>{{posts}}</span>
                        </h4>
                    </div>
                    <div class="allDashboardOptionMid">
                        <div class="allDashboardOptionMidItem">
                            <h4>{{unActivePost}}</h4>
                            <h5>پیشنویس</h5>
                        </div>
                        <div class="allDashboardOptionMidItem">
                            <h4>{{activePost}}</h4>
                            <h5>منتشر شده</h5>
                        </div>
                    </div>
                    <div class="allDashboardOptionBot">
                        <h4>امروز</h4>
                        <h5>{{todayPost}} پست</h5>
                    </div>
                </div>
                <div class="allDashboardOption">
                    <div class="allDashboardOptionTop">
                        <h3>پرداختی ها</h3>
                        <h4>
                            <svg-icon :icon="'#billFront'"></svg-icon>
                            <span>{{pays|NumFormat}} تومان</span>
                        </h4>
                    </div>
                    <div class="allDashboardOptionMid">
                        <div class="allDashboardOptionMidItem">
                            <h4>{{payActive}}</h4>
                            <h5>پرداخت شده</h5>
                        </div>
                        <div class="allDashboardOptionMidItem">
                            <h4>{{payUnActive}}</h4>
                            <h5>درحال پرداخت</h5>
                        </div>
                    </div>
                    <div class="allDashboardOptionBot">
                        <h4>امروز</h4>
                        <h5>{{todayPay|NumFormat}} تومان</h5>
                    </div>
                </div>
            </div>
            <div class="allDashboardVidget">
                <div class="allDashboardVidgetOption">
                    <div class="allDashboardVidgetOptionTop">
                        <h2>بازدید امروز</h2>
                        <div class="allDashboardVidgetOptionTopCircle">
                            <span>{{todayView}}</span>
                        </div>
                    </div>
                    <div class="allDashboardVidgetOptionMid">
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>کل بازدید</h5>
                                <span>{{views|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (views * '100') / views +'%'}">
                                    <span>{{(views * '100') / views}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>اندروید</h5>
                                <span>{{androidView|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (androidView * '100') / views +'%'}">
                                    <span v-if="androidView >= 1">{{(androidView * '100') / views}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>ویندوز</h5>
                                <span>{{windowView|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (windowView * '100') / views +'%'}">
                                    <span v-if="windowView >= 1">{{(windowView * '100') / views}} %</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allDashboardVidgetOption">
                    <div class="allDashboardVidgetOptionTop">
                        <h2>دیدگاه امروز</h2>
                        <div class="allDashboardVidgetOptionTopCircle">
                            <span>{{todayComment}}</span>
                        </div>
                    </div>
                    <div class="allDashboardVidgetOptionMid">
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>کل دیدگاه</h5>
                                <span>{{comments|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (comments * '100') / comments +'%'}">
                                    <span v-if="comments >= 1">{{(comments * '100') / comments}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>تایید شده</h5>
                                <span>{{activeComment}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (activeComment * '100') / comments +'%'}">
                                    <span v-if="activeComment >= 1">{{(activeComment * '100') / comments}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>در انتظار تایید</h5>
                                <span>{{unActiveComment|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (unActiveComment * '100') / comments +'%'}">
                                    <span v-if="unActiveComment >= 1">{{(unActiveComment * '100') / comments}} %</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allDashboardVidgetOption">
                    <div class="allDashboardVidgetOptionTop">
                        <h2>سفارشات امروز</h2>
                        <div class="allDashboardVidgetOptionTopCircle">
                            <span>{{todayBill}}</span>
                        </div>
                    </div>
                    <div class="allDashboardVidgetOptionMid">
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>کل سفارشات</h5>
                                <span>{{allBill|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (allBill * '100') / allBill +'%'}">
                                    <span v-if="allBill >= 1">{{(allBill * '100') / allBill}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>تحویل داده شده</h5>
                                <span>{{activeBill|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (activeBill * '100') / allBill +'%'}">
                                    <span v-if="activeBill >= 1">{{(activeBill * '100') / allBill}} %</span>
                                </div>
                            </div>
                        </div>
                        <div class="allDashboardVidgetOptionMidItem">
                            <div class="allDashboardVidgetOptionMidItemTitle">
                                <h5>در حال ارسال</h5>
                                <span>{{unActiveBill|NumFormat}}</span>
                            </div>
                            <div class="allDashboardVidgetOptionMidItemSize">
                                <div class="allDashboardVidgetOptionMidItemSizeFill" :style="{'width' : (unActiveBill * '100') / allBill +'%'}">
                                    <span v-if="unActiveBill >= 1">{{(unActiveBill * '100') / allBill}} %</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="allDashboardPayCharts">
                <div class="allDashboardPayChart">
                    <label>آمار پرداختی ها</label>
                    <apexchart width="80%" id="chart" height="500px" type="area" :options="chartPay" :series="seriesPay"></apexchart>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '../../Layouts/Admin/AdminLayout.vue';
import SvgIcon from '../Svg/SvgIcon.vue';
import Vue from 'vue';
import VueApexCharts from 'vue-apexcharts';
Vue.use(VueApexCharts);
Vue.component('apexchart', VueApexCharts)
export default {
    name: "AllPanel",
    props:['users','onlineUser','farvardinPay','ordibeheshtPay','khordadPay','tirPay','mordadPay','shahrivarPay','mehrPay','abanPay','azarPay','deyPay','bahmanPay','esfandPay','offUser','todayUser','unActivePost','activePost','todayPost','posts','pays','todayPay','payActive','payUnActive','todayView','androidView','windowView','views','unActiveComment','activeComment','comments','todayComment','todayBill','allBill','activeBill','unActiveBill'],
    components:{
        AdminLayout,
        SvgIcon,
    },
    metaInfo: {
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
        title: 'داشبورد'
    },
    data(){
        return{
            chartPay: {
                chart: {
                    id: 'vuechart-example',
                    fontFamily:'irsans, irsans, sans-serif',
                    fontWeight:'300',
                },
                labels:['فروردین', 'اردیبهشت', 'خرداد', 'تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'],
            },
            seriesPay: [{
                name: 'تومان',
                data: [this.farvardinPay, this.ordibeheshtPay, this.khordadPay, this.tirPay,this.mordadPay,this.shahrivarPay,this.mehrPay,this.abanPay,this.azarPay,this.deyPay,this.bahmanPay,this.esfandPay],
            }],
        }
    },
    methods:{
        sidebar(){
            this.$eventHub.emit('sidebar' , ['1','2']);
        }
    },
    mounted() {
        this.sidebar();
    },
}
</script>

<style>

</style>
