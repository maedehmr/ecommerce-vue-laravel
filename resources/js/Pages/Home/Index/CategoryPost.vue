<template>
    <div class="allCategoryPosts" v-if="allCatPost">
        <div class="allCategoryPost width" :title="catSiteAdvance.post.name">
            <div class="allCategories">
                <div class="allCategoriesRight">
                    <div class="allCategoriesRightTitles">
                        <div class="allCategoriesRightTitle">
                            از زیرمجموعه های
                            <h3>{{catSiteAdvance.post.name}}</h3>
                            دیدن فرمایید
                        </div>
                        <div class="allCategoryPostTitlesOptions">
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 0">جدیدترین</button>
                                <button v-else @click="btnFilterCatPost(0)">جدیدترین</button>
                            </div>
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 1">محبوبترین</button>
                                <button v-else @click="btnFilterCatPost(1)">محبوبترین</button>
                            </div>
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 2">پربازدیدترین</button>
                                <button v-else @click="btnFilterCatPost(2)">پربازدیدترین</button>
                            </div>
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 3">پرفروش ترین</button>
                                <button v-else @click="btnFilterCatPost(3)">پرفروش ترین</button>
                            </div>
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 4">ارزان ترین</button>
                                <button v-else @click="btnFilterCatPost(4)">ارزان ترین</button>
                            </div>
                            <div class="allCategoryPostTitlesOption">
                                <button class="active" v-if="allCatPost.optionTab == 5">گران ترین</button>
                                <button v-else @click="btnFilterCatPost(5)">گران ترین</button>
                            </div>
                        </div>
                    </div>
                    <div class="allCategoriesRightPosts">
                        <div class="allCategoriesRightPostsItems">
                            <div class="allCategoriesRightPostsItem" v-for="cats in catSiteAdvance.post.cats" :key="cats.id" :title="cats.name" @click="btnShowCatPost(cats.id)">
                                <button class="active" v-if="allCatPost.categoryTab == cats.id">
                                    <div class="allCategoriesLeftItem">
                                        <div class="allCategoriesLeftItemPic">
                                            <img v-lazy="JSON.parse(cats.post[0].image)[0]" :alt="cats.post[0].title">
                                        </div>
                                        <div class="allCategoriesLeftItemData">
                                            <div class="allCategoriesLeftItemInfo">
                                                <h3>{{cats.name}}</h3>
                                                <h5>{{cats.post.length}} کالا</h5>
                                            </div>
                                            <svg-icon :icon="'#left'"></svg-icon>
                                        </div>
                                    </div>
                                </button>
                                <button v-else>
                                    <div class="allCategoriesLeftItem">
                                        <div class="allCategoriesLeftItemPic">
                                            <img v-lazy="JSON.parse(cats.post[0].image)[0]" :alt="cats.post[0].title">
                                        </div>
                                        <div class="allCategoriesLeftItemData">
                                            <div class="allCategoriesLeftItemInfo">
                                                <h3>{{cats.name}}</h3>
                                                <h5>{{cats.post.length}} کالا</h5>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <hooper :settings="hooperSettings">
                            <slide v-for="post in allCatPost.posts" :key="post.id" :title="post.title">
                                <inertia-link :href="'/product/'+post.slug">
                                    <article class="allCategoryPostItem">
                                        <div class="offProduct" v-if="post.off">
                                            <div class="offProductItem">
                                                <svg-icon :icon="'#off-tag'"></svg-icon>
                                                <div>
                                                    <span>٪{{post.off}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="allSuggestIndexPostOption" v-if="post.used == 1">کارکرده</div>
                                        <div class="allCategoryPostItemPic">
                                            <img v-lazy="JSON.parse(post.image)[0]" :alt="post.title">
                                        </div>
                                        <div class="allCategoryPostItemSubject">
                                            <h3>{{post.title}}</h3>
                                            <div class="allCategoryPostItemPrice">
                                                <h4>
                                                    {{post.price|NumFormat}}
                                                    <span>تومان</span>
                                                </h4>
                                                <i @click.prevent="addCart(post.id)">
                                                    <svg-icon :icon="'#add2'"></svg-icon>
                                                </i>
                                            </div>
                                        </div>
                                    </article>
                                </inertia-link>
                            </slide>
                            <hooper-navigation slot="hooper-addons"></hooper-navigation>
                        </hooper>
                    </div>
                </div>
            </div>
            <div class="allCategoryPostsOver" v-if="allCatPost.loading != 9">
                <div class="loader">
                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon.vue';
import 'hooper/dist/hooper.css';
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination,} from 'hooper';
export default {
    props:['catSiteAdvance'],
    components: {
        SvgIcon,
        Hooper,
        HooperNavigation,
        HooperPagination,
        Slide,
    },
    data(){
        return{
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                transition: 700,
                breakpoints: {
                    100: {
                        itemsToShow: 2,
                        itemsToSlide: 2,
                    },
                    1100: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                    1300: {
                        itemsToShow: 4,
                        itemsToSlide: 4,
                    },
                    1500: {
                        itemsToShow: 5,
                        itemsToSlide: 5,
                    },
                }
            },
            allCatPost:[],
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
            showPostCategory: ['0','0'],
        }
    },
    methods:{
        btnFilterCatPost(number){
            this.allCatPost.optionTab= number;
            this.allCatPost.loading= number;
            const url = '/get-filter-cat-post';
            axios.post(url ,{
                filter: number,
                category: this.allCatPost.categoryTab,
            })
                .then(response=>{
                    this.allCatPost.posts = response.data;
                    this.allCatPost.loading= 9;
                })
        },
        btnShowCatPost(id){
            this.allCatPost.categoryTab= id;
            this.allCatPost.loading= 10;
            const url = '/get-filter-cat-post';
            axios.post(url ,{
                filter: this.allCatPost.optionTab,
                category: this.allCatPost.categoryTab,
            })
                .then(response=>{
                    this.allCatPost.posts = response.data;
                    this.allCatPost.loading= 9;
                })
        },
        getData(){
            this.allCatPost={
                categoryTab: '',
                optionTab: '',
                loading: 9,
                posts: '',
            };
            this.allCatPost.categoryTab = this.catSiteAdvance.post.cats[0].id;
            if(this.catSiteAdvance.show == 0){
                this.allCatPost.optionTab = 0;
            }
            if(this.catSiteAdvance.show == 1){
                this.allCatPost.optionTab = 1;
            }
            if(this.catSiteAdvance.show == 2){
                this.allCatPost.optionTab = 2;
            }
            if(this.catSiteAdvance.show == 5){
                this.allCatPost.optionTab = 3;
            }
            if(this.catSiteAdvance.show == 3){
                this.allCatPost.optionTab = 4;
            }
            if(this.catSiteAdvance.show == 4){
                this.allCatPost.optionTab = 5;
            }
            this.allCatPost.posts = this.catSiteAdvance.post.cats[0].post;
        },
        addCart(id){
            const url = `/add-cart`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if(response.data == 'limit'){
                        this.$toast.error('انجام نشد', 'موجودی کالا کافی نیست', this.notificationSystem.options.error);
                    }
                    if (response.data === 'no'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                    }else{
                        this.$eventHub.emit('getCart');
                        this.$toast.success('انجام شد', 'به سبد خرید با موفقیت اضافه شد', this.notificationSystem.options.success);
                    }
                })
        },
    },
    mounted(){
        this.getData();
    }
}
</script>

<style>

</style>
