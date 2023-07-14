<template>
    <home-layout>
        <div class="allNews width">
            <div class="allNewsRight">
                <div class="allArchiveIndexDataPostsPaginate">
                    <paginate-panel :link="news.links"></paginate-panel>
                </div>
                <div class="allNewsRightItems">
                    <a class="allNewsRightItem" v-for="(item,index) in news.data" :href="'/news/' + item.slug" :key="index" :title="item.title">
                        <img :src="item.image" :alt="item.title">
                        <div class="allNewsRightItemOver">
                            <span class="active" v-if="item.accept">تایید شده</span>
                            <span v-else>در انتظار تایید</span>
                            <h3>{{item.title}}</h3>
                        </div>
                    </a>
                </div>
                <div class="allArchiveIndexDataPostsPaginate">
                    <paginate-panel :link="news.links"></paginate-panel>
                </div>
            </div>
            <div class="allNewsSideBar">
                <div class="allNewsSideBarItem" v-if="suggest.length">
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
    </home-layout>
</template>

<script>
import NewsIndex from "../Index/NewsIndex";
import PaginatePanel from "../../Admin/PaginatePanel";
import HomeLayout from "../../../Layouts/Home/HomeLayout";
export default {
    name: "AllNews",
    props: ['news','suggest','titleSite','url'],
    components: {
        HomeLayout,
        PaginatePanel,
        NewsIndex,
    },
}
</script>

<style scoped>

</style>
