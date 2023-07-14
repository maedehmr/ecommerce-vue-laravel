<template>
    <home-layout>
        <div class="allRegisters">
            <div class="allHeaderIndexRegister" v-if="level == 0">
                <div class="allHeaderIndexRegisterData">
                    <div class="allHeaderIndexRegisterItems">
                        <div class="allHeaderIndexRegisterItemsTitle">
                            <div class="allHeaderIndexRegisterTitleItem">ثبت نام / ورود</div>
                        </div>
                        <div class="registerWaysBlock">
                            <div class="registerWays">
                                <button @click="level = 2">
                                    <svg-icon :icon="'#email2'"/>
                                    از طریق ایمیل
                                </button>
                                <button @click="level = 1">
                                    <svg-icon :icon="'#sms2'"/>
                                    از طریق پیامک
                                </button>
                            </div>
                            <div class="registerWays">
                                <a href="/google-login">
                                    <svg-icon :icon="'#google'"/>
                                    از طریق جیمیل
                                </a>
                            </div>
                            <div class="registerWayBody">
                                <p>انتخاب هریک از راه های ورود میتوانید عضو وبسایت ما شوید</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <transition name="slide-fade">
                <div class="allHeaderIndexRegisterItemsContainer" v-if="level == 1">
                    <auth-phone v-on:sendUser="getUser"></auth-phone>
                </div>
            </transition>
            <transition name="slide-fade">
                <div class="allHeaderIndexRegisterItemsContainer" v-if="level == 2">
                    <auth-email v-on:sendUser="getUser"></auth-email>
                </div>
            </transition>
        </div>
    </home-layout>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
import AuthPhone from "./Phone/AuthPhone";
import AuthEmail from "./Email/AuthEmail";
import HomeLayout from "../../../Layouts/Home/HomeLayout";
export default {
    name: "AuthIndex",
    components: {HomeLayout, AuthEmail, AuthPhone, SvgIcon},
    data(){
        return{
            level: 0
        }
    },
    methods:{
        getUser(){
            window.location.reload();
        },
    }
}
</script>

<style scoped>

</style>
