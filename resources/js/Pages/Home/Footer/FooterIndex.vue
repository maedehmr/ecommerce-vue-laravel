<template>
    <div class="allFooter">
        <svg-icon :icon="'#shape1'"></svg-icon>
        <div class="allFooterBlock">
            <div class="allFooterBtn">
                <a href="#top">
                    <svg-icon :icon="'#up'"></svg-icon>
                </a>
            </div>
            <div class="allFooterTop width">
                <div class="allFooterTopHooper">
                    <hooper :settings="hooperSettings2">
                        <slide>
                            <a href="/">
                                <img src="/img/etemad.png" alt="نماد اعتماد">
                            </a>
                        </slide>
                        <slide>
                            <a href="/">
                                <img src="/img/samandehi-logo.png" alt="نماد ساماندهی">
                            </a>
                        </slide>
                        <hooper-pagination slot="hooper-addons"></hooper-pagination>
                    </hooper>
                </div>
                <div class="allFooterTopCats">
                    <label>دسته بندی ها</label>
                    <ul>
                        <li v-for="item in $page.catFooter" :key="item.id">
                            <inertia-link :href="'/archive/category/' + item.slug">{{item.name}}</inertia-link>
                        </li>
                    </ul>
                </div>
                <div class="allFooterTopLogo">
                    <div class="allFooterTopLogoPic">
                        <img :src="$page.logo" :alt="$page.logo">
                    </div>
                    <p>{{$page.aboutFooter}}</p>
                </div>
            </div>
            <div class="allFooterBot width">
                <div class="allFooterBotItem">
                    <span>پیشتیبانی 24 ساعته و هفت روز هفته</span>
                </div>
                <div class="allFooterBotItem">
                    <span>شماره تماس : </span>
                    <span>{{$page.numberSite}}</span>
                </div>
                <div class="allFooterBotItem">
                    <span>ایمیل آدرس : </span>
                    <span>{{$page.siteEmail}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    Hooper,
    Slide,
    Pagination as HooperPagination,
} from 'hooper';
import 'hooper/dist/hooper.css';
import SvgIcon from '../../Svg/SvgIcon.vue';
export default {
    name: 'FooterIndex',
    components:{
        Hooper,
        Slide,
        HooperPagination,
        SvgIcon,
    },
    data() {
        return {
            hooperSettings2: {
                wheelControl:false,
                centerMode: true,
                rtl: true,
                transition: 300,
                itemsToShow: 1,
                autoPlay:true,
                playSpeed : 5000
            },
        };
    },
}
</script>

<style>

</style>
