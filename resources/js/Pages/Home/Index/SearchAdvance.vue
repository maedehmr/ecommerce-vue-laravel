<template>
    <div class="allSearchAdvanceIndex">
        <div class="allSearchAdvance width">
            <div class="allSearchAdvanceRight">
                <div class="allSearchAdvanceRightSearch">
                    <div class="allSearchAdvanceRightTitle">
                        <label for="search-advance">
                            <svg-icon :icon="'#search'"></svg-icon>
                            <input id="search-advance" v-model="form.name" type="text" placeholder="نام محصول را وارد کنید">
                        </label>
                    </div>
                    <div class="allSearchAdvanceRightContainer">
                        <div class="allSearchAdvanceRightContainerTitle">جستجو پیشرفته</div>
                        <div class="allSearchAdvanceRightContainerItems">
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkAbility" class="allHeaderIndexInput" @keydown="ability = 'start'">
                                    <span :class="ability">ویژگی کالا</span>
                                    <input id="checkAbility" type="text" v-model="form.ability">
                                </label>
                            </div>
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkCode" class="allHeaderIndexInput" @keydown="code = 'start'">
                                    <span :class="code">کد محصول</span>
                                    <input id="checkCode" type="text" v-model="form.code">
                                </label>
                            </div>
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkOff" class="allHeaderIndexInput" @keydown="off = 'start'">
                                    <span :class="off">تخفیف محصول</span>
                                    <input id="checkOff" type="text" v-model="form.off">
                                </label>
                            </div>
                        </div>
                        <div class="allSearchAdvanceRightContainerItems">
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkColor" class="allHeaderIndexInput" @click="color = 'start'">
                                    <span :class="color">رنگ محصول</span>
                                    <div class="allCategoryPanel" @click="changeSearchShow(1)">
                                        <input id="checkColor" type="text" v-model="form.color" @keyup="btnSearch('رنگ')">
                                        <ul v-if="showSearch == 1">
                                            <PerfectScrollbar>
                                                <li v-for="(item,index) in allColorsList" :key="index" @click="getColor(item.name)">{{item.name}}</li>
                                            </PerfectScrollbar>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkColor" class="allHeaderIndexInput" @click="category = 'start'">
                                    <span :class="category">دسته بندی محصول</span>
                                    <div class="allCategoryPanel" @click="changeSearchShow(2)">
                                        <input type="text" v-model="form.category" @keyup="btnSearch('دسته')">
                                        <ul v-if="showSearch == 2">
                                            <PerfectScrollbar>
                                            <li v-for="(item,index) in allCategoriesList" :key="index" @click="getCategory(item.name)">{{item.name}}</li>
                                            </PerfectScrollbar>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                            <div class="allSearchAdvanceRightContainerItem">
                                <label for="checkBrand" class="allHeaderIndexInput" @click="brand = 'start'">
                                    <span :class="brand">برند محصول</span>
                                    <div class="allCategoryPanel" @click="changeSearchShow(3)">
                                        <input id="checkBrand" type="text" v-model="form.brand" @keyup="btnSearch('برند')">
                                        <ul v-if="showSearch == 3">
                                            <PerfectScrollbar>
                                                <li v-for="(item,index) in allBrandList" :key="index" @click="getBrand(item.name)">{{item.name}}</li>
                                            </PerfectScrollbar>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="allSearchAdvanceRightContainerItemsButton">
                            <div class="allSearchAdvanceRightContainerButtonItem">
                                <a href="#searchResult" @click="btnSearchAdvance">
                                    جستجو
                                    <img v-if="showLoader" src="/img/loading.gif" alt="صبر کنید">
                                </a>
                                <button @click="btnClear">پاک کردن</button>
                            </div>
                            <h4>
                                <span>{{posts.length|NumFormat}}</span>
                                مورد
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="allSearchAdvanceRightPic" id="searchResult">
                    <a :href="info.slug">
                        <img :src="info.title" :alt="info.title">
                    </a>
                </div>
            </div>
            <div class="allSearchAdvanceLeft">
                <hooper :settings="hooperSettings2">
                    <slide v-for="post in moment" :key="post.id" :title="post.title">
                        <inertia-link :href="'/product/' + post.slug">
                            <div class="allSearchAdvanceLeftTitle">
                                پیشنهاد لحظه ای
                            </div>
                            <div class="allSearchAdvanceLeftPic">
                                <img v-lazy="JSON.parse(post.image)[0]">
                            </div>
                            <div class="allSearchAdvanceLeftSubject">
                                <inertia-link :href="'/product/' + post.slug">{{post.title}}</inertia-link>
                                <h4>
                                    {{post.price|NumFormat}}
                                    <span>تومان</span>
                                </h4>
                            </div>
                        </inertia-link>
                    </slide>
                </hooper>
            </div>
        </div>
        <div>
            <div class="allHoopers" v-if="posts.length">
                <div class="allHooperItems">
                    <div class="allHooperItemsTitle">
                        <h3>نتیجه جستجو</h3>
                        <div class="allHooperItemsTitleBlock"></div>
                    </div>
                    <hooper :settings="hooperSettings">
                        <slide v-for="item in posts" :key="item.id" :title="item.title">
                            <inertia-link :href="'/product/'+item.slug">
                                <article class="allHoopersPost">
                                    <div class="offProduct" v-if="item.off">
                                        <div class="offProductItem">
                                            <svg-icon :icon="'#off-tag'"></svg-icon>
                                            <div>
                                                <span>٪{{item.off}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="allHoopersPostPic">
                                        <img v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                    </div>
                                    <h3>{{item.title}}</h3>
                                    <div class="allHoopersPostData">
                                        <h4>
                                            <svg-icon :icon="'#info'"></svg-icon>
                                            <span>
                                                جزییات
                                            </span>
                                        </h4>
                                        <div class="allHoopersPostDataPrice">
                                            <h6>تومان</h6>
                                            <h5>{{item.price|NumFormat}}</h5>
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
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon.vue'
import {PerfectScrollbar} from 'vue2-perfect-scrollbar';
import 'hooper/dist/hooper.css';
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination,} from 'hooper';
export default {
    components: {
        SvgIcon,
        Hooper,
        HooperNavigation,
        HooperPagination,
        PerfectScrollbar,
        Slide,
    },
    props:['allBrand','allColors','allCategories','moment','info'],
    data(){
        return{
            hooperSettings2: {
                wheelControl:false,
                centerMode: false,
                hoverPause: false,
                rtl: true,
                transition: 0,
                itemsToShow: 1,
                autoPlay:true,
                playSpeed : 10000,
                mouseDrag:false,
                touchDrag:false,
            },
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                transition: 700,
                breakpoints: {
                    500: {
                        itemsToShow: 2,
                        itemsToSlide: 2,
                    },
                    800: {
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
                    1500: {
                        itemsToShow: 6,
                        itemsToSlide: 6,
                    },
                }
            },
            form:{
                color : '',
                brand : '',
                name : '',
                ability : '',
                code : '',
                off : '',
                category : '',
            },
            showSearch: 0,
            posts:[],
            showLoader:false,
            i: 0,
            color : '',
            brand : '',
            ability : '',
            code : '',
            off : '',
            category : '',
            allColorsList: this.allColors,
            allBrandList: this.allBrand,
            allCategoriesList: this.allCategories,
        }
    },
    methods:{
        btnClear(){
            this.form.color = '';
            this.form.brand = '';
            this.form.name = '';
            this.form.ability = '';
            this.form.code = '';
            this.form.category = '';
            this.form.off = '';
        },
        getColor(name){
            this.form.color = name;
            this.showSearch = 0;
        },
        getCategory(name){
            this.form.category = name;
            this.showSearch = 0;
        },
        getBrand(name){
            this.form.brand = name;
            this.showSearch = 0;
        },
        btnSearch(name){
            if(name == 'رنگ'){
                const url = '/search-tax';
                axios.post(url ,{
                    taxRoute:name,
                    search:this.form.color,
                })
                    .then(response=>{
                        this.allColorsList = response.data;
                    })
            }
        },
        btnSearchAdvance(){
            this.showLoader = true;
            const url = `/search-advance`;
            axios.post(url , this.form)
            .then(response=>{
                this.posts = response.data;
                this.showLoader = false;
            })
        },
        changeSearchShow(number){
            if(this.showSearch == number){
                this.showSearch = 0;
            }else{
                this.showSearch = number;
            }
        },
    },
}
</script>

<style>

</style>
