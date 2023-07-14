<template>
    <div class="allSideBarPanel">
        <inertia-link href="/" class="allSideBarPanelLogo">
            <img :src="$page.logo" :alt="$page.logo">
        </inertia-link>
        <VuePerfectScrollbar class="scroll-area">
            <div class="allSideBarPanelContainers">
                <div class="allSideBarPanelContainer" v-if="dashboard">
                        <div class="allSideBarPanelContainerTitle" v-if="index != 1" @click="showIndex(1)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#dashboard'"></svg-icon>
                                <h4>داشبورد</h4>
                            </div>
                            <svg-icon :icon="'#down'"></svg-icon>
                        </div>
                        <div class="allSideBarPanelContainerTitleActive" v-if="index == 1" @click="showIndex(1)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#dashboard'"></svg-icon>
                                <h4>داشبورد</h4>
                            </div>
                            <svg-icon :icon="'#up'"></svg-icon>
                        </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 1">
                            <li>
                                <inertia-link href="/">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    خانه
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin" class="active" v-if="index2 == 2">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    داشبورد
                                </inertia-link>
                                <inertia-link href="/admin" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    داشبورد
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="gallery">
                    <inertia-link href="/admin/gallery" class="active" v-if="index2 == 3">
                        <svg-icon :icon="'#gallery'"></svg-icon>
                        گالری
                    </inertia-link>
                    <inertia-link href="/admin/gallery" v-else>
                        <svg-icon :icon="'#gallery'"></svg-icon>
                        گالری
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="pack">
                    <inertia-link href="/admin/pack" class="active" v-if="index2 == 40">
                        <svg-icon :icon="'#pack'"></svg-icon>
                        پک
                    </inertia-link>
                    <inertia-link href="/admin/pack" v-else>
                        <svg-icon :icon="'#pack'"></svg-icon>
                        پک
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainer">
                    <div class="allSideBarPanelContainerTitleActive" v-if="index == 2" @click="showIndex(2)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#post'"></svg-icon>
                            <h4>پست</h4>
                        </div>
                        <svg-icon :icon="'#up'"></svg-icon>
                    </div>
                    <div class="allSideBarPanelContainerTitle" v-if="index != 2" @click="showIndex(2)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#post'"></svg-icon>
                            <h4>پست</h4>
                        </div>
                        <svg-icon :icon="'#down'"></svg-icon>
                    </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 2">
                            <li>
                                <inertia-link href="/admin/post" class="active" v-if="index2 == 4">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    همه پست ها
                                </inertia-link>
                                <inertia-link href="/admin/post" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    همه پست ها
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/post/create" class="active" v-if="index2 == 5">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    افزودن پست
                                </inertia-link>
                                <inertia-link href="/admin/post/create" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    افزودن پست
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
                <div class="allSideBarPanelContainer">
                    <div class="allSideBarPanelContainerTitleActive" v-if="index == 12" @click="showIndex(12)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#car'"></svg-icon>
                            <h4>حامل</h4>
                        </div>
                        <svg-icon :icon="'#up'"></svg-icon>
                    </div>
                    <div class="allSideBarPanelContainerTitle" v-if="index != 12" @click="showIndex(12)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#car'"></svg-icon>
                            <h4>حامل</h4>
                        </div>
                        <svg-icon :icon="'#down'"></svg-icon>
                    </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 12">
                            <li>
                                <inertia-link href="/admin/carrier" class="active" v-if="index2 == 31">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    حامل
                                </inertia-link>
                                <inertia-link href="/admin/carrier" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    حامل
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/time" class="active" v-if="index2 == 30">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    زمان ارسال
                                </inertia-link>
                                <inertia-link href="/admin/time" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    زمان ارسال
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
                <div class="allSideBarPanelContainer">
                    <div class="allSideBarPanelContainerTitleActive" v-if="index == 10" @click="showIndex(10)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#news'"></svg-icon>
                            <h4>خبر و وبلاگ</h4>
                        </div>
                        <svg-icon :icon="'#up'"></svg-icon>
                    </div>
                    <div class="allSideBarPanelContainerTitle" v-if="index != 10" @click="showIndex(10)">
                        <div class="allSideBarPanelContainerTitleItem">
                            <svg-icon :icon="'#news'"></svg-icon>
                            <h4>خبر و وبلاگ</h4>
                        </div>
                        <svg-icon :icon="'#down'"></svg-icon>
                    </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 10">
                            <li>
                                <inertia-link href="/admin/news" class="active" v-if="index2 == 42">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    همه خبر ها
                                </inertia-link>
                                <inertia-link href="/admin/news" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    همه خبر ها
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/news/create" class="active" v-if="index2 == 43">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    افزودن خبر
                                </inertia-link>
                                <inertia-link href="/admin/news/create" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    افزودن خبر
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="user">
                    <inertia-link href="/admin/user" class="active" v-if="index2 == 6">
                        <svg-icon :icon="'#user'"></svg-icon>
                        همه کاربران
                    </inertia-link>
                    <inertia-link href="/admin/user" v-else>
                        <svg-icon :icon="'#user'"></svg-icon>
                        همه کاربران
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="excel">
                    <inertia-link href="/admin/excel" class="active" v-if="index2 == 44">
                        <svg-icon :icon="'#excel'"></svg-icon>
                        خروجی اکسل
                    </inertia-link>
                    <inertia-link href="/admin/excel" v-else>
                        <svg-icon :icon="'#excel'"></svg-icon>
                        خروجی اکسل
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="page">
                    <inertia-link href="/admin/page" class="active" v-if="index2 == 20">
                        <svg-icon :icon="'#page'"></svg-icon>
                        همه برگه ها
                    </inertia-link>
                    <inertia-link href="/admin/page" v-else>
                        <svg-icon :icon="'#page'"></svg-icon>
                        همه برگه ها
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="pay">
                    <inertia-link href="/admin/pay" class="active" v-if="index2 == 21">
                        <svg-icon :icon="'#billFront'"></svg-icon>
                        همه پرداختی ها
                    </inertia-link>
                    <inertia-link href="/admin/pay" v-else>
                        <svg-icon :icon="'#billFront'"></svg-icon>
                        همه پرداختی ها
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="comment">
                    <inertia-link href="/admin/comment" class="active" v-if="index2 == 23">
                        <svg-icon :icon="'#comment'"></svg-icon>
                        دیدگاه ها
                    </inertia-link>
                    <inertia-link href="/admin/comment" v-else>
                        <svg-icon :icon="'#comment'"></svg-icon>
                        دیدگاه ها
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainer" v-if="setting">
                        <div class="allSideBarPanelContainerTitleActive" v-if="index == 3" @click="showIndex(3)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#setting'"></svg-icon>
                                <h4>تنظیمات</h4>
                            </div>
                            <svg-icon :icon="'#up'"></svg-icon>
                        </div>
                        <div class="allSideBarPanelContainerTitle" v-if="index != 3" @click="showIndex(3)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#setting'"></svg-icon>
                                <h4>تنظیمات</h4>
                            </div>
                            <svg-icon :icon="'#down'"></svg-icon>
                        </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 3">
                            <li>
                                <inertia-link href="/admin/setting-template" class="active" v-if="index2 == 22">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات قالب سایت
                                </inertia-link>
                                <inertia-link href="/admin/setting-template" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات قالب سایت
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/setting-comment" class="active" v-if="index2 == 7">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات دیدگاه
                                </inertia-link>
                                <inertia-link href="/admin/setting-comment" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات دیدگاه
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/site-setting" class="active" v-if="index2 == 40">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات سایت
                                </inertia-link>
                                <inertia-link href="/admin/site-setting" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات سایت
                                </inertia-link>
                            </li>
                            <li>
                                <inertia-link href="/admin/seo-setting" class="active" v-if="index2 == 10">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات سئو
                                </inertia-link>
                                <inertia-link href="/admin/seo-setting" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    تنظیمات سئو
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
                <div class="allSideBarPanelContainersItem" v-if="role">
                    <inertia-link href="/role" class="active" v-if="index2 == 11">
                        <svg-icon :icon="'#role'"></svg-icon>
                        مقام ها
                    </inertia-link>
                    <inertia-link href="/admin/role" v-else>
                        <svg-icon :icon="'#role'"></svg-icon>
                        مقام ها
                    </inertia-link>
                </div>
                <div class="allSideBarPanelContainer">
                        <div class="allSideBarPanelContainerTitleActive" v-if="index == 4" @click="showIndex(4)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#tax'"></svg-icon>
                                <h4>تاکسونامی</h4>
                            </div>
                            <svg-icon :icon="'#up'"></svg-icon>
                        </div>
                        <div class="allSideBarPanelContainerTitle" v-if="index != 4" @click="showIndex(4)">
                            <div class="allSideBarPanelContainerTitleItem">
                                <svg-icon :icon="'#tax'"></svg-icon>
                                <h4>تاکسونامی</h4>
                            </div>
                            <svg-icon :icon="'#down'"></svg-icon>
                        </div>
                    <transition name="slide-fade">
                        <ul v-if="index == 4">
                            <li v-if="cat">
                                <inertia-link href="/admin/category" class="active" v-if="index2 == 12">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    دسته بندی
                                </inertia-link>
                                <inertia-link href="/admin/category" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    دسته بندی
                                </inertia-link>
                            </li>
                            <li v-if="brand">
                                <inertia-link href="/admin/brand" class="active"  v-if="index2 == 13">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    برند
                                </inertia-link>
                                <inertia-link href="/admin/brand" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    برند
                                </inertia-link>
                            </li>
                            <li v-if="size">
                                <inertia-link href="/admin/size" class="active"  v-if="index2 == 14">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    سایز
                                </inertia-link>
                                <inertia-link href="/admin/size" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    سایز
                                </inertia-link>
                            </li>
                            <li v-if="color">
                                <inertia-link href="/admin/color" class="active"  v-if="index2 == 15">
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    رنگ
                                </inertia-link>
                                <inertia-link href="/admin/color" v-else>
                                    <svg-icon :icon="'#left-arrow'"></svg-icon>
                                    رنگ
                                </inertia-link>
                            </li>
                        </ul>
                    </transition>
                </div>
            </div>
        </VuePerfectScrollbar>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon.vue';
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
export default {
    components: { SvgIcon , VuePerfectScrollbar },
    data(){
        return{
            index: 0,
            index2: 0,
            gallery: 0,
            setting: 0,
            user: 0,
            post: 0,
            i: 0,
            role: 0,
            cat: 0,
            brand: 0,
            size: 0,
            color: 0,
            page: 0,
            comment: 0,
            dashboard: 0,
            singer: 0,
            pay: 0,
            pack: 0,
            excel: 0,
            allows: [],
            settings: {
                maxScrollbarLength: 60
            },
        }
    },
    methods:{
        showIndex(number){
            if(number == this.index){
                this.index = 0;
            }else{
                this.index = number;
            }
        },
        sidebar(item){
            this.index = item[0];
            this.index2 = item[1];
        },
        getAllow(){
            this.allows = this.$page.allow;
            if(this.allows.length == 0){
                this.allows=[{}];
            }
            for ( this.i ; this.i <  this.allows.length; this.i++) {
                if (this.allows[this.i].name == 'خروجی اکسل' || this.$page.userData.admin == 1){
                    this.excel = 1;
                }
                if (this.allows[this.i].name == 'نمایش همه تصویر ها' || this.allows[this.i].name == 'نمایش تصویر های خودش' || this.allows[this.i].name == 'افزودن تصویر' || this.allows[this.i].name == 'حذف تصویر' || this.$page.userData.admin == 1){
                    this.gallery = 1;
                }
                if (this.allows[this.i].name == 'تنظیمات دسته بندی ها' || this.allows[this.i].name == 'تنظیمات قالب سایت' || this.allows[this.i].name == 'تنظیمات سئو' || this.allows[this.i].name == 'تنظیمات سایت' || this.allows[this.i].name == 'تنظیمات دیدگاه' || this.$page.userData.admin == 1 ){
                    this.setting = 1;
                }
                if (this.allows[this.i].name == 'نمایش همه کاربر ها' || this.allows[this.i].name == 'نمایش کاربر های خودش' || this.allows[this.i].name == 'افزودن کاربر' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف کاربر' || this.allows[this.i].name == 'ویرایش کاربر'){
                    this.user = 1;
                }
                if (this.allows[this.i].name == 'نمایش همه پست ها' || this.allows[this.i].name == 'نمایش پست های خودش' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف پست' || this.allows[this.i].name == 'ویرایش پست'){
                    this.post = 1;
                }
                if (this.allows[this.i].name == 'نمایش مقام' || this.allows[this.i].name == 'افزودن مقام' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف مقام' || this.allows[this.i].name == 'ویرایش مقام'){
                    this.role = 1;
                }
                if (this.allows[this.i].name == 'نمایش دسته های خودش' || this.allows[this.i].name == 'نمایش همه دسته ها' || this.allows[this.i].name == 'افزودن دسته' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف دسته' || this.allows[this.i].name == 'ویرایش دسته'){
                    this.cat = 1;
                }
                if (this.allows[this.i].name == 'نمایش سایز های خودش' || this.allows[this.i].name == 'نمایش همه سایز ها' || this.allows[this.i].name == 'افزودن سایز' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف سایز' || this.allows[this.i].name == 'ویرایش سایز'){
                    this.size = 1;
                }
                if (this.allows[this.i].name == 'نمایش رنگ های خودش' || this.allows[this.i].name == 'نمایش همه رنگ ها' || this.allows[this.i].name == 'افزودن رنگ' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف رنگ' || this.allows[this.i].name == 'ویرایش رنگ'){
                    this.color = 1;
                }
                if (this.allows[this.i].name == 'نمایش برند های خودش' || this.allows[this.i].name == 'نمایش همه برند ها' || this.allows[this.i].name == 'افزودن برند' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف برند' || this.allows[this.i].name == 'ویرایش برند'){
                    this.brand = 1;
                }
                if (this.allows[this.i].name == 'نمایش پرداختی' || this.allows[this.i].name == 'حذف پرداختی' || this.$page.userData.admin == 1 ){
                    this.pay = 1;
                }
                if (this.allows[this.i].name == 'نمایش برگه' || this.allows[this.i].name == 'افزودن برگه' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف برگه' || this.allows[this.i].name == 'ویرایش برگه'){
                    this.page = 1;
                }
                if (this.allows[this.i].name == 'نمایش پک' || this.allows[this.i].name == 'افزودن پک' || this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف پک' || this.allows[this.i].name == 'ویرایش پک'){
                    this.pack = 1;
                }
                if (this.$page.userData.admin == 1 || this.allows[this.i].name == 'حذف دیدگاه' || this.allows[this.i].name == 'ویرایش دیدگاه'){
                    this.comment = 1;
                }
                if (this.$page.userData.admin == 1 || this.allows[this.i].name == 'نمایش داشبورد'){
                    this.dashboard = 1;
                }
            }
        },
    },
    mounted(){
        this.getAllow();
    },
    created: function() {
        this.$eventHub.on('sidebar', this.sidebar);
    },
}
</script>

<style>

</style>
