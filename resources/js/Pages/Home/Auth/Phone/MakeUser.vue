<template>
    <div class="allHeaderIndexRegisterItemsContainers">
        <div class="allHeaderIndexRegisterItemsContainer" v-if="level == 5">
            <div class="allHeaderIndexRegisterItem">
                <label for="nameUser" class="allHeaderIndexInput">
                    <span :class="callName">نام کاربری</span>
                    <input v-model="name" @keydown="callName = 'start'" id="nameUser" type="text"/>
                </label>
            </div>
            <div class="allHeaderIndexRegisterItem">
                <label for="passwordUser" class="allHeaderIndexInput">
                    <span :class="callPassword">رمز عبور</span>
                    <input v-model="password" @keydown="callPassword = 'start'" id="passwordUser" type="password"/>
                </label>
            </div>
            <div class="allHeaderIndexRegisterItemsContainerButton">
                <div>
                    <button @click="btnMakeUser" :style="styleLoader"><span>تایید</span></button>
                </div>
            </div>
        </div>
        <div class="allHeaderIndexRegisterLoader" v-if="level == 4">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MakeUser",
    props:['number','shows','levels'],
    data(){
        return{
            styleLoader : {
                transition: 'all .3s ease-in-out',
                width: '10rem'
            },
            level: this.levels,
            show: this.shows,
            name: '',
            callPassword: '',
            callName: '',
            password: '',
            errors:[],
            notificationSystem: {
                options: {
                    show: {
                        icon: "icon-person",
                        position: "topCenter",
                    },
                    success: {
                        position: "bottomLeft"
                    },
                    error: {
                        theme: "#FCA001",
                        progressBarColor: "#DC0808",
                        position: "bottomRight"
                    },
                }
            },
        }
    },
    methods:{
        btnMakeUser(){
            this.level = 4;
            const url  = '/make-user';
            axios.post(url,{
                phone : this.number,
                password : this.password,
                name : this.name,
            })
                .then(response=>{
                    if(response.data[0] == 'success'){
                        this.$toast.success('انجام شد', 'عضویت با موفقیت انجام شد', this.notificationSystem.options.success);
                        this.$emit('sendEnd' , response.data[1]);
                    }else{
                        this.level = 5;
                        this.$toast.error('انجام نشد', 'رمز اشتباه است', this.notificationSystem.options.error);
                    }
                })
                .catch((error)=>{
                    this.level = 5;
                    this.errors = error.response.data.errors;
                    if (this.errors['name']){
                        this.$toast.error('انجام نشد', this.errors['name'][0], this.notificationSystem.options.error);
                    }else{
                        this.$toast.error('انجام نشد', this.errors['password'][0], this.notificationSystem.options.error);
                    }
                });
        },
    },
}
</script>

<style scoped>

</style>
