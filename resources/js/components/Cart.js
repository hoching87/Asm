import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Button, Card, message, Space, Typography, List } from 'antd';
const { Link, Text } = Typography;
import { PlusCircleTwoTone, MinusCircleOutlined, PlusCircleOutlined } from '@ant-design/icons';

function Cart(props) {
    const [cart, setCart] = useState()
    const [totalPrice, setTotalPrice] = useState()

    useEffect(() => {
        getCart()
    }, [])

    const getCart = async () => {
        let res = await axios.get(window.location.origin + '/getcart')
        // console.log('getCart', res.data)
        if (res.data) {
            const toArray = Object.entries(res.data).map(([key, value]) => value)
            console.log('getCart', toArray)
            let total = 0
            toArray.forEach(item => total += item.price * item.quantity)
            setCart(toArray)
            setTotalPrice(total)
        }
    }

    const clearCart = async () => {
        let res = await axios.post(window.location.origin + '/clear')
        console.log('clearCart', res)
        if (res.status == 200) {
            location.reload();
        }
    }

    const addToCart = async (req) => {
        let res = await axios.post(window.location.origin + '/addToCart', req)
        console.log('addToCart', res)
        getCart()
    }

    const updateCart = async (req) => {
        let res = await axios.post(window.location.origin + '/updateCart', req)
        console.log('updateCart', res.data)
        getCart()
    }

    const removeCart = async (req) => {
        let res = await axios.post(window.location.origin + '/removeCart', req)
        console.log('removeCart', res.data)
        getCart()
    }

    const onFinish = async (values) => {
        try {
            if (!cart.length)
                throw ('Empty Cart')
            const res = await axios.post(window.location.origin + '/api/comfirmorder', {
                ...values, cart
            }, {
                headers: {
                    'Authorization': `Bearer ${props.jwt}`
                }
            })
            console.log('comfirmorder', res)
            // console.log(values.concat(cart))
            if (res.statusText == 'Created') {
                message.success('Order Success!');
                await clearCart()
                window.location.replace(window.location.origin + "/orders");
            }
        } catch (error) {
            if (error.response) {
                // Request made and server responded
                // let obj = JSON.parse(error.response)
                console.log(error.response.data.message);
                
                // Object.entries(obj).forEach(([key, value]) => {
                //     value.forEach((error) => {
                //         message.error(error);
                //     })
                // });
                console.log(error.response.data);
                //For validation
                if(error.response.data.errors.reciever_phone !==undefined)
                {
                    message.error(error.response.data.errors.reciever_phone);
                }
                if(error.response.data.errors.reciever_name !==undefined)
                {
                     message.error(error.response.data.errors.reciever_name);
                }
                if(error.response.data.errors.reciever_address !==undefined)
                {
                     message.error(error.response.data.errors.reciever_address);
                }
                
               
            } else if (error.request) {
                // The request was made but no response was received
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                message.error(error);
            }
        }
    };

    const onFinishFailed = (errorInfo) => {
        message.error('Order Error!');
    };

    return (
        <Space align="center" direction="vertical" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>
            <Card title='Cart' style={{ width: '50vw' }}>
                <List
                    itemLayout="horizontal"
                    dataSource={cart}
                    renderItem={cart => (
                        <List.Item>
                            <List.Item.Meta
                                title={cart.name}
                                description={`Per item : RM${cart.price}`}
                            />
                            <Space >
                                Total : RM{cart.price * cart.quantity}
                                <Button type='primary' icon={<MinusCircleOutlined />}
                                    onClick={
                                        cart.quantity == 1 ?
                                            () => removeCart({
                                                'id': cart.id,
                                            })
                                            :
                                            () => updateCart({
                                                'id': cart.id,
                                                'quantity': cart.quantity - 1
                                            })
                                    }
                                ></Button>
                                {cart.quantity}
                                <Button type='primary' icon={<PlusCircleOutlined />}
                                    onClick={
                                        () => updateCart({
                                            'id': cart.id,
                                            'quantity': cart.quantity + 1
                                        })
                                    }
                                ></Button>
                            </Space>
                        </List.Item>
                    )}
                />
                {
                    totalPrice > 0 &&
                    <Space>
                        Total Price : RM{totalPrice}
                        <Button onClick={clearCart} danger>Empty Cart</Button>
                    </Space>
                }
            </Card>

            <Card title='Submit' style={{ width: '50vw' }}>
                <Form
                    name="basic"
                    initialValues={{ remember: true }}
                    onFinish={onFinish}
                    onFinishFailed={onFinishFailed}
                    autoComplete="off"
                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 10,
                    }}
                >
                    <Form.Item
                        label="reciever_name"
                        name="reciever_name"
                        rules={[{ required: true, message: 'Please input your reciver name!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="reciever_address"
                        name="reciever_address"
                        rules={[{ required: true, message: 'Please input your reciver address!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="reciever_phone"
                        name="reciever_phone"
                        rules={[{ required: true, message: 'Please input your reciver phone!' }]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
            </Card>
        </Space>
    );
}

export default Cart;

let root = document.getElementById('cart')
if (root) {
    ReactDOM.render(<Cart {...(root.dataset)} />, root);
}