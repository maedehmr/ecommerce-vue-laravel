<template>
    <div class="allHomeLayout" id="top">
        <header-index></header-index>
        <svg-content></svg-content>
        <div class="content">
            <slot></slot>
        </div>
        <footer-index></footer-index>
    </div>
</template>

<script>
import FooterIndex from '../../Pages/Home/Footer/FooterIndex.vue';
import HeaderIndex from '../../Pages/Home/Header/HeaderIndex.vue';
import SvgContent from '../../Pages/Svg/SvgContent';

export default {
    name: "HomeLayout",
    components: { SvgContent,HeaderIndex, FooterIndex },

}
</script>

<style>

</style>