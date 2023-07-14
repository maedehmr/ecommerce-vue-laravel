<template>
    <home-layout>
        <div class="allSingle width">
            <div class="allSingleAddress">
                <ul>
                    <li>
                        <inertia-link href="/">
                            <i class="fa fa-home" aria-hidden="true">
                                <svg-icon :icon="'#home'"></svg-icon>
                            </i>
                            <h4>خانه</h4>
                        </inertia-link>
                    </li>
                    <li v-if="post.category.length">
                        <inertia-link :href="'/archive/category/' + post.category[0].slug">
                            <i class="fa fa-shopping-bag" aria-hidden="true">
                                <svg-icon :icon="'#box'"></svg-icon>
                            </i>
                            <h4>{{post.category[0].name}}</h4>
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link :href="'/product/' + post.slug">
                            <i class="fa fa-shopping-bag" aria-hidden="true">
                                <svg-icon :icon="'#product'"></svg-icon>
                            </i>
                            <h4>{{post.title}}</h4>
                        </inertia-link>
                    </li>
                </ul>
            </div>
            <div class="allSingleProduct">
                <div class="allSingleTopPic">
                    <div class="allSingleHomeInfoTime" v-if="post.suggest">
                        <div class="allSingleHomeInfoTimeText">
                            <h4>پیشنهاد شگفت انگیز</h4>
                            <h5>زمان باقیمانده</h5>
                        </div>
                        <div class="allSingleHomeInfoTimeItem">
                            <flip-countdown :deadline="post.suggest"></flip-countdown>
                        </div>
                    </div>
                    <div class="allSingleTopImage">
                        <zoom-on-hover :img-normal="JSON.parse(post.image)[showImage]" :scale="3"></zoom-on-hover>
                        <div class="allSingleTopPicOption">
                            <div class="allSingleTopPicOptionItem" @click.stop="btnLike(post.id)">
                                <svg-icon  v-for="(values,index) in like" :key="index" v-if="values == post.id" :icon="'#like'"></svg-icon>
                                <svg-icon :icon="'#unlike'"></svg-icon>
                            </div>
                            <div class="allSingleTopPicOptionItem" @click.stop="btnBookmark(post.id)">
                                <svg-icon v-for="(values,index) in bookmark" :key="index" v-if="values == post.id"  :icon="'#bookmark'"></svg-icon>
                                <svg-icon :icon="'#unbookmark'"></svg-icon>
                            </div>
                            <div class="allSingleTopPicOptionItem" @click.stop="showShare = !showShare">
                                <svg-icon :icon="'#share'"></svg-icon>
                            </div>
                        </div>
                    </div>
                    <hooper :settings="hooperSettings2">
                        <slide v-for="(item,index2) in JSON.parse(post.image)" :key="index2">
                            <img @click="showImage = index2" :src="item" :alt="item">
                        </slide>
                        <hooper-navigation slot="hooper-addons"></hooper-navigation>
                    </hooper>
                </div>
                <div class="allSingleProductSubject">
                    <div class="allSingleProductSubjectTitle">
                        <h1>
                            {{post.title}}
                            <span class="fake" v-if="post.original == 0">غیراصل</span>
                            <span class="original" v-if="post.original == 1">اصل</span>
                            <span class="used" v-if="post.used == 1">کارکرده</span>
                        </h1>
                        <span>{{post.post_meta[0].titleEn}}</span>
                    </div>
                    <div class="allSingleProductSubjectItems">
                        <div class="allSingleProductSubjectItem">
                            <div class="allSingleTopSubjectItems">
                                <div class="allSingleTopSubjectInfo" title="امتیاز">
                                    <i>
                                        <svg-icon :icon="'#star'"></svg-icon>
                                    </i>
                                    <span>{{allRate}}</span>
                                </div>
                                <div class="allSingleTopSubjectInfo" title="تعداد دیدگاه">
                                    <i>
                                        <svg-icon :icon="'#commentFront'"></svg-icon>
                                    </i>
                                    <span>{{post.comments_count}}</span>
                                </div>
                            </div>
                            <div class="allSingleProductSubjectOptions">
                                <div class="allSingleProductSubjectTaxes">
                                    <div class="allSingleProductSubjectTax" v-if="post.category.length">
                                        <label>دسته بندی :</label>
                                        <ul>
                                            <li v-for="item in post.category" :key="item.id" :title="item.name"><inertia-link :href="'/archive/category/' + item.slug">{{item.name}}</inertia-link></li>
                                        </ul>
                                    </div>
                                    <div class="allSingleProductSubjectTax" v-if="post.brand.length">
                                        <label>برند :</label>
                                        <ul>
                                            <li v-for="item in post.brand" :key="item.id" :title="item.name"><inertia-link :href="'/archive/brand/' + item.slug">{{item.name}}</inertia-link></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allSingleProductSubjectOption" v-if="post.color.length">
                                    <div class="swatch clearfix" data-option-index="1">
                                        <div class="allSingleProductSubjectOptionTitle">رنگ</div>
                                        <div v-for="item in post.color" :key="item.name" data-value="Blue" class="swatch-element color blue available">
                                            <div class="tooltip">{{item.name}}</div>
                                            <input quickbeam="color" :id="item.name" type="radio" v-model="form.color" name="color" :value="item.name"  />
                                            <label :for="item.name" :style="{'border-color': item.code}">
                                                <span :style="{'background-color': item.code}"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="allSingleProductSubjectOption" v-if="post.size.length">
                                    <div class="allSingleProductSubjectOptionTitle">سایز</div>
                                    <div class="allCategoryPanel">
                                        <div class="categoryShow" @click="showAllCat = !showAllCat">
                                            <h4>{{form.size}}</h4>
                                            <i>
                                                <svg-icon :icon="'#down'"></svg-icon>
                                            </i>
                                        </div>
                                        <ul v-if="showAllCat">
                                            <VuePerfectScrollbar class="scroll-area">
                                                <li v-for="item in post.size" :key="item.name" :title="item.name" @click="sendSortCat(item.name)">{{item.name}}</li>
                                            </VuePerfectScrollbar>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allSingleProductSubjectOption">
                                    <div class="allSingleProductSubjectOptionTitle">ویژگی کالا</div>
                                    <ul>
                                        <li v-for="(item , index) in JSON.parse(post.post_meta[0].ability).slice(0,8)" :key="index">
                                            <svg-icon :icon="'#checkmark'"></svg-icon>
                                            {{item.name}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="allSingleProductDetail">
                            <div class="allSingleTopDetailItem" title="تاریخ ثبت">
                                <svg-icon :icon="'#calendar'"></svg-icon>
                                <span>{{post.created_at}}</span>
                            </div>
                            <div class="allSingleTopDetailItem" title="شناسه کالا">
                                <svg-icon :icon="'#barcode'"></svg-icon>
                                <span>{{post.code}}</span>
                            </div>
                            <div class="allSingleTopDetailItem" title="رنگ انتخابی">
                                <svg-icon :icon="'#color'"></svg-icon>
                                <span v-if="post.color.length">{{form.color}}</span>
                                <span v-else>نامشخص</span>
                            </div>
                            <div class="allSingleTopDetailItem" title="سایز انتخابی">
                                <svg-icon :icon="'#sizeFront'"></svg-icon>
                                <span v-if="post.size.length">{{form.size}}</span>
                                <span v-else>نامشخص</span>
                            </div>
                            <div class="allSingleTopDetailItem" title="گارانتی">
                                <svg-icon :icon="'#shield'"></svg-icon>
                                <span>{{post.post_meta[0].guarantee}}</span>
                            </div>
                            <div class="allSingleTopDetailItem" title="وضعیت">
                                <svg-icon :icon="'#found'"></svg-icon>
                                <span v-if="post.count >= 1">موجود در انبار</span>
                                <span v-else>ناموجود</span>
                            </div>
                            <div class="allSingleTopDetailItemPrice">
                                <s v-if="post.off">{{post.offPrice|NumFormat}} تومان</s>
                                <span v-if="post.off">{{post.off}}٪</span>
                                <h3>
                                    {{post.price|NumFormat}}
                                    <h5>تومان</h5>
                                </h3>
                                <button @click="AddCartSingle">
                                    <svg-icon :icon="'#cart'"></svg-icon>
                                    افزودن به سبد خرید
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="allSingleRell">
                <div class="allHooperItemsTitle">
                    <h3>محصولات مرتبط</h3>
                    <div class="allHooperItemsTitleBlock"></div>
                </div>
                <hooper :settings="hooperSettings">
                    <slide v-for="item in related" :key="item.id" :title="item.title">
                        <inertia-link :href="'/product/' + item.slug">
                            <article class="allSuggestIndexPost">
                                <div class="offProduct" v-if="item.off">
                                    <div class="offProductItem">
                                        <svg-icon :icon="'#off-tag'"></svg-icon>
                                        <div>
                                            <span>٪{{item.off}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="allSuggestIndexPostPic">
                                    <img :src="JSON.parse(item.image)[0]" :alt="item.title">
                                    <img v-if="JSON.parse(item.image)[1]" v-lazy="JSON.parse(item.image)[1]" :alt="item.title">
                                    <img v-else v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                </div>
                                <h3>{{item.title}}</h3>
                                <div class="allSurprisingSubjectPrice">
                                    <s v-if="item.off">{{item.offPrice|NumFormat}} تومان</s>
                                    <h4>
                                        {{item.price|NumFormat}}
                                        <span>تومان</span>
                                    </h4>
                                </div>
                                <div class="allSuggestIndexPostOptions">
                                    <div class="allSuggestIndexPostOption" @click.prevent="btnBookmark(item.id)">
                                        <svg-icon v-for="(values,index) in bookmark" :key="index" v-if="values == item.id" :icon="'#bookmark'"></svg-icon>
                                        <svg-icon :icon="'#unbookmark'"></svg-icon>
                                    </div>
                                    <div class="allSuggestIndexPostOption" @click.prevent="btnLike(item.id)">
                                        <svg-icon v-for="(values,index) in like" :key="index" v-if="values == item.id" :icon="'#like'"></svg-icon>
                                        <svg-icon :icon="'#unlike'"></svg-icon>
                                    </div>
                                </div>
                            </article>
                        </inertia-link>
                    </slide>
                    <hooper-navigation slot="hooper-addons"></hooper-navigation>
                </hooper>
            </div>
            <div class="allSingleData">
                <div class="allSingleDescription">
                    <div class="allSingleDescriptionTitles">
                        <div class="allSingleDescriptionTitle">
                            <div class="allSingleDescriptionTitleItems" @click="showDetail = 0">
                                <div class="active" v-if="showDetail == 0">
                                    <i>
                                        <svg-icon :icon="'#detail'"></svg-icon>
                                    </i>
                                    <span>جزییات و بررسی</span>
                                </div>
                                <div v-else>
                                    <i>
                                        <svg-icon :icon="'#detail'"></svg-icon>
                                    </i>
                                    <span>جزییات و بررسی</span>
                                </div>
                            </div>
                            <div class="allSingleDescriptionTitleItems" @click="showDetail = 1">
                                <div class="active" v-if="showDetail == 1">
                                    <i>
                                        <svg-icon :icon="'#ability'"></svg-icon>
                                    </i>
                                    <span>مشخصات</span>
                                </div>
                                <div v-else>
                                    <i>
                                        <svg-icon :icon="'#ability'"></svg-icon>
                                    </i>
                                    <span>مشخصات</span>
                                </div>
                            </div>
                            <div class="allSingleDescriptionTitleItems" @click="showDetail = 2">
                                <div class="active" v-if="showDetail == 2">
                                    <i>
                                        <svg-icon :icon="'#commentFront'"></svg-icon>
                                    </i>
                                    <span>دیدگاه</span>
                                </div>
                                <div v-else>
                                    <i>
                                        <svg-icon :icon="'#commentFront'"></svg-icon>
                                    </i>
                                    <span>دیدگاه</span>
                                </div>
                            </div>
                        </div>
                        <div class="allSingleDescriptionButtons">
                            <i @click="btnDetail(0)">
                                <svg-icon :icon="'#right'"></svg-icon>
                            </i>
                            <i @click="btnDetail(1)">
                                <svg-icon :icon="'#left'"></svg-icon>
                            </i>
                        </div>
                    </div>
                    <div class="allSingleDetailContainer" v-if="showDetail == 0">
                        <div class="allSingleDetailContainerItem" v-if="post.summery != null">
                            <label>توضیح اجمالی</label>
                            <div class="allSingleDetailContainerItemBody">
                                <p v-html="post.summery"></p>
                            </div>
                        </div>
                        <div class="allSingleDetailContainerItem" v-if="post.post_meta[0].body != null">
                            <label>توضیحات تخصصی</label>
                            <div class="allSingleDetailContainerItemBody">
                                <p v-html="post.post_meta[0].body"></p>
                            </div>
                        </div>
                    </div>
                    <div class="allSingleDetailProperties" v-if="showDetail == 1">
                        <label>مشخصات فنی</label>
                        <ul>
                            <li v-for="(item , check) in JSON.parse(post.post_meta[0].property)" :key="check">
                                <h3>{{item.title}}</h3>
                                <p>{{item.body}}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="allSingleDescriptionComment" v-if="showDetail == 2">
                        <all-comment v-on:allRate="getAllRate" :posts="post" :rate="JSON.parse(post.post_meta[0].rate)" :replyAllow="reply" :showUser="showUser" :coercion="coercion" :checkOnline="checkOnline"></all-comment>
                    </div>
                </div>
                <div class="allSingleDataShops">
                    <div class="allSingleDataShop">
                        <div class="allSingleDataShopTop">
                            <img :src="JSON.parse(post.image)[0]" :alt="post.title">
                            <div class="allSingleDataShopTitle">
                                <h3>{{post.title}}</h3>
                                <h4 v-if="form.color">- {{form.color}}</h4>
                                <h4 v-if="form.size">- {{form.size}}</h4>
                            </div>
                        </div>
                        <div class="allSingleShopDetail">
                            <div class="allSingleShopDetailItem">
                                <svg-icon :icon="'#shield'"></svg-icon>
                                <span>{{post.post_meta[0].guarantee}}</span>
                            </div>
                            <div class="allSingleShopDetailItem">
                                <svg-icon :icon="'#found'"></svg-icon>
                                <span v-if="post.count >= 1">موجود در انبار</span>
                                <span v-else>ناموجود</span>
                            </div>
                            <div class="allSingleShopDetailPrice">
                                <s v-if="post.off">{{post.offPrice|NumFormat}} تومان</s>
                                <span v-if="post.off">{{post.off}}٪</span>
                                <h3>
                                    {{post.price|NumFormat}}
                                    <h5>تومان</h5>
                                </h3>
                                <button @click="AddCartSingle">
                                    <svg-icon :icon="'#cart'"></svg-icon>
                                    افزودن به سبد خرید
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showAllShare" v-if="showShare">
                <div class="showAllShareHome">
                    <div class="showAllShareTop">
                        <span>اشتراک گذاری در شبکه های اجتماعی</span>
                        <i @click="showShare = false">
                            <svg-icon :icon="'#cancel'"></svg-icon>
                        </i>
                    </div>
                    <div class="showAllShareItems">
                        <div class="showAllShareItem">
                            <a :href="'https://twitter.com/intent/tweet?url=' + address + 'product/' + post.slug" target="_blank">
                                <i>
                                    <svg-icon :icon="'#twitter'"></svg-icon>
                                </i>
                            </a>
                            <span>توییتر</span>
                        </div>
                        <div class="showAllShareItem">
                            <a :href="'https://telegram.me/share/url?url=' + address + 'product/' + post.slug" target="_blank">
                                <i>
                                    <svg-icon :icon="'#telegram'"></svg-icon>
                                </i>
                            </a>
                            <span>تلگرام</span>
                        </div>
                        <div class="showAllShareItem">
                            <a :href="'https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=' + address + 'product/' + post.slug" target="_blank">
                                <i>
                                    <svg-icon :icon="'#facebook'"></svg-icon>
                                </i>
                            </a>
                            <span>فیسبوک</span>
                        </div>
                        <div class="showAllShareItem">
                            <a :href="'https://api.whatsapp.com/send/?phone&text=' + address + 'product/' + post.slug" target="_blank">
                                <i>
                                    <svg-icon :icon="'#whatsapp'"></svg-icon>
                                </i>
                            </a>
                            <span>واتساپ</span>
                        </div>
                    </div>
                    <div class="showAllShareTag">
                        <i>
                            <svg-icon :icon="'#tag'"></svg-icon>
                        </i>
                        <span>{{address}}product/{{post.slug}}</span>
                    </div>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '../../../Layouts/Home/HomeLayout.vue'
import SvgIcon from '../../Svg/SvgIcon.vue'
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination} from 'hooper';
import 'hooper/dist/hooper.css';
import AllComment from './AllComment.vue';
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import FlipCountdown from "vue2-flip-countdown";
export default {
    props:['post','related' , 'reply','title' , 'show' , 'showUser' , 'coercion' , 'checkOnline' , 'address'],
    components: {
        SvgIcon,
        HomeLayout,
        HooperNavigation,
        VuePerfectScrollbar,
        HooperPagination,
        Slide,
        Hooper,
        AllComment,
        FlipCountdown,
    },
    data(){
        return{
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                transition: 700,
                breakpoints: {
                    700: {
                        itemsToShow: 2,
                        itemsToSlide: 2,
                    },
                    900: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                    1100: {
                        itemsToShow: 4,
                        itemsToSlide: 4,
                    },
                    1300: {
                        itemsToShow: 5,
                        itemsToSlide: 5,
                    },
                    1600: {
                        itemsToShow: 6,
                        itemsToSlide: 6,
                    },
                    1800: {
                        itemsToShow: 7,
                        itemsToSlide: 7,
                    },
                }
            },
            hooperSettings2: {
                wheelControl:false,
                centerMode: false,
                transition: 700,
                breakpoints: {
                    100: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                }
            },
            form:{
                color : '',
                size : '',
            },
            showImage:0,
            showDetail: 0,
            rating: 0,
            allRate: 0,
            countRate: 0,
            showAllCat:false,
            showShare:false,
            like: [],
            bookmark: [],
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
        getAllRate(item){
            this.allRate = item;
            ++this.countRate;
        },
        sendSortCat(name){
            this.form.size = name;
            this.showAllCat = false;
        },
        btnLike(id){
            const url = `/like`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.like = [];
                    }else{
                        if (response.data === 'delete'){
                            this.getLike();
                        }else{
                            this.$toast.success('انجام شد', 'به علاقه مندی با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.getLike();
                        }
                    }
                })
        },
        getLike(){
            const url = `/get-like`;
            axios.get(url)
                .then(response=>{
                    this.like = response.data;
                })
        },
        btnBookmark(id){
            const url = `/bookmark`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.bookmark = [];
                    }else {
                        if (response.data === 'delete') {
                            this.getBookmark();
                        }else {
                            this.$toast.success('انجام شد', 'نشانه با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.bookmark.push(response.data.post_id);
                        }
                    }
                })
        },
        getBookmark(){
            const url = `/get-bookmark`;
            axios.get(url)
                .then(response=>{
                    this.bookmark = response.data;
                })
        },
        getData(){
            if(this.post.color.length){
                this.form.color=this.post.color[0].name;
            }
            if(this.post.size.length){
                this.form.size=this.post.size[0].name;
            }
        },
        btnDetail(number){
            if(number == 0){
                if(this.showDetail == 0){
                    this.showDetail = 2;
                }else{
                    --this.showDetail;
                }
            }
            if(number == 1){
                if(this.showDetail == 2){
                    this.showDetail = 0;
                }else{
                    ++this.showDetail;
                }
            }
        },
        getRate(){
            const url = '/get-rate';
            axios.post(url ,{
                post_id : this.post.id,
            })
                .then(response=>{
                    this.rating = response.data[0];
                    this.allRate = response.data[1];
                    this.countRate = response.data[2];
                })
        },
        allViews(){
            const url = "/view";
            axios.post(url,{
                postId : this.post.id
            })
        },
        AddCartSingle(){
            const url = `/add-cart-single`;
            axios.post(url ,{
                postID : this.post.id,
                color : this.form.color,
                size : this.form.size,
            })
                .then(response=>{
                    if(response.data == 'limit'){
                        this.$toast.error('انجام نشد', 'موجودی کالا کافی نیست', this.notificationSystem.options.error);
                    }
                    if (response.data === 'no'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                    }else{
                        this.$eventHub.emit('getCart');
                        this.$toast.success('با موفقیت انجام شد', 'به سبد خرید با موفقیت اضافه شد', this.notificationSystem.options.success);
                    }
                })
        },
    },
    mounted(){
        this.getData();
        this.getRate();
        this.getBookmark();
        this.getLike();
        this.allViews();
    }
}
</script>

<style>

</style>
