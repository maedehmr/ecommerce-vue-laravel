<template>
    <admin-layout>
        <div class="allSettingComment">
            <div class="allSettingCommentTop">
                <h1>تنظیمات دیدگاه</h1>
                <div class="allSettingCommentTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/setting-comment">تنظیمات دیدگاه</inertia-link>
                </div>
            </div>
            <div class="settingCommentContainer">
                <div class="settingCommentContainerItems">
                    <div class="allSettingCommentItem">
                        <label>کلماتی که ممنوع هستند با (,) جدا کنید</label>
                        <textarea placeholder="کلماتی که ممنوع هستند" v-model="form.forbiddens"></textarea>
                    </div>
                    <div class="allSettingCommentItem">
                        <label>نمایش کاربر</label>
                        <select v-model="form.showUser">
                            <option value="0">نمایش کاربر همراه عکس و نام</option>
                            <option value="1">نمایش کاربر همراه فقط نام</option>
                            <option value="2">نمایش کاربر همراه فقط عکس</option>
                        </select>
                    </div>
                    <button @click="sendUpdate">ارسال اطلاعات</button>
                </div>
                <div class="settingCommentContainerDetail">
                    <div class="settingCommentContainerDetailTitle" @click="showDetail = !showDetail">
                        جزییات
                        <svg-icon :icon="'#up'" v-if="showDetail"></svg-icon>
                        <svg-icon :icon="'#down'" v-else></svg-icon>
                    </div>
                    <transition name="slide-fade">
                        <div class="allSettingCommentItems" v-if="showDetail">
                            <label for="s1d" class="allSettingCommentItem">
                                نیاز به تایید دیدگاه
                                <input id="s1d" type="checkbox" class="switch" v-model="form.approved">
                            </label>
                            <label for="s2d" class="allSettingCommentItem">
                                فعال کردن دکمه پاسخ به دیدگاه
                                <input id="s2d" type="checkbox" class="switch" v-model="form.reply">
                            </label>
                            <label for="s3d" class="allSettingCommentItem">
                                اجبار به نوشتن ایمیل و نام
                                <input id="s3d" type="checkbox" class="switch" v-model="form.coercion">
                            </label>
                            <label for="s4d" class="allSettingCommentItem">
                                نمایش دیدگاه فقط برای کاربران سایت
                                <input id="s4d" type="checkbox" class="switch" v-model="form.checkUser">
                            </label>
                            <label for="s5d" class="allSettingCommentItem">
                                نمایش زمان آنلاین بودن کاربر
                                <input id="s5d" type="checkbox" class="switch" v-model="form.checkOnline">
                            </label>
                            <div class="allSettingCommentItem">
                                <label>محدود سازی دیدگاه گذاشتن</label>
                                <input type="number" min="1" max="30" step="1" v-model="form.limited">
                            </div>
                            <div class="allSettingCommentItem">
                                <label>تعداد نمایش دیدگاه ها در هر صفحه</label>
                                <input type="number" min="0" max="100" step="10" v-model="form.pages">
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "CommentSetting",
    props:['forbidden','show','limit','page','approve','replay','coercions','check','online'],
    components:{
        AdminLayout,
        SvgIcon,
    },
    metaInfo: {
      title: 'تنظیمات دیدگاه',
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
    },
    data(){
        return{
            showDetail: false,
            form:{
                update: false,
                forbiddens: this.forbidden,
                limited : this.limit,
                pages : this.page,
                showUser : this.show,
                approved : this.approve,
                reply : this.replay,
                coercion : this.coercions,
                checkUser : this.check,
                checkOnline : this.online,
            },
        }
    },
    methods:{
        sendUpdate(){
            this.form.update = true;
            const url = "/admin/setting-comment";
            this.$inertia.post(url , this.form)
            .then(response=>{
                this.$swal.fire(
                    'با موفقیت انجام شد',
                    'تنظیمات با موفقیت انجام شد',
                    'success'
                );
            })
        },
        checks(){
            if (this.show == '0'){
                this.form.showUser = 0;
            }
            if (this.approve == '0'){
                this.form.approved = 0;
            }
            if (this.replay == '0'){
                this.form.reply = 0;
            }
            if (this.coercions == '0'){
                this.form.coercion = 0;
            }
            if (this.check == '0'){
                this.form.checkUser = 0;
            }
            if (this.online == '0'){
                this.form.checkOnline = 0;
            }
        },
        sidebar(){
            this.$eventHub.emit('sidebar' , ['3','7']);
        },
    },
    mounted() {
        this.checks();
        this.sidebar();
    }
}
</script>

<style>

</style>