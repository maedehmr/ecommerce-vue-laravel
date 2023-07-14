<template>
    <div class="allNewsIndex width">
        <div class="title">
            <div class="titleItem">
                <h3>{{ data.title }}</h3>
            </div>
            <div class="titleBlock">
                <inertia-link href="/archive/news">{{ data.more }}</inertia-link>
            </div>
        </div>
        <div class="items">
            <inertia-link v-for="(item,index) in data.post" :key="index" :href="'/news/' + item.slug" class="item">
                <div class="pic">
                    <img v-lazy="item.image" :alt="item.title">
                </div>
                <div class="over">
                    <div class="subject">
                        <h3>{{ item.title }}</h3>
                        <ul>
                            <li>
                                <svg-icon :icon="'#edit2'"></svg-icon>
                                {{ item.user.name }}
                            </li>
                            <li>
                                <svg-icon :icon="'#clock'"></svg-icon>
                                {{ item.created_at }}
                            </li>
                        </ul>
                        <span>تایید شده</span>
                    </div>
                </div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "NewsIndex",
    props:['data'],
    components: {SvgIcon}
}
</script>

<style scoped>

</style>
