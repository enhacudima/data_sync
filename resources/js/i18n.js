
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
        l_name:"Alias",
        prefix_:"Prefix",
        phone_number:"Phone Number",
        b_date:"Foundation date",
        i_have_read_and_agree:"I have read and agree to the",
        terms_service:"Terms of Service",
        open_terms_and_conditions:"Open Terms and condition",
        register:"Register",
        save:"Save",
        o_password:"Old Password",
        full_address:"Full Address",
        update_avatar:"Update Picture",
        dark_moee:"Dark Mode",
        logout_all_devi:"Logout All Devices",

        send_link: "Send Link",
        reset: "Reset",
        views: "Views",
        my_plan:"My Plan",
    },
    'pt_BR': {
        login:'Iniciar sessão',
        search: 'Pesquisa',
        welcome: 'Bem Vindo',
        about_us:'Sobre nós',
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
        f_name:"Nome da Empresa",
        l_name:"Pseudônimo",
        prefix_:"Prefixo",
        phone_number:"Número de telefone",
        b_date:"Data de criação",
        i_have_read_and_agree:"Eu li e concordo com o",
        terms_service:"Termos de serviço",
        open_terms_and_conditions:"Termos e condições abertos",
        register:"Criar conta",
        save:"Salvar",
        o_password:"Password Atual",
        full_address:"Endereço completo",
        update_avatar:"Foto do perfil",
        dark_moee:"Modo Escuro",
        logout_all_devi:"Sair em todos os dispositivos",

        send_link: "Enviar Link",
        reset: "Redifinir",
        views: "Visualizações",
        my_plan: "Meu Plano",
    }
};

const i18n = new VueI18n({
    locale: 'pt_BR', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
});

export {i18n};
