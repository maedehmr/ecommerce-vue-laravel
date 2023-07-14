<template>
    <div class="allUserIndexLists">
        <div class="allUserIndexListsUser">
            <div class="allUserIndexListsUserPic">
                <img v-if="$page.userData.profile == null" src="/img/user.png" :alt="$page.userData.name">
                <img v-else :src="$page.userData.profile" :alt="$page.userData.name">
            </div>
            <div class="allUserIndexListsUserItem">
                <div class="allUserIndexListsUserName">{{ $page.userData.name }}</div>
                <div class="allUserIndexListsUserNumber">{{ $page.userData.number }}</div>
            </div>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#billFront'"></svg-icon>
            </i>
            <inertia-link href="/profile/pay">پرداختی ها</inertia-link>
            <i v-if="select == 4">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#unlike'"></svg-icon>
            </i>
            <inertia-link href="/profile/like">علاقه مندی ها</inertia-link>
            <i v-if="select == 2">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#unbookmark'"></svg-icon>
            </i>
            <inertia-link href="/profile/bookmark">نشانه ها</inertia-link>
            <i v-if="select == 1">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#comment'"></svg-icon>
            </i>
            <inertia-link href="/profile/comment">دیدگاه ها</inertia-link>
            <i v-if="select == 3">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#recentFront'"></svg-icon>
            </i>
            <inertia-link href="/profile/recently">بازدید های اخیر</inertia-link>
            <i v-if="select == 6">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#user'"></svg-icon>
            </i>
            <inertia-link href="/profile/personal-info">حساب من</inertia-link>
            <i v-if="select == 5">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#homeFront'"></svg-icon>
            </i>
            <inertia-link href="/profile">مدیریت حساب</inertia-link>
            <i v-if="select == 0">
                <svg-icon :icon="'#left'"></svg-icon>
            </i>
        </div>
        <div class="allUserIndexListsItem">
            <i>
                <svg-icon :icon="'#logout'"></svg-icon>
            </i>
            <inertia-link href="/logout">خروج از حساب</inertia-link>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon.vue'
export default {
    props:['select'],
    components: { SvgIcon },

}
</script>

<style>

</style>
