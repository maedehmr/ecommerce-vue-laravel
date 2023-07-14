<template>
    <admin-layout>
        <div class="allSettingSite">
            <div class="allSettingCommentTop">
                <h1>تنظیمات سایت</h1>
                <div class="allSettingCommentTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/site-setting">تنظیمات سایت</inertia-link>
                </div>
            </div>
            <div class="allSettingSiteContainer">
                <div class="allSettingSiteItems">
                    <div class="allSettingSiteItem">
                        <label>نام سایت</label>
                        <input type="text" placeholder="نام سایت را وارد کنید" v-model="form.name">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>عنوان سایت</label>
                        <input type="text" placeholder="عنوان سایت را وارد کنید" v-model="form.title">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>آدرس ایمیل</label>
                        <input type="text" placeholder="آدرس ایمیل را وارد کنید" v-model="form.email">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>شماره تماس</label>
                        <input type="text" placeholder="شماره تماس را وارد کنید" v-model="form.number">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>MerchantId</label>
                        <input type="text" placeholder="MerchantId را وارد کنید" v-model="form.merchantID">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>حروف برای کد کالا</label>
                        <input type="text" placeholder="حروف را وارد کنید" v-model="form.productId">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>آدرس نماد ساماندهی</label>
                        <input type="text" placeholder="آدرس را وارد کنید" v-model="form.samandehi">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>آدرس نماد اعتماد</label>
                        <input type="text" placeholder="آدرس را وارد کنید" v-model="form.etemad">
                    </div>
                    <div class="allSettingSiteItem">
                        <label>هزینه ارسال(تومان)</label>
                        <input type="text" placeholder="هزینه ارسال را وارد کنید" v-model="form.payDeliver">
                    </div>
                    <div class="settingCommunication">
                        <div class="allSettingSiteItem">
                            <label>تلگرام</label>
                            <input type="text" placeholder="آدرس تلگرام خود را وارد کنید" v-model="form.telegram">
                        </div>
                        <div class="allSettingSiteItem">
                            <label>اینستاگرام</label>
                            <input type="text" placeholder="آدرس اینستاگرام خود را وارد کنید" v-model="form.instagram">
                        </div>
                    </div>
                    <div class="settingCommunication">
                        <div class="allSettingSiteItem">
                            <label>توییتر</label>
                            <input type="text" placeholder="آدرس توییتر خود را وارد کنید" v-model="form.twitter">
                        </div>
                        <div class="allSettingSiteItem">
                            <label>فیسبوک</label>
                            <input type="text" placeholder="آدرس فیسبوک خود را وارد کنید" v-model="form.facebook">
                        </div>
                    </div>
                    <div class="allSettingSiteItem">
                        <label>درباره ما</label>
                        <textarea placeholder="درباره ما را وارد کنید" v-model="form.about"></textarea>
                    </div>
                </div>
                <div class="allSettingSiteItems">
                    <div class="allSettingSiteItem">
                        <label>آدرس لوگو</label>
                        <div class="sendGallery">
                            <show-image v-on:sendClose="getClose" v-if="showImage" v-on:sendUrl="getUrl"></show-image>
                            <div class="getImageItem" @click="showImage = !showImage">
                                <div class="getImagePic" v-if="form.image">
                                    <img :src="form.image">
                                </div>
                                <span v-else>تصویر شاخص خود را وارد کنید</span>
                            </div>
                        </div>
                    </div>
                    <div class="allSettingSiteRole">
                        <label>مقام پیشفرض برای کاربران :</label>
                        <div class="allCategoryPanel" @click="showRole = !showRole">
                            <div class="categoryShow">
                                <h4>{{form.role}}</h4>
                                <i>
                                    <svg-icon :icon="'#down'"></svg-icon>
                                </i>
                            </div>
                            <ul v-if="showRole">
                                <VuePerfectScrollbar class="scroll-area" v-once :settings="settings">
                                    <li v-for="item in roles" @click="sendRole(item.name)">{{item.name}}</li>
                                </VuePerfectScrollbar>
                            </ul>
                        </div>
                    </div>
                    <div class="allSettingSiteRole">
                        <label>دسته بندی های منو بالا سایت :</label>
                        <post-taxonami :taxes="categories" :taxRoute="'دسته بندی'" :tax="category"  v-on:sendTax="getCat"></post-taxonami>
                    </div>
                    <div class="allSettingSiteRole">
                        <label>دسته بندی های منو فوتر سایت :</label>
                        <post-taxonami :taxes="categories" :taxRoute="'دسته بندی'" :tax="categoryF"  v-on:sendTax="getCatF"></post-taxonami>
                    </div>
                    <div class="captchaItem">
                        <label for="s1d" class="item">
                            فعال کردن reCAPTCHA
                            <input id="s1d" type="checkbox" class="switch" v-model="form.captcha">
                        </label>
                        <label for="s2d" class="item">
                            اجازه عضویت بدون تایید ایمیل
                            <input id="s2d" type="checkbox" class="switch" v-model="form.verify">
                        </label>
                        <label for="s3d" class="item">
                            ورود از طریق جیمیل
                            <input id="s3d" type="checkbox" class="switch" v-model="form.gm">
                        </label>
                        <label for="s6d" class="item">
                            تایید ایمیل برای ورود
                            <input id="s6d" type="checkbox" class="switch" v-model="form.verifyEmail">
                        </label>
                    </div>
                    <div class="allSettingSiteShow" title="نمایش تعداد پست های هر دسته بندی در هر صفحه">
                        <label>
                            تعداد پست برای صفحه بندی
                            <input type="number" placeholder="تعداد را وارد کنید" v-model="form.showPostPage">
                        </label>
                    </div>
                    <div class="allSettingSiteShow" title="نمایش تعداد پست های هر دسته بندی در هر اسلایدر">
                        <label>
                            نمایش تعداد کالا در هر اسلایدر دسته بندی
                            <input type="number" placeholder="تعداد را وارد کنید" v-model="form.showPostCategory">
                        </label>
                    </div>
                </div>
            </div>
            <div class="button" @click="sendSetting">
                <button>ارسال</button>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '../../../Layouts/Admin/AdminLayout'
import SvgIcon from "../../Svg/SvgIcon";
import ShowImage from "../ShowImage";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import PostTaxonami from "../Post/PostTaxonami";
export default {
    name: "SiteSetting",
    props:['name','verifyEmail','merchantID','etemad','categories','category','categoryF','samandehi','productId','roles','payDeliver','role','gm','showPostPage','showPostCategory','logo','about','number','title','captcha','verify','email','twitter','facebook','instagram','telegram'],
    components:{
        PostTaxonami,
        AdminLayout,
        VuePerfectScrollbar,
        ShowImage,
        SvgIcon
    },
    metaInfo: {
      title: 'تنظیمات سایت',
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
    },
    data(){
        return{
            form:{
                showPostPage: this.showPostPage,
                showPostCategory: this.showPostCategory,
                image: this.logo,
                about: this.about,
                category: [],
                categoryF: [],
                twitter: this.twitter,
                name: this.name,
                merchantID: this.merchantID,
                telegram: this.telegram,
                instagram: this.instagram,
                facebook: this.facebook,
                email: this.email,
                suggest: this.suggest,
                search: this.search,
                verifyEmail: this.verifyEmail,
                title: this.title,
                address: this.address,
                number: this.number,
                role: this.role,
                captcha: this.captcha,
                payDeliver: this.payDeliver,
                gm: this.gm,
                verify: this.verify,
                samandehi: this.samandehi,
                etemad: this.etemad,
                productId: this.productId,
                update: false,
            },
            settings: {
                maxScrollbarLength: 60
            },
            showRole : false,
            showImage : false,
        }
    },
    methods:{
        sendSetting(){
            this.form.update = true;
            const url = "/admin/site-setting";
            this.$inertia.post(url , this.form)
            .then(response=>{
                this.$swal.fire(
                    'با موفقیت انجام شد',
                    'تنظیمات با موفقیت انجام شد',
                    'success'
                );
            })
        },
        getCat(cat){
            this.form.category = cat;
        },
        getCatF(cat){
            this.form.categoryF = cat;
        },
        sendRole(name){
            this.form.role = name;
        },
        getClose(){
            this.showImage = !this.showImage;
        },
        getUrl(url){
            this.form.image = url;
        },
        checks(){
            if (this.verify == '0'){
                this.form.verify = 0;
            }
            if (this.gm == '0'){
                this.form.gm = 0;
            }
            if (this.captcha == '0'){
                this.form.captcha = 0;
            }
            if (this.search == '0'){
                this.form.search = 0;
            }
            if (this.verifyEmail == '0'){
                this.form.verifyEmail = 0;
            }
        },
        sidebar(){
            this.$eventHub.emit('sidebar' , ['3','40']);
        },
    },
    mounted() {
        this.checks();
        this.sidebar();
    },
}
</script>

<style scoped>

</style>
