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
    const [loading, setLoading] = useState();
    const [imageUrl, setImageUrl] = useState();

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
        values.id = modalData.id
        console.log('onFin', values)
        try {
            const res = await axios.post(window.location.origin + '/api/UpdateBouquet', values,
                {
                    headers: {
                        'Authorization': `Bearer ${props.jwt}`
                    }
                }
            )
            if (res.status == 200) {
                message.success('Login Success!');
                // window.location.replace(window.location.origin + "/home");
            }
        } catch (err) {
            message.error('Login Failed!');
        }
    };

    const onFinishFailed = (errorInfo) => {
        message.error('Login Error!');
    };

    const handleChange = info => {
        if (info.file.status === 'uploading') {
            setLoading(true);
            return;
        }
        if (info.file.status === 'done') {
            // Get this url from response in real world.
            getBase64(info.file.originFileObj, imageUrl => {
                setImageUrl(imageUrl)
                setLoading(false)
            });
        }
    };

    function getBase64(img, callback) {
        const reader = new FileReader();
        reader.addEventListener('load', () => callback(reader.result));
        reader.readAsDataURL(img);
    }

    function beforeUpload(file) {
        const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
        if (!isJpgOrPng) {
            message.error('You can only upload JPG/PNG file!');
        }
        const isLt2M = file.size / 1024 / 1024 < 2;
        if (!isLt2M) {
            message.error('Image must smaller than 2MB!');
        }
        return isJpgOrPng && isLt2M;
    }

    const uploadButton = (
        <div>
            {loading ? <LoadingOutlined /> : <PlusOutlined />}
            <div style={{ marginTop: 8 }}>Upload</div>
        </div>
    );

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
                                                () => 0
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

                        <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                            <Button type="primary" htmlType="submit">
                                Submit
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