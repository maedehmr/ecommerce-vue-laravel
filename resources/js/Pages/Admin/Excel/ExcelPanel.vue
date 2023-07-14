<template>
    <admin-layout>
        <div class="allExcelPanel">
            <div class="allExcelPanelTop">
                <h1>خروجی اکسل</h1>
                <div class="allExcelPanelTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/excel">خروجی اکسل</inertia-link>
                </div>
            </div>
            <div class="allExcelPanelItems">
                <a href="/admin/get-excel/allUser" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی همه کاربران</h3>
                </a>
                <a href="/admin/get-excel/todayUser" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی کاربران امروز</h3>
                </a>
                <a href="/admin/get-excel/allProduct" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی همه محصولات</h3>
                </a>
                <a href="/admin/get-excel/todayProduct" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی محصولات امروز</h3>
                </a>
                <a href="/admin/get-excel/allPay" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی همه سفارش ها</h3>
                </a>
                <a href="/admin/get-excel/todayPay" class="allExcelItem">
                    <i>
                        <svg-icon :icon="'#excel'"></svg-icon>
                    </i>
                    <h3>خروجی سفارش امروز</h3>
                </a>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '../../../Layouts/Admin/AdminLayout.vue';
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "ExcelPanel",
    components: {SvgIcon, AdminLayout},
    metaInfo: {
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
        title: 'خروجی اکسل ها'
    },
    methods:{
        sidebar(){
            this.$eventHub.emit('sidebar' , ['0','44']);
        }
    },
    mounted(){
        this.sidebar();
    }
}
</script>

<style scoped>

</style>
