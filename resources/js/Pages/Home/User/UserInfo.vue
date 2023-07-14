<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="5"></all-user>
            <div class="allUserIndexInfo">
                <label>حساب من</label>
                <div class="errorsCreate" v-if="Object.keys(errors).length > 0">
                    <i>
                        <svg-icon :icon="'#error'"></svg-icon>
                    </i>
                    <span>{{errors[Object.keys(errors)[0]][0]}}</span>
                </div>
                <div class="allUserIndexInfoPersonal">
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>نام و نام خانوادگی</label>
                            <input type="text" placeholder="نام کامل را وارد کنید" v-model="form.name">
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>نام کاربری</label>
                            <input type="text" placeholder="نام را وارد کنید" v-model="form.user">
                        </div>
                    </div>
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>شماره تماس</label>
                            <input type="text" placeholder="شماره را وارد کنید" v-model="form.number">
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>ایمیل</label>
                            <input type="email" placeholder="ایمیل را وارد کنید" v-model="form.email">
                        </div>
                    </div>
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>تاریخ تولد</label>
                            <div class="allUserIndexInfoPersonalItemDate">
                                <date-picker
                                    v-model="form.date"
                                    type="date"
                                    format="YYYY-MM-DD"
                                    display-format="jYYYY-jMM-jDD"
                                />
                            </div>
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>شغل</label>
                            <input type="text" placeholder="شغل را وارد کنید" v-model="form.job">
                        </div>
                    </div>
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>کد ملی</label>
                            <input type="text" placeholder="کد ملی را وارد کنید" v-model="form.code">
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>کد پستی</label>
                            <input type="text" placeholder="کد پستی را وارد کنید" v-model="form.post">
                        </div>
                    </div>
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>رمز عبور (در صورت تغیر رمز جدید را وارد کنید)</label>
                            <input type="password" placeholder="رمز عبور را وارد کنید" v-model="form.password">
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>آدرس محل زندگی</label>
                            <input type="text" placeholder="آدرس را وارد کنید" v-model="form.address">
                        </div>
                    </div>
                </div>
                <button class="infoButton" @click.prevent="updateUser">تغییر اطلاعات</button>
            </div>
        </div>
    </home-layout>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import SvgIcon from "../../Svg/SvgIcon";
import AllUser from './AllUser';
export default {
    name: "UserInfo",
    components:{
        HomeLayout,
        SvgIcon,
        datePicker: VuePersianDatetimePicker,
        AllUser,
    },
    props: ['user','errors','title'],
    metaInfo() {
        return {
            title: `اطلاعات شخصی - ${this.title}`,
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
    data() {
        return {
            form:{
                date: '',
                address: '',
                password: '',
                name: '',
                user: '',
                number: '',
                email: '',
                post: '',
                job: '',
                code: '',
                update: this.user.id,
            },
        }
    },
    methods:{
        updateUser() {
            const url = `/profile/personal-info`;
            this.$inertia.post(url , this.form)
                .then(response=>{
                    if(!this.errors.name && !this.errors.post && !this.errors.date && !this.errors.code && !this.errors.date)
                    this.$toast.success('انجام شد', 'تغییر با موفقیت انجام شد', this.notificationSystem.options.success);
                })
        },
        check(){
            if(this.user.user_meta.length){
                this.form.date = this.user.user_meta[0].date;
                this.form.name = this.user.user_meta[0].name;
                this.form.post = this.user.user_meta[0].post;
                this.form.job = this.user.user_meta[0].job;
                this.form.code = this.user.user_meta[0].code;
                this.form.address = this.user.user_meta[0].address;
            }
            this.form.user = this.user.name;
            this.form.number = this.user.number;
            this.form.email = this.user.email;
            this.form.password = this.user.password;
        },
    },
    mounted(){
        this.check();
    }
}
</script>

