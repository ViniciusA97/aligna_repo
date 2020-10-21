import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Modal from 'react-modal';


import Header from './structs/header';
import Footer from './structs/footer';
import NavSideBar from './structs/navSideBar';

Modal.setAppElement('#app-body')
const modalStyles = {
    overlay: {
        zIndex: 9995,
        backgroundColor: 'rgba(0, 0, 0, 0.5)'
    },
    content : {
      border: 0,
      backgroundColor: 'transparent'
    }
};

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
        <>
            <form onSubmit={handleLogin} onReset={handleLogin} on>
                <label>
                    Email:
                    <input type="text" value={email} onChange={(e)=>{setEmail(e.target.value)}} />
                </label>
                <label>
                    Senha:
                    <input type="text" value={password} onChange={(e)=>{setPassword(e.target.value)}} />
                </label>
                <input type="reset" value="Enviar" />
            </form>
        </>
    );
}

export default Login;

if (document.getElementById('app')) {
    ReactDOM.render(<Login />, document.getElementById('app'));
}
