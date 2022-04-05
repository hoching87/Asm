import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Button, Card, message, Space, Typography, Divider, Upload, Select } from 'antd';
import { UploadOutlined } from '@ant-design/icons';
const { Link, Text } = Typography;
const { Option: option } = Select;


function AddBouquet(props) {
    const [selectedImage, setSelectedImage] = useState('');
    const handleFileChange = (file) => {
        setSelectedImage(file[0]);
    }

    const [bouequetName, setbouequetName] = useState("");
    const updateName = (event) => {
        setbouequetName(event.target.value);
    };

    const [bouequetDescription, setbouequetDescription] = useState("");
    const updateDescription = (event) => {
        setbouequetDescription(event.target.value);
    };

    const [bouequetPrice, setbouequetPrice] = useState("");
    const updatePrice = (event) => {
        setbouequetPrice(event.target.value);
    };
    
    const [type, settype] = useState('');
    function handleChange(event) {
        settype(event.target.value);
        console.log(`selected ${event.target.value}`);
    }

    const onFinish = async (values) => {

        const dataArray = new FormData();
        dataArray.append("image", selectedImage);
        dataArray.append("bouequetName", bouequetName);
        dataArray.append("bouequetDescription", bouequetDescription);
        dataArray.append("bouequetPrice", bouequetPrice);
        dataArray.append("type", type);
        console.log(selectedImage)


        try {
            console.log('values', values)
            const res = await axios.post(window.location.origin + '/api/createBouquet', dataArray, { headers: { 'Content-Type': 'multipart/form-data' } })

            console.log('res', res.data)
            if (res.statusText == 'Created') {
                message.success('Bouquet Added!');
                window.location.replace(window.location.origin + "/home");
            }
        } catch (error) {
            if (error.response) {
                // Request made and server responded
                let obj = JSON.parse(error.response.data)
                console.log(obj);
                Object.entries(obj).forEach(([key, value]) => {
                    value.forEach((error) => {
                        message.error(error);
                    })
                });
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
        message.error('Error occured while add new bouquet!');
    };

    // const image = {
    //     name: 'bouquetImage',
    //     action: 'https://www.mocky.io/v2/5cc8019d300000980a055e76',
    //     headers: {
    //         authorization: 'authorization-text',
    //       },
    //       onChange(info) {
    //         if (info.file.status !== 'uploading') {
    //           console.log(info.file, info.fileList);
    //         }
    //         if (info.file.status === 'done') {
    //           message.success(`${info.file.name} file uploaded successfully`);
    //         } else if (info.file.status === 'error') {
    //           message.error(`${info.file.name} file upload failed.`);
    //         }
    //       },
    // };

    return (
        <Space align="baseline" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>
            <Card title='Add Bouquet' style={{ width: '50vw' }}>
                <Form
                    name="basic"
                    initialValues={{ remember: true }}
                    onFinish={onFinish}
                    onFinishFailed={onFinishFailed}
                    autoComplete="on"
                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 10,
                    }}
                    encType="multipart/form-data"
                >
                    <Form.Item
                        label="Bouquet Name"

                        rules={[{ required: true, message: 'Please input bouquet name!' }]}
                    >
                        <>
                            <input
                                type="text"
                                value={bouequetName}
                                onChange={updateName}
                                
                            />
                        </>
                    </Form.Item>
                    <Form.Item
                        label="Description"

                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <>
                            <input
                                type="text"
                                value={bouequetDescription}
                                onChange={updateDescription}

                            />
                        </>
                    </Form.Item>
                    <Form.Item
                        label="Bouquet Price"

                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <>
                            <input
                                type="text"
                                value={bouequetPrice}
                                onChange={updatePrice}
                                
                            />
                        </>
                    </Form.Item>
                    <Form.Item
                        label="Bouquet Image"

                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <><input
                            type="file"
                            name="image"
                            onChange={e => {
                                handleFileChange(e.target.files)
                            }}
                        /></>


                    </Form.Item>


                    <Form.Item
                        label="Bouquet Type"

                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <><select name='type' style={{ width: 120 }} onChange={handleChange}>
                            <option value="lilies">Lilies</option>
                            <option value="orchids">Orchids</option>
                            <option value="roses">Roses</option>
                            <option value="tulip">Tulip</option>
                            <option value="peony">Peony</option>
                            <option value="sunflower">Sunflower</option>
                            <option value="carnation">Carnation</option>
                        </select></>

                    </Form.Item>

                    <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
                <Divider></Divider>

            </Card>
        </Space >
    );
}

export default AddBouquet;

let root = document.getElementById('addbouquet')
if (root) {
    ReactDOM.render(<AddBouquet {...(root.dataset)} />, root);
}