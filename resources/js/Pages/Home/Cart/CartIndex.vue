<template>
    <home-layout>
        <div class="allCartIndex width">
            <div class="allCartIndexAddress">
                <ul>
                    <li>
                        <inertia-link href="/">
                            <h4>خانه</h4>
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/cart">
                            <h4>سبد خرید</h4>
                        </inertia-link>
                    </li>
                </ul>
            </div>
            <div class="allCartIndexContainer" v-if="allCarts.length">
                <div class="allCartIndexContainerItems">
                    <inertia-link class="allCartIndexContainerItem" v-for="(item , index) in allCarts" :key="index" :href="item.carts.code ? '/product/' + item.carts.slug : '/pack/' + item.carts.slug">
                        <div class="allCartIndexPost" v-if="item.carts.code">
                            <div class="allCartIndexContainerItemPic">
                                <img v-lazy="JSON.parse(item.carts.image)[0]" :alt="item.carts.title">
                            </div>
                            <div class="allCartIndexContainerItemSubject">
                                <div class="allCartIndexContainerItemSubjectData">
                                    <h3>{{item.carts.title}}</h3>
                                    <div class="allCartIndexContainerDataItem">
                                        <svg-icon :icon="'#color'"></svg-icon>
                                        <p>{{item.count.color}}</p>
                                    </div>
                                    <div class="allCartIndexContainerDataItem">
                                        <svg-icon :icon="'#sizeFront'"></svg-icon>
                                        <p>{{item.count.size}}</p>
                                    </div>
                                    <div class="allCartIndexContainerDataItem">
                                        <svg-icon :icon="'#size'"></svg-icon>
                                        <p>{{item.carts.count}} کالا موجود است</p>
                                    </div>
                                </div>
                                <div class="allCartIndexContainerItemSubjectPrice">
                                    <div class="allCartIndexContainerItemSubjectPriceRight">
                                        <div class="allCartIndexContainerItemPrice">{{item.carts.price|NumFormat}} تومان</div>
                                        <s class="allCartIndexContainerItemOff" v-if="item.carts.off">{{item.carts.offPrice|NumFormat}} تومان</s>
                                    </div>
                                    <div class="allCartIndexContainerItemSubjectPriceLeft">
                                        <button @click.prevent="changeCart(item.carts.id,item.count.color,item.count.size , index,0 , change = '1')">+</button>
                                        <img v-if="showLoad == index" src="/img/loading.gif" alt="صبر کنید">
                                        <h5 v-else>{{item.count.count}}</h5>
                                        <button @click.prevent="changeCart(item.carts.id,item.count.color,item.count.size , index,0 , change = '0')">-</button>
                                    </div>
                                </div>
                            </div>
                            <div class="allCartIndexContainerItemCancel" @click.prevent="deleteCart(item.carts.id,item.count.color,item.count.size , index,0)">
                                <svg-icon :icon="'#cancel'"></svg-icon>
                            </div>
                        </div>
                        <div class="allCartIndexPost" v-else>
                            <div class="allCartIndexContainerItemPic">
                                <img v-lazy="item.carts.image" :alt="item.carts.title">
                            </div>
                            <div class="allCartIndexContainerItemSubject">
                                <div class="allCartIndexContainerItemSubjectData">
                                    <h3>{{item.carts.title}}</h3>
                                    <div class="allCartIndexContainerDataItem">
                                        <svg-icon :icon="'#size'"></svg-icon>
                                        <p>{{item.carts.count}} پک موجود است</p>
                                    </div>
                                </div>
                                <div class="allCartIndexContainerItemSubjectPrice">
                                    <div class="allCartIndexContainerItemSubjectPriceRight">
                                        <div class="allCartIndexContainerItemPrice">{{item.carts.price|NumFormat}} تومان</div>
                                    </div>
                                    <div class="allCartIndexContainerItemSubjectPriceLeft">
                                        <button @click.prevent="changeCart(item.carts.id,item.count.color,item.count.size , index ,1, change = '1')">+</button>
                                        <img v-if="showLoad == index" src="/img/loading.gif" alt="صبر کنید">
                                        <h5 v-else>{{item.count.count}}</h5>
                                        <button @click.prevent="changeCart(item.carts.id,item.count.color,item.count.size , index ,1, change = '0')">-</button>
                                    </div>
                                </div>
                            </div>
                            <div class="allCartIndexContainerItemCancel" @click.prevent="deleteCart(item.carts.id,item.count.color,item.count.size , index,1)">
                                <svg-icon :icon="'#cancel'"></svg-icon>
                            </div>
                        </div>
                    </inertia-link>
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
                    <div class="nextItem">
                        <a href="/user-info-cart">ادامه فرآیند خرید</a>
                    </div>
                </div>
            </div>
            <div class="allCartIndexEmpty" v-else>
                <i>
                    <svg-icon :icon="'#cart'"></svg-icon>
                </i>
                <h3>سبد کالا خالی است</h3>
                <p>می‌توانید برای مشاهده محصولات بیشتر به صفحات زیر بروید</p>
                <div class="allCartIndexEmptyOptions">
                    <inertia-link href="/">صفحه اصلی</inertia-link>
                    <inertia-link href="/archive/suggest">پیشنهاد های شگفت انگیز</inertia-link>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '../../../Layouts/Home/HomeLayout.vue'
import SvgIcon from '../../Svg/SvgIcon.vue'
import VuePerfectScrollbar from "vue-perfect-scrollbar";
export default {
    components: { HomeLayout, SvgIcon, VuePerfectScrollbar },
    props:['title'],
    data(){
        return{
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
            change: '',
            i: 0,
            showLoad: -1,
        }
    },
    metaInfo() {
        return {
            title: `سبد خرید - ${this.title}`,
            htmlAttrs: {
                lang: 'fa',
                reptilian: 'gator',
                amp: true
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
        deleteCart(id , color , size , index,pack){
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
                    const url = `/delete-cart`;
                    axios.post(url,{
                        color : color,
                        size : size,
                        product : id,
                        pack : pack,
                    })
                        .then(response=>{
                            this.allCarts.splice(index , 1);
                            this.$eventHub.emit('getCart');
                        })
                }
            })
        },
        getCarts(){
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
                    }
                })
        },
        changeCart(id , color , size , index,pack){
            this.showLoad = index;
            const url = `/change-carts`;
            axios.post(url,{
                color : color,
                size : size,
                product : id,
                pack : pack,
                change : this.change
            })
                .then(response=>{
                    this.showLoad = -1;
                    if(response.data == 'limit'){
                        this.$swal.fire(
                            'انجام نشد',
                            'موجودی کالا کافی نیست',
                            'error'
                        );
                    }
                    if(response.data == 'success'){
                        if(this.change == 0){
                            if (this.allCarts[index].count.count == 1){
                                this.allCarts.splice(index , 1);
                            }else{
                                this.allCarts[index].count.count = --this.allCarts[index].count.count;
                            }
                        }else{
                            this.allCarts[index].count.count = ++this.allCarts[index].count.count;
                        }
                        this.$eventHub.emit('getCart');
                    }
                })
        }
    },
    mounted() {
        this.getCarts();
    },
    created: function() {
        this.$eventHub.on('getCart', this.getCarts);
    },
}
</script>

<style>

</style>
