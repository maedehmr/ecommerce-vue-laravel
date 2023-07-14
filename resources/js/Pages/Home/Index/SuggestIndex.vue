<template>
    <div class="allSuggestIndex" :style="'background: ' + data.background">
        <div class="allSuggestIndexBlock width">
            <div class="allSuggestIndexPic">
                <img :src="data.more" :alt="data.title">
                <inertia-link :href="'/archive/product/'+data.slug">مشاهده بیشتر</inertia-link>
            </div>
            <hooper :settings="hooperSettings">
                <slide v-for="item in data.post" :key="item.id" :title="item.title">
                    <inertia-link :href="'/product/' + item.slug">
                        <article class="allSuggestIndexPost">
                            <div class="offProduct" v-if="item.off">
                                <div class="offProductItem">
                                    <svg-icon :icon="'#off-tag'"></svg-icon>
                                    <div>
                                        <span>٪{{item.off}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="allSuggestIndexPostUsed" v-if="item.used == 1">کارکرده</div>
                            <div class="allSuggestIndexPostPic">
                                <img v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                <img v-if="JSON.parse(item.image)[1]" v-lazy="JSON.parse(item.image)[1]" :alt="item.title">
                                <img v-else v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                            </div>
                            <h3>{{item.title}}</h3>
                            <div class="allSurprisingSubjectPrice">
                                <h4>
                                    {{item.price|NumFormat}}
                                    <span>تومان</span>
                                </h4>
                            </div>
                            <div class="allSuggestIndexPostOptions">
                                <div class="allSuggestIndexPostOption" @click.prevent="btnBookmark(item.id)">
                                    <svg-icon v-for="(values,index) in bookmark" :key="index" v-if="values == item.id" :icon="'#bookmark'"></svg-icon>
                                    <svg-icon :icon="'#unbookmark'"></svg-icon>
                                </div>
                                <div class="allSuggestIndexPostOption" @click.prevent="btnLike(item.id)">
                                    <svg-icon v-for="(values,index) in like" :key="index" v-if="values == item.id" :icon="'#like'"></svg-icon>
                                    <svg-icon :icon="'#unlike'"></svg-icon>
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
    name: 'SuggestIndex',
    props: ['data'],
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
                    1000: {
                        itemsToShow: 3,
                        itemsToSlide: 3,
                    },
                    1200: {
                        itemsToShow: 4,
                        itemsToSlide: 4,
                    },
                    1600: {
                        itemsToShow: 5,
                        itemsToSlide: 5,
                    },
                    1800: {
                        itemsToShow: 6,
                        itemsToSlide: 6,
                    },
                }
            },
            notificationSystem: {
                options: {
                    show: {
                        icon: "icon-person",
                        position: "topCenter",
                    },
                    success: {
                        position: "bottomRight"
                    },
                    error: {
                        theme: "#FCA001",
                        progressBarColor: "#DC0808",
                        position: "bottomRight"
                    },
                }
            },
            like: [],
            bookmark: [],
        }
    },
    methods:{
        checkLike(item){
            this.like = item;
        },
        checkBookmark(item){
            this.bookmark = item;
        },
        btnLike(id){
            const url = `/like`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.$eventHub.emit('getLike' , []);
                    }else{
                        if (response.data === 'delete'){
                            this.$eventHub.emit('allLike');
                        }else{
                            this.$toast.success('انجام شد', 'به علاقه مندی با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.like.push(response.data.post_id);
                            this.$eventHub.emit('getLike' , this.like);
                        }
                    }
                })
        },
        btnBookmark(id){
            const url = `/bookmark`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.$eventHub.emit('getBookmark' , []);
                    }else {
                        if (response.data === 'delete') {
                            this.$eventHub.emit('allBookmark');
                        }else {
                            this.$toast.success('انجام شد', 'نشانه با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.bookmark.push(response.data.post_id);
                            this.$eventHub.emit('getBookmark' , this.bookmark);
                        }
                    }
                })
        },
    },
    created: function() {
        this.$eventHub.on('getLike', this.checkLike);
        this.$eventHub.on('getBookmark', this.checkBookmark);
    },
}
</script>

<style>

</style>
