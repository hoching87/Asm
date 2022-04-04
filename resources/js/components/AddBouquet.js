import React from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Button, Card, message, Space, Typography, Divider, Upload, Select } from 'antd';
import { UploadOutlined } from '@ant-design/icons';
const { Link, Text } = Typography;
const { Option } = Select;

function handleChange(value) {
    console.log(`selected ${value}`);
}
function AddBouquet(props) {
    const onFinish = async (values) => {
        values['role'] = 'user'
        try {
            const res = await axios.post(window.location.origin + '/auth/register', values)
            console.log('res', res)
            if (res.statusText == 'Created') {
                message.success('Register Success!');
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

    const image = {
        
        action: 'https://www.mocky.io/v2/5cc8019d300000980a055e76',
        onChange({ file, fileList }) {
            if (file.status !== 'uploading') {
              console.log(file, fileList);
            }
          }
    };

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
                >
                    <Form.Item
                        label="Bouquet Name"
                        name="bouequetName"
                        rules={[{ required: true, message: 'Please input bouquet name!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Description"
                        name="bouequetDescription"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Bouquet Price"
                        name="bouequetPrice"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Bouquet Image"
                        name="bouquetImage"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Upload {...image}>
                            <Button icon={<UploadOutlined />}>Click to Upload Bouquet Image</Button>
                        </Upload>
                    </Form.Item>


                    <Form.Item
                        label="Bouquet Type"
                        name="type"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Select  style={{ width: 120 }} onChange={handleChange}>
                            <Option value="lilies">Lilies</Option>
                            <Option value="orchids">Orchids</Option>
                            <Option value="roses">Roses</Option>
                            <Option value="tulip">Tulip</Option>
                            <Option value="peony">Peony</Option>
                            <Option value="sunflower">Sunflower</Option>
                            <Option value="carnation">Carnation</Option>
                        </Select>
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