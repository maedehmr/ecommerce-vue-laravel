<template>
    <div class="allShowFast" v-if="showFast">
        <div class="showFastContainerIndex">
            <div class="showFastContainerPic">
                <zoom-on-hover :img-normal="JSON.parse(showFast.image)[0]" :scale="3"></zoom-on-hover>
            </div>
            <div class="showFastContainerItems">
                <div class="showFastContainerItem">
                    <div class="showFastContainerItemsTitle">
                        <h3>{{showFast.title}}</h3>
                    </div>
                    <div class="showFastContainerItemsBody">
                        <p>{{showFast.summery}}</p>
                    </div>
                    <div class="postPriceItem" v-if="showFast.count >= 1">
                        <div class="offPrice" v-if="showFast.off != null">
                            <s>{{showFast.offPrice|NumFormat}} تومان</s>
                        </div>
                        <h3>{{showFast.price|NumFormat}} تومان</h3>
                    </div>
                    <div class="showFastContainerItemAddCart" v-if="showFast.count >= 1" @click.prevent="addCart(showFast.id)">
                        <i>
                            <svg-icon :icon="'#cart'"></svg-icon>
                        </i>
                        افزودن به سبد خرید
                    </div>
                </div>
                <div class="showFastContainerItem">
                    <div class="showFastContainerPropertiesTitle">
                        <h3>ویژگی های محصول</h3>
                    </div>
                    <div class="showFastContainerProperties" v-if="showFast.post_meta[0].ability != null">
                        <ul>
                            <li v-for="(item,index2) in JSON.parse(showFast.post_meta[0].ability).slice(0 , 3)">
                                <svg-icon :icon="'#checkmark'"></svg-icon>
                                <span>{{item.name}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="showFastContainerItem">
                    <div class="showFastContainerItemCat">
                        <label>دسته بندی :</label>
                        <ul>
                            <li v-for="(item , check) in showFast.category">
                                <inertia-link :href="'/archive/category/' + item.slug">{{item.name}}</inertia-link>
                            </li>
                        </ul>
                    </div>
                    <div class="showFastContainerItemCat" v-if="showFast.brand.length">
                        <label>برند ها :</label>
                        <ul>
                            <li v-for="(item , check) in showFast.brand">
                                <inertia-link :href="'/archive/brand/' + item.slug">{{item.name}}</inertia-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="showFastContainerIndexClose" @click.prevent="showFast = ''">
                <i>
                    <svg-icon :icon="'#cancel'"></svg-icon>
                </i>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../Svg/SvgIcon.vue';
export default {
  components: { SvgIcon },
    name: 'AllShowFast',
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
            showFast: ''
        }
    },
    methods:{
        getShow(id){
            const url = '/show-fast';
            axios.post(url ,{
                postId: id,
            })
                .then(response=>{
                    this.showFast = response.data;
                })
        },
        addCart(id){
            const url = `/add-cart`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if(response.data == 'limit'){
                        this.$toast.error('انجام نشد', 'موجودی کالا کافی نیست', this.notificationSystem.options.error);
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
    created: function() {
        this.$eventHub.on('sendShow', this.getShow);
    },
}
</script>

<style>

</style>
