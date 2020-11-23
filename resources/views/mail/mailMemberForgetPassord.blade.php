<style>
    *{
        margin: 0;
        padding: 0;
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
    }
    .container-email{
        position: relative;
        width: 100%; 
        height: 100vh; 
        background-color: #E5E5E5;
    }
    .box{
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        width: 50%;
        margin: auto;
        background: #FFFFFF;
        border-radius: 3px;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .logo{
        margin-bottom: 3rem;
    }
    .bem-vindo{
        font-size: 36px;
        color: #3A525A;
    }
    .instrucao{
        font-size: 18px;
        text-align: center;
        color: #A5B1B8;
        margin-top: 1.5rem;
    }
    .btn-link{
        font-size: 16px;
        color: #fff;
        padding: .8rem 1.5rem;
        background: #11998E;
        border-radius: 3px;
        text-decoration: none;
        margin-top: 3rem;
    }
    .btn-link:hover{ background-color: #24c7b9; }
    .copy{
        position: absolute;
        width: 100%;
        text-align: center;
        bottom: 3rem;
    }
    .copy p{
        font-size: 12px;
        color:  #AFBBC1;
    }
    @media(max-width: 1030px){
        .bem-vindo{ font-size: 28px;}
        .instrucao{ font-size: 16px;}
        .logo{margin-bottom: 2rem;}
    }
    @media(max-width: 860px){
        .bem-vindo{ font-size: 24px;}
        .instrucao{ font-size: 14px;}
        .logo{margin-bottom: 1.5rem;}
    }
    @media(max-width: 576px){
        .box{width: 70%;}
    }
</style>
<div class="container-email">
    <div class="box">
        <img src="../../../public/assets/images/logo_aligna.png" alt="..." class="logo">
        <p class="instrucao"> Para cadastrar sua nova senha no Aligna, por favor clique no link. </p>
        <a href={{$link}} class="btn-link"> Resetar senha </a>
    </div>
    <div class="copy">
        <p> 2020. TODOS OS DIREITOS RESERVADOS</p>
    </div>
</div>