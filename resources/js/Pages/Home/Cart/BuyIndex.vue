<template>
    <home-layout>
        <div class="buyIndex">
            <div class="allBuyItems">
                <div class="allBuySuccessItemTitle" v-if="pay.status == 100 || pay.status == 50">
                    <h3>عملیات خرید</h3>
                </div>
                <div class="allBuyFailItemTitle" v-else>
                    <h3>عملیات خرید</h3>
                </div>
                <div class="allBuyItem">
                    <label>زمان ثبت</label>
                    <h4>{{pay.created_at}}</h4>
                </div>
                <div class="allBuyItem">
                    <label>نام خریدار</label>
                    <h4>{{name}}</h4>
                </div>
                <div class="allBuyItem">
                    <label>مبلغ</label>
                    <h4 v-if="pay.status == 50">{{pay.deposit|NumFormat}} تومان</h4>
                    <h4 v-else>{{pay.price|NumFormat}} تومان</h4>
                </div>
                <div class="allBuyItem">
                    <label>شناسه پرداخت</label>
                    <h4>{{pay.property}}</h4>
                </div>
                <div class="allBuyItem">
                    <label>شماره تراکنش پرداخت</label>
                    <h4>{{pay.refId}}</h4>
                </div>
                <div class="allBuyItem">
                    <label>وضعیت خرید</label>
                    <h4 v-if="pay.status == 100 || pay.status == 50">موفق</h4>
                    <h4 v-else>نا موفق</h4>
                </div>
                <div class="allBuyButton">
                    <a href="/" :title="'صفحه نخست'" :name="'صفحه نخست'">بازگشت به خانه</a>
                </div>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from "../../../Layouts/Home/HomeLayout";
export default {
    name: "BuyIndex",
    components: {HomeLayout},
    props : ['name','pay'],

}
</script>

<style scoped>

</style>
