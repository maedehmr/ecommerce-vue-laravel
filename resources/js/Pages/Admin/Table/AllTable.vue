<template>
    <table>
        <tr>
            <div>
                <th @click="checkAll">
                    <svg-icon :icon="'#check'" v-if="table.length == value.length"></svg-icon>
                    <svg-icon :icon="'#uncheck'" v-else></svg-icon>
                </th>
                <th v-for="label in labels">{{label}}</th>
            </div>
        </tr>
        <tr v-for="(item, index) in table" :key="index">
            <div class="active" v-for="(focus , index3) in value" v-if="focus == item.id" :key="index3">
                <td @click="getCheck(item.id)">
                    <i v-for="(values , index2) in value" v-if="values == item.id" :key="index2">
                        <svg-icon :icon="'#check'"></svg-icon>
                    </i>
                    <i>
                        <svg-icon :icon="'#uncheck'"></svg-icon>
                    </i>
                </td>
                <td v-for="label in labels">
                    <span v-if="label == '#'">{{++index}}</span>
                    <span v-if="label == 'آیدی'">{{item.id}}</span>
                    <span v-if="label == 'تصویر' && nameTable == 'post'">
                        <img :src="JSON.parse(item.image)[0]">
                    </span>
                    <span v-if="label == 'تصویر' && nameTable != 'post'">
                        <img v-if="item.profile_photo_url" :src="item.profile_photo_url">
                        <img v-else :src="item.image">
                    </span>
                    <span v-if="label == 'نام'">{{item.name}}</span>
                    <span v-if="label == 'عنوان'">{{item.title}}</span>
                    <span v-if="label == 'آخرین بازدید'">{{item.activity}}</span>
                    <span v-if="label == 'تاریخ ثبت'">{{item.created_at}}</span>
                    <span v-if="label == 'پیوند'">{{item.slug}}</span>
                    <span v-if="label == 'شماره ﺗﺮﺍﻛﻨﺶ ﭘﺮﺩﺍﺧﺖ'">{{item.refId}}</span>
                    <span v-if="label == 'شماره سفارش'">{{item.property}}</span>
                    <span v-if="label == 'وضعیت پرداخت'">
                        <span class="activeStatus" v-if="item.status == 100">پرداخت شده</span>
                        <span class="unActive" v-else>در حال پرداخت</span>
                    </span>
                    <span v-if="label == 'روز'">{{item.day}} روز</span>
                    <span v-if="label == 'مبلغ'">{{item.price|NumFormat}} تومان</span>
                    <span v-if="label == 'وضعیت'">
                        <span class="unActive" v-if="item.status == 0">پیشنویس</span>
                        <span class="activeStatus" v-else>منتشر شده</span>
                    </span>
                    <span v-if="label == 'وضعیت ارسال'">
                        <span class="unActive" v-if="item.deliver == 0">درحال ارسال</span>
                        <span class="activeStatus" v-else>تحویل داده شده</span>
                    </span>
                    <span v-if="nameTable == 'post' && label == 'عملیات'">
                        <inertia-link  :href="'/admin/post/' + item.id + '/edit'" v-if="edits == 1">
                            <svg-icon :icon="'#edit'"></svg-icon>
                        </inertia-link>
                        <inertia-link :href="'/admin/post/' + item.id + '/show'">
                            <svg-icon :icon="'#show'"></svg-icon>
                        </inertia-link>
                        <i v-if="label == 'عملیات' && deletes" @click="btnRemoveArray(item.id)"><svg-icon :icon="'#trash'"></svg-icon></i>
                    </span>
                    <span v-else>
                        <i v-if="label == 'عملیات' && edits" @click="openEdit(item.id)"><svg-icon :icon="'#edit'"></svg-icon></i>
                        <i v-if="label == 'عملیات' && shows" @click="openShow(item.id)"><svg-icon :icon="'#show'"></svg-icon></i>
                        <i v-if="label == 'عملیات' && deletes" @click="btnRemoveArray(item.id)"><svg-icon :icon="'#trash'"></svg-icon></i>
                    </span>
                </td>
            </div>
            <div>
                <td @click="getCheck(item.id)">
                    <i v-for="(values , index2) in value" v-if="values == item.id" :key="index2">
                        <svg-icon :icon="'#check'"></svg-icon>
                    </i>
                    <i>
                        <svg-icon :icon="'#uncheck'"></svg-icon>
                    </i>
                </td>
                <td v-for="label in labels">
                    <span v-if="label == '#'">{{++index}}</span>
                    <span v-if="label == 'آیدی'">{{item.id}}</span>
                    <span v-if="label == 'تصویر' && nameTable == 'post'">
                        <img :src="JSON.parse(item.image)[0]">
                    </span>
                    <span v-if="label == 'تصویر' && nameTable != 'post'">
                        <img v-if="item.profile_photo_url" src="/img/user.png">
                        <img v-else :src="item.image">
                    </span>
                    <span v-if="label == 'نام'">{{item.name}}</span>
                    <span v-if="label == 'عنوان'">{{item.title}}</span>
                    <span v-if="label == 'آخرین بازدید'">{{item.activity}}</span>
                    <span v-if="label == 'تاریخ ثبت'">{{item.created_at}}</span>
                    <span v-if="label == 'پیوند'">{{item.slug}}</span>
                    <span v-if="label == 'روز'">{{item.day}} روز</span>
                    <span v-if="label == 'شماره سفارش'">{{item.property}}</span>
                    <span v-if="label == 'شماره ﺗﺮﺍﻛﻨﺶ ﭘﺮﺩﺍﺧﺖ'">{{item.refId}}</span>
                    <span v-if="label == 'مبلغ'">{{item.price|NumFormat}} تومان</span>
                    <span v-if="label == 'وضعیت'">
                        <span class="unActive" v-if="item.status == 0">پیشنویس</span>
                        <span class="activeStatus" v-else>منتشر شده</span>
                    </span>
                    <span v-if="label == 'وضعیت ارسال'">
                        <span class="unActive" v-if="item.deliver == 0">درحال ارسال</span>
                        <span class="activeStatus" v-else>تحویل داده شده</span>
                    </span>
                    <span v-if="label == 'وضعیت پرداخت'">
                        <span class="activeStatus" v-if="item.status == 100">پرداخت شده</span>
                        <span class="unActive" v-else>در حال پرداخت</span>
                    </span>
                    <span v-if="nameTable == 'post' && label == 'عملیات'">
                        <inertia-link  :href="'/admin/post/' + item.id + '/edit'" v-if="edits == 1">
                            <svg-icon :icon="'#edit'"></svg-icon>
                        </inertia-link>
                        <inertia-link :href="'/admin/post/' + item.id + '/show'">
                            <svg-icon :icon="'#show'"></svg-icon>
                        </inertia-link>
                        <i v-if="label == 'عملیات' && deletes" @click="btnRemoveArray(item.id)"><svg-icon :icon="'#trash'"></svg-icon></i>
                    </span>
                    <span v-else-if="nameTable == 'news' && label == 'عملیات'">
                        <inertia-link  :href="'/admin/news/' + item.id + '/edit'" v-if="edits == 1">
                            <svg-icon :icon="'#edit'"></svg-icon>
                        </inertia-link>
                        <i v-if="label == 'عملیات' && deletes" @click="btnRemoveArray(item.id)"><svg-icon :icon="'#trash'"></svg-icon></i>
                    </span>
                    <span v-else>
                        <i v-if="label == 'عملیات' && edits" @click="openEdit(item.id)"><svg-icon :icon="'#edit'"></svg-icon></i>
                        <i v-if="label == 'عملیات' && shows" @click="openShow(item.id)"><svg-icon :icon="'#show'"></svg-icon></i>
                        <i v-if="label == 'عملیات' && deletes" @click="btnRemoveArray(item.id)"><svg-icon :icon="'#trash'"></svg-icon></i>
                    </span>
                </td>
            </div>
        </tr>
    </table>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
import AdminLayout from '../../../Layouts/Admin/AdminLayout.vue';
import ShowImage from "../ShowImage";
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import PaginatePanel from '../PaginatePanel.vue';
export default {
    name: "AllTable",
    props:['labels','nameTable','table','shows','deletes','edits'],
    components:{
        SvgIcon,
        VuePerfectScrollbar,
        ShowImage,
        AdminLayout,
        PaginatePanel,
    },
    data(){
        return{
            value: [],
            i: 0,
        }
    },
    methods:{
        checkAll(){
            this.i = 0;
            if(this.table.length == this.value.length){
                this.value = [];
            }else{
                this.value = [];
                for ( this.i ; this.i <  this.table.length; this.i++) {
                    this.value.push(this.table[this.i].id);
                }
                this.i = 0;
            }
            this.$emit('sendCheck' , this.value);
        },
        getCheck(id){
            for ( this.i ; this.i <  this.value.length; this.i++) {
                if (this.value[this.i] == id){
                    this.value.splice(this.i , 1);
                    this.i = 100;
                }
            }
            if (this.i != 101){
                this.value.push(id);
            }
            this.i = 0;
            this.$emit('sendCheck' , this.value);
        },
        openEdit(id){
            this.$emit('sendEdit' , id);
        },
        openShow(id){
            this.$emit('sendShow' , id);
        },
        btnRemoveArray(id){
            this.value = [id]
            this.$emit('sendDelete' , id);
        },
    },
}
</script>

<style>

</style>
