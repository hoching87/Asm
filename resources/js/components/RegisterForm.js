import React from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Button, Card, message, Space, Typography, Divider } from 'antd';
const { Link, Text } = Typography;

function RegisterForm(props) {
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
                        message.error(error.message.errors);
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
        message.error('Register Error!');
    };

    return (
        <Space align="baseline" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>
            <Card title='Register' style={{ width: '50vw' }}>
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
                        label="Name"
                        name="name"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Email"
                        name="email"
                        rules={[{ required: true, message: 'Please input your email!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Address"
                        name="address"
                        rules={[{ required: true, message: 'Please input your address!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Phone"
                        name="phone"
                        rules={[{ required: true, message: 'Please input your phone!' }]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        label="password"
                        name="password"
                        rules={[{ required: true, message: 'Please input your password!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="password_confirmation"
                        name="password_confirmation"
                        rules={[{ required: true, message: 'Please input your password confirmation!' }]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
                <Divider></Divider>
                <Text>Have a existing account? </Text>
                <Link href={window.location.origin + '/login'}>
                    Login
                </Link>
            </Card>
        </Space >
    );
}

export default RegisterForm;

let root = document.getElementById('registerform')
if (root) {
    ReactDOM.render(<RegisterForm {...(root.dataset)} />, root);
}