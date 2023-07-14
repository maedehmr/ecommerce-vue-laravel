<template>
    <home-layout>
        <div class="allPacksIndex">
            <div class="allPackSingleTop">
                <div class="allPackSingleTopBlock">
                    <h1>همه پک ها</h1>
                    <p>با خرید هر یک از این پک ها با قیمتی بسیار مناسب و به صرفه صاحب همه محصولات آن میشوید</p>
                </div>
            </div>
            <div class="allPacks width">
                <div class="allPackItem" v-for="item in packs.data">
                    <inertia-link :href="'/pack/'+item.slug">
                        <div class="packPostCount" :title="item.post_count + ' مجصول'">
                            <svg-icon :icon="'#product'"></svg-icon>
                            {{item.post_count}}
                        </div>
                        <ul>
                            <li v-for="items in item.post.slice(0,6)">
                                <img v-lazy="JSON.parse(items.image)[0]" :alt="item.title">
                            </li>
                        </ul>
                        <div class="allPackIndexItemData">
                            <h3>{{item.title}}</h3>
                            <h4>
                                {{item.price|NumFormat}}
                                <span>تومان</span>
                            </h4>
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "AllPack",
    components: {SvgIcon, HomeLayout},
    props:['packs']
}
</script>

<style scoped>

</style>
