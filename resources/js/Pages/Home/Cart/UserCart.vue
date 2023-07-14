<template>
    <home-layout>
        <div class="allPersonalUser width">
            <div class="allCartIndexAddress">
                <ul>
                    <li>
                        <inertia-link href="/">
                            <i class="fa fa-home" aria-hidden="true">
                                <svg-icon :icon="'#home'"></svg-icon>
                            </i>
                            <h4>خانه</h4>
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/cart">
                            <i class="fa fa-shopping-bag" aria-hidden="true">
                                <svg-icon :icon="'#cart'"></svg-icon>
                            </i>
                            <h4>سبد خرید</h4>
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/user-info-cart">
                            <i class="fa fa-shopping-bag" aria-hidden="true">
                                <svg-icon :icon="'#user'"></svg-icon>
                            </i>
                            <h4>اطلاعات شخصی</h4>
                        </inertia-link>
                    </li>
                </ul>
            </div>
            <div class="allPersonalUserBot">
                <div class="userCartData">
                    <div class="personalInfo">
                        <div class="errorsCreate" v-if="Object.keys(errors).length > 0">
                            <i>
                                <svg-icon :icon="'#error'"></svg-icon>
                            </i>
                            <span>
                                {{errors[Object.keys(errors)[0]][0]}}
                                </span>
                        </div>
                        <div class="personalInfoItems">
                            <div class="personalInfoItem">
                                <label>نام و نام خانوادگی</label>
                                <input type="text" placeholder="نام را وارد کنید" v-model="form.name">
                            </div>
                            <div class="personalInfoItem">
                                <label>شماره تلفن</label>
                                <input type="text" placeholder="شماره را وارد کنید" v-model="form.number">
                            </div>
                        </div>
                        <div class="personalInfoItems">
                            <div class="personalInfoItem">
                                <label>کد پستی</label>
                                <input type="text" placeholder="کد پستی را وارد کنید" v-model="form.post">
                            </div>
                            <div class="personalInfoItem">
                                <label>محل زندگی</label>
                                <input type="text" placeholder="آدرس محل زندگی را وارد کنید" v-model="form.address">
                            </div>
                        </div>
                        <div class="personalInfoButton">
                            <button @click="changeInfo">تغییر اطلاعات</button>
                        </div>
                    </div>
                    <div class="cartDays">
                        <div class="cartDaysTitle">انتخاب زمان ارسال مرسوله ها</div>
                        <ul>
                            <li v-for="item in days">
                                <h3>{{item.dayL}}</h3>
                                <p>
                                    <span>{{item.day}}</span>
                                    <span>{{item.month}}</span>
                                </p>
                                <div class="dayItem">
                                    <div class="active" v-if="item.day == getTime.day">
                                        <h4>
                                            بازه
                                            {{item.from}}
                                            -
                                            {{item.to}}
                                        </h4>
                                        <h5>{{ allSends|NumFormat }} تومان</h5>
                                    </div>
                                    <div v-else @click="btnTimeGet(item)">
                                        <h4>
                                            بازه
                                            {{item.from}}
                                            -
                                            {{item.to}}
                                        </h4>
                                        <h5>{{ allSends|NumFormat }} تومان</h5>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="allCartIndexItemNext">
                    <div class="WithoutOff">
                        <label>قیمت :</label>
                        <span>{{allPay|NumFormat}} تومان</span>
                    </div>
                    <div class="postCount">
                        <label>تعداد کالا :</label>
                        <span>{{allCount|NumFormat}} کالا</span>
                    </div>
                    <div class="allOff">
                        <label>تخفیف محصول :</label>
                        <span>{{allOff|NumFormat}} تومان</span>
                    </div>
                    <div class="allSum">
                        <label>جمع کل :</label>
                        <span>{{allSum|NumFormat}} تومان</span>
                    </div>
                    <div class="sendMoney">
                        <label>هزینه ارسال :</label>
                        <span>{{allSends|NumFormat}} تومان</span>
                    </div>
                    <div class="allMoney">
                        <label>مبلغ قابل پرداخت :</label>
                        <span>{{allSum2|NumFormat}} تومان</span>
                    </div>
                    <div class="allCarrier">
                        <label>نوع حامل :</label>
                        <div class="allCategoryPanel" @click="showAllCarrier = !showAllCarrier">
                            <div class="categoryShow">
                                <h4>{{getCarriers}}</h4>
                                <i>
                                    <svg-icon :icon="'#down'"></svg-icon>
                                </i>
                            </div>
                            <ul v-if="showAllCarrier">
                                <VuePerfectScrollbar class="scroll-area">
                                    <li v-for="item in carriers" @click="sendGetCarriers(item.title,item.id)">{{item.title}}</li>
                                </VuePerfectScrollbar>
                            </ul>
                        </div>
                    </div>
                    <div class="nextItem">
                        <a href="/shop" v-if="getCarriers && getTime">پرداخت آنلاین</a>
                        <a v-else-if="getTime">حامل را انتخاب کنید</a>
                        <a v-else>زمان را انتخاب کنید</a>
                    </div>
                    <div class="nextItem">
                        <a href="/spot/shop" v-if="getCarriers && getTime">پرداخت در محل و واریز بیعانه</a>
                        <a v-else-if="getTime">حامل را انتخاب کنید</a>
                        <a v-else>زمان را انتخاب کنید</a>
                    </div>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "UserCart",
    props: ['users','number','errors','title','carriers','days'],
    components: {
        datePicker: VuePersianDatetimePicker,
        HomeLayout,
        SvgIcon
    },
    metaInfo() {
        return {
            title: `اطلاعات شخصی - ${this.title}`,
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
    data() {
        return {
            form:{
                date: '',
                update: 1,
                name: '',
                number: '',
                address: '',
                post: '',
                job: '',
                code: '',
            },
            allCarts: [],
            allSum: 0,
            allSum2: 0,
            allPay: 0,
            allCount: 0,
            allOff: 0,
            allSends: 0,
            allProfit: 0,
            count: [],
            carts: [],
            getCarriers: '',
            getTime: '',
            showAllCarrier: false,
            i: 0,
        }
    },
    methods:{
        btnTimeGet(item){
            this.getTime = item;
            const url = '/change-time-delivery';
            axios.post(url,{
                time: JSON.stringify(item)
            })
        },
        sendGetCarriers(name,id){
            this.getCarriers = name;
            const url = '/change-carrier';
            axios.post(url,{
                carrier: id
            })
        },
        getCarts(){
            if(this.carriers.length){
                this.getCarriers = this.carriers[0].title;
            }
            const url = '/get-carts';
            axios.get(url)
                .then(response=>{
                    if (response.data === 'no'){

                    }else{
                        this.allCarts =[];
                        this.allSum =0;
                        this.allCount =0;
                        this.allPay =0;
                        this.allOff =0;
                        this.carts = response.data[0];
                        this.count = response.data[1];
                        this.allSends = response.data[2];
                        for ( this.i ; this.i <  this.carts.length; this.i++) {
                            this.allCarts.push({count : '',carts : '',});
                            this.allCarts[this.i].count = this.count[this.i];
                            this.allCarts[this.i].carts = this.carts[this.i];
                            this.allPay = parseInt(this.allPay) + parseInt(this.allCarts[this.i].carts.price) * parseInt(this.allCarts[this.i].count.count);
                            this.allSum = parseInt(this.allSum) + parseInt(this.allCarts[this.i].carts.price) * parseInt(this.allCarts[this.i].count.count);
                            if (this.allCarts[this.i].carts.off != null){
                                this.allOff = parseInt(this.allOff) + parseInt(this.allCarts[this.i].carts.price * this.allCarts[this.i].carts.off / 100) * parseInt(this.allCarts[this.i].count.count);
                            }
                            this.allCount = parseInt(this.allCount) + parseInt(this.allCarts[this.i].count.count);
                        }
                        this.allSum2 = parseInt(this.allSum) + parseInt(this.allSends);
                        this.allProfit = this.allPay - this.allSum;
                        this.i = 0;
                        this.form.number= this.number;
                        if (this.users){
                            this.form.date= this.users.date;
                            this.form.name= this.users.name;
                            this.form.address= this.users.address;
                            this.form.post= this.users.post;
                            this.form.job= this.users.job;
                            this.form.code= this.users.code;
                        }
                        if(response.data[1][0]['carrier'].length){
                            this.getCarriers = response.data[1][0]['carrier'][0]['title'];
                        }
                        if(response.data[1][0]['delivery']){
                            this.getTime = JSON.parse(response.data[1][0]['delivery']);
                        }
                    }
                })
        },
        changeInfo(){
            const url = '/user-info-cart';
            this.$inertia.post(url , this.form)
                .then(response=>{
                    this.$swal.fire(
                        'انجام شد',
                        'تغییر با موفقیت انجام شد',
                        'success'
                    );
                })
        },
    },
    mounted() {
        this.getCarts();
    },
    created: function() {
        this.$eventHub.on('getCart', this.getCarts);
    },
}
</script>

<style scoped>

</style>
