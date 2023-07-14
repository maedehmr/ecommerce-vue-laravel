<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="3"></all-user>
            <div class="allUserIndexComment">
                <label>دیدگاه ها و نظرات</label>
                <div class="allUserIndexInfoPayFilter">
                    <div class="allUserIndexInfoPayFilterItem" @click="btnComment(0)">
                            <span class="active" v-if="show == 0">همه</span>
                            <span v-else>همه</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnComment(1)">
                        <span class="active" v-if="show == 1">در انتظار تایید</span>
                        <span v-else>در انتظار تایید</span>
                    </div>
                    <div class="allUserIndexInfoPayFilterItem" @click="btnComment(2)">
                        <span class="active" v-if="show == 2">تایید شده</span>
                        <span v-else>تایید شده</span>
                    </div>
                </div>
                <div class="paginate" v-if="allComment.links">
                    <paginate-panel :link="allComment.links"></paginate-panel>
                </div>
                <div class="allUserIndexCommentItems">
                    <div class="allUserIndexCommentItem" v-for="(item , index) in allComment.data" :key="index">
                        <inertia-link :href="'/product/' + item.post.slug">
                            <div class="allUserIndexCommentItemPic">
                                <img v-lazy="JSON.parse(item.post.image)[0]" :alt="item.post.title">
                            </div>
                            <div class="allUserIndexCommentItemSubject">
                                <div class="allUserIndexCommentItemSubjectTitle">
                                    {{item.title}}
                                </div>
                                <div class="allUserIndexCommentItemSubjectStatus">
                                    <span v-if="item.status == 0">در مورد خرید این محصول مطمئن نیستم</span>
                                    <span v-if="item.status == 1">خرید این محصول را توصیه نمی‌کنم</span>
                                    <span v-if="item.status == 2">خرید این محصول را توصیه می‌کنم</span>
                                </div>
                                <div class="allUserIndexCommentItemSubjectBody">
                                    <p>{{item.body}}</p>
                                </div>
                                <div class="allUserIndexCommentItemSubjectAccept">
                                    <span v-if="item.approved == 0">در انتظار تایید</span>
                                    <span v-if="item.approved == 1" class="active">تایید شده</span>
                                </div>
                            </div>
                        </inertia-link>
                        <div class="allUserIndexCommentItemDelete">
                            <i @click.stop="remove(item.id , index)">
                                <svg-icon :icon="'#trash'"></svg-icon>
                            </i>
                        </div>
                    </div>
                </div>
                <div class="paginate" v-if="allComment.links">
                    <paginate-panel :link="allComment.links"></paginate-panel>
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
import PaginatePanel from '../../Admin/PaginatePanel';
import SvgIcon from "../../Svg/SvgIcon";
import AllUser from './AllUser.vue';
export default {
    name: "CommentUser",
    props: ['comments','title'],
    components:{
        HomeLayout,
        SvgIcon,
        AllUser,
        PaginatePanel
    },
    metaInfo() {
        return {
            title: `دیدگاه های من - ${this.title}`,
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
    data() {
        return {
            show : 0,
            allComment : this.comments,
        }
    },
    methods:{
        btnComment(index){
            const url = `/profile/comment`;
            this.show = index;
            this.$inertia.post(url , {
                show : this.show,
            })
        },
        remove(id , index){
            this.$swal.fire({
                title: 'آیا مطمینی ؟',
                text: "فایل حذف شده برنمیگردد!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'پشیمون شدم'
            }).then((result) => {
                if (result.value) {
                    const url = `/profile/comment`;
                    this.showLoader = true;
                    this.$inertia.post(url , {
                        removeId : id,
                        show : this.show,
                    })
                }
            })
        },
    },
    watch: {
        'comments': function(val, oldVal){
            this.allComment = this.comments;
        }
    }
}
</script>
