<template>
    <home-layout>
        <div class="allSingleNews">
            <div class="newsBlog width">
                <div class="right">
                    <div class="blog">
                        <div class="guidSite">
                            <a href="/">خانه</a>
                            <a href="/news">همه اخبار</a>
                            <a  :href="'/news/' + post.slug">{{post.title}}</a>
                        </div>
                        <div class="titleNews">
                            <h1>{{post.title}}</h1>
                        </div>
                        <div class="detailNews">
                            <div class="user">
                                <img v-if="post.user.profile == null" :src="post.user.profile_photo_url" :alt="post.user.name">
                                <img v-else :src="post.user.profile" :alt="post.user.name">
                                <h4>{{post.user.name}}</h4>
                                <h5>{{post.created_at}}</h5>
                            </div>
                            <div class="catNews">
                                <ul>
                                    <li>دسته بندی ها :</li>
                                    <li v-for="item in post.category">
                                        <a :href="'/news/archive/category/' + item.slug">{{item.name}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="newsTime">
                            <svg-icon :icon="'#clock'"></svg-icon>
                            <span>مدت زمان مطالعه :</span>
                            <span>{{post.time}} دقیقه</span>
                        </div>
                        <div class="acceptNews">
                            <h4 class="accept" v-if="post.accept">
                                خبر تایید شده است
                            </h4>
                            <h4 v-else>
                                خبر در انتظار تایید شدن است
                            </h4>
                        </div>
                        <div class="singleInfo">
                            <div class="picNews">
                                <img :src="post.image" :alt="post.title">
                            </div>
                            <p v-html="post.body"></p>
                        </div>
                    </div>
                </div>
                <div class="left">
                    <div class="item" v-if="related.length">
                        <label>مطالب مرتبط</label>
                        <ul>
                            <li v-for="item in related">
                                <a :href="'/news/' + item.slug">
                                    <img :src="item.image" alt="">
                                    <div class="showInfo">
                                        <h4>{{item.title}}</h4>
                                        <span>{{item.created_at}}</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="item" v-if="suggest.length">
                        <label>پیشنهادات :</label>
                        <ul>
                            <li v-for="item in suggest">
                                <a :href="'/news/' + item.slug">
                                    <img :src="item.image" alt="">
                                    <div class="showInfo">
                                        <h4>{{item.title}}</h4>
                                        <span>{{item.created_at}}</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
import HomeLayout from "../../../Layouts/Home/HomeLayout";
export default {
    name: "SingleNews",
    props:['post','suggest','related'],
    components: {
        HomeLayout,
        SvgIcon,
    },
}
</script>

<style scoped>

</style>
