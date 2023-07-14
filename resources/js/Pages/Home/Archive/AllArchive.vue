<template>
    <home-layout>
        <div class="AllArchive">
            <div class="AllArchiveTitle width">
                <ul>
                    <li>
                        <inertia-link href="/" title="خانه">
                            <i class="fa fa-home" aria-hidden="true">
                                <svg-icon :icon="'#home'"></svg-icon>
                            </i>
                            <h4>خانه</h4>
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link :href="'/archive/' + url + categories.slug" :key="categories.id" :title="categories.title">
                            <i class="fa fa-home" aria-hidden="true">
                                <svg-icon :icon="'#box'"></svg-icon>
                            </i>
                            <h4>{{categories.name}}</h4>
                        </inertia-link>
                    </li>
                    <li v-if="url == 'category/'" v-for="item in categories.cats" :key="item.id" :title="item.title">
                        <inertia-link :href="'/archive/' + url + item.slug">
                            <i class="fa fa-home" aria-hidden="true">
                                <svg-icon :icon="'#box'"></svg-icon>
                            </i>
                            <h4>{{item.name}}</h4>
                        </inertia-link>
                    </li>
                </ul>
            </div>
            <div class="AllArchiveCategories width" v-if="url == 'category/' && categories.cats.length">
                <div class="AllArchiveCategoriesTitle">
                    <div class="AllArchiveCategoriesTitleItem">
                        <span>دسته بندی ها</span>
                    </div>
                </div>
                <div class="AllArchiveCategoriesItems">
                    <inertia-link class="AllArchiveCategoriesItem" v-for="value in categories.cats" v-if="value.post[0]" :key="value.id" :title="value.name" :href="'/archive/category/' + value.slug">
                        <div class="AllArchiveCategoriesItemPic">
                            <img :src="JSON.parse(value.post[0].image)[0]" :alt="value.name">
                        </div>
                        <h4>{{value.name}}</h4>
                    </inertia-link>
                </div>
            </div>
            <div class="AllArchiveData width">
                <div class="AllArchiveDataFilters">
                    <div class="AllArchiveDataFiltersShowcase">
                        <div class="AllArchiveDataFiltersShowcaseTitle">
                            ویترین محصولات
                        </div>
                        <hooper :settings="hooperSettings">
                            <slide v-for="(item,index) in showcasePost" :key="index">
                                <inertia-link :href="'/product/'+ item.slug"  class="AllArchiveDataFiltersShowcaseItem">
                                    <img :src="JSON.parse(item.image)[0]" :alt="item.title">
                                    <h3>{{item.title}}</h3>
                                    <h4>
                                        {{item.price|NumFormat}}
                                        <span>تومان</span>
                                    </h4>
                                </inertia-link>
                            </slide>
                            <hooper-pagination slot="hooper-addons"></hooper-pagination>
                        </hooper>
                    </div>
                    <div class="AllArchiveDataFiltersItems" v-if="off.length">
                        <div class="AllArchiveDataFiltersItemsTitle" @click="showOff = !showOff">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                تخفیف ها
                            </div>
                            <i v-if="showOff">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersItemContainer" v-if="showOff">
                                <PerfectScrollbar class="scroll-area" :settings="settings">
                                    <div class="AllArchiveDataFiltersItem" v-for="item in off">
                                        <label :for="item">
                                            <input :id="item" type="checkbox" @change="sendOff(item)">
                                            {{item}}
                                        </label>
                                    </div>
                                </PerfectScrollbar>
                            </div>
                        </transition>
                    </div>
                    <div class="AllArchiveDataFiltersSearch">
                        <div class="AllArchiveDataFiltersSearchTitle">
                            جستجو نام کالا
                        </div>
                        <div class="AllArchiveDataFiltersSearchItem">
                            <label>
                                <input type="text" placeholder="نام را وارد کنید ..." v-model="search" @keypress.enter="btnChange">
                            </label>
                        </div>
                    </div>
                    <div class="AllArchiveDataFiltersItems" v-if="brands.length">
                        <div class="AllArchiveDataFiltersItemsTitle" @click="showBrand = !showBrand">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                برند ها
                            </div>
                            <i v-if="showBrand">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersItemContainer" v-if="showBrand">
                                <PerfectScrollbar class="scroll-area" :settings="settings">
                                    <div class="AllArchiveDataFiltersItem" v-for="item in brands">
                                        <label :for="item.name">
                                            <input :id="item.name" type="checkbox" @change="sendBrand(item.name)">
                                            {{item.name}}
                                        </label>
                                    </div>
                                </PerfectScrollbar>
                            </div>
                        </transition>
                    </div>
                    <div class="AllArchiveDataFiltersPrice">
                        <div class="AllArchiveDataFiltersPriceTitle" @click="showPrice = !showPrice">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                محدوده قیمت ها
                            </div>
                            <i v-if="showPrice">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersPriceItem" v-if="showPrice">
                                <VueSimpleRangeSlider
                                    :max="maxPrice"
                                    :logarithmic="true"
                                    v-model="rangePrice"
                                />
                                <input v-model="rangePrice" hidden>
                                <div class="AllArchiveDataFiltersPriceItemNumbers">
                                    <div class="AllArchiveDataFiltersPriceItemNumber">
                                        <span>از</span>
                                        <h5>{{showMinPrice|NumFormat}}</h5>
                                        <span>تومان</span>
                                    </div>
                                    <div class="AllArchiveDataFiltersPriceItemNumber">
                                        <span>تا</span>
                                        <h5>{{showMaxPrice|NumFormat}}</h5>
                                        <span>تومان</span>
                                    </div>
                                </div>
                            </div>
                        </transition>
                        <transition name="slide-fade">
                            <div class="button" v-if="showPrice">
                                <button @click="btnChange">اعمال محدود سازی</button>
                            </div>
                        </transition>
                    </div>
                    <div class="AllArchiveDataFiltersItems" v-if="color.length">
                        <div class="AllArchiveDataFiltersItemsTitle" @click="showColor = !showColor">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                رنگ ها
                            </div>
                            <i v-if="showColor">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersItemContainer" v-if="showColor">
                                <PerfectScrollbar class="scroll-area" :settings="settings">
                                    <div class="AllArchiveDataFiltersItem" v-for="item in color" :key="item.id">
                                        <label :for="item.id">
                                            <input :id="item.id" type="checkbox" @change="sendColor(item.id)">
                                            <svg-icon :icon="'#circle'" :style="{'fill' : item.code}"></svg-icon>
                                            {{item.name}}
                                        </label>
                                    </div>
                                </PerfectScrollbar>
                            </div>
                        </transition>
                    </div>
                    <div class="AllArchiveDataFiltersCheck">
                        <label for="count">
                            <input id="count" type="checkbox" class="switch" v-model="count" @change="btnChange">
                            فقط کالاهای موجود
                        </label>
                    </div>
                    <div class="AllArchiveDataFiltersCheck">
                        <label for="suggest">
                            <input id="suggest" type="checkbox" class="switch" v-model="suggest" @change="btnChange">
                            فقط کالاهای پیشنهادی
                        </label>
                    </div>
                    <div class="AllArchiveDataFiltersItems" v-if="size.length">
                        <div class="AllArchiveDataFiltersItemsTitle" @click="showSize = !showSize">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                سایز ها
                            </div>
                            <i v-if="showSize">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersItemContainer" v-if="showSize">
                                <PerfectScrollbar class="scroll-area" :settings="settings">
                                    <div class="AllArchiveDataFiltersItem" v-for="item in size">
                                        <label :for="item.id">
                                            <input :id="item.id" type="checkbox" @change="sendSize(item.id)">
                                            {{item.name}}
                                        </label>
                                    </div>
                                </PerfectScrollbar>
                            </div>
                        </transition>
                    </div>
                    <div class="AllArchiveDataFiltersItems" v-if="ability.length">
                        <div class="AllArchiveDataFiltersItemsTitle" @click="showAbility = !showAbility">
                            <div class="AllArchiveDataFiltersItemsTitleOption">
                                ویژگی های کالا
                            </div>
                            <i v-if="showAbility">
                                <svg-icon :icon="'#up'"></svg-icon>
                            </i>
                            <i v-else>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <transition name="slide-fade">
                            <div class="AllArchiveDataFiltersItemContainer" v-if="showAbility">
                                <PerfectScrollbar class="scroll-area" :settings="settings">
                                    <div class="AllArchiveDataFiltersItem" v-for="item in ability">
                                        <label :for="item.name">
                                            <input :id="item.name" type="checkbox" @change="sendAbility(item.name)">
                                            {{item.name}}
                                        </label>
                                    </div>
                                </PerfectScrollbar>
                            </div>
                        </transition>
                    </div>
                </div>
                <div class="AllArchiveDataPosts">
                    <all-surprising :getSuggest="suggestPost" showTab="0"></all-surprising>
                    <div class="paginate" v-if="catPost.links">
                        <paginate-panel :link="catPost.links"></paginate-panel>
                    </div>
                    <div class="AllArchiveDataPostsFilter">
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(0)">
                            <h4 class="active" v-if="show == 0">جدیدترین</h4>
                            <h4 v-else>جدیدترین</h4>
                        </div>
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(1)">
                            <h4 class="active" v-if="show == 1">پربازدیدترین</h4>
                            <h4 v-else>پربازدیدترین</h4>
                        </div>
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(2)">
                            <h4 class="active" v-if="show == 2">پرفروش ترین</h4>
                            <h4 v-else>پرفروش ترین</h4>
                        </div>
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(3)">
                            <h4 class="active" v-if="show == 3">محبوبترین</h4>
                            <h4 v-else>محبوبترین</h4>
                        </div>
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(4)">
                            <h4 class="active" v-if="show == 4">ارزان ترین</h4>
                            <h4 v-else>ارزان ترین</h4>
                        </div>
                        <div class="AllArchiveDataPostsFilterItem" @click="btnShowSort(5)">
                            <h4 class="active" v-if="show == 5">گران ترین</h4>
                            <h4 v-else>گران ترین</h4>
                        </div>
                    </div>
                    <div class="AllArchiveDataPostsData">
                        <div class="AllArchiveDataPostsItems">
                            <div class="AllArchiveDataPostsItem" v-for="(post , index) in catPost.data" :key="index" :title="post.title">
                                <inertia-link :href="'/product/' + post.slug">
                                    <div class="offProduct" v-if="post.off">
                                        <div class="offProductItem">
                                            <svg-icon :icon="'#off-tag'"></svg-icon>
                                            <div>
                                                <span>٪{{post.off}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="AllArchiveDataPostsItemPic">
                                        <img :src="JSON.parse(post.image)[0]" :alt="post.title">
                                        <img v-if="JSON.parse(post.image)[1]" :src="JSON.parse(post.image)[1]" :alt="post.title">
                                        <img v-else :src="JSON.parse(post.image)[0]" :alt="post.title">
                                    </div>
                                    <div class="AllArchiveDataPostsItemSubject">
                                        <h3>{{post.title}}</h3>
                                        <div class="AllArchiveDataPostsItemSubjectPrice" v-if="post.count >= 1">
                                            <s v-if="post.off">{{post.offPrice|NumFormat}}</s>
                                            <h4>{{post.price|NumFormat}} <span>تومان</span></h4>
                                        </div>
                                        <div class="checkCount" v-else>
                                            <span>ناموجود</span>
                                        </div>
                                    </div>
                                </inertia-link>
                                <i @click="btnComparison(post)">
                                    <svg-icon v-for="(values,index) in allComparison" :key="index" v-if="values.id == post.id" class="active" :icon="'#better'"></svg-icon>
                                    <svg-icon :icon="'#better'"></svg-icon>
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="paginate" v-if="catPost.links">
                        <paginate-panel :link="catPost.links"></paginate-panel>
                    </div>
                </div>
            </div>
            <div class="allComparison" v-if="allComparison.length">
                <div class="allComparisonBlock">
                <div class="allComparisonTitle">
                    <button @click="btnShowCompare">
                    <svg-icon :icon="'#better'"></svg-icon>
                    مقایسه
                    </button>
                    <div class="allComparisonTitleItem" v-for="(item,index) in allComparison" :key="item.id" :title="item.title">
                    <img :src="JSON.parse(item.image)[0]" :alt="item.title">
                    <i @click="deleteComparison(index)">
                        <svg-icon :icon="'#cancel'"></svg-icon>
                    </i>
                    </div>
                </div>
                </div>
                <div class="comparePostsContainerIndex" v-if="postCompares != ''">
                    <div class="comparePostsContainerItems">
                        <table>
                            <tr>
                                <th>
                                    <h5>مقایسه کالا</h5>
                                    <div class="comparePostsContainerItemsClose" @click.stop="postCompares = []">
                                        <i>
                                            <svg-icon :icon="'#cancel'"></svg-icon>
                                        </i>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th v-for="(item , index) in postCompares">
                                    <div class="comparePostsContainerItemsDelete" @click.stop="deleteCompares(index)">
                                        <i>
                                            <svg-icon :icon="'#cancel'"></svg-icon>
                                        </i>
                                    </div>
                                    <div class="comparePostsContainerItemsPic">
                                    <img :src="JSON.parse(item.image)[0]" :alt="item.title">
                                    </div>
                                    <div class="comparePostsContainerItemsTitle">
                                        <h4>{{item.title}}</h4>
                                    </div>
                                    <div class="comparePostsContainerItemsAddCart" @click.prevent="addCart(item.id)" v-if="item.count >= 1">
                                        افزودن به سبد خرید
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <h4>قیمت</h4>
                                </td>
                            </tr>
                            <tr>
                                <td v-for="item in postCompares">
                                    <span>{{item.price|NumFormat}} تومان</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>موجودی</h4>
                                </td>
                            </tr>
                            <tr>
                                <td v-for="item in postCompares">
                                        <span v-if="item.count == 0">
                                            ناموجود
                                        </span>
                                    <span v-else>{{item.count}} کالا</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>مقدار تخفیف</h4>
                                </td>
                            </tr>
                            <tr>
                                <td v-for="item in postCompares">
                                    <span v-if="item.off == null">بدون تخفیف</span>
                                    <span v-else>٪{{item.off}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>رنگ های موجود</h4>
                                </td>
                            </tr>
                            <tr>
                                <td v-for="all in postCompares">
                                    <ul v-if="all.color.length">
                                        <li v-for="(item,index2) in all.color.slice(0 , 3)" :key="index2">
                                            <span>{{item.name}}</span>
                                        </li>
                                    </ul>
                                    <span v-else>بدون رنگ</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>ویژگی ها</h4>
                                </td>
                            </tr>
                            <tr>
                                <td v-for="all in postCompares">
                                    <ul v-if="all.post_meta[0].ability != null">
                                        <li v-for="(item,index2) in JSON.parse(all.post_meta[0].ability).slice(0 , 3)" :key="index2">
                                            <span>{{item.name}}</span>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '../../../Layouts/Home/HomeLayout.vue';
import {PerfectScrollbar} from 'vue2-perfect-scrollbar';
import SvgIcon from '../../Svg/SvgIcon.vue';
import VueSimpleRangeSlider from "vue-simple-range-slider";
import 'vue-simple-range-slider/dist/vueSimpleRangeSlider.css';
import PaginatePanel from '../../Admin/PaginatePanel.vue';
import AllSurprising from '../Index/AllSurprising.vue';
import 'hooper/dist/hooper.css';
import {
    Hooper,
    Slide,
    Pagination as HooperPagination,
} from 'hooper';
export default {
    components: { HomeLayout , Hooper , Slide , HooperPagination , SvgIcon , PerfectScrollbar , VueSimpleRangeSlider, PaginatePanel, AllSurprising },
    name: 'AllArchive',
    props:['color','size','showcasePost','off','url','categories','title','catPost','ability','brands','maxPrice','minPrice','suggestPost'],
    metaInfo() {
        return {
            title: `${this.categories.name} - ${this.title}`,
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
    data(){
        return{
            showOff: true,
            showColor: true,
            showBrand: true,
            showSize: true,
            showPrice: true,
            showAbility: true,
            rangePrice: [this.minPrice,this.maxPrice],
            showMinPrice: this.minPrice,
            showMaxPrice: this.maxPrice,
            allColor: [],
            allBrands: [],
            allSize: [],
            showFast: [],
            allAbility: [],
            allOff: [],
            search: '',
            postCompares: [],
            allComparison: [],
            settings: {
                maxScrollbarLength: 60
            },
            i: 0,
            count: 0,
            show: 0,
            suggest: 0,
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                hoverPause: false,
                rtl: true,
                transition: 300,
                itemsToShow: 1,
                autoPlay:true,
                playSpeed : 5000,
                mouseDrag:false,
                touchDrag:false,
            },
        }
    },
    methods:{
        btnShowSort(number){
            this.show = number;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                show : number,
                allAbility : this.allAbility,
                search : this.search,
                suggest : this.suggest,
                count : this.count,
                allSize : this.allSize,
                allBrands : this.allBrands,
                rangePrice : this.rangePrice,
                allColor : this.allColor,
            })
                .then(response=>{
                    this.show = number;
                })
        },
        btnChange(){
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                allAbility : this.allAbility,
                show : this.show,
                search : this.search,
                suggest : this.suggest,
                count : this.count,
                allSize : this.allSize,
                allBrands : this.allBrands,
                rangePrice : this.rangePrice,
                allColor : this.allColor,
            })
        },
        sendOff(item){
            for ( this.i ; this.i <  this.allOff.length; this.i++) {
                if (this.allOff[this.i] == item){
                    this.allOff.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.allOff.push(item);
            }
            this.i = 0;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                allBrands : this.allBrands,
                suggest : this.suggest,
                show : this.show,
                count : this.count,
                allAbility : this.allAbility,
                search : this.search,
                rangePrice : this.rangePrice,
                allSize : this.allSize,
                allColor : this.allColor,
            })
        },
        sendAbility(item){
            for ( this.i ; this.i <  this.allAbility.length; this.i++) {
                if (this.allAbility[this.i] == item){
                    this.allAbility.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.allAbility.push(item);
            }
            this.i = 0;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                suggest : this.suggest,
                show : this.show,
                count : this.count,
                allBrands : this.allBrands,
                allAbility : this.allAbility,
                allColor : this.allColor,
                rangePrice : this.rangePrice,
                search : this.search,
                allSize : this.allSize,
            })
        },
        sendBrand(item){
            for ( this.i ; this.i <  this.allBrands.length; this.i++) {
                if (this.allBrands[this.i] == item){
                    this.allBrands.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.allBrands.push(item);
            }
            this.i = 0;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                allBrands : this.allBrands,
                suggest : this.suggest,
                count : this.count,
                show : this.show,
                rangePrice : this.rangePrice,
                search : this.search,
                allAbility : this.allAbility,
                allSize : this.allSize,
                allColor : this.allColor,
            })
        },
        sendSize(item){
            for ( this.i ; this.i <  this.allSize.length; this.i++) {
                if (this.allSize[this.i] == item){
                    this.allSize.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.allSize.push(item);
            }
            this.i = 0;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allBrands : this.allBrands,
                allOff : this.allOff,
                search : this.search,
                show : this.show,
                rangePrice : this.rangePrice,
                allAbility : this.allAbility,
                suggest : this.suggest,
                count : this.count,
                allSize : this.allSize,
                allColor : this.allColor,
            })
        },
        sendColor(item){
            for ( this.i ; this.i <  this.allColor.length; this.i++) {
                if (this.allColor[this.i] == item){
                    this.allColor.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.allColor.push(item);
            }
            this.i = 0;
            const url = `/archive/${this.url}${this.categories.slug}`;
            this.$inertia.post(url , {
                allOff : this.allOff,
                show : this.show,
                allBrands : this.allBrands,
                rangePrice : this.rangePrice,
                suggest : this.suggest,
                count : this.count,
                search : this.search,
                allAbility : this.allAbility,
                allSize : this.allSize,
                allColor : this.allColor,
            })
        },
        getComparison(item){
            this.allComparison = item;
        },
        deleteComparison(index){
            this.allComparison.splice(index , 1);
        },
        btnComparison(item){
            this.i = 0;
            if (this.allComparison.length <= 7){
                for ( this.i ; this.i <  this.allComparison.length; this.i++) {
                    if (this.allComparison[this.i].id == item.id){
                        this.allComparison.splice(this.i , 1);
                        this.i = 100;
                    }
                }
                if (this.i != 101){
                    this.allComparison.push(item);
                }
                this.i = 0;
            }
        },
        btnShowCompare(){
            const url = '/show-compares';
            axios.post(url ,{
                postCompare: this.allComparison,
            })
                .then(response=>{
                    this.postCompares = response.data;
                })
        },
    },
    watch: {
        'rangePrice': function(val, oldVal){
            this.showMinPrice = `${this.rangePrice[0]}`;
            this.showMaxPrice = `${this.rangePrice[1]}`;
        }
    }
}
</script>

<style scoped>

</style>
