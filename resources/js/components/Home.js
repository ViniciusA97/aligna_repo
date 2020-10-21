import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Header from './structs/header';
import Footer from './structs/footer';
import NavSideBar from './structs/navSideBar';

import Login from './Login';

import PopList from './PopList';

function Home(){

    const urlValidate = laroute.route('validate');    
    const token = localStorage.getItem('@aligna/token');
    
    function validateToken(){
        Axios.post(urlValidate,{headers:{'Authorization': `Bearer ${token}`}}
        ).then((response)=>{
            console.log(response);
            if(response.status===200){
                //renderBlocs();
            }
        })
    }

    function renderBlocs(){
        //ReactDOM.render(<Header />, document.getElementById('header'));
        //ReactDOM.render(<Footer />, document.getElementById('footer'));
        //ReactDOM.render(<NavSideBar />, document.getElementById('navSideBar'));
    }

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

