<template>
    <div class="allHoopers">
        <div class="allHooperItems width" :title="catPost.title">
            <div class="allHooperItemsTitle">
                <div class="allHooperItemsTitleItem">
                    <h3>{{catPost.title}}</h3>
                </div>
                <div class="allHooperItemsTitleBlock">
                    <inertia-link :href="'/archive/product/' + catPost.slug">{{catPost.more}}</inertia-link>
                </div>
            </div>
            <hooper :settings="hooperSettings">
                <slide v-for="item in catPost.post" :key="item.id" :title="item.title">
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
</template>

<script>
import 'hooper/dist/hooper.css';
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination,} from 'hooper';
import SvgIcon from '../../Svg/SvgIcon.vue';
export default {
    name: 'AllHooper',
    props:['catPost'],
    components:{
        Hooper,
        HooperNavigation,
        HooperPagination,
        Slide,
        SvgIcon,
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
                    700: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                    1100: {
                        itemsToShow: 4,
                        itemsToSlide: 4,
                    },
                    1200: {
                        itemsToShow: 5,
                        itemsToSlide: 5,
                    },
                }
            },
        }
    },
}
</script>

<style>

</style>
