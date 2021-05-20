
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
        login:'Iniciar sessão',
        search: 'Pesquisar',
        welcome: 'Bem Vindo',
        about_us:'Sobre nós',
        contact:'Contacte-nos',
        terms_and_conditions:'Termos e condições',
        language:"Idioma",
        forgot_password:"Esqueceu senha?",
        use_link_reset:"Use este link para redefinir sua senha",
        register_now:"Criar Conta",
        register:"Registar",
        password:"Senha",
        password_confirm:"Confirmar senha",
        at_least_8_characters:"Pelo menos 8 caráteres",
         //registrer
        f_name:"Nome da Entidade",
        l_name:"Pseudônimo",
        prefix_:"Prefixo",
        phone_number:"Número de telefone",
        b_date:"Data de criação",
        i_have_read_and_agree:"Li e concordo com os",
        terms_service:"Termos de Serviço",
        open_terms_and_conditions:"Abrir Termos e Condições",
        register:"Criar conta",
        save:"Salvar",
        o_password:"Password Actual",
        full_address:"Endereço",
        update_avatar:"Foto de perfil",
        dark_moee:"Modo Escuro",
        logout_all_devi:"Sair em todos os dispositivos",

        send_link: "Enviar Link",
        reset: "Redifinir",
        views: "Visualizações",
        my_plan: "Meu Plano",
        no_data: "Ooops, sem dados para exibir",
        cancel_login:"Cancelar",
        actions: "Acções",
        //nav bar
        painel:'Painel',
        publicacao:'Publicação',
        publicacoes:"Publicações",
        nova_publicacao:"Nova Publicação",
        definicoes: 'Definições',
        //pub card
        inicio_pub :'Publicação', //deve ser simplificado
        fim_pub :'Fim de Submissões', //deve ser simplificado`

        //contact form
        title_conta : "Envie-nos uma mensagem",
        sub_title_conta : "Nossa equipa irá responder logo que possível",
        result_title_conta :"Mensagem enviada com sucesso",
        message : "Mensagem",
        contact_form : "Formulário de Contacto",
        team : "Equipa",
        thank_you : "Thank you | Obrigado | Khanimambo | Asante",
        //geral
        created_at:"Criado à",
        updated_at: "Actualizado à",
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
        title:"Título",
        no:"Não",
        yes:"Sim",
        yes_rigth_now:"Sim, agora",
        cancel:"Cancelar",
        //new pub
        upload_pdf:"Carregar PDF",
        location:"Local",
        details:"Detalhes",
        category:"Categoria",
        select:"Seleccionar",
        options:"Opções",
        tags:"Tags",
        reference:"Referência",
        //subscription
        plan:'Plano',
        subscriptions: "Subscrições",
        subscription: "Subscrição",
        starts_at: "Inicia à",
        ends_at: "Termina à",
        trial_ends_at: "Trial ends at",
        canceled_at: "Cancelado à",
        new_invoice: "Nova factura",
        invoices: "Facturas",
        confirm_cancelation:"Tem certeza que pretende cancelar esta subscrição?",

        //graf
        post_reation:"Criação de Publicação",
        last_post_performance:"Performance de publicações",
        last_registration:"Último registo",
        post_read:"Publicações lidas",
        last_post_read_performance:"Perfomance das visualizações",
        last_read:"Última visualização",
    }
};

const i18n = new VueI18n({
    locale: 'pt', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
});

export {i18n};
