<template>
    <admin-layout>
        <div class="allTemplateSetting">
            <div class="allTemplateSettingContainer">
                <div class="allTemplateSettingList">
                    <div class="allTemplateSettingListTitle">
                        همه ویجت ها
                    </div>
                    <draggable v-model="allVidget" class="drags" group="people" @start="drag=true" @change="btnSend" @end="drag = false">
                        <div class="allCategorySettingContainerListItem" v-for="(item,index) in allVidget" :key="index">
                            <img v-if="item.name == 'پیشنهادات'" src="/img/allSuggest.png">
                            <img v-if="item.name == 'تبلیغات اسلایدری'" src="/img/adHooper.png">
                            <img v-if="item.name == 'دسته بندی زیرمجموعه دار'" src="/img/categoryPost.png">
                            <img v-if="item.name == 'دسته بندی ها'" src="/img/allCategory.png">
                            <img v-if="item.name == 'دسته بندی با پست'" src="/img/allHooper.png">
                            <img v-if="item.name == 'برند های ویژه'" src="/img/allBrand.png">
                            <img v-if="item.name == 'شگفت انگیزان'" src="/img/suggestPost.png">
                            <img v-if="item.name == 'جستجو'" src="/img/searchIndex.png">
                            <img v-if="item.name == 'پک'" src="/img/packIndex.png">
                            <img v-if="item.name == 'خبر'" src="/img/newsIndex.png">
                            <img v-if="item.name == 'تبلیغ'" src="/img/allAd.png">
                        </div>
                    </draggable>
                </div>
                <div class="allTemplateSettingList">
                    <div class="allTemplateSettingListTitle">
                        قالب وبسایت شما
                    </div>
                    <draggable class="allTemplateSettingListDrag" v-model="form.allSiteTemplate" group="people" @start="drag=true" @end="drag = false">
                        <div class="allCategorySettingContainerListItemChoice"  v-for="(item , allIndex) in form.allSiteTemplate" :key="allIndex">
                            <img v-if="item.name == 'پیشنهادات'" src="/img/allSuggest.png">
                            <img v-if="item.name == 'تبلیغات اسلایدری'" src="/img/adHooper.png">
                            <img v-if="item.name == 'دسته بندی زیرمجموعه دار'" src="/img/categoryPost.png">
                            <img v-if="item.name == 'دسته بندی ها'" src="/img/allCategory.png">
                            <img v-if="item.name == 'دسته بندی با پست'" src="/img/allHooper.png">
                            <img v-if="item.name == 'برند های ویژه'" src="/img/allBrand.png">
                            <img v-if="item.name == 'شگفت انگیزان'" src="/img/suggestPost.png">
                            <img v-if="item.name == 'جستجو'" src="/img/searchIndex.png">
                            <img v-if="item.name == 'تبلیغ'" src="/img/allAd.png">
                            <img v-if="item.name == 'پک'" src="/img/packIndex.png">
                            <img v-if="item.name == 'خبر'" src="/img/newsIndex.png">
                            <div class="allCategorySettingContainerListItemChoiceData">
                                <h3>{{item.name}}</h3>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'پیشنهادات' && item.name != 'تبلیغ' && item.name != 'دسته بندی زیرمجموعه دار' && item.name != 'جستجو'">
                                    <label>نمایش عنوان :</label>
                                    <input type="text" placeholder="عنوان را وارد کنید" v-model="item.title">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'پیشنهادات' && item.name != 'تبلیغ' && item.name != 'برند های ویژه' && item.name != 'شگفت انگیزان' && item.name != 'دسته بندی زیرمجموعه دار' && item.name != 'جستجو' && item.name != 'دسته بندی ها'">
                                    <label>عنوان مشاهده بیشتر :</label>
                                    <input type="text" placeholder="عنوان را وارد کنید" v-model="item.more">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name == 'شگفت انگیزان' && item.name != 'تبلیغ'">
                                    <label>تصویر :</label>
                                    <input type="text" placeholder="آدرس را وارد کنید" v-model="item.more">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name == 'جستجو' && item.name != 'تبلیغ'">
                                    <label>تصویر تبلیغ :</label>
                                    <input type="text" placeholder="آدرس را وارد کنید" v-model="item.title">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name == 'جستجو' && item.name != 'تبلیغ'">
                                    <label>آدرس تبلیغ :</label>
                                    <input type="text" placeholder="آدرس URL را وارد کنید" v-model="item.slug">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'پیشنهادات' && item.name != 'پک' && item.name != 'خبر' && item.name != 'تبلیغ' && item.name != 'برند های ویژه' && item.name != 'دسته بندی زیرمجموعه دار' && item.name != 'جستجو' && item.name != 'دسته بندی ها'">
                                    <label>پیوند یکتا (slug) :</label>
                                    <input type="text" placeholder="پیوند را وارد کنید" v-model="item.slug">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'تبلیغ'">
                                    <label>تعداد نمایش :</label>
                                    <input type="text" placeholder="تعداد را وارد کنید" v-model="item.count">
                                </div>
                                <div class="allCategoryTitle" v-if="item.name == 'شگفت انگیزان'">
                                    <label>رنگ پس زمینه :</label>
                                    <input type="text" placeholder="رنگ را وارد کنید" v-model="item.background">
                                </div>
                                <div class="allCategorySettingSelect" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'جستجو' && item.name != 'پک' && item.name != 'خبر' && item.name != 'تبلیغ' && item.name != 'برند های ویژه' && item.name != 'پیشنهادات'">
                                    <label>دسته بندی :</label>
                                    <div class="allTaxes">
                                        <div class="taxShow" @click="btnShowTax(2,allIndex)">
                                            <h4 v-if="item.category.length == 0">دسته بندی را وارد کنید</h4>
                                            <ul v-else>
                                                <li v-for="(item , index) in item.category" :key="index">
                                                    <i @click.stop="btnClose(index,allIndex,'category')">
                                                        <svg-icon :icon="'#cancel'"></svg-icon>
                                                    </i>
                                                    <span>{{item}}</span>
                                                </li>
                                            </ul>
                                            <svg-icon :icon="'#down'"></svg-icon>
                                        </div>
                                        <ul class="showAllTaxes" v-if="showTax == 2 && showAllTax == allIndex">
                                            <VuePerfectScrollbar class="scroll-area">
                                                <li v-for="(item , index) in category" @click.stop="sendTax(item.name,allIndex,'category')" :key="index">
                                                    {{item.name}}
                                                </li>
                                            </VuePerfectScrollbar>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allCategorySettingSelect" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'پیشنهادات' && item.name != 'پک' && item.name != 'خبر' && item.name != 'تبلیغ' && item.name != 'جستجو' && item.name != 'دسته بندی ها' && item.name != 'دسته بندی زیرمجموعه دار'">
                                    <label>برند :</label>
                                    <div class="allTaxes">
                                        <div class="taxShow" @click="btnShowTax(1,allIndex)">
                                            <h4 v-if="item.brand.length == 0">برند را وارد کنید</h4>
                                            <ul v-else>
                                                <li v-for="(item , index) in item.brand" :key="index">
                                                    <i @click.stop="btnClose(index,allIndex,'brand')">
                                                        <svg-icon :icon="'#cancel'"></svg-icon>
                                                    </i>
                                                    <span>{{item}}</span>
                                                </li>
                                            </ul>
                                            <svg-icon :icon="'#down'"></svg-icon>
                                        </div>
                                        <ul class="showAllTaxes" v-if="showTax == 1 && showAllTax == allIndex">
                                            <VuePerfectScrollbar class="scroll-area">
                                                <li v-for="(item , index) in brand" @click.stop="sendTax(item.name,allIndex,'brand')" :key="index">
                                                    {{item.name}}
                                                </li>
                                            </VuePerfectScrollbar>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allCategorySettingSelect" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'جستجو' && item.name != 'پک' && item.name != 'خبر' && item.name != 'تبلیغ' && item.name != 'برند های ویژه' && item.name != 'دسته بندی ها'">
                                    <label>نمایش براساس :</label>
                                    <div class="allCategoryPanel" @click="btnShowTax(3,allIndex)">
                                        <div class="categoryShow">
                                            <h4 v-if="item.show == 0">جدید ترین</h4>
                                            <h4 v-if="item.show == 1">محبوب ترین</h4>
                                            <h4 v-if="item.show == 2">پربازدید ترین</h4>
                                            <h4 v-if="item.show == 3">ارزان ترین</h4>
                                            <h4 v-if="item.show == 4">گران ترین</h4>
                                            <h4 v-if="item.show == 5">پرفروش ترین</h4>
                                            <i>
                                                <svg-icon :icon="'#down'"></svg-icon>
                                            </i>
                                        </div>
                                        <ul v-if="showTax == 3 && showAllTax == allIndex">
                                            <li @click="item.show = 0">جدید ترین</li>
                                            <li @click="item.show = 1">محبوب ترین</li>
                                            <li @click="item.show = 2">پربازدید ترین</li>
                                            <li @click="item.show = 3">ارزان ترین</li>
                                            <li @click="item.show = 4">گران ترین</li>
                                            <li @click="item.show = 5">پرفروش ترین</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allCategorySettingSelect" v-if="item.name != 'تبلیغات اسلایدری' && item.name != 'جستجو' && item.name != 'پک' && item.name != 'خبر' && item.name != 'تبلیغ' && item.name != 'برند های ویژه' && item.name != 'دسته بندی ها' && item.name != 'دسته بندی زیرمجموعه دار'">
                                    <label>نوع کالا :</label>
                                    <div class="allCategoryPanel" @click="btnShowTax(4,allIndex)">
                                        <div class="categoryShow">
                                            <h4 v-if="item.type == 3">همه</h4>
                                            <h4 v-if="item.type == 0">فقط موجود</h4>
                                            <h4 v-if="item.type == 1">تخفیف خورده</h4>
                                            <h4 v-if="item.type == 2">پیشنهادی</h4>
                                            <i>
                                                <svg-icon :icon="'#down'"></svg-icon>
                                            </i>
                                        </div>
                                        <ul v-if="showTax == 4 && showAllTax == allIndex">
                                            <li @click="item.type = 3">همه</li>
                                            <li @click="item.type = 0">فقط موجود</li>
                                            <li @click="item.type = 1">تخفیف خورده</li>
                                            <li @click="item.type = 2">پیشنهادی</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="abilityPost" v-if="item.name == 'تبلیغ'">
                                    <table class="abilityTable">
                                        <tr>
                                            <th>تصویر تبلیغ</th>
                                            <th>آدرس تبلیغ</th>
                                            <th>
                                                <i @click="addAbility(allIndex)">
                                                    <svg-icon :icon="'#add'"></svg-icon>
                                                </i>
                                            </th>
                                        </tr>
                                        <tr v-for="(value, index2) in item.category" :key="index2">
                                            <td>
                                                <input type="text" placeholder="تصویر را وارد کنید" v-model="value.image">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="آدرس را وارد کنید" v-model="value.address">
                                            </td>
                                            <td>
                                                <i @click="deleteAbility(allIndex,index2)">
                                                    <svg-icon :icon="'#trash'"></svg-icon>
                                                </i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="abilityPost" v-if="item.name == 'تبلیغات اسلایدری'">
                                    <table class="abilityTable">
                                        <tr>
                                            <th>تصویر تبلیغ سمت راست</th>
                                            <th>آدرس تبلیغ سمت راست</th>
                                            <th>
                                                <i @click="addAd2(allIndex)">
                                                    <svg-icon :icon="'#add'"></svg-icon>
                                                </i>
                                            </th>
                                        </tr>
                                        <tr v-for="(value, index2) in item.slug" :key="index2">
                                            <td>
                                                <input type="text" placeholder="تصویر را وارد کنید" v-model="value.image">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="آدرس را وارد کنید" v-model="value.address">
                                            </td>
                                            <td>
                                                <i @click="deleteAd2(allIndex,index2)">
                                                    <svg-icon :icon="'#trash'"></svg-icon>
                                                </i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="abilityPost" v-if="item.name == 'تبلیغات اسلایدری'">
                                    <table class="abilityTable">
                                        <tr>
                                            <th>تصویر تبلیغ سمت چپ</th>
                                            <th>آدرس تبلیغ سمت چپ</th>
                                            <th>
                                                <i @click="addAd(allIndex)">
                                                    <svg-icon :icon="'#add'"></svg-icon>
                                                </i>
                                            </th>
                                        </tr>
                                        <tr v-for="(value, index2) in item.view" :key="index2">
                                            <td>
                                                <input type="text" placeholder="تصویر را وارد کنید" v-model="value.image">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="آدرس را وارد کنید" v-model="value.address">
                                            </td>
                                            <td>
                                                <i @click="deleteAd(allIndex,index2)">
                                                    <svg-icon :icon="'#trash'"></svg-icon>
                                                </i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
            <button @click="btnCreate">ارسال اطلاعات</button>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '../../../Layouts/Admin/AdminLayout.vue';
import draggable from 'vuedraggable';
import SvgIcon from '../../Svg/SvgIcon.vue';
import VuePerfectScrollbar from "vue-perfect-scrollbar";
export default {
    name:'TemplateSetting',
    props:['vidget','category','brand'],
    components: {
        AdminLayout,
        draggable,
        SvgIcon,
        VuePerfectScrollbar,
    },
    metaInfo: {
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
        title: 'تنظیمات قالب سایت'
    },
    data() {
        return {
            allVidget:[
                {
                    name:'پیشنهادات',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'خبر',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'پک',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'دسته بندی زیرمجموعه دار',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'دسته بندی ها',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'دسته بندی با پست',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'برند های ویژه',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'شگفت انگیزان',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'جستجو',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'تبلیغ',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'تبلیغات اسلایدری',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: [],
                    slug: [],
                },
            ],
            form:{
                update: false,
                allSiteTemplate: [],
            },
            showTax: 0,
            showAllTax: 0,
            i:0
        }
    },
    methods:{
        deleteAbility(allIndex,index){
            this.form.allSiteTemplate[allIndex].category.splice(index,1);
        },
        addAbility(allIndex) {
            this.form.allSiteTemplate[allIndex].category.push({
                image:'',
                address:'',
            });
        },
        deleteAd(allIndex,index){
            this.form.allSiteTemplate[allIndex].view.splice(index,1);
        },
        addAd(allIndex) {
            this.form.allSiteTemplate[allIndex].view.push({
                image:'',
                address:'',
            });
        },
        deleteAd2(allIndex,index){
            this.form.allSiteTemplate[allIndex].slug.splice(index,1);
        },
        addAd2(allIndex) {
            this.form.allSiteTemplate[allIndex].slug.push({
                image:'',
                address:'',
            });
        },
        btnShowTax(num,index){
            if (this.showTax == num){
                this.showTax = 0
            }else{
                this.showTax = num;
            }
            this.showAllTax = index;
        },
        btnSend(){
            this.allVidget=[
                {
                    name:'پیشنهادات',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'خبر',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'پک',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                },
                {
                    name:'دسته بندی زیرمجموعه دار',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'دسته بندی ها',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'دسته بندی با پست',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'برند های ویژه',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'شگفت انگیزان',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'جستجو',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'تبلیغ',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: 0,
                    slug: '',
                    background: '',
                    more: '',
                },
                {
                    name:'تبلیغات اسلایدری',
                    brand:[],
                    category:[],
                    type:3,
                    show:0,
                    title:'',
                    more: '',
                    count: '',
                    new: 0,
                    popular: 0,
                    view: [],
                    slug: [],
                },
            ];
        },
        btnClose(index,allIndex,type){
            if(type == 'brand'){
                this.form.allSiteTemplate[allIndex].brand.splice(index,1);
            }
            if(type == 'category'){
                this.form.allSiteTemplate[allIndex].category.splice(index,1);
            }
        },
        sendTax(name,allIndex,type){
            if(type == 'brand'){
                this.form.allSiteTemplate[allIndex].brand.push(name);
            }
            if(type == 'category'){
                this.form.allSiteTemplate[allIndex].category.push(name);
            }
        },
        btnCreate(){
            this.i = 0;
            for ( this.i ; this.i < this.form.allSiteTemplate.length; this.i++) {
                if(this.form.allSiteTemplate[this.i].name == 'تبلیغ'){
                    this.form.allSiteTemplate[this.i].brand = JSON.stringify(this.form.allSiteTemplate[this.i].category);
                }
                if(this.form.allSiteTemplate[this.i].name == 'تبلیغات اسلایدری'){
                    this.form.allSiteTemplate[this.i].category = JSON.stringify(this.form.allSiteTemplate[this.i].view);
                    this.form.allSiteTemplate[this.i].brand = JSON.stringify(this.form.allSiteTemplate[this.i].slug);
                }
            }
            this.form.update = true;
            const url = "/admin/setting-template";
            this.$inertia.post(url , this.form)
            this.$swal.fire(
                'با موفقیت انجام شد',
                'تنظیمات با موفقیت انجام شد',
                'success'
            );
        },
        getData(){
            this.form.allSiteTemplate = this.vidget;
            this.i = 0;
            for ( this.i ; this.i < this.form.allSiteTemplate.length; this.i++) {
                if(this.form.allSiteTemplate[this.i].name == 'تبلیغ'){
                    if(this.form.allSiteTemplate[this.i].brand != ''){
                        this.form.allSiteTemplate[this.i].category = JSON.parse(this.form.allSiteTemplate[this.i].brand);
                    }
                }
                if(this.form.allSiteTemplate[this.i].name == 'تبلیغات اسلایدری'){
                    if(this.form.allSiteTemplate[this.i].brand != ''){
                        this.form.allSiteTemplate[this.i].slug = JSON.parse(this.form.allSiteTemplate[this.i].brand);
                    }
                    if(this.form.allSiteTemplate[this.i].category != ''){
                        this.form.allSiteTemplate[this.i].view = JSON.parse(this.form.allSiteTemplate[this.i].category);
                    }
                }
            }
        },
        sidebar(){
            this.$eventHub.emit('sidebar' , ['3','22']);
        },
    },
    mounted(){
        this.getData();
        this.sidebar();
    },
}
</script>

<style>

</style>
