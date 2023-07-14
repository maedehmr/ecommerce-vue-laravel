<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="6"></all-user>
            <div class="allUserIndexInfo">
                <label>بازدید های اخیر من</label>
                <div class="paginate" v-if="views.links">
                    <paginate-panel :link="views.links"></paginate-panel>
                </div>
                <div class="allProductArchiveContainerPosts">
                    <div class="containerMostItem" v-for="(post , index) in views.data" :key="index">
                        <inertia-link :href="'/product/'+post.slug">
                            <div class="offProduct" v-if="post.off">
                                <span>
                                    ٪{{post.off}}
                                </span>
                            </div>
                            <div class="pic">
                                <img :src="JSON.parse(post.image)[0]" :alt="post.title">
                            </div>
                            <div class="postTitle">
                                <inertia-link :href="'/product/'+post.slug">{{post.title}}</inertia-link>
                            </div>
                            <div class="postPrice" v-if="post.count >= 1">
                                <s v-if="post.off != null">{{post.offPrice|NumFormat}} تومان</s>
                                <h3>{{post.price|NumFormat}} تومان</h3>
                            </div>
                            <div class="checkCount" v-else>
                                <span>نا موجود</span>
                            </div>
                            <ul>
                                <li v-for="color in post.color" :key="color.id" :title="color.name">
                                    <svg-icon :icon="'#circle'" :style="{'fill' : color.code}"></svg-icon>
                                </li>
                            </ul>
                        </inertia-link>
                    </div>
                </div>
                <div class="paginate" v-if="views.links">
                    <paginate-panel :link="views.links"></paginate-panel>
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
import PaginatePanel from '../../Admin/PaginatePanel.vue';
import SvgIcon from "../../Svg/SvgIcon";
import AllUser from "./AllUser";
export default {
    name: "ViewUser",
    components:{
        HomeLayout,
        SvgIcon,
        AllUser,
        PaginatePanel,
    },
    props: ['views','title'],
    data() {
        return {
            showLoader : false,
        }
    },
    metaInfo() {
        return {
            title: `بازدید های اخیر - ${this.title}`,
            htmlAttrs: {
                lang: 'fa',
                amp: true
            },
            htmlAttrs: {
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
    methods:{
        addCart(id){
            const url = `/add-cart`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'no'){
                        this.$swal.fire(
                            'ابتدا عضو شوید',
                            'به سبد خرید با اضافه نشد',
                            'error'
                        );
                    }else{
                        this.$eventHub.emit('getCart');
                        this.$swal.fire(
                            'با موفقیت انجام شد',
                            'به سبد خرید با موفقیت اضافه شد',
                            'success'
                        );
                    }
                })
        },
    }
}
</script>

