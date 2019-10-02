<template>
    <form class="form-signin">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Iceberg Estate CRM Login</h1>
        </div>

        <div class="form-label-group">
            <input type="email" autocomplete="off" id="email" v-model="email" class="form-control"
                   placeholder="e-posta" required autofocus>
            <label for="email">Email address</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password" autocomplete="off" v-model="password" class="form-control"
                   placeholder="şifre" required>
            <label for="password">Password</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="button" @click="login">Giriş Yap</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2019</p>
    </form>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            login() {
                let email = this.email;
                let password = this.password;
                this.$store.dispatch('login', {email, password})
                    .then(() => this.$router.push('/'))
                    .catch(err => console.log(err))
            }
        }
    }
</script>

<style scoped>
    :root {
        --input-padding-x: .75rem;
        --input-padding-y: .75rem;
    }

    .form-signin {
        width: 100%;
        max-width: 420px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-label-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-label-group > input,
    .form-label-group > label {
        padding: var(--input-padding-y) var(--input-padding-x);
    }

    .form-label-group > input {
        text-indent: 4px;
        height: 50px;
        font-size: 13px;
    }

    .form-label-group > label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0; /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
        padding: 3px;
        font-size: 12px;
    }

    .form-label-group input::-webkit-input-placeholder {
        color: transparent;
    }

    .form-label-group input:-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-moz-placeholder {
        color: transparent;
    }

    .form-label-group input::placeholder {
        color: transparent;
    }

    .form-label-group input:not(:placeholder-shown) {
        padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
        padding-bottom: calc(var(--input-padding-y) / 3);
    }

    .form-label-group input:not(:placeholder-shown) ~ label {
        padding-top: calc(var(--input-padding-y) / 3);
        padding-bottom: calc(var(--input-padding-y) / 3);
        font-size: 12px;
        color: #777;
    }

</style>