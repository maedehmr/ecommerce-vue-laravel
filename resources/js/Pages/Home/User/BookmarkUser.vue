<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="1"></all-user>
            <div class="allUserIndexInfo">
                <div class="allUserIndexInfoLike">
                    <label>نشانه های من</label>
                    <div class="paginate" v-if="allBookmark.links">
                        <paginate-panel :link="allBookmark.links"></paginate-panel>
                    </div>
                    <div class="allUserIndexInfoLikeItem">
                        <ul>
                            <li v-for="(item , index) in allBookmark.data" :key="index">
                                <inertia-link :href="'/product/' + item.slug">
                                    <div class="userItemPic">
                                        <img v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                    </div>
                                    <div class="userItemSubject">
                                        <div class="userItemSubjectTitle">{{item.title}}</div>
                                        <div class="postPriceItem">
                                            <div class="offPrice" v-if="item.off != null">
                                                <s>{{item.offPrice|NumFormat}} تومان</s>
                                            </div>
                                            <h3>{{item.price|NumFormat}} تومان</h3>
                                        </div>
                                    </div>
                                </inertia-link>
                                <i @click.stop="btnBookmark(item.id , index)">
                                    <svg-icon :icon="'#trash'"></svg-icon>
                                </i>
                            </li>
                        </ul>
                    </div>
                    <div class="paginate" v-if="allBookmark.links">
                        <paginate-panel :link="allBookmark.links"></paginate-panel>
                    </div>
                </div>
            </div>
            <div class="archiveLoader" v-if="showLoader">
                <div class="archiveLoaderItem">
                    <img src="/img/loadingImage.gif" alt="صبر کنید">
                </div>
            </div>

        </div>
    </home-layout>
</template>

<script>
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import SvgIcon from "../../Svg/SvgIcon";
import AllUser from "./AllUser";
import PaginatePanel from "../../Admin/PaginatePanel";
export default {
    name: "BookmarkUser",
    props: ['bookmarkPosts','title'],
    components:{
        HomeLayout,
        SvgIcon,
        AllUser,
        PaginatePanel
    },
    metaInfo() {
        return {
            title: `نشانه های من - ${this.title}`,
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
            showPayMeta : [],
            showLoader : false,
            allBookmark : this.bookmarkPosts,
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
        }
    },
    methods:{
        btnBookmark(id , index){
            const url = `/bookmark`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data == 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                    }
                    if (response.data == 'delete'){
                        this.allBookmark.splice(index , 1);
                    }else{
                        this.$toast.success('نشانه اضافه شد', 'نشانه با موفقیت اضافه شد', this.notificationSystem.options.success);
                    }
                })
        },
    }
}
</script>
