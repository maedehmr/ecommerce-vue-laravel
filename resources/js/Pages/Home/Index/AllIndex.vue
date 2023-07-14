<template>
    <home-layout>
        <div class="allIndex">
            <div class="allIndexOrder" v-for="item in vidget" :key="item.id">
                <div v-if="item.name == 'پیشنهادات'">
                    <all-surprising :getSuggest="item.post"/>
                </div>
                <div v-if="item.name == 'شگفت انگیزان'">
                    <suggest-index :data="item"/>
                </div>
                <div v-if="item.name == 'تبلیغ'">
                    <all-ads :ads="item"/>
                </div>
                <div v-if="item.name == 'تبلیغات اسلایدری'">
                    <ads-hooper :data="item"></ads-hooper>
                </div>
                <div v-if="item.name == 'دسته بندی زیرمجموعه دار'">
                    <category-post :catSiteAdvance="item"/>
                </div>
                <div v-if="item.name == 'دسته بندی ها'">
                    <all-category :allVidgets="item"/>
                </div>
                <div v-if="item.name == 'دسته بندی با پست'">
                    <all-hooper :catPost="item"/>
                </div>
                <div v-if="item.name == 'برند های ویژه'">
                    <all-brand :allBrands="item"/>
                </div>
                <div v-if="item.name == 'جستجو'">
                    <search-advance :allBrand="allBrand" :info="item" :allCategories="allCategories" :allColors="allColors" :moment="moment"/>
                </div>
                <div v-if="item.name == 'خبر'">
                    <news-index :data="item"></news-index>
                </div>
                <div v-if="item.name == 'پک'">
                    <pack-index :data="item"></pack-index>
                </div>
            </div>
            <div class="showFast">
                <all-show-fast></all-show-fast>
            </div>
        </div>
    </home-layout>
</template>

<script>
import AllHooper from './AllHooper';
import AllAds from './AllAds';
import CategoryPost from './CategoryPost';
import HomeLayout from '../../../Layouts/Home/HomeLayout';
import SearchAdvance from './SearchAdvance';
import SvgIcon from '../../Svg/SvgIcon';
import AllShowFast from '../AllShowFast.vue';
import AllCategory from './AllCategory.vue';
import AllSurprising from './AllSurprising.vue';
import SuggestIndex from './SuggestIndex';
import AllBrand from './AllBrand.vue';
import PackIndex from './PackIndex.vue';
import NewsIndex from "./NewsIndex";
import AdsHooper from "./AdsHooper";
export default {
    components: {
        AdsHooper,
        NewsIndex, CategoryPost,AllAds,AllHooper,HomeLayout, SearchAdvance ,SuggestIndex , SvgIcon ,AllShowFast, AllCategory ,AllSurprising, AllBrand, PackIndex},
    props:['title','vidget','title','allBrand','allColors','allCategories' , 'moment'],
    metaInfo() {
        return {
            title: `${this.title}`,
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
        getLike(){
            const url = `/get-like`;
            axios.get(url)
                .then(response=>{
                    this.$eventHub.emit('getLike' , response.data);
                })
        },
        getBookmark(){
            const url = `/get-bookmark`;
            axios.get(url)
                .then(response=>{
                    this.$eventHub.emit('getBookmark' , response.data);
                })
        },
    },
    mounted(){
        this.getLike();
        this.getBookmark();
    },
    created: function() {
        this.$eventHub.on('allLike', this.getLike);
        this.$eventHub.on('allBookmark', this.getBookmark);
    },
}
</script>

<style>

</style>
