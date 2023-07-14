<template>
    <div class="allPackIndex width">
        <div class="allPackIndexTitle">
            <div class="allPackIndexTitleItem">
                <h3>{{ data.title }}</h3>
            </div>
            <div class="allPackIndexTitleBlock">
                <inertia-link href="/archive/pack">{{ data.more }}</inertia-link>
            </div>
        </div>
        <hooper :settings="hooperSettings">
            <slide v-for="item in data.post" :key="item.id" :title="item.title">
                <div class="allPackIndexItem">
                    <inertia-link :href="'/pack/'+item.slug">
                        <div class="packPostCount" :title="item.post_count + ' مجصول'">
                            <svg-icon :icon="'#product'"></svg-icon>
                            {{item.post_count}}
                        </div>
                        <ul>
                            <li v-for="items in item.post.slice(0,6)">
                                <img v-lazy="JSON.parse(items.image)[0]" :alt="item.title">
                            </li>
                        </ul>
                        <div class="allPackIndexItemData">
                            <h3>{{item.title}}</h3>
                            <h4>
                                {{item.price|NumFormat}}
                                <span>تومان</span>
                            </h4>
                        </div>
                    </inertia-link>
                </div>
            </slide>
            <hooper-navigation slot="hooper-addons"></hooper-navigation>
        </hooper>
    </div>
</template>

<script>
import 'hooper/dist/hooper.css';
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination,} from 'hooper';
import SvgIcon from '../../Svg/SvgIcon.vue';
export default {
    name: 'PackIndex',
    props:['data'],
    components:{
        SvgIcon,
        Hooper,
        HooperNavigation,
        HooperPagination,
        Slide,
    },
    data(){
        return{
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                transition: 700,
                breakpoints: {
                    700: {
                        itemsToShow: 1,
                        itemsToSlide: 1,
                    },
                    1100: {
                        itemsToShow: 2,
                        itemsToSlide: 2,
                    },
                    1200: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                }
            },
        }
    },
}
</script>

<style>

</style>
