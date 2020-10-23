import styled from 'styled-components';


export const Logo = styled.div`
    background-image: url('assets/images/img-login.png');
    width: 100%;
    height: 100vh;
    background-size: 100% 100%;
    background-position: cover;
    background-repeat: no-repeat;

    .centralizar{
        margin: 25vh 5rem;
    }

    .logo-marca{
        color: rgba(255, 255, 255, 0.7);
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 28px;
        margin: 2rem .5rem;
    }
`;

export const Title = styled.h2`
    color: #3A525A;
    font-size: 24px;
    font-weight: normal;
    span{
        font-weight: bold;
    }
`;

export const Form = styled.form`
    margin: 15vh 0 0;
    padding: 0 5%;
    font-family: Roboto;

    .pd-5{
        padding: 5%;
    }
`;


export const Input = styled.input`
    border: none;
    border-bottom: 1px solid #e5e5e5;
    margin: .5rem 0;
    padding: 1rem;
    font-family: Roboto;
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 16px;

    color: #99A8B0;
`;

export const Submit = styled.input`
    border: none;
    margin: .5rem 0;
    padding: 1rem;
    color: #FFFFFF;
    font-family: Roboto;
    background: #11998E;
    
    &:hover {
        background-color: #5DE3D8;
    }
`;

