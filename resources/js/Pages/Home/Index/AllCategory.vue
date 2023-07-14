<template>
    <div class="allCategory width">
        <div class="allCategoryItemsTitle">از دسته بندی های زیر دیدن فرمایید</div>
        <div class="allCategoryItems">
            <div class="allCategoryItem" v-for="item in allVidgets.post" :key="item.id" :title="item.name">
                <inertia-link :href="'/archive/category/' + item.slug">
                    <img v-if="item.post.length" v-lazy="JSON.parse(item.post[0].image)[0]" :alt="item.name">
                    <div class="allCategoryItemSubject">
                        <span>{{item.post.length}}+ کالا</span>
                        <h4>{{item.name}}</h4>
                    </div>
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon.vue';
export default {
    name:'AllCategory',
    components: {SvgIcon},
    props: ['allVidgets'],
}
</script>
