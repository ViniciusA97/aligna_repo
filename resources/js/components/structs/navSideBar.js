import React from 'react';

export default function NavSideBar() {
    const urlPop = laroute.route('pop.index');
    return (
        <>
            <div className="site-menubar">
                <div className="site-menubar-body">
                    <div>
                        <ul className="site-menu" data-plugin="menu">
                            <li className="site-menu-category">MENU</li>
                            <li className="site-menu-item">
                                <a href={urlPop}>
                                    <i className="site-menu-icon wb-file" aria-hidden="true"></i>
                                    <span className="site-menu-title">POPs</span>
                                    <span className="site-menu-arrow"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </>
    );
}
