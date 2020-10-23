import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';
import { Link } from 'react-router-dom'

import { Title, Form, Input, Submit, Logo } from './styles'

import Modal from 'react-modal';

Modal.setAppElement('#app-body')

 function Login(){
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    
    const url = laroute.route('login');
    
    console.log(url);

    function validateToken(){
        console.log(urlValidate);
        const urlValidate = laroute.route('validate');
        const token = JSON.parse(localStorage.getItem('@aligna/token'));
        console.log(token);
        Axios.post(urlValidate,{},{headers:{Authorization: `Bearer ${token}`}}
        ).then((response)=>{
            console.log(response);
            if(response.status===200){
                window.location.href = "/pops"
            }
        })
    }
    
     useEffect(() => {
        (async function anyNameFunction() {
            await validateToken();
          })();
    })
    
    function handleLogin(){
        console.log(url);
        var body=JSON.stringify({
            "email":email,
            "password":password
        });
        console.log(body);
        console.log(url);
        Axios.post(url, body, {headers:{'Content-Type': 'application/json'}}
        ).then((response)=>{
            console.log(response);
            if(response.status===200){
                localStorage.setItem('@aligna/token',JSON.stringify(response.data.token));
                localStorage.setItem('@aligna/user',JSON.stringify(response.data.user));
                window.location.href = "/pops"
            }
        })
    };
    

    return(
        <div className="row m-0">
            <Logo className="col-md-8">
                <div className="centralizar">
                     <img src="/assets/images/logo.png" alt="..."/>
                     <p className="logo-marca"> A melhor forma de organizar <br/> e gerir procedimentos. </p>
                </div>
            </Logo>
            <div className="col-md-4">
                <Form className="row flex-column" 
                      onSubmit={handleLogin} 
                      onReset={handleLogin} on>
                    
                    <Title>
                         Iniciar sessão em <span> Salema </span>
                    </Title>

                    <p>
                        Insira seus dados de acesso para continuar:
                    </p>

                    <Input type="text" 
                           value={email} 
                           onChange={(e)=>{setEmail(e.target.value)}}  
                           placeholder="Email:" 
                           className="formStyle"/>
                    
                    <Input type="password" 
                           value={password} 
                           onChange={(e)=>{setPassword(e.target.value)}} 
                           placeholder="Senha:"
                           className="formStyle" />

                    <div className="row flex-row justify-content-between pd-5">
                        <div class="form-check">
                            <input type="checkbox" className="form-check-input" id="exampleCheck1" />
                            <label class="form-check-label" for="exampleCheck1">Manter-me conectado</label>
                        </div>
                       
                       <a>
                            Esqueceu a senha? 
                       </a>
                    </div>
                    <Submit type="reset" value="Enviar" />
                </Form>
            </div>
        </div>
    );
}

export default Login;

if (document.getElementById('app')) {
    ReactDOM.render(<Login />, document.getElementById('app'));
}
