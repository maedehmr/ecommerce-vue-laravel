<template>
    <admin-layout>
        <div class="allPayPanel">
            <div class="allPayPanelTop">
                <h1>پرداختی ها</h1>
                <div class="allPayPanelTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/pay">پرداختی ها</inertia-link>
                </div>
            </div>
            <div class="allTable">
                <div class="allTopTable">
                    <div class="allTopTableItem">
                        <button class="button" @click="btnRemoveArray('')" v-if="value.length">حذف</button>
                    </div>
                    <div class="allTopTableItem">
                        <div class="filterItems">
                            <div class="ContentOptionsFilterButton" @click.stop="showFilter = !showFilter">
                                <i>
                                    <svg-icon :icon="'#filter'"></svg-icon>
                                </i>
                                فیلتر اطلاعات
                            </div>
                            <transition name="bounce">
                                <div class="filterContent" v-if="showFilter">
                                    <div class="filterContentItem">
                                        <label>فیلتر شماره تراکنش پرداخت یا شماره سفارش</label>
                                        <input type="text" v-model="search"  placeholder="شماره تراکنش پرداخت یا شماره سفارش را وارد کنید" @keypress.enter="btnSearch(0)">
                                    </div>
                                    <div class="filterContentItem">
                                        <label>فیلتر تاریخ</label>
                                        <div class="allTicketPanelTitleDate">
                                            <date-picker
                                                v-model="date"
                                                type="datetime"
                                                format="YYYY-MM-DD"
                                                display-format="jYYYY-jMM-jDD"
                                                @close="dateClose"
                                                placeholder="تاریخ را وارد کنید"
                                                :timezone="true"
                                            />
                                            <i @click.stop="btnSearch(1)" v-if="date">
                                                <svg-icon :icon="'#cancel'"></svg-icon>
                                            </i>
                                        </div>
                                    </div>
                                    <div class="filterContentItem">
                                        <label>فیلتر وضعیت پرداخت</label>
                                        <div class="allCategoryPanel" @click="showSort = !showSort">
                                            <div class="categoryShow">
                                                <h4 v-if="sort == 0">همه</h4>
                                                <h4 v-if="sort == 1">پرداخت نشده</h4>
                                                <h4 v-if="sort == 2">پرداخت شده</h4>
                                                <i>
                                                    <svg-icon :icon="'#down'"></svg-icon>
                                                </i>
                                            </div>
                                            <ul v-if="showSort">
                                                <li @click="sort = 0" v-on:click="btnSearch(0)">همه</li>
                                                <li @click="sort = 1" v-on:click="btnSearch(0)">پرداخت نشده</li>
                                                <li @click="sort = 2" v-on:click="btnSearch(0)">پرداخت شده</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="filterContentItem">
                                        <label>فیلتر وضعیت ارسال</label>
                                        <div class="allCategoryPanel" @click="showSortDeliver = !showSortDeliver">
                                            <div class="categoryShow">
                                                <h4 v-if="sortDeliver == 0">همه</h4>
                                                <h4 v-if="sortDeliver == 1">در حال ارسال</h4>
                                                <h4 v-if="sortDeliver == 2">تحویل داده</h4>
                                                <i>
                                                    <svg-icon :icon="'#down'"></svg-icon>
                                                </i>
                                            </div>
                                            <ul v-if="showSortDeliver">
                                                <li @click="sortDeliver = 0" v-on:click="btnSearch(0)">همه</li>
                                                <li @click="sortDeliver = 1" v-on:click="btnSearch(0)">در حال ارسال</li>
                                                <li @click="sortDeliver = 2" v-on:click="btnSearch(0)">تحویل داده</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="filterContentItem">
                                        <label>تعداد نمایش</label>
                                        <div class="allCategoryPanel" @click="showPage = !showPage">
                                            <div class="categoryShow">
                                                <h4 v-if="getPage == 25">25</h4>
                                                <h4 v-if="getPage == 50">50</h4>
                                                <h4 v-if="getPage == 70">70</h4>
                                                <h4 v-if="getPage == 100">100</h4>
                                                <i>
                                                    <svg-icon :icon="'#down'"></svg-icon>
                                                </i>
                                            </div>
                                            <ul v-if="showPage">
                                                <li @click="getPage = 25" v-on:click="btnSearch(0)">25</li>
                                                <li @click="getPage = 50" v-on:click="btnSearch(0)">50</li>
                                                <li @click="getPage = 70" v-on:click="btnSearch(0)">70</li>
                                                <li @click="getPage = 100" v-on:click="btnSearch(0)">100</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
                <div class="paginate">
                    <paginate-panel :link="pays.links"></paginate-panel>
                </div>
                <div class="allTableContainer" v-if="show">
                    <all-table :table="pays.data" :labels="labels" :deletes="deleted" :shows="1" :edits="0" v-on:sendCheck="getCheck" v-on:sendDelete="btnRemoveArray" v-on:sendShow="btnShow"></all-table>
                </div>
                <div class="paginate">
                    <div class="showInfo">
                        نمایش
                        {{pays.from}}
                        تا
                        {{pays.to}}
                        از
                        {{pays.total}}
                        ورودی
                    </div>
                    <paginate-panel :link="pays.links"></paginate-panel>
                </div>
            </div>
            <div class="allShowFastPost" v-if="showPayMeta != ''">
                <div class="allShowFastPostPanel">
                    <ul>
                        <li v-for="item in showPayMeta">
                            <div class="payMetaItem" v-if="item.pack == null">
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
                                    <div class="payMetaSubjectItem" v-if="item.count">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                            <div class="payMetaItem" v-else>
                                <div class="payMetaPic"><img :src="item.pack.image"></div>
                                <div class="payMetaSubject">
                                    <div class="payMetaSubjectTitle">{{item.pack.title}}</div>
                                    <div class="payMetaSubjectItem" v-if="item.count">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="allCategoryPanel" @click="showStatus2 = !showStatus2">
                        <div class="categoryShow">
                            <h4 v-if="showStatus.deliver == 0">در حال ارسال</h4>
                            <h4 v-if="showStatus.deliver == 1">تحویل داده شده</h4>
                            <i>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <ul v-if="showStatus2">
                            <li @click="showStatus.deliver = 0">در حال ارسال</li>
                            <li @click="showStatus.deliver = 1">تحویل داده شده</li>
                        </ul>
                    </div>
                    <div class="showDetail">
                        <inertia-link :href="'/admin/show-pay/' + showStatus.id">جزییات سفارش</inertia-link>
                        <a :href="'/admin/pay/invoice/' + showStatus.id">فاکتور سفارش</a>
                    </div>
                    <div class="userInfo">
                        <div class="userInfoItem">
                            <label>مبلغ خریداری شده :</label>
                            <span>{{showStatus.price|NumFormat}} تومان</span>
                        </div>
                        <div class="userInfoItem">
                            <label>وضعیت خریداری :</label>
                            <span v-if="showStatus.status == 0">پرداخت شده</span>
                            <span v-else>در حال پرداخت</span>
                        </div>
                        <div class="userInfoItem">
                            <label>زمان خرید :</label>
                            <span>{{showStatus.created_at}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>شماره سفارش :</label>
                            <span>{{showStatus.property}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>آیدی خریدار :</label>
                            <span>{{showStatus.user.id}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>روز ارسال :</label>
                            <span>
                                {{JSON.parse(showStatus.time).dayL}}
                            </span>
                        </div>
                        <div class="userInfoItem">
                            <label>بازه زمانی ارسال :</label>
                            <span>
                                {{JSON.parse(showStatus.time).from}}
                                -
                                {{JSON.parse(showStatus.time).to}}
                            </span>
                        </div>
                        <div class="userInfoItem">
                            <label>نوع ارسال :</label>
                            <span>{{showStatus.carrier[0].title}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>نام خریدار :</label>
                            <span>{{showStatus.user.user_meta[0].name}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>شماره تماس خریدار :</label>
                            <span>{{showStatus.user.number}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>کد پستی :</label>
                            <span>{{showStatus.user.user_meta[0].post}}</span>
                        </div>
                        <div class="userInfoItem">
                            <label>آدرس خریدار :</label>
                            <span>{{showStatus.user.user_meta[0].address}}</span>
                        </div>
                    </div>
                    <div class="buttons">
                        <button @click="sendUpdate">اعمال تغییر</button>
                        <button @click="showPayMeta = []">انصراف</button>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import PaginatePanel from "../PaginatePanel";
import SvgIcon from "../../Svg/SvgIcon";
import VuePersianDatetimePicker from "vue-persian-datetime-picker";
import AllTable from '../Table/AllTable.vue';
export default {
    name: "PayPanel",
    components:{
        AdminLayout,
        PaginatePanel,
        datePicker: VuePersianDatetimePicker,
        SvgIcon,
        AllTable
    },
    props:['pays','deleted','labels','deleted','show'],
    metaInfo: {
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
      title: 'پرداختی ها'
    },
    data() {
        return {
            search : '',
            date : '',
            sort : 0,
            sortDeliver : 0,
            getPage : 25,
            showPage : false,
            showFilter : false,
            showStatus2 : false,
            showSort : false,
            showSortDeliver : false,
            showPayMeta : [],
            showStatus : [],
            postId : '',
            value : [],
        }
    },
    methods:{
        sendUpdate(){
            const url = `/admin/pay`;
            this.$inertia.post(url , {
                deliver : this.showStatus,
                search : this.search,
                getPage : this.getPage,
                sort : this.sort,
                sortDeliver : this.sortDeliver,
                date : this.date,
            })
                .then(response=>{
                    this.showPayMeta = [];
                })
        },
        btnShow(id){
            const url = `/admin/pay/${id}`;
            axios.get(url)
                .then(response=>{
                    this.showPayMeta = response.data[1];
                    this.showStatus = response.data[0];
                })
        },
        btnSearch(number){
            if(number == 1){
                this.date = '';
            }
            const url = `/admin/pay`;
            this.$inertia.post(url , {
                search : this.search,
                getPage : this.getPage,
                sort : this.sort,
                sortDeliver : this.sortDeliver,
                date : this.date,
            })
        },
        getCheck(id){
            this.value = id;
        },
        btnRemoveArray(id){
            if(id){
                this.value = [id]
            }
            this.$swal.fire({
                title: 'آیا مطمینی ؟',
                text: "فایل حذف شده برگشتی ندارد!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'پشیمون شدم'
            }).then((result) => {
                if (result.value) {
                    const url = `/admin/pay`;
                    this.$inertia.post(url ,{'value' : this.value})
                }
            })
        },
        sidebar(){
            this.$eventHub.emit('sidebar' , ['0','21']);
        }
    },
    mounted(){
        this.sidebar();
    }
}
</script>
