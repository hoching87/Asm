import React, { useEffect } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';

import { Menu, message, Layout } from 'antd';
import {
    HomeOutlined, SettingOutlined, UserOutlined, TagsOutlined, ShoppingCartOutlined,
    PayCircleOutlined, LogoutOutlined, LoginOutlined
} from '@ant-design/icons';
const { SubMenu, Item } = Menu;

function Header(props) {
    useEffect(() => {
        if (!(props.url == 'http://127.0.0.1:8000/login' || props.url == 'http://127.0.0.1:8000/register') && !props.user) {
            window.location.replace("http://127.0.0.1:8000/login");
        }
    }, [])

    const logout = async () => {
        try {
            const res = await axios.post('http://127.0.0.1:8000/auth/logout', null, {
                headers: {
                    'Authorization': `Bearer ${props.jwt}`
                }
            })

            if (res.status == 200) {
                message.warning('Log Out Seccessful!');
                window.location.replace("http://127.0.0.1:8000/login");
            }
        }
        catch (err) {
            message.error('Logout Failed!')
        }
    }

    return (
        <Layout className="layout">
            <Layout.Header>
                <div className="logo" style={{ float: 'left' }}>
                    <img height={35} src={`http://localhost:8000/uploads/images/logo.png`} style={{ marginTop: 14 }}></img>
                </div>
                {
                    props.user &&
                    <Menu mode="horizontal" theme='dark'>
                        <Menu.Item key="Home" icon={<HomeOutlined />} onClick={() => window.location.href = 'http://127.0.0.1:8000/home'}>
                            Home
                        </Menu.Item>

                        <Menu.Item key="Shop" icon={<TagsOutlined />} onClick={() => window.location.href = 'http://127.0.0.1:8000/products'}>
                            Shop
                        </Menu.Item>
                        
                        
                            <Menu.Item key="Cart" icon={<ShoppingCartOutlined />} onClick={() => window.location.href = 'http://127.0.0.1:8000/cart'}>
                            Cart
                        </Menu.Item>
                      

                        {
                            props.user ?
                                <SubMenu key="SubMenu" title={props.user} icon={<UserOutlined />}>
                                    <Menu.Item key="Order" icon={<PayCircleOutlined />}
                                        onClick={() => window.location.href = 'http://127.0.0.1:8000/orders'}>Order</Menu.Item>

                                    <Menu.Item key="personalinfo" icon={<SettingOutlined />}
                                        onClick={() => window.location.href = 'http://127.0.0.1:8000/userinfo'}>Personal Info</Menu.Item>
                                    <Menu.Item key="logout" icon={<LogoutOutlined />} onClick={logout}>logout</Menu.Item>
                                </SubMenu>
                                :
                                <Menu.Item key="login" icon={<LoginOutlined />}>
                                    Log In
                                </Menu.Item>
                        }

                    </Menu>
                }
            </Layout.Header>
        </Layout >

    );
}

export default Header;

let root = document.getElementById('header')
if (root) {
    ReactDOM.render(<Header {...(root.dataset)} />, root);
}
