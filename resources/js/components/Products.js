import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Space, Card, Typography, Button, Divider } from 'antd';
const { Title } = Typography;
const { Meta } = Card;
import { PlusCircleTwoTone, MinusCircleOutlined, PlusCircleOutlined } from '@ant-design/icons';

function Products(props) {
    const [products, setProducts] = useState();
    const [cart, setCart] = useState()
    let foundCounter = 0;

    useEffect(() => {
        getProducts()
        getCart()
    }, [])

    const getProducts = async () => {
        let res = await axios.get('http://127.0.0.1:8000/api/products');
        console.log('getProducts', res.data)
        setProducts(res.data)
    }

    const getCart = async () => {
        let res = await axios.get('http://127.0.0.1:8000/getcart')
        if (res.data) {
            const toArray = Object.entries(res.data).map(([key, value]) => value)
            console.log('getCart', toArray)

            setCart(toArray)
        }
    }

    const updateCart = async (req) => {
        let res = await axios.post('http://127.0.0.1:8000/updateCart', req)
        console.log('updateCart', res.data)
        getCart()
    }

    const removeCart = async (req) => {
        let res = await axios.post('http://127.0.0.1:8000/removeCart', req)
        console.log('removeCart', res.data)
        getCart()
    }

    const addToCart = async (req) => {
        let res = await axios.post('http://127.0.0.1:8000/addToCart', req)
        console.log('addToCart', res)
        getCart()
    }

    return (
        <>
            <Title level={4}>Our Products</Title>
            <Divider> </Divider>
            <Space wrap>
                {
                    products?.map(product => {
                        return (
                            <Card key={product.id}
                                style={{ width: 250 }}
                                cover={<img alt="img" src={`http://localhost:8000/uploads/images/${product.bouquetImage}`} />}
                            >
                                <Space direction="vertical" size='small'>
                                    <Meta title={product.bouequetName} description={`RM${product.bouequetPrice}`} />
                                    {
                                        cart?.length &&
                                            cart.find(cartitem => cartitem.id == product.id) ?
                                            cart.map((cartitem, index) => {
                                                if (cartitem.id == product.id) {
                                                    return (
                                                        <Space key={cartitem.id}>
                                                            <Button type='primary' icon={<MinusCircleOutlined />}
                                                                onClick={
                                                                    cartitem.quantity == 1 ?
                                                                        () => removeCart({
                                                                            'id': product.id,
                                                                        })
                                                                        :
                                                                        () => updateCart({
                                                                            'id': product.id,
                                                                            'quantity': cartitem.quantity - 1
                                                                        })
                                                                }
                                                            ></Button>
                                                            {cartitem.quantity}
                                                            <Button type='primary' icon={<PlusCircleOutlined />}
                                                                onClick={
                                                                    () => updateCart({
                                                                        'id': product.id,
                                                                        'quantity': cartitem.quantity + 1
                                                                    })
                                                                }
                                                            ></Button>
                                                        </Space>
                                                    )
                                                }
                                            })
                                            :
                                            <Button type="primary" icon={<PlusCircleTwoTone />}
                                                onClick={() => addToCart({
                                                    'id': product.id,
                                                    'price': product.bouequetPrice,
                                                    'quantity': 1,
                                                    'name': product.bouequetName,
                                                    'image': product.bouquetImage,
                                                })}>
                                                Add to cart
                                            </Button>
                                    }
                                </Space>

                            </Card>
                        )
                    })
                }
            </Space>

        </>
    );
}

export default Products;

let root = document.getElementById('products')
if (root) {
    ReactDOM.render(<Products {...(root.dataset)} />, root);
}