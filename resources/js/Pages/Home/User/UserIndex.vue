<template>
    <home-layout>
        <div class="allUserIndex width">
            <all-user :select="0"></all-user>
            <div class="allUserIndexInfo">
                <div class="allUserIndexInfoTop">
                    <div class="allUserIndexInfoTopItem">
                        <label>آخرین علاقه مندی</label>
                        <ul>
                            <li v-for="(item , index) in allLike.slice(0,3)" :key="index">
                                <inertia-link :href="'/product/' + item.slug">
                                    <div class="userItemPic">
                                        <img v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                    </div>
                                    <div class="userItemSubject">
                                        <div class="userItemSubjectTitle">{{item.title}}</div>
                                        <div class="postPriceItem">
                                            <div class="offPrice" v-if="item.off != null">
                                                <s>{{item.price|NumFormat}} تومان</s>
                                            </div>
                                            <h3 v-if="item.off != null">{{item.offPrice|NumFormat}} تومان</h3>
                                            <h3 v-else>{{item.price|NumFormat}} تومان</h3>
                                        </div>
                                    </div>
                                </inertia-link>
                                <i @click.stop="btnLike(item.id , index)">
                                    <svg-icon :icon="'#trash'"></svg-icon>
                                </i>
                            </li>
                        </ul>
                        <div class="allUserIndexInfoTopItemAddress">
                            <inertia-link href="/profile/like">لیست علاقه مندی ها</inertia-link>
                        </div>
                    </div>
                    <div class="allUserIndexInfoTopItem">
                        <label>آخرین نشانه ها</label>
                        <ul>
                            <li v-for="(item , index) in allBookmark.slice(0,3)" :key="index">
                                <inertia-link :href="'/product/' + item.slug">
                                    <div class="userItemPic">
                                        <img v-lazy="JSON.parse(item.image)[0]" :alt="item.title">
                                    </div>
                                    <div class="userItemSubject">
                                        <div class="userItemSubjectTitle">{{item.title}}</div>
                                        <div class="postPriceItem">
                                            <div class="offPrice" v-if="item.off != null">
                                                <s>{{item.price|NumFormat}} تومان</s>
                                            </div>
                                            <h3 v-if="item.off != null">{{item.offPrice|NumFormat}} تومان</h3>
                                            <h3 v-else>{{item.price|NumFormat}} تومان</h3>
                                        </div>
                                    </div>
                                </inertia-link>
                                <i @click.stop="btnBookmark(item.id , index)">
                                    <svg-icon :icon="'#trash'"></svg-icon>
                                </i>
                            </li>
                        </ul>
                        <div class="allUserIndexInfoTopItemAddress">
                            <inertia-link href="/profile/bookmark">ویرایش نشانه ها</inertia-link>
                        </div>
                    </div>
                </div>

                <label>آخرین پرداختی ها</label>

                <div class="allUserIndexInfoPay">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>وضعیت ارسال</th>
                            <th>شماره سفارش</th>
                            <th>وضعیت پرداخت</th>
                            <th>تاریخ سفارش</th>
                            <th>عملیات</th>
                        </tr>
                        <div class="showTr">
                            <tr v-for="(item , index) in pays" :key="index">
                                <td>
                                    <span>{{++index}}</span>
                                </td>
                                <td>
                                    <span class="unActive" v-if="item.deliver == 0">در حال ارسال</span>
                                    <span class="active" v-else>تحویل داده شده</span>
                                </td>
                                <td>
                                    <span>{{item.property}}</span>
                                </td>
                                <td>
                                    <span class="active" v-if="item.status == 100">پرداخت شده</span>
                                    <span class="active" v-else-if="item.status == 50">پرداخت بیعانه</span>
                                    <span class="unActive" v-else>پرداخت نشده</span>
                                </td>
                                <td>
                                    <span>{{item.created_at}}</span>
                                </td>
                                <td>
                                    <inertia-link :href="'/show-pay/'+item.property">
                                        <svg-icon :icon="'#left'"></svg-icon>
                                    </inertia-link>
                                </td>
                            </tr>
                        </div>
                    </table>
                </div>
            </div>
            <div class="allShowFastPost" v-if="showPayMeta != ''">
                <div class="allShowFastPostPanel">
                    <ul>
                        <li v-for="item in showPayMeta" :key="item.id">
                            <div class="payMetaItem" v-if="item.post == null">
                                <div class="payMetaPic"><img :src="item.pack.image"></div>
                                <div class="payMetaSubject">
                                    <div class="payMetaSubjectTitle">{{item.pack.title}}</div>
                                    <div class="payMetaSubjectItem" v-if="item.count">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                            <div class="payMetaItem" v-else>
                                <div class="payMetaPic"><img :src="JSON.parse(item.post.image)[0]"></div>
                                <div class="payMetaSubject">
                                    <div class="payMetaSubjectTitle">{{item.post.title}}</div>
                                    <div class="payMetaSubjectItem" v-if="item.color">
                                        <i>
                                            <svg-icon :icon="'#color'"></svg-icon>
                                        </i>
                                        {{item.color}}
                                    </div>
                                    <div class="payMetaSubjectItem" v-if="item.size">
                                        <i>
                                            <svg-icon :icon="'#size'"></svg-icon>
                                        </i>
                                        {{item.size}}
                                    </div>
                                    <div class="payMetaSubjectItem">
                                        {{item.count}}
                                        عدد
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="buttons">
                        <button @click="showPayMeta = []">انصراف</button>
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
export default {
    name: "UserIndex",
    props: ['likePost','bookmarkPost','pays','title'],
    components:{
        HomeLayout,
        SvgIcon,
        AllUser
    },
    data() {
        return {
            showPayMeta : [],
            showLoader : false,
            allLike : this.likePost,
            allBookmark : this.bookmarkPost,
        }
    },
    metaInfo() {
        return {
            title: `مدیریت حساب - ${this.title}`,
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
    methods:{
        btnShow(id){
            this.showLoader = true;
            const url = `/pay/${id}`;
            axios.get(url)
                .then(response=>{
                    this.showPayMeta = response.data;
                    this.showLoader = false;
                })
        },
        btnBookmark(id , index){
            const url = `/bookmark`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$swal.fire(
                            'عضو نیستید',
                            'برای اینکار ابتدا ثبت نام کنید',
                            'warning'
                        );
                    }else{
                        if (response.data === 'delete'){
                            this.allBookmark.splice(index , 1);
                        }else{
                            this.$swal.fire(
                                'علاقه مندی اضافه شد',
                                'به علاقه مندی با موفقیت اضافه شد',
                                'success'
                            );
                        }
                    }
                })
        },
        btnLike(id , index){
            const url = `/like`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$swal.fire(
                            'عضو نیستید',
                            'برای اینکار ابتدا ثبت نام کنید',
                            'warning'
                        );
                        this.like = [];
                    }else{
                        if (response.data === 'delete'){
                            this.allLike.splice(index , 1);
                        }else{
                            this.$swal.fire(
                                'علاقه مندی اضافه شد',
                                'به علاقه مندی با موفقیت اضافه شد',
                                'success'
                            );
                        }
                    }
                })
        },
    }
}
</script>
