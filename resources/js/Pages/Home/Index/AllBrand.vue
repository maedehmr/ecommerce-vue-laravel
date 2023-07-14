<template>
    <div class="allBrand">
        <div class="allBrandItems width">
            <div class="allHooperItemsTitle">
                <div class="allHooperItemsTitleItem">
                    <h3>{{allBrands.title}}</h3>
                </div>
                <div class="allHooperItemsTitleBlock">
                </div>
            </div>
            <hooper :settings="hooperSettings">
                <slide v-for="item in allBrands.post" :key="item.id" :title="item.name">
                    <article class="allBrandPost">
                        <inertia-link :href="'/archive/brand/' + item.slug">
                            <img v-lazy="item.image" :alt="item.name">
                            <span>{{item.name}}</span>
                        </inertia-link>
                    </article>
                </slide>
                <hooper-navigation slot="hooper-addons"></hooper-navigation>
            </hooper>
        </div>
    </div>
</template>

<script>
import 'hooper/dist/hooper.css';
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination,} from 'hooper';
export default {
    name:'AllBrand',
    props: ['allBrands'],
    components:{
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
                    100: {
                        itemsToShow: 2,
                        itemsToSlide: 2,
                    },
                    1100: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                    1200: {
                        itemsToShow: 4,
                        itemsToSlide: 4,
                    },
                    1300: {
                        itemsToShow: 5,
                        itemsToSlide: 5,
                    },
                    1400: {
                        itemsToShow: 6,
                        itemsToSlide: 6,
                    },
                }
            },
        }
    },
}
</script>

<style>

</style>
