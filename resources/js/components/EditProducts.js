import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Space, Card, Typography, Button, Divider, Modal, Form, Input, message, Upload } from 'antd';
const { Title } = Typography;
const { Meta } = Card;
import { EditFilled, DeleteFilled, LoadingOutlined, PlusOutlined } from '@ant-design/icons';

function EditProducts(props) {
    const [products, setProducts] = useState();
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [modalData, SetModalData] = useState();
    // const [loading, setLoading] = useState();
    // const [imageUrl, setImageUrl] = useState();
    const [selectedImage, setSelectedImage] = useState('');

    const handleFileChange = (file) => {
        setSelectedImage(file[0]);
    }
    useEffect(() => {
        getProducts()
    }, [])

    const getProducts = async () => {
        let res = await axios.get(window.location.origin + '/api/products');
        console.log('getProducts', res.data)
        setProducts(res.data)
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

    // const handleChange = info => {
    //     if (info.file.status === 'uploading') {
    //         setLoading(true);
    //         return;
    //     }
    //     if (info.file.status === 'done') {
    //         // Get this url from response in real world.
    //         getBase64(info.file.originFileObj, imageUrl => {
    //             setImageUrl(imageUrl)
    //             setLoading(false)
    //         });
    //     }
    // };

    // function getBase64(img, callback) {
    //     const reader = new FileReader();
    //     reader.addEventListener('load', () => callback(reader.result));
    //     reader.readAsDataURL(img);
    // }

    // function beforeUpload(file) {
    //     const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
    //     if (!isJpgOrPng) {
    //         message.error('You can only upload JPG/PNG file!');
    //     }
    //     const isLt2M = file.size / 1024 / 1024 < 2;
    //     if (!isLt2M) {
    //         message.error('Image must smaller than 2MB!');
    //     }
    //     return isJpgOrPng && isLt2M;
    // }

    // const uploadButton = (
    //     <div>
    //         {loading ? <LoadingOutlined /> : <PlusOutlined />}
    //         <div style={{ marginTop: 8 }}>Upload</div>
    //     </div>
    // );

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
                                cover={<img alt="img" src={`${window.location.origin}/uploads/images/${product.bouquetImage}`} />}
                            >
                                <Space direction="vertical" size='small'>
                                    <Meta title={product.bouequetName} description={`RM${product.bouequetPrice}`} />
                                    <Space>
                                        <Button type='primary' icon={<EditFilled />}
                                            onClick={() => OpenModal(product)}
                                        >Edit</Button>
                                        <Button icon={<DeleteFilled />} danger
                                            onClick={
                                                () => DeleteBouquet(product.id)
                                            }
                                        >Delete</Button>
                                    </Space>
                                </Space>

                            </Card>
                        )
                    })
                }
            </Space>
            {
                modalData &&
                <Modal title="Basic Modal" visible={isModalVisible} onOk={modalToggle} onCancel={modalToggle}>

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