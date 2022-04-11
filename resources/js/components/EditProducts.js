import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Space, Card, Typography, Button, Divider, Modal, Form, Input, message, Upload, Select } from 'antd';
const { Title } = Typography;
const { Meta } = Card;
import { EditFilled, DeleteFilled, LoadingOutlined, PlusOutlined } from '@ant-design/icons';
import { confirmAlert } from 'react-confirm-alert'
import 'react-confirm-alert/src/react-confirm-alert.css'; 

function EditProducts(props) {
    const [products, setProducts] = useState();
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [modalData, SetModalData] = useState();
    const [selectedImage, setSelectedImage] = useState('');
    const [type, settype] = useState('');
    const [price, setPrice] = useState('');

    const handleFileChange = (file) => {
        setSelectedImage(file[0]);
    }
    useEffect(() => {
        getProducts()
    }, [])

    const getProducts = async () => {
        if(price!== null){
            let res = await axios.get(window.location.origin + '/api/type', { params: { 'price': price } })
            console.log('getProducts', res.data)
            let result = Object.values(res.data);
         
            setProducts(result)
        }
        else{
             let res = await axios.get(window.location.origin + '/api/products');
        console.log('getProducts', res.data)
        setProducts(res.data)
        }
       
    }

    const modalToggle = () => {
        if (isModalVisible)
            SetModalData(null)
        setIsModalVisible(!isModalVisible)
    }

    const OpenModal = (data) => {
        SetModalData(data)
        modalToggle()
    }

    const submit = (value) => {
        confirmAlert({
          title: 'Confirm to delete this bouquet?',
          message: 'Are you sure to delete this bouquet?.',
          buttons: [
            {
              label: 'Yes',
              onClick: () => DeleteBouquet(value)
            },
            {
              label: 'No',
              onClick: () => message.success('Bouquet unchanged')
            }
          ]
        });
      };

    const onFinish = async (values) => {
        const dataArray = new FormData();
        values.id = modalData.id
        dataArray.append("image", selectedImage);
        dataArray.append("bouequetName", values.bouequetName);
        dataArray.append("bouequetDescription", values.bouequetDescription);
        dataArray.append("bouequetPrice", values.bouequetPrice);
        dataArray.append("id", values.id);
        console.log(dataArray)

        values.image = dataArray
        console.log('onFin', values)
        try {
            const res = await axios.post(window.location.origin + '/api/UpdateBouquet', dataArray,
                {
                    headers: {
                        'Authorization': `Bearer ${props.jwt}`
                    }
                }
            )
            if (res.status == 200) {
                message.success('Bouquet Update Success!');
                // window.location.replace(window.location.origin + "/home");
                getProducts()
            }
        } catch (error) {
            if (error.response) {
                // Request made and server responded
                if(error.response.data.errors.bouequetName !==undefined)
                {
                    message.error(error.response.data.errors.bouequetName);
                }
                if(error.response.data.errors.bouequetDescription !==undefined)
                {
                     message.error(error.response.data.errors.bouequetDescription);
                }
                if(error.response.data.errors.bouequetPrice !==undefined)
                {
                     message.error(error.response.data.errors.bouequetPrice);
                }
               
            } else if (error.request) {
                // The request was made but no response was received
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
        }
    };

    const onFinishFailed = (errorInfo) => {
        message.error('Upload Error!');
    };

 

    const DeleteBouquet = async (id) => {
        console.log(id)
        const res = await axios.post('http://127.0.0.1:8000/api/DeleteBouquet', { 'id': id }, {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        message.success('Bouquet deleted')
        console.log(res)
        getProducts()
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
     
        setProducts(result)

    }
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
                                        <Space>
                                            <Button type='primary' icon={<EditFilled />}
                                                onClick={() => OpenModal(product)}
                                            >Edit</Button>
                                            <Button icon={<DeleteFilled />} danger
                                                onClick={
                                                    () => submit(product.id)
                                                }
                                            >Delete</Button>
                                        </Space>
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
                                        <Space>
                                            <Button type='primary' icon={<EditFilled />}
                                                onClick={() => OpenModal(product)}
                                            >Edit</Button>
                                            <Button icon={<DeleteFilled />} danger
                                                onClick={
                                                    () => submit(product.id)
                                                }
                                            >Delete</Button>
                                        </Space>
                                    </Space>
    
                                </Card>
                            )
                        }
                        
                    })
                }
            </Space>
            {
                modalData &&
                <Modal title="Edit Bouquet" visible={isModalVisible} onOk={modalToggle} onCancel={modalToggle}>

                    <Form
                        name="basic"
                        onFinish={onFinish}
                        onFinishFailed={onFinishFailed}
                        initialValues={{
                            bouequetName: modalData.bouequetName,
                            bouequetDescription: modalData.bouequetDescription, bouequetPrice: modalData.bouequetPrice
                        }}
                        labelCol={{
                            span: 8,
                        }}
                        wrapperCol={{
                            span: 10,
                        }}
                    >
                        <Form.Item
                            label="Name"
                            name="bouequetName"
                            rules={[{ required: true, message: 'Please input bouequet name!' }]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Description"
                            name="bouequetDescription"
                            rules={[{ required: true, message: 'Please input description!' }]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Price (RM)"
                            name="bouequetPrice"
                            rules={[{ required: true, message: 'Please input price!' }]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Image"

                            rules={[{ required: true, message: 'Please upload image!' }]}
                        >
                            <><input
                                type="file"
                                name="image"
                                onChange={e => {
                                    handleFileChange(e.target.files)
                                }}
                            /></>
                        </Form.Item>
                        <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                            <Button type="primary" htmlType="submit">
                                Update
                            </Button>
                        </Form.Item>
                    </Form>
                </Modal>
            }
        </>
    );
}

export default EditProducts;

let root = document.getElementById('editproducts')
if (root) {
    ReactDOM.render(<EditProducts {...(root.dataset)} />, root);
}