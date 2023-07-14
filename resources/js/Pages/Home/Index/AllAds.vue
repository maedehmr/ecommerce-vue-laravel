<template>
    <div class="allAdsIndex width" v-if="ads.post != ''">
        <div class="adsItems">
            <div class="adsItem" v-for="item in JSON.parse(ads.post)">
                <a :href="item.address">
                    <img :src="item.image" :alt="item.address">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AllAds",
    props:['ads']
}
</script>

<style scoped>

</style>
