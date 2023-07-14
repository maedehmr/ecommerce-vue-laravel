<template>
    <div class="allHeaderPanel">
        <div class="allHeaderPanelOption">
            <inertia-link href="/admin/comment">
                <svg-icon :icon="'#comment'"></svg-icon>
            </inertia-link>
            <i>
                <svg-icon :icon="'#search'"></svg-icon>
            </i>
        </div>
        <div class="allHeaderPanelOption">
            <i @click="toggle">
                <svg-icon :icon="'#full-screen'"></svg-icon>
            </i>
            <div class="alertHeader">
                <div class="alertHeaderIcon" @click="showBell = !showBell">
                    <i v-if="$page.paySeen == 0 && $page.commentSeen == 0 && $page.userSeen == 0">
                        <svg-icon :icon="'#bell'"></svg-icon>
                    </i>
                    <i v-else class="active">
                        <svg-icon :icon="'#bell'"></svg-icon>
                    </i>
                </div>
                <ul v-if="showBell">
                    <li>اطلاعات جدید</li>
                    <li>
                        <div class="alarmHeaderPanelIcon">
                            <svg-icon :icon="'#billFront'"></svg-icon>
                        </div>
                        <div class="alarmHeaderPanelInfo">
                            <inertia-link href="/admin/pay">پرداختی جدید</inertia-link>
                            <span>{{ $page.paySeen }} مورد </span>
                        </div>
                    </li>
                    <li>
                        <div class="alarmHeaderPanelIcon">
                            <svg-icon :icon="'#user'"></svg-icon>
                        </div>
                        <div class="alarmHeaderPanelInfo">
                            <inertia-link href="/admin/user">کاربر جدید</inertia-link>
                            <span>{{ $page.userSeen }} مورد </span>
                        </div>
                    </li>
                    <li>
                        <div class="alarmHeaderPanelIcon">
                            <svg-icon :icon="'#comment'"></svg-icon>
                        </div>
                        <div class="alarmHeaderPanelInfo">
                            <inertia-link href="/admin/comment">دیدگاه جدید</inertia-link>
                            <span>{{ $page.commentSeen }} مورد </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="userHeader">
                <span>{{$page.userData.name}}</span>
                <img v-if="$page.userData.profile == null" src="/img/user.png" :alt="$page.userData.name">
                <img v-else :src="$page.userData.profile" :alt="$page.userData.name">
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon';
export default {
    name:'HeaderPanel',
    components:{
        SvgIcon
    },
    data(){
        return{
            showBell:false
        }
    },
    methods: {
        fullscreenChange (fullscreen) {
            this.fullscreen = fullscreen
        },
        toggle () {
            this.$eventHub.emit('fullS');
        },
    },
}
</script>

<style>

</style>
