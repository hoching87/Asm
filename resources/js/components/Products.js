import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Space, Card, Typography, Button, Divider, Select,message } from 'antd';
const { Title } = Typography;
const { Meta } = Card;
import { PlusCircleTwoTone, MinusCircleOutlined, PlusCircleOutlined } from '@ant-design/icons';
import sortBy from 'lodash/sortBy'
function Products(props) {
    const [products, setProducts] = useState();
    const [cart, setCart] = useState()
    const [type, settype] = useState('');
    const [price, setPrice] = useState('');
    const [PRICE, setPRICE] = useState();
    

    let foundCounter = 0;

    useEffect(() => {
        getProducts()
        getCart()
    }, [])

    const getProducts = async () => {
        let res = await axios.get(window.location.origin + '/api/products');
        console.log('getProducts', res.data)
        setProducts(res.data)
    }

    const getCart = async () => {
        let res = await axios.get(window.location.origin + '/getcart')
        if (res.data) {
            const toArray = Object.entries(res.data).map(([key, value]) => value)
            console.log('getCart', toArray)

            setCart(toArray)
        }
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

    const addToCart = async (req) => {
        let res = await axios.post(window.location.origin + '/addToCart', req)
        console.log('addToCart', res)
        getCart()
    }

    function handleChange1(value) {
        settype(value);
        console.log(`selected ${value}`);
    }

    const handleChange2= async (price) => {
        setPrice(price);
        console.log(`selected ${price}`);
        let res = await axios.get(window.location.origin + '/api/type', { params: { 'price': price } })
        console.log('getProducts', res.data)
        let result = Object.values(res.data);
        // let sorted;
        // for(let i=0; i<result.length;i++){
            
        // let price = result[i].bouequetPrice;
       
        // sorted = [...result].sort((a, b) => b[price] - a[price]).reverse();
        
        // }
       
        // console.log('Sorted Result',sorted)
        // for(let i=0; i<result.length;i++){
        // let price = result[i].bouequetPrice;
        // console.log('Price',price);
        // }
        setProducts(result)

    }

//     function handleStatus()
//     {
//         let res = await axios.get(window.location.origin + '/api/products');
//         console.log('getProducts', res.data)
//         setProducts(res.data)
//     }
  
//     const [MyArray, setMyArray] = useState([]);
//     const [sortStatus, setSortStatus] = useState(true);

//   const handleSort = () => {
   
//     if (sortStatus) {
//         let sorted = product.bouequetPrice.sort((a, b) => a[1] - b[1]);
//         setMyArray(sorted);
//         setSortStatus(!sortStatus);
//     } else {
//         let sorted = product.bouequetPrice.sort((a, b) => b[1] - a[1]);
//         setMyArray(sorted);
//         setSortStatus(!sortStatus);
//     }
//   }
    return (

        <>
            <Title level={4}>Our Products</Title>
            <Divider> </Divider>
            <Select defaultValue="Sort By Type"  style={{ width: 200 }} onChange={handleChange1}>
                    <Select.Option value="All">All Bouquet Type</Select.Option>
                    <Select.Option value="lilies">Lilies</Select.Option>
                    <Select.Option value="orchids">Orchids</Select.Option>
                    <Select.Option value="roses">Roses</Select.Option>
                    <Select.Option value="tulip">Tulip</Select.Option>
                    <Select.Option value="peony">Peony</Select.Option>
                    <Select.Option value="sunflower">Sunflower</Select.Option>
                    <Select.Option value="carnation">Carnation</Select.Option>
            </Select> 

            <Select defaultValue="Sort By Price" style={{ width: 200 }} onChange={handleChange2}>
            <Select.Option value="All">All</Select.Option>
                    <Select.Option value="Low_High">Low to High</Select.Option>
                    <Select.Option value="High_Low">High to Low</Select.Option>
                    <Select.Option value="Newest">Newest</Select.Option>
            </Select>
            <Divider> </Divider>
            <Space wrap>
                {
                    products?.map(product => {
                        
                         if(type==product.type)
                         {
                         
                            return (

                            <Card key={product.id}
                                style={{ width: 250 }}
                                cover={<img alt="img" src={`${window.location.origin}/uploads/images/${product.bouquetImage}`} />}
                            >

                                <Space direction="vertical" size='small'>
                                    <Meta title={'Bouquet Name :'} description={product.bouequetName} />
                                    <Meta title={'Price :'} description={`Price : RM${product.bouequetPrice}`} />
                                    <Meta title={'Description :'} description={product.bouequetDescription} />
                                    <Meta title={'Type :'} description={product.type} />
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
                         }
                         else if(type =='All' || type =='')
                         {
                            return (

                                <Card key={product.id}
                                    style={{ width: 250 }}
                                    cover={<img alt="img" src={`${window.location.origin}/uploads/images/${product.bouquetImage}`} />}
                                >
    
                                    <Space direction="vertical" size='small'>
                                        <Meta title={'Bouquet Name :'} description={product.bouequetName} />
                                        <Meta title={'Price :'} description={`Price : RM${product.bouequetPrice}`} />
                                        <Meta title={'Description :'} description={product.bouequetDescription} />
                                        <Meta title={'Type :'} description={product.type} />
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
                         }
                        
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