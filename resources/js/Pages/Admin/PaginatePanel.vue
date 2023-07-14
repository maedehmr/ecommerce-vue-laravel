<template>
    <div class="allPaginatePanel" v-if="link.length != 3">
        <div class="pageItem" v-for="item in link">
            <div class="pageItemLabel" v-if="item.label == 'Previous' || item.label == 'Next'">
                <inertia-link :href="item.url" v-if="item.label == 'Previous' && item.url != null"><svg-icon :icon="'#right'"></svg-icon></inertia-link>
                <inertia-link :href="item.url" v-if="item.label == 'Next' && item.url != null"><svg-icon :icon="'#forward'"></svg-icon></inertia-link>
            </div>
            <div class="pageItemLabel" v-else>
                <inertia-link :href="item.url" v-if="item.active == true" class="active">{{item.label}}</inertia-link>
                <inertia-link :href="item.url" v-else>{{item.label}}</inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from "../Svg/SvgIcon";
export default {
    name: "PaginatePanel",
    components: {SvgIcon},
    props : ['link']
}
</script>

<style scoped>

</style>
