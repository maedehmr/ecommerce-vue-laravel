<template>
    <home-layout>
        <div class="allPackSingle">
            <div class="allPackSingleTop">
                <div class="allPackSingleTopBlock">
                    <h1>{{packs.title}}</h1>
                    <p>با خرید این پک با قیمتی بسیار مناسب و به صرفه صاحب همه این محصولات میشوید</p>
                </div>
            </div>
            <div class="allPackSingleTopBlockInfo width">
                <div class="allPackSingleTopBlockInfoItem" v-if="packs.count != 0">
                    <button @click="addCart">افزودن به سبد خرید</button>
                    <h3>
                        {{packs.price|NumFormat}}
                        <span>تومان</span>
                    </h3>
                </div>
                <div class="allPackSingleTopBlockInfoItem" v-else>
                    <h3>ناموجود</h3>
                </div>
                <h4>
                    <svg-icon :icon="'#product'"></svg-icon>
                    تعداد : {{packs.post.length}}
                </h4>
            </div>
            <div class="allPackSinglePosts width">
                <div class="allPackSinglePost" v-for="item in packs.post" :key="item.id" :title="item.title">
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
                                <img :src="JSON.parse(item.image)[0]" :alt="item.title">
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
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '../../../Layouts/Home/HomeLayout.vue'
import SvgIcon from '../../Svg/SvgIcon.vue'
export default {
    components: { SvgIcon, HomeLayout },
    name: 'PackSingle',
    props: ['packs','title'],
    metaInfo() {
        return {
            title: `${this.packs.title} - ${this.title}`,
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
    data(){
        return{
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
        addCart(){
            const url = `/add-pack`;
            axios.post(url ,{
                packID : this.packs.id
            })
                .then(response=>{
                    if(response.data == 'limit'){
                        this.$toast.error('انجام نشد', 'موجودی پک کافی نیست', this.notificationSystem.options.error);
                    }
                    if (response.data === 'no'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                    }else{
                        this.$eventHub.emit('getCart');
                        this.$toast.success('انجام شد', 'به سبد خرید با موفقیت اضافه شد', this.notificationSystem.options.success);
                    }
                })
        },
    },
}
</script>

<style>

</style>
