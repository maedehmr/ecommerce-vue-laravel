<template>
    <div class="allHeaderIndexRegisterItemsContainers">
        <div class="allHeaderIndexRegisterItemsContainer" v-if="level == 0">
            <div class="allHeaderIndexRegisterItem">
                <label for="emails" class="allHeaderIndexInput">
                    <span :class="call">ایمیل</span>
                    <input @keyup="call = 'start'" type="email" id="emails" v-model="email"/>
                </label>
            </div>
            <div class="alert" v-if="errors['email']">
                {{errors['email'][0]}}
            </div>
            <div class="allHeaderIndexRegisterItemsContainerButton">
                <div>
                    <button @click="btnSendCode(1)" :style="styleLoader">
                        <span>ارسال کد</span>
                    </button>
                </div>
            </div>
            <p class="allHeaderIndexRegisterItemsContainerSecurity">
                با ورود و یا ثبت نام شما شرایط و قوانین استفاده از سرویس های سایت ما و قوانین حریم خصوصی آن را می‌پذیرید.
            </p>
        </div>
        <div class="allHeaderIndexRegisterLoader" v-if="level == 4">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
</template>

<script>
import SvgIcon from "../../../Svg/SvgIcon";

export default {
    name: "StartEmail",
    data(){
        return{
            errors:[],
            show: 0,
            level: 0,
            email: '',
            call: '',
            styleLoader : {
                transition: 'all .3s ease-in-out',
                width: '10rem'
            },
        }
    },
    methods:{
        btnSendCode(show){
            this.level = 4;
            const url  = '/check-email';
            axios.post(url,{
                email : this.email,
                show : show
            })
                .then(response=>{
                    this.show=show;
                    this.level = response.data;
                    this.$emit('sendData' , [this.show,this.level,this.email]);
                })
        },
    }
}
</script>

<style scoped>

</style>
