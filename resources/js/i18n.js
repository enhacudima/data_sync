
import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);


const messages = {
    'en': {
        login:'Login',
        search:'Search',
        about_us:'About Us',
        contact:'Contact Us',
        terms_and_conditions:'Terms and Condictions',
        type:'Type',
        language:"Language",
        forgot_password:"Forgot password?",
        use_link_reset:"Use this link to reset your password",
        register_now:"Register Account",
        password:"Password",
        password_confirm:"Confirm Password",
        at_least_8_characters:"At least 8 characters",
        //registrer
        f_name:"Entity Name",
        l_name:"Alias",
        prefix_:"Prefix", // Alterar para Country
        phone_number:"Phone Number",
        b_date:"Foundation date",
        i_have_read_and_agree:"I have read and agree to the",
        terms_service:"Terms of Service",
        open_terms_and_conditions:"Open Terms and Conditions",
        register:"Register",
        o_password:"Old Password",
        full_address:"Address",
        update_avatar:"Update Profile Picture",
        dark_moee:"Dark Mode",
        logout_all_devi:"Logout from All Devices",

        send_link: "Resend Link",
        reset: "Reset",
        views: "Views",
        my_plan:"My Plan",
        no_data: "Oops, no data found",
        cancel_login:"Cancel",
        created_at:"Created at",
        updated_at: "Updated at",
        actions: "Actions",
        //nav bar
        painel:'Panel',
        publicacao:'Post',
        publicacoes:"Posts",
        nova_publicacao:"New Post",
        definicoes: 'Admin Settings',
        //pub card
        inicio_pub :'Issue Date', //deve ser simplificado
        fim_pub :'Closing Date', //deve ser simplificado
        //contact form
        title_conta : "Send us a message",
        sub_title_conta : "Our team will respond shortly",
        result_title_conta :"Message sent successfully",
        message : "Message",
        contact_form : "Contact Form",
        team : "Team",
        thank_you : "Thank you | Obrigado | Khanimambo | Asante",
        //geral
        submit : "Submit",
        clear : "Clear",
        name:"Name",
        ok:"Ok",
        contents:"Contents",
        email: "E-mail",
        save:"Save",
        website :"Website",
        close: "Close",
        pdf_file:"PDF File",
        date:"Date",
        update:"Update",
        title:"Title",
        no:"No",
        yes:"Yes",
        yes_rigth_now:"Yes Rigth now",
        cancel:"Cancel",
        //new pub
        upload_pdf:"Upload PDF",
        location:"Location",
        details:"Details",
        category:"Category",
        select:"Select",
        options:"Options",
        tags:"Tags",
        reference:"Reference",
        //subscription
        plan:'Plan',
        subscriptions: "Subscriptions",
        subscription: "Subscription",
        starts_at: "Starts at",
        ends_at: "Ends at",
        trial_ends_at: "Trial ends at",
        canceled_at: "Canceled at",
        new_invoice: "New Invoice",
        invoices: "Invoices",
        confirm_cancelation:"Are you sure you want to cancel this subscription?",

        //graf
        post_reation:"Post Creation",
        last_post_performance:"Posts Performance",
        last_registration:"Last Registration",
        post_read:"Read Posts",
        last_post_read_performance:"Read Posts Performance",
        last_read:"Last Read",

    },
    'pt': {
        login:'Iniciar sess??o',
        search: 'Pesquisar',
        welcome: 'Bem Vindo',
        about_us:'Sobre n??s',
        contact:'Contacte-nos',
        terms_and_conditions:'Termos e condi????es',
        language:"Idioma",
        forgot_password:"Esqueceu senha?",
        use_link_reset:"Use este link para redefinir sua senha",
        register_now:"Criar Conta",
        register:"Registar",
        password:"Senha",
        password_confirm:"Confirmar senha",
        at_least_8_characters:"Pelo menos 8 car??teres",
         //registrer
        f_name:"Nome da Entidade",
        l_name:"Pseud??nimo",
        prefix_:"Prefixo",
        phone_number:"N??mero de telefone",
        b_date:"Data de cria????o",
        i_have_read_and_agree:"Li e concordo com os",
        terms_service:"Termos de Servi??o",
        open_terms_and_conditions:"Abrir Termos e Condi????es",
        register:"Criar conta",
        save:"Salvar",
        o_password:"Password Actual",
        full_address:"Endere??o",
        update_avatar:"Foto de perfil",
        dark_moee:"Modo Escuro",
        logout_all_devi:"Sair em todos os dispositivos",

        send_link: "Enviar Link",
        reset: "Redifinir",
        views: "Visualiza????es",
        my_plan: "Meu Plano",
        no_data: "Ooops, sem dados para exibir",
        cancel_login:"Cancelar",
        actions: "Ac????es",
        //nav bar
        painel:'Painel',
        publicacao:'Publica????o',
        publicacoes:"Publica????es",
        nova_publicacao:"Nova Publica????o",
        definicoes: 'Defini????es',
        //pub card
        inicio_pub :'Publica????o', //deve ser simplificado
        fim_pub :'Fim de Submiss??es', //deve ser simplificado`

        //contact form
        title_conta : "Envie-nos uma mensagem",
        sub_title_conta : "Nossa equipa ir?? responder logo que poss??vel",
        result_title_conta :"Mensagem enviada com sucesso",
        message : "Mensagem",
        contact_form : "Formul??rio de Contacto",
        team : "Equipa",
        thank_you : "Thank you | Obrigado | Khanimambo | Asante",
        //geral
        created_at:"Criado ??",
        updated_at: "Actualizado ??",
        submit : "Submeter",
        clear : "Limpar",
        name:"Nome",
        ok:"Ok",
        contents:"Contents",
        email: "E-mail",
        save:"Salvar",
        website :"Website",
        close: "Fechar",
        pdf_file:"Ficheiro PDF",
        date:"Data",
        update:"Actualizar",
        title:"T??tulo",
        no:"N??o",
        yes:"Sim",
        yes_rigth_now:"Sim, agora",
        cancel:"Cancelar",
        //new pub
        upload_pdf:"Carregar PDF",
        location:"Local",
        details:"Detalhes",
        category:"Categoria",
        select:"Seleccionar",
        options:"Op????es",
        tags:"Tags",
        reference:"Refer??ncia",
        //subscription
        plan:'Plano',
        subscriptions: "Subscri????es",
        subscription: "Subscri????o",
        starts_at: "Inicia ??",
        ends_at: "Termina ??",
        trial_ends_at: "Trial ends at",
        canceled_at: "Cancelado ??",
        new_invoice: "Nova factura",
        invoices: "Facturas",
        confirm_cancelation:"Tem certeza que pretende cancelar esta subscri????o?",

        //graf
        post_reation:"Cria????o de Publica????o",
        last_post_performance:"Performance de publica????es",
        last_registration:"??ltimo registo",
        post_read:"Publica????es lidas",
        last_post_read_performance:"Perfomance das visualiza????es",
        last_read:"??ltima visualiza????o",
    }
};

const i18n = new VueI18n({
    locale: 'pt', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
});

export {i18n};
