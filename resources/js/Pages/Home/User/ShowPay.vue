<template>
    <home-layout>
        <div class="allUserIndex width">
            <div class="allUserLists">
                <user-list tab="4"></user-list>
            </div>
            <div class="allShowPay">
                <div class="topShowPay">
                    <div class="title">
                        <h1>جزئیات سفارش</h1>
                        <span>{{pay.created_at}}</span>
                        <span v-if="pay.status == 100">
                            <a :href="'/pay/invoice/' + pay.property">دریافت فاکتور</a>
                        </span>
                    </div>
                    <div class="detail">
                        <div class="topDetail">
                            <div class="items">
                                <div class="item">
                                    <h5>گیرنده :</h5>
                                    <div>{{pay.user.name}}</div>
                                </div>
                                <div class="item">
                                    <h5>شماره تماس :</h5>
                                    <div>{{pay.user.number}}</div>
                                </div>
                            </div>
                            <div class="items" v-if="pay.user.user_meta.length">
                                <div class="item">
                                    <h5>آدرس تحویل :</h5>
                                    <div>{{pay.user.user_meta[0].address}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="botDetail">
                            <div class="items">
                                <div class="item">
                                    <h5>مبلغ پرداخت شده :</h5>
                                    <div v-if="pay.status == 100">{{pay.price|NumFormat}} تومان</div>
                                    <div v-else-if="pay.status == 50">{{pay.deposit|NumFormat}} تومان</div>
                                    <div v-else>0 تومان</div>
                                </div>
                                <div class="item">
                                    <h5>وضعیت پرداخت :</h5>
                                    <div class="active" v-if="pay.status == 100">پرداخت شده</div>
                                    <div class="active" v-else-if="pay.status == 50">پرداخت بیعانه</div>
                                    <div class="unActive" v-else>پرداخت نشده</div>
                                </div>
                                <div class="item">
                                    <h5>نحوه پرداخت :</h5>
                                    <div v-if="pay.method == 0">درگاه پرداخت</div>
                                    <div v-if="pay.method == 2">پرداخت در محل</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allShowPayContainer">
                    <div class="topContainer">
                        <div class="level">
                            <h3>وضعیت سفارش :</h3>
                            <span class="unActive" v-if="pay.deliver == 0">درحال بررسی</span>
                            <span class="unActive" v-if="pay.deliver == 1">تحویل داده شده</span>
                        </div>
                        <div class="rateItemsCount">
                            <div class="rateItemsCountItem" title="درحال بررسی">
                                <div class="rateItemsCountItemBarActive" v-if="pay.deliver >= 1">
                                </div>
                                <div class="rateItemsCountItemBar" v-if="pay.deliver == 0">
                                </div>
                                <div class="rateItemsCountItemCircleActives" v-if="pay.deliver >= 1">
                                    <svg-icon :icon="'#waiting-room'"></svg-icon>
                                </div>
                                <div class="rateItemsCountItemCircleActive" v-if="pay.deliver == 0">
                                    <svg-icon :icon="'#waiting-room'"></svg-icon>
                                </div>
                            </div>
                            <div class="rateItemsCountItem" title="تحویل داده شده">
                                <div class="rateItemsCountItemCircleActive" v-if="pay.deliver == 1">
                                    <svg-icon :icon="'#delivery-complete'"></svg-icon>
                                </div>
                                <div class="rateItemsCountItemCircle" v-if="pay.deliver <= 1">
                                    <svg-icon :icon="'#delivery-complete'"></svg-icon>
                                </div>
                            </div>
                        </div>
                        <div class="code">
                            <h3>شماره سفارش :</h3>
                            <span>{{pay.property}}</span>
                        </div>
                    </div>
                    <div class="items">
                        <div class="title">محصولات سفارش داده شده</div>
                        <div class="item" v-for="item in pay.pay_meta">
                            <inertia-link :href="'/product/'+item.post.slug" class="cartDetailPic">
                                <img :src="JSON.parse(item.post.image)[0]" :alt="item.post.title">
                            </inertia-link>
                            <div class="cartDetailInfo">
                                <inertia-link :href="'/product/'+item.post.slug" class="cartDetailInfoItem">
                                    <h3>{{item.post.title}}</h3>
                                </inertia-link>
                                <div class="cartDetailInfoItem" v-if="item.color">
                                    <i>
                                        <svg-icon :icon="'#color'"></svg-icon>
                                    </i>
                                    <span>{{item.color}}</span>
                                </div>
                                <div class="cartDetailInfoItem" v-if="item.size">
                                    <i>
                                        <svg-icon :icon="'#sizeFront'"></svg-icon>
                                    </i>
                                    <span>{{item.size}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <i>
                                        <svg-icon :icon="'#count'"></svg-icon>
                                    </i>
                                    <span>{{item.count}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <i>
                                        <svg-icon :icon="'#cost'"></svg-icon>
                                    </i>
                                    <span>{{item.price|NumFormat}} تومان</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from "../../../Layouts/Home/HomeLayout";
import UserList from "./AllUser";
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "ShowPay",
    components: {UserList,HomeLayout,SvgIcon},
    props: ['pay']
}
</script>

<style scoped>

</style>
