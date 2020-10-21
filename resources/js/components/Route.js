import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import {Switch, Route, BrowserRouter, Redirect} from 'react-router-dom';

import Login from './Login';
import PopList from './PopList';

class RouteHome extends React.Component{

    constructor(props){
        super(props);
        this.state={
            Comp:undefined,
            isValid: false,
        }
    }

    async componentDidMount(){
        console.log('Init DidMount');
        const urlValidate = laroute.route('validate');    
        const token = JSON.parse(localStorage.getItem('@aligna/token'));
        console.log(urlValidate);
        console.log(token);
        const x  = await Axios.post(urlValidate,{},{headers:{'Authorization': `Bearer ${token}`}}
        ).then((response)=>{
            console.log(response);
            if(response.status===200){
                return PopList;
            }
        });
        console.log(x);
    }

    render(){
        const { Comp, isValid } = this.state;
        console.log(Comp);
        return (
            <>
                <Comp/>
            </>
        );
    }

    //Se estiver com token -> popList
    //Se nao -> Login
}

export default RouteHome;
if (document.getElementById('app')) {
    ReactDOM.render(<RouteHome />, document.getElementById('app'));
}
