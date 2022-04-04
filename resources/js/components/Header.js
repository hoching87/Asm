import React, { useEffect } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';

import { Menu, message, Layout } from 'antd';
import {
    HomeOutlined, SettingOutlined, UserOutlined, TagsOutlined, ShoppingCartOutlined,
    PayCircleOutlined, LogoutOutlined, LoginOutlined, DollarCircleOutlined, EditOutlined, PlusCircleOutlined
} from '@ant-design/icons';
const { SubMenu } = Menu;

function Header(props) {
    console.log('props', props)
    useEffect(() => {
        if (!(props.url == window.location.origin + '/login' || props.url == window.location.origin + '/register') && !props.user) {
            window.location.replace(window.location.origin + "/login");
        }
    }, [])

    const logout = async () => {
        try {
            const res = await axios.post(window.location.origin + '/auth/logout', null, {
                headers: {
                    'Authorization': `Bearer ${props.jwt}`
                }
            })

            if (res.status == 200) {
                message.warning('Log Out Seccessful!');
                window.location.replace(window.location.origin + "/login");
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
                    <img height={35} src={`${window.location.origin}/uploads/images/logo.png`} style={{ marginTop: 14 }}></img>
                </div>
                {
                    props.user &&
                    <Menu mode="horizontal" theme='dark'>
                        {
                            props.admin ?
                                <>
                                    <Menu.Item key="Orders" icon={<DollarCircleOutlined />} onClick={() => window.location.href = window.location.origin + '/home'}>
                                        Orders
                                    </Menu.Item>
                                    <Menu.Item key="Add Bouquet" icon={<PlusCircleOutlined />} onClick={() => window.location.href = window.location.origin + '/home'}>
                                        Add Bouquet
                                    </Menu.Item>
                                    <Menu.Item key="Edit Bouquest" icon={<EditOutlined />} onClick={() => window.location.href = window.location.origin + '/home'}>
                                        Edit Bouquest
                                    </Menu.Item>
                                </>
                                :
                                <>
                                    <Menu.Item key="Home" icon={<HomeOutlined />} onClick={() => window.location.href = window.location.origin + '/home'}>
                                        Home
                                    </Menu.Item>
                                    <Menu.Item key="Shop" icon={<TagsOutlined />} onClick={() => window.location.href = window.location.origin + '/products'}>
                                        Shop
                                    </Menu.Item>
                                    <Menu.Item key="Cart" icon={<ShoppingCartOutlined />} onClick={() => window.location.href = window.location.origin + '/cart'}>
                                        Cart
                                    </Menu.Item>
                                </>
                        }

                        {
                            props.user ?
                                <SubMenu key="SubMenu" title={props.user} icon={<UserOutlined />}>
                                    {
                                        !props.admin &&
                                        <Menu.Item key="Order" icon={<PayCircleOutlined />}
                                            onClick={() => window.location.href = window.location.origin + '/orders'}>Order</Menu.Item>
                                    }
                                    <Menu.Item key="personalinfo" icon={<SettingOutlined />}>personal info</Menu.Item>
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
