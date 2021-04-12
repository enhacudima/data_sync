
import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);


const messages = {
    'en': {
        login:'Login',
        search:'Search',
        welcome:'Welcome',
        about_us:'About Us',
        contact:'Contact',
        terms_and_conditions:'Terms and Condictions',
        cusine:'Cuisine',
        common_timing:'Common timing',
        type:'Type',
        allergies:'Allergies',
        language:"Language",
        forgot_password:"Forgot password",
        use_link_reset:"Use this link to reset you password",
        register_now:"Register now!",
        register:"Register",
        password:"Password",
        password_confirm:"Confirm Password",
        at_least_8_characters:"At least 8 characters",
        //registrer
        f_name:"First Name",
        l_name:"Last Name",
        prefix_:"Prefix",
        phone_number:"Phone Number",
        b_date:"Birthday date",
        i_have_read_and_agree:"I have read and agree to the",
        terms_service:"Terms of Service",
        open_terms_and_conditions:"Open Terms and condition",
        register:"Register",

        send_link: "Send Link",
        reset: "Reset",
    },
    'pt_BR': {
        login:'Iniciar sessão',
        search: 'Pesquisa',
        welcome: 'Bem Vindo',
        about_us:'Acerca de nós',
        contact:'Contactos',
        terms_and_conditions:'Termos e condições',
        cusine:'Culinária',
        common_timing:'Servido em',
        type:'Tipo',
        allergies:'Alergias',
        language:"Idioma",
        forgot_password:"Esqueceu sua senha",
        use_link_reset:"Use este link para redefinir sua senha",
        register_now:"Criar conta!",
        register:"Registrar",
        password:"Senha",
        password_confirm:"Confirmar senha",
        at_least_8_characters:"Pelo menos 8 caracteres",
         //registrer
        f_name:"Primeiro nome",
        l_name:"Último nome",
        prefix_:"Prefixo",
        phone_number:"Número de telefone",
        b_date:"Data de nascimento",
        i_have_read_and_agree:"Eu li e concordo com o",
        terms_service:"Termos de serviço",
        open_terms_and_conditions:"Termos e condições abertos",
        register:"Criar conta",

        send_link: "Enviar Link",
        reset: "Redifinir",
    }
};

const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'pt_BR', // set fallback locale
    messages, // set locale messages
});

export {i18n};
