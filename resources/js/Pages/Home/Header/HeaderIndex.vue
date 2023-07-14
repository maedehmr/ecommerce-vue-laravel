<template>
    <div class="allHeaderHome">
        <div class="allHeaderHomeBlock width">
            <div class="allHeaderHomeTop">
                <div class="allHeaderHomeTopLogo">
                    <inertia-link href="/">
                        <img :src="$page.logo" :alt="$page.logo">
                    </inertia-link>
                </div>
                <label for="searchInput">
                    <svg-icon :icon="'#search'"></svg-icon>
                    <input type="text" v-model="searchProduct" @keypress.enter="btnSearchProduct" id="searchInput" placeholder="جستجو ...">
                </label>
                <div class="allHeaderHomeTopOption">
                    <div class="showUser" v-if="$page.userData != null">
                        <div class="pic" @click="btnShowData(1)">
                            <img v-if="$page.userData.profile == null" src="/img/user.png" :alt="$page.userData.name">
                            <img v-else :src="$page.userData.profile" :alt="$page.userData.name">
                        </div>
                        <ul v-if="showData == 1">
                            <li>
                                <div class="picUser">
                                    <img v-if="$page.userData.profile == null" :src="$page.userData.profile_photo_url" :alt="$page.userData.name">
                                    <img v-else :src="$page.userData.profile" :alt="$page.userData.name">
                                </div>
                                <div class="infoUser">
                                    <span>{{$page.userData.name}}</span>
                                    <span>{{$page.userData.created_at}}</span>
                                </div>
                            </li>
                            <li>
                                <inertia-link href="/profile">
                                    <i>
                                        <svg-icon :icon="'#home'"></svg-icon>
                                    </i>
                                    حساب کاربری
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/profile/bookmark">
                                    <i>
                                        <svg-icon :icon="'#bookmark'"></svg-icon>
                                    </i>
                                    نشانه های من
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/profile/pay">
                                    <i>
                                        <svg-icon :icon="'#bill'"></svg-icon>
                                    </i>
                                    پرداختی های من
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/profile/like">
                                    <i>
                                        <svg-icon :icon="'#like'"></svg-icon>
                                    </i>
                                    علاقه مندی های من
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/logout">
                                    <i>
                                        <svg-icon :icon="'#logout'"></svg-icon>
                                    </i>
                                    خروج از حساب
                                </inertia-link>
                            </li>
                        </ul>
                    </div>
                    <a href="/login" v-else>
                        <svg-icon :icon="'#user'"></svg-icon>
                        <span>
                            ورود | عضویت
                        </span>
                    </a>
                    <a>
                        <svg-icon :icon="'#cart'"></svg-icon>
                        <h5 v-if="allCarts.length">{{allCarts.length}}</h5>
                        <div class="showCart">
                            <ul v-if="allCarts.length && !loadingCart">
                                <VuePerfectScrollbar class="scroll-area">
                                    <li v-for="(item , index) in allCarts" :key="index">
                                        <div class="cartsPost" v-if="item.carts.code">
                                            <div class="cartPic">
                                                <img v-lazy="JSON.parse(item.carts.image)[0]" :alt="item.carts.title">
                                            </div>
                                            <div class="cartText">
                                                <div class="cartTitle">
                                                    <h6>
                                                        {{item.carts.title}}
                                                        <h6 v-if="item.count.size"> - {{item.count.size}}</h6>
                                                        <h6 v-if="item.count.color"> - {{item.count.color}}</h6>
                                                    </h6>
                                                    <i @click.stop="deleteCart(item.carts.id,item.count.color,item.count.size , index,0)">
                                                        <svg-icon :icon="'#cancel'"></svg-icon>
                                                    </i>
                                                </div>
                                                <div class="cartTextItem">
                                                    <div class="cartPrice">
                                                        <h4>{{item.carts.price|NumFormat}}</h4>
                                                    </div>
                                                    <div class="cartCount">
                                                        <button @click.stop="changeCart(item.carts.id,item.count.color,item.count.size , index ,0 , change = '1')">+</button>
                                                        <h6>{{item.count.count}}</h6>
                                                        <button @click.stop="changeCart(item.carts.id,item.count.color,item.count.size , index ,0 , change = '0')">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cartsPost" v-else>
                                            <div class="cartPic">
                                                <img v-lazy="item.carts.image" :alt="item.carts.title">
                                            </div>
                                            <div class="cartText">
                                                <div class="cartTitle">
                                                    <h6>
                                                        {{item.carts.title}}
                                                    </h6>
                                                    <i @click.stop="deleteCart(item.carts.id,item.count.color,item.count.size , index,1)">
                                                        <svg-icon :icon="'#cancel'"></svg-icon>
                                                    </i>
                                                </div>
                                                <div class="cartTextItem">
                                                    <div class="cartPrice">
                                                        <h4>{{item.carts.price|NumFormat}}</h4>
                                                    </div>
                                                    <div class="cartCount">
                                                        <button @click.stop="changeCart(item.carts.id,item.count.color,item.count.size , index ,1, change = '1')">+</button>
                                                        <h6>{{item.count.count}}</h6>
                                                        <button @click.stop="changeCart(item.carts.id,item.count.color,item.count.size , index ,1, change = '0')">-</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </VuePerfectScrollbar>
                            </ul>
                            <div class="showCartEmpty" v-if="allCarts.length == 0 && !loadingCart">
                                <i>
                                    <svg-icon :icon="'#cart'"></svg-icon>
                                </i>
                                <h3>سبد خریدتان خالی است</h3>
                            </div>
                            <div class="showCartLoad" v-if="loadingCart">
                                <div class="showCartLoadPic">
                                    <img src="/img/loading.gif" alt="صبر کنید">
                                </div>
                                <h3>لطفا صبر کنید !</h3>
                            </div>
                            <div class="showCartBot">
                                <inertia-link href="/cart">خرید محصولات</inertia-link>
                                <div class="showCartBotLoader" v-if="showLoader">
                                    <img src="/img/loading.gif" alt="صبر کنید">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="allHeaderHomeBlockBot">
                <div class="allHeaderHomeBlockBotCategory">
                    <svg-icon :icon="'#align'"></svg-icon>
                    دسته بندی محصولات
                    <div class="allHeaderHomeBlockBotCategoryItems" v-if="$page.catHeader">
                        <div class="allHeaderHomeBlockBotCategoryItem" v-for="(item,index) in $page.catHeader.slice(0,6)" :key="index" v-if="item">
                            <inertia-link :href="'/archive/category/'+item.slug" class="allHeaderHomeBlockBotCategoryItemTitle">
                                {{item.name}}
                                <i>
                                    <svg-icon :icon="'#left'"></svg-icon>
                                </i>
                            </inertia-link>
                            <div class="allHeaderHomeBlockBotCategoryItemLists">
                                <div class="allHeaderHomeBlockBotCategoryItemList" v-for="(value , valueIndex) in item.cats.slice(0,3)" :key="valueIndex">
                                    <inertia-link :href="'/archive/category/'+value.slug" class="allHeaderHomeBlockBotCategoryItemListTitle">{{value.name}}</inertia-link>
                                    <div class="allHeaderHomeBlockBotCategoryItemListItems">
                                        <div class="allHeaderHomeBlockBotCategoryItemListItem" v-for="(child,childIndex) in value.cats.slice(0,6)" :key="childIndex">
                                            <inertia-link :href="'/archive/category/'+child.slug">{{child.name}}</inertia-link>
                                        </div>
                                    </div>
                                </div>
                                <div class="allHeaderHomeBlockBotCategoryItemList" v-if="item.image">
                                    <inertia-link :href="'/archive/category/'+item.slug">
                                        <img :src="item.image" :alt="item.name">
                                    </inertia-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="headerHomeContentBotCats">
                    <i @click="showCats = true">
                        <svg-icon :icon="'#align'"></svg-icon>
                    </i>
                    <div class="allHeaderHomeContentBotCats" v-if="showCats">
                        <ul>
                            <li>
                                <span>دسته بندی</span>
                                <i @click="showCats = false">
                                    <svg-icon :icon="'#cancel'"></svg-icon>
                                </i>
                            </li>
                            <li v-if="$page.allow != ''">
                                <inertia-link href="/admin" v-for="(item , index) in $page.allow" :key="index" v-if="item.name == 'نمایش داشبورد'">
                                    داشبورد
                                </inertia-link>
                            </li>
                            <li v-else>
                                <inertia-link href="/admin" v-if="$page.userData.admin == 1">
                                    داشبورد
                                </inertia-link>
                            </li>
                            <li v-for="(allList , index) in $page.catHeader" :key="index">
                                <inertia-link :href="'/archive/category/' + allList.slug">
                                    <i v-if="allList.cats.length">
                                        <svg-icon :icon="'#forward'"></svg-icon>
                                    </i>
                                    {{allList.name}}
                                </inertia-link>
                                <ul class="allListContainer">
                                    <li v-for="lists in allList.cats.slice(0 , 8)">
                                        <inertia-link :href="'/archive/category/' + lists.slug">
                                            <i>
                                                <svg-icon :icon="'#circle'"></svg-icon>
                                            </i>
                                            {{lists.name}}
                                        </inertia-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <ul>
                    <li v-if="$page.allow != ''">
                        <inertia-link href="/admin" v-for="(item , index) in $page.allow" :key="index" v-if="item.name == 'نمایش داشبورد'">
                            داشبورد
                        </inertia-link>
                    </li>
                    <li v-else>
                        <inertia-link href="/admin" v-if="$page.userData.admin == 1">
                            داشبورد
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/">خانه</inertia-link>
                    </li>
                    <li v-for="(item,index) in $page.allPages" :key="index">
                        <inertia-link :href="'/page/' + item.slug">{{item.title}}</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
export default {
    name:'HeaderIndex',
    components:{
        SvgIcon,
        VuePerfectScrollbar
    },
    data(){
        return{
            allCarts: [],
            count: [],
            carts: [],
            allows: [],
            showCats: false,
            showLoader: false,
            loadingCart: false,
            showTicket: false,
            showData: false,
            ticket: '',
            change: '',
            searchProduct: '',
            i: 0,
            notificationSystem: {
                options: {
                    show: {
                        icon: "icon-person",
                        position: "topCenter",
                    },
                    success: {
                        position: "bottomRight"
                    },
                    error: {
                        theme: "#FCA001",
                        progressBarColor: "#DC0808",
                        position: "bottomRight"
                    },
                }
            },
        }
    },
    methods:{
        sendTicket(){
            if(this.ticket == ''){
                this.$toast.error('انجام نشد', 'فیلد درخواست اجباری است', this.notificationSystem.options.error);
            }else{
                const url = '/ticket';
                axios.post(url,{
                    ticket: this.ticket
                })
                    .then(response=>{
                        if (response.data === 'noUser'){
                            this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        }else{
                            this.$toast.success('انجام شد', 'عملیات با موفقیت انجام شد', this.notificationSystem.options.success);
                            this.ticket = '';
                        }
                    })
            }
        },
        btnSearchProduct(){
            const url = `/archive/search?searchProduct=${this.searchProduct}`;
            this.$inertia.post(url)
        },
        btnShowData(num){
            if(num == this.showData){
                this.showData = 0;
            }else{
                this.showData = num;
            }
        },
        deleteCart(id , color , size , index,pack){
            this.$swal.fire({
                title: 'آیا مطمینین ؟',
                text: "محصول حذف شده از سبد حذف میشود!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'پشیمون شدم'
            }).then((result) => {
                if (result.value) {
                    this.showLoader = true;
                    const url = `/delete-cart`;
                    axios.post(url,{
                        color : color,
                        size : size,
                        product : id,
                        pack : pack,
                    })
                        .then(response=>{
                            this.showLoader = false;
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
                        this.carts = response.data[0];
                        this.count = response.data[1];
                        for ( this.i ; this.i <  this.carts.length; this.i++) {
                            this.allCarts.push({count : '',carts : '',});
                            this.allCarts[this.i].count = this.count[this.i];
                            this.allCarts[this.i].carts = this.carts[this.i];
                        }
                        this.i = 0;
                    }
                })
        },
        changeCart(id , color , size , index , pack){
            this.showLoader = true;
            const url = `/change-carts`;
            axios.post(url,{
                color : color,
                size : size,
                product : id,
                pack : pack,
                change : this.change
            })
                .then(response=>{
                    if(response.data == 'limit'){
                        this.$swal.fire(
                            'انجام نشد',
                            'موجودی کالا کافی نیست',
                            'error'
                        );
                        this.$toast.error('انجام نشد', 'موجودی کالا کافی نیست', this.notificationSystem.options.error);
                    }else{
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
                    this.showLoader = false;
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

<style>

</style>
